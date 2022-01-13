<?php

namespace Drupal\log_mod\Controller;
class TestController {
  public function logtest() {
    $element = array(
        '#markup' => 'Hello World',
    );
    return $element;
  }
}
?>