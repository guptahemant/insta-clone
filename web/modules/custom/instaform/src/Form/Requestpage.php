<?php

namespace Drupal\instaform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * {@inheritdoc}
 */
class Requestpage extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'requestpage';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['userfile']['usersname'] = [
      '#title' => $this->t('The Requested page could not found'),
      '#type' => 'label',
    ];

    $form['#attached']['library'][] = 'instaform/global-styling';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
