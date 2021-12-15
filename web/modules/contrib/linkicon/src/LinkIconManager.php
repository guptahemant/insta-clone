<?php

namespace Drupal\linkicon;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides LinkIconManager service.
 */
class LinkIconManager implements LinkIconManagerInterface {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $config_factory, ModuleHandlerInterface $module_handler) {
    $this->config = $config_factory->get('linkicon.settings');
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public function getSetting($setting_name) {
    return $this->config->get($setting_name);
  }

  /**
   * {@inheritdoc}
   */
  public function simplifySettings(array $settings = []) {
    $config = [];
    foreach ($settings as $key => $value) {
      $config[str_replace('linkicon_', '', $key)] = $value;
    }
    return $config;
  }

  /**
   * {@inheritdoc}
   */
  public function extractAllowedValues($values, $is_tooltip = FALSE) {
    $allowed_values = [];
    if ($values) {
      $list = explode("\n", strip_tags($values));

      foreach ($list as $value) {
        if (strpos($value, "|") !== FALSE) {
          list($key, $title, $tooltip) = array_pad(array_map('trim', explode("|", $value, 3)), 3, NULL);
          $allowed_values[$key] = $is_tooltip && !empty($tooltip) ? $tooltip : $title;
        }
        else {
          $allowed_values[$value] = $value;
        }
      }
    }
    return $allowed_values;
  }

  /**
   * Implements hook_library_info_build().
   */
  public function libraryInfoBuild() {
    $libraries = [];
    if ($font_path = $this->getSetting('font')) {
      if (strpos($font_path, ',') !== FALSE) {
        $paths = array_map('trim', explode(',', $font_path));
        foreach ($paths as $path) {
          $library_path[$path] = [];
        }
      }
      else {
        $library_path = [$font_path => []];
      }
      $libraries['linkicon.font'] = [
        'css' => [
          'base' => $library_path,
        ],
      ];
    }
    return $libraries;
  }

}
