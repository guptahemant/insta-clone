<?php

namespace Drupal\signupform\Form;

use Drupal\user\Entity\User;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Submit a personal details form.
 */
class Personform extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $database;

  /**
   * Contruct method to get Services.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   Service.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
          $container->get('database')
      );
  }

  /**
   * Getter method for Form ID.
   *
   * @return string
   *   The unique ID of the form defined by this class.
   */
  public function getFormId() {
    return 'personalForm';
  }

  /**
   * Build the simple form.
   *
   * @param array $form
   *   Default form array structure.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Object containing current form state.
   *
   * @return array
   *   The render array defining the elements of the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['Heading'] = [
      '#markup' => '<div class="insta_head"></div>',
    ];

    $form['description'] = [
      '#markup' => '<div class="signup-description">Signup to see photos and media from your friends</div>',
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First name'),
      '#description' => $this->t('Enter firstname.'),
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['fullname'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['username'] = [
      '#type' => 'textfield',
      '#description' => $this->t('Enter firstname.'),
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['pass'] = [
      '#type' => 'password',
      '#description' => $this->t('Enter Last name.'),
      '#required' => TRUE,
      '#default_value' => '',
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Sign Up'),
    ];

    return $form;
  }

  /**
   * Implements a form submit handler.
   *
   * @param array $form
   *   The render array of the currently built form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Object describing the current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $user = User::create();

    $user->setPassword($form_state->getValue('pass'),);
    $user->enforceIsNew();
    $user->setEmail($form_state->getValue('name'));
    $user->setUsername($form_state->getValue('username'));
    $user->activate();

    // Save user account.
    $result = $user->save();
    if ($result) {

      user_login_finalize($user);
      $form_state->setRedirect('<front>');

      return;
    }
    else {
      $this->messenger()->addStatus($this->t('Error!'));
    }
  }

}
