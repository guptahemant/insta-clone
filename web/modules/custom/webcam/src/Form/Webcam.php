<?php

namespace Drupal\webcam\Form;

use Drupal\Core\Url;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * {@inheritdoc}
 */
class Webcam extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'webcam_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['videowrap'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#attributes' => [
        'class' => ['videowrap'],
        'id' => ['videowrap'],
      ],
      [
        '#type' => 'html_tag',
        '#tag' => 'video',
        '#attributes' => [
          'id' => ['video'],
          'playsinline autoplay' => '',
          'width' => ['320'],
          'height' => ['240'],
        ],

      ],
      [
        '#type' => 'html_tag',
        '#tag' => 'button',
        '#value' => 'Click',
        '#attributes' => [
          'id' => ['snap'],
        ],
      ],
      [
        '#type' => 'html_tag',
        '#tag' => 'canvas',
        '#attributes' => [
          'id' => ['canvas'],
          'width' => ['200'],
          'height' => ['200'],
        ],
      ],

          [
            '#type' => 'html_tag',
            '#tag' => 'button',
            '#value' => 'Upload',
            '#attributes' => [
              'id' => ['upload'],
            ],
          ],
          [
            '#type' => 'html_tag',
            '#tag' => 'button',
            '#attributes' => [
              'class' => ['submit1'],
            ],
            [
              '#type' => 'link',
              '#title' => $this->t('Submit'),
              '#url' => Url::fromRoute('webcam.open_capture_form'),
              '#attributes' => [
                'class' => 'use-ajax',
                'data-dialog-type' => 'modal',
                'data-dialog-options' => "Json::encode(['width' => 400])",
              ],
            ],
          ],

          [
            '#type' => 'html_tag',
            '#tag' => 'img',
            '#attributes' => [
              'id' => ['photo'],
              'name' => ['photo'],
            ],
          ],

    ];
    $form['#attached']['library'][] = 'webcam/global-styling';
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
