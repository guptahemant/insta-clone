<?php

namespace Drupal\log_mod\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "custom_block",
 *   admin_label = @Translation("Custom Block"),
 *   category = @Translation("Hello World"),
 * )
 */
class CustomBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $out = 'Hello, World!';
    dump($out);

    return [
      '#theme' => 'cust-block',
      '#data' => $out,

    ];
  }

}
