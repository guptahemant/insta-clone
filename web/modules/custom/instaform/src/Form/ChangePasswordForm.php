<?php

namespace Drupal\instaform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Password\PasswordInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileUrlGenerator;

/**
 * {@inheritdoc}
 */
class ChangePasswordForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(PasswordInterface $password_hasher, AccountInterface $account, EntityTypeManagerInterface $entity_type_manager, FileUrlGenerator $fileUrlGenerator) {
    $this->passwordHasher = $password_hasher;
    $this->account = $account;
    $this->entityTypeManager = $entity_type_manager;
    $this->fileUrlGenerator = $fileUrlGenerator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('password'),
      $container->get('current_user'),
      $container->get('entity_type.manager'),
      $container->get('file_url_generator'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'changepasswordform';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $uid = $this->account->id();

    if ($uid) {
      $user = $this->entityTypeManager->getStorage('user')->load($uid);
      $name = $user->get('name')->value;

      $picture = '../sites/default/files/pictures/2022-03/instadefault.jpg';

      if (!$user->user_picture->isEmpty()) {
        $pic = $user->user_picture->entity->getFileUri();
        $picture = $this->fileUrlGenerator->generateString($pic);
      }

    }

    $form['userfile'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'userfile',
      ],
    ];
    $form['userfile']['userimg'] = [
      '#type' => 'html_tag',
      '#tag' => 'img',
      '#attributes' => [
        'class' => 'profilefield',
        'src' => [$picture],
      ],
    ];
    $form['userfile']['usersname'] = [
      '#title' => $this->t('%name', ['%name' => $name]),
      '#type' => 'label',
      '#attributes' => [
        'class' => 'usersname',
      ],
    ];

    $form['old'] = [
      '#type' => 'password',
      '#title' => $this->t('Old Password'),
    ];

    $form['new'] = [
      '#type' => 'password',
      '#title' => $this->t('New Password'),
    ];

    $form['confirm'] = [
      '#type' => 'password',
      '#title' => $this->t('Confirm New Password'),
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Change Password'),
      '#attributes' => [
        'class' => ['changepass'],
      ],
    ];
    $form['#attached']['library'][] = 'instaform/global-styling';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $old = $form_state->getValue('old');
    $new = $form_state->getValue('new');
    $confirm = $form_state->getValue('confirm');

    $uid = $this->account->id();
    if ($uid) {
      $user = $this->entityTypeManager->getStorage('user')->load($uid);
      $pass = $user->get('pass')->value;
    }
    if ($pass) {
      $checkpass = $this->passwordHasher->check($old, $pass);

      if ($checkpass) {
        if ($new == $confirm) {
          $user->setPassword($new);
          $user->save();
        }

      }
    }

  }

}
