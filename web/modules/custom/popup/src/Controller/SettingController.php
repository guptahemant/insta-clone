<?php

namespace Drupal\popup\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * A controller class.
 */
class SettingController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function setting() {
    $set = [];
    $set['contain'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'setwrap',
      ],
    ];
    $set['contain']['changepass'] = [
      '#type' => 'html_tag',
      '#tag' => 'button',
          [
            '#type' => 'html_tag',
            '#tag' => 'a',
            '#attributes' => [
              'href' => ['/changepass'],
            ],
            '#value' => 'Change Password',
          ],
    ];
    $set['contain']['nametag'] = [
      '#type' => 'html_tag',
      '#tag' => 'button',
          [
            '#type' => 'html_tag',
            '#tag' => 'a',
            '#attributes' => [
              'href' => ['/nametag'],
            ],
            '#value' => 'Nametag',
          ],
    ];
    $set['contain']['apps'] = [
      '#type' => 'html_tag',
      '#tag' => 'button',
          [
            '#type' => 'html_tag',
            '#tag' => 'a',
            '#attributes' => [
              'href' => ['/apps'],
            ],
            '#value' => 'Apps And Websites',
          ],
    ];
    $set['contain']['notification'] = [
      '#type' => 'html_tag',
      '#tag' => 'button',
          [
            '#type' => 'html_tag',
            '#tag' => 'a',
            '#attributes' => [
              'href' => ['/notification'],
            ],
            '#value' => 'Notification',
          ],
    ];
    $set['contain']['privacy'] = [
      '#type' => 'html_tag',
      '#tag' => 'button',
          [
            '#type' => 'html_tag',
            '#tag' => 'a',
            '#attributes' => [
              'href' => ['/privacy'],
            ],
            '#value' => 'Privacy and Security',
          ],
    ];
    $set['contain']['loginactivity'] = [
      '#type' => 'html_tag',
      '#tag' => 'button',
          [
            '#type' => 'html_tag',
            '#tag' => 'a',
            '#attributes' => [
              'href' => ['/loginactivity'],
            ],
            '#value' => 'Login Activity',
          ],
    ];
    $set['contain']['instamail'] = [
      '#type' => 'html_tag',
      '#tag' => 'button',
      [
        '#type' => 'html_tag',
        '#tag' => 'a',
        '#attributes' => [
          'href' => ['/instamail'],
        ],
        '#value' => 'Emails from Instagram',
      ],
    ];
    $set['contain']['report'] = [
      '#type' => 'html_tag',
      '#tag' => 'button',
      [
        '#type' => 'html_tag',
        '#tag' => 'a',
        '#attributes' => [
          'href' => ['/report'],
        ],
        '#value' => 'Report a Problem',
      ],
    ];
    $set['contain']['logout'] = [
      '#type' => 'html_tag',
      '#tag' => 'button',
      [
        '#type' => 'html_tag',
        '#tag' => 'a',
        '#attributes' => [
          'href' => ['/user/logout'],
        ],
        '#value' => 'Logout',
      ],
    ];
    $set['contain']['cancel'] = [
      '#type' => 'html_tag',
      '#tag' => 'button',
      [
        '#type' => 'html_tag',
        '#tag' => 'a',
        '#attributes' => [
          'href' => ['#'],
          'class' => ['cancel'],
        ],
        '#value' => 'Cancel',
      ],
    ];
    $set['#attached']['library'][] = 'popup/global';
    return $set;
  }

}
