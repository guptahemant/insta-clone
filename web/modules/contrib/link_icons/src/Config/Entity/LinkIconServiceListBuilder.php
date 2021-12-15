<?php

namespace Drupal\link_icons\Config\Entity;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;

/**
 * Provides a listing of link icon service entities.
 */
class LinkIconServiceListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return t('Link icon services');
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Name');
    $header['hostnames'] = $this->t('Hostname(s)');
    $header['class'] = $this->t('Class');
    $header['icon'] = $this->t('Icon name');
    $header['icon_style'] = $this->t('Icon style');
    $header['icon_square'] = $this->t('Square icon');
    $header['icon_circle'] = $this->t('Circular icon');
    $header['color'] = $this->t('Icon color');
    $header['preview'] = $this->t('Preview');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /**
     * @var \Drupal\link_icons\Entity\LinkIconServiceInterface $service
    */
    $service = $entity;

    $row['label'] = $service->label();

    $hostnames = $service->get('hostnames');
    for ($x = 0; $x < count($hostnames); $x++) {
      $hostnames[$x] = Link::fromTextAndUrl(
        $hostnames[$x],
        Url::fromUri(
          'http://' . $hostnames[$x],
          [
            'attributes' => [
              'title' => $service->label(),
              'target' => '_blank',
            ],
          ]
        )
      )->toString();
    }
    $row['hostnames']['data']['#markup'] = Markup::create(implode('<br />', $hostnames));

    $row['class'] = $service->get('class');
    $class = $row['class'] == '' ? $service->id() : $row['class'];

    $row['icon'] = Markup::create(
      Link::fromTextAndUrl(
        $service->get('icon'),
        Url::fromUri(
          'https://fontawesome.com/icons/' . $service->get('icon'),
          [
            'attributes' => [
              'title' => $service->get('icon'),
              'target' => '_blank',
            ],
          ]
        )
      )->toString()
    );

    $row['icon_style'] = $service->get('icon_style');
    switch ($row['icon_style']) {
      case 'solid':
        $style = 's';
        break;

      case 'regular':
        $style = 'r';
        break;

      case 'light':
        $style = 'l';
        break;

      case 'duotone':
        $style = 'd';
        break;

      case 'brand':
      default:
        $style = 'b';
        break;
    }

    $row['icon_square'] = $service->get('icon_square') ? Markup::create(
      Link::fromTextAndUrl(
        $service->get('icon_square'),
        Url::fromUri(
          'https://fontawesome.com/icons/' . $service->get('icon_square'),
          [
            'attributes' => [
              'title' => $service->get('icon_square'),
              'target' => '_blank',
            ],
          ]
        )
      )->toString()
    ) :
    '';

    $row['icon_circle'] = $service->get('icon_circle') ? Markup::create(
      Link::fromTextAndUrl(
        $service->get('icon_circle'),
        Url::fromUri(
          'https://fontawesome.com/icons/' . $service->get('icon_circle'),
          [
            'attributes' => [
              'title' => $service->get('icon_circle'),
              'target' => '_blank',
            ],
          ]
        )
      )->toString()
    ) :
    '';

    $row['color']['data']['#markup'] = Markup::create('<span style="display: inline-block; width: 1em; height: 1em; background-color: ' . $service->get('color') . '"></span> ' . $service->get('color'));

    $row['preview']['data']['#markup'] = Markup::create(
      '<i class="service ' . $class . ' fa' . $style . ' fa-' . $service->get('icon') . '" style="color: ' . $service->get('color') . '; font-size: 2em;"></i>'
      . ($service->get('icon_square') ? ' <i class="service ' . $class . ' fa' . $style . ' fa-' . $service->get('icon_square') . '" style="color: ' . $service->get('color') . '; font-size: 2em;"></i>' : '')
      . ($service->get('icon_circle') ? ' <i class="service ' . $class . ' fa' . $style . ' fa-' . $service->get('icon_circle') . '" style="color: ' . $service->get('color') . '; font-size: 2em;"></i>' : '')
    );

    return $row + parent::buildRow($entity);
  }

}
