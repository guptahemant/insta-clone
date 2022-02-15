<?php

namespace Drupal\log_mod\Controller;

/**
 * A Controller class.
 */
class TestController {

  /**
   * To initiate the the custom block.
   */
  public function logtest() {
    $element = [
      '#markup' => 'Hello World',
    ];
    return $element;
  }

}
