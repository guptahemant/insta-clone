<?php

namespace Drupal\linkicon\Plugin\Field\FieldFormatter;

use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;

/**
 * A Trait to decluter the main formatter class for readability.
 */
trait LinkIconFormatterTrait {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'rel'                    => '',
      'target'                 => '',
      'linkicon_prefix'        => 'icon',
      'linkicon_icon_class'    => '',
      'linkicon_wrapper_class' => '',
      'linkicon_load'          => FALSE,
      'linkicon_vertical'      => FALSE,
      'linkicon_style'         => '',
      'linkicon_color'         => '',
      'linkicon_tooltip'       => FALSE,
      'linkicon_maxlength'     => 60,
      'linkicon_no_text'       => FALSE,
      'linkicon_position'      => '',
      'linkicon_link'          => FALSE,
      'linkicon_global_title'  => '',
      'linkicon_size'          => '',
      'linkicon_bundle'        => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);
    $settings = $this->getSettings();

    // Predefined titles are supposed to be controlled.
    if (isset($elements['trim_length'])) {
      unset($elements['trim_length']);
    }

    $elements['opening'] = [
      '#type'   => 'item',
      '#markup' => '<h3>' . $this->t('If your theme has no icon font library, define one <a href=":url" target="_blank">here</a>.', [':url' => Url::fromRoute('linkicon.settings')->toString()]) . '</h3>',
    ];

    $elements['linkicon_prefix'] = [
      '#type'        => 'textfield',
      '#title'       => $this->t('Icon prefix class'),
      '#required'    => TRUE,
      '#description' => $this->t('A "prefix" or "namespace", e.g.: icon (Fontello), fa (FontAwesome), st-icon (Stackicons), genericon, fonticon, etc. <br />If the link title is <em>Facebook</em>, it will create classes: <em>icon icon-facebook</em> for Fontello, or <em>fa fa-facebook</em> for FontAwesome > 3. <br />The individual icon class itself is based on the link text key matching the pattern: icon-KEY, or fa-KEY.'),

    ];

    $elements['linkicon_wrapper_class'] = [
      '#type'        => 'textfield',
      '#title'       => $this->t('Additional wrapper class'),
      '#description' => $this->t('Additional wrapper class for the entire icon list apart from <strong>item-list item-list--linkicon</strong> separated by spaces.'),
    ];

    $elements['linkicon_icon_class'] = [
      '#type'        => 'textfield',
      '#title'       => $this->t('Additional icon classes'),
      '#description' => $this->t('Additional icon class for the actual icon apart from <strong>linkicon__icon icon</strong> separated by spaces, e.g: fab fas far.'),
    ];

    $elements['linkicon_link'] = [
      '#type'        => 'checkbox',
      '#title'       => $this->t('Add the classes to the A tag.'),
      '#description' => $this->t('By default linkicon adds additional SPAN tag to hold the icon, enable this to add the classes to the A tag instead. This is all about DIY.'),
      '#states'      => [
        'visible' => [
          ':input[name*="linkicon_load"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $elements['linkicon_load'] = [
      '#type'        => 'checkbox',
      '#title'       => $this->t('Allow linkicon to provide CSS assets'),
      '#description' => $this->t('Otherwise, DIY accordingly.'),
      '#states'      => [
        'visible' => [
          ':input[name*="linkicon_link"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $elements['linkicon_vertical'] = [
      '#type'        => 'checkbox',
      '#title'       => $this->t('Vertical'),
      '#description' => $this->t('By default, icons are displayed inline. Check to make icons stacked vertically.'),
      '#states'      => [
        'visible' => [
          ':input[name*="linkicon_load"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $elements['linkicon_style'] = [
      '#type'    => 'select',
      '#title'   => $this->t('Icon style'),
      '#options' => [
        'round'    => $this->t('Round'),
        'round-2'  => $this->t('Round 2'),
        'round-5'  => $this->t('Round 5'),
        'round-8'  => $this->t('Round 8'),
        'round-10' => $this->t('Round 10'),
        'square'   => $this->t('Square'),
        'button'   => $this->t('Button'),
      ],
      '#empty_option' => $this->t('- None -'),
      '#states'       => [
        'visible' => [
          ':input[name*="linkicon_load"]' => ['checked' => TRUE],
        ],
      ],
      '#description' => $this->t('Button is more prominent if the title text is not hidden over the background color.'),
    ];

    $elements['linkicon_color'] = [
      '#type'    => 'select',
      '#title'   => $this->t('Icon background color'),
      '#options' => [
        'grey'   => $this->t('Grey'),
        'dark'   => $this->t('Dark'),
        'purple' => $this->t('Purple'),
        'orange' => $this->t('Orange'),
        'blue'   => $this->t('Blue'),
        'lime'   => $this->t('Lime'),
        'red'    => $this->t('Red'),
      ],
      '#empty_option' => $this->t('- None -'),
      '#states'       => [
        'visible' => [
          ':input[name*="linkicon_load"]' => ['checked' => TRUE],
        ],
      ],
      '#description' => $this->t('Basic background color. You should do proper theming to suit your design better, and disable all this.'),
    ];

    $elements['linkicon_tooltip'] = [
      '#type'   => 'checkbox',
      '#title'  => $this->t('Display title as tooltip'),
      '#states' => [
        'visible' => [
          ':input[name*="linkicon_load"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $elements['linkicon_no_text'] = [
      '#type'   => 'checkbox',
      '#title'  => $this->t('Visually hide the title text'),
      '#states' => [
        'visible' => [
          ':input[name*="linkicon_load"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $elements['linkicon_maxlength'] = [
      '#type'        => 'textfield',
      '#title'       => $this->t('The title and tooltip maxlength'),
      '#description' => $this->t('Limit the amount of characters if using token replacement for the title and tootip as defined at the widget settings, default to 60 characters.'),
      '#size'        => 6,
      '#maxlength'   => 3,
    ];

    $elements['linkicon_global_title'] = [
      '#type'        => 'textfield',
      '#title'       => $this->t('Override title with a generic link title'),
      '#description' => $this->t('If provided, the link title will be overriden with this text, e.g.: Visit the site, View Demo. Token is supported.'),
      '#states'      => [
        'visible' => [
          [':input[name*="linkicon_tooltip"]' => ['checked' => FALSE]],
          [':input[name*="linkicon_no_text"]' => ['checked' => FALSE]],
        ],
      ],
    ];

    $elements['linkicon_position'] = [
      '#type'        => 'select',
      '#title'       => $this->t('Icon position to the title text.'),
      '#description' => $this->t('By default icon is before the text - Left.'),
      '#options'     => [
        'bottom' => $this->t('Bottom'),
        'right'  => $this->t('Right'),
        'top'    => $this->t('Top'),
      ],
      '#empty_option' => $this->t('Left'),
      '#states'       => [
        'visible' => [
          [':input[name*="linkicon_load"]' => ['checked' => TRUE]],
          [':input[name*="linkicon_no_text"]' => ['checked' => FALSE]],
          [':input[name*="linkicon_link"]' => ['checked' => FALSE]],
        ],
      ],
    ];

    $icon_sizes = [
      'small'   => $this->t('Small'),
      'medium'  => $this->t('Medium'),
      'large'   => $this->t('Large'),
      'xlarge'  => $this->t('X-large'),
      'xxlarge' => $this->t('Xx-large'),
    ];

    $elements['linkicon_size'] = [
      '#type'         => 'select',
      '#title'        => $this->t('Icon font size'),
      '#options'      => $icon_sizes,
      '#empty_option' => $this->t('Default'),
      '#states'       => [
        'visible' => [
          ':input[name*="linkicon_load"]' => ['checked' => TRUE],
        ],
      ],
    ];

    // Build a preview.
    if (function_exists('icon_providers')) {
      $providers = icon_providers();

      $provider_options = [];
      foreach ($providers as $provider) {
        $provider_options[$provider['name']] = $provider['title'];
      }

      if ($provider_options) {
        $elements['linkicon_bundle'] = [
          '#type'         => 'select',
          '#title'        => $this->t('Icon module integration'),
          '#options'      => $provider_options,
          '#empty_option' => $this->t('- None -'),
          '#description'  => $this->t('The above icon providers modules are detected. You can choose which icon CSS file to load with this module. <br>Make sure that you have a working module that loads relevant CSS accordingly. <br>Known working modules as of this writing: fontawesome, and icomoon.'),
          '#states' => [
            'visible' => [
              ':input[name*="linkicon_link"]' => ['checked' => FALSE],
            ],
          ],
        ];
      }
    }

    // Provides default values.
    foreach ($elements as $key => &$element) {
      if (in_array($key, ['opening', 'linkicon_size_preview'])) {
        continue;
      }

      $default = isset(self::defaultSettings()[$key]) ? self::defaultSettings()[$key] : '';
      $element['#default_value'] = isset($settings[$key]) ? $settings[$key] : $default;
    }

    // Previews.
    $field_settings = $this->getFieldSettings();
    $has_icon_path = $this->linkIconManager->getSetting('font');
    $config = $this->linkIconManager->simplifySettings($settings);
    $icon_previews = [];

    $linkicon_item = [
      '#theme'     => 'linkicon_item',
      '#title'     => 'Twitter',
      '#icon_name' => 'twitter',
      '#settings'  => $config,
    ];

    if (!empty($field_settings['title_predefined'])) {
      $values = $this->linkIconManager->extractAllowedValues($field_settings['title_predefined']);
      if (!isset($values['twitter'])) {
        $linkicon_item['#icon_name'] = key($values);
        $linkicon_item['#title'] = current($values);
      }
    }

    $icon = $this->renderer->render($linkicon_item);
    $tooltip = '';
    if ($config['tooltip']) {
      $tooltip = ' data-title="Twitter"';
    }

    foreach ($icon_sizes as $key => $size) {
      $is_active = $key == $config['size'] ? ' active' : '';
      $icon_previews[] = ['#markup' => '<a class="linkicon__item linkicon--' . $key . $is_active . '" href="#"' . $tooltip . '>' . $icon . '</a>'];
    }

    $config['_preview'] = TRUE;
    if ($config['load']) {
      if ($has_icon_path) {
        $elements['#attached']['library'][] = 'linkicon/linkicon.font';
      }
      $elements['#attached']['library'][] = 'linkicon/linkicon';
    }

    $elements['linkicon_size_preview'] = [
      '#theme'       => 'linkicon',
      '#linkicon_id' => 'linkicon-preview',
      '#items'       => $icon_previews,
      '#config'      => $config,
      '#states' => [
        'visible' => [
          ':input[name*="linkicon_link"]' => ['checked' => FALSE],
        ],
      ],
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $settings = $this->getSettings();

    if (!empty($settings['rel'])) {
      $summary[] = $this->t('Add rel="@rel"', ['@rel' => $settings['rel']]);
    }
    if (!empty($settings['target'])) {
      $summary[] = $this->t('Open link in new window');
    }

    $summary[] = $this->t('Prefix class: <em>@linkicon_prefix</em>.', [
      '@linkicon_prefix' => $settings['linkicon_prefix'],
    ]);

    if (isset($settings['linkicon_link'])) {
      $summary[] = t('Icon classes at A tag: <em>@linkicon_link</em>.', [
        '@linkicon_link' => $settings['linkicon_link'] ? t('Yes') : t('No'),
      ]);
    }

    if (isset($settings['linkicon_icon_class'])) {
      $summary[] = t('Extra icon classes: <em>@linkicon_icon_class</em>.', [
        '@linkicon_icon_class' => $settings['linkicon_icon_class'],
      ]);
    }

    $summary[] = $this->t('Module CSS: <em>@linkicon_load</em>. Wrapper: <em>@linkicon_wrapper_class</em>. Style: <em>@linkicon_style</em>. Bg: <em>@linkicon_color</em>.', [
      '@linkicon_load' => $settings['linkicon_load'] ? $this->t('Yes') : $this->t('No'),
      '@linkicon_wrapper_class' => $settings['linkicon_wrapper_class'] ? $settings['linkicon_wrapper_class'] : $this->t('None'),
      '@linkicon_vertical' => $settings['linkicon_vertical'] ? $this->t('Vertical') : $this->t('Horizontal'),
      '@linkicon_style' => $settings['linkicon_style'] ? $settings['linkicon_style'] : $this->t('None'),
      '@linkicon_color' => $settings['linkicon_color'] ? $settings['linkicon_color'] : $this->t('None'),
    ]);

    if ($settings['linkicon_load']) {
      $summary[] = $this->t('Size: <em>@linkicon_size</em>. No text: <em>@linkicon_no_text</em>. Tooltip: <em>@linkicon_tooltip</em>', [
        '@linkicon_size' => $settings['linkicon_size'],
        '@linkicon_no_text' => $settings['linkicon_no_text'] ? $this->t('Yes') : $this->t('No'),
        '@linkicon_tooltip' => $settings['linkicon_tooltip'] ? $this->t('Yes') : $this->t('No'),
      ]);

      if (empty($settings['linkicon_no_text'])) {
        $summary[] = $this->t('Use global title: <em>@linkicon_global_title</em>. <br>Icon position: <em>@linkicon_position</em>.', [
          '@linkicon_global_title' => $settings['linkicon_global_title'] ? $settings['linkicon_global_title'] : $this->t('No'),
          '@linkicon_position' => $settings['linkicon_position'] ? $settings['linkicon_position'] : $this->t('Left'),
        ]);
      }
    }

    return $summary;
  }

}
