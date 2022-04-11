<?php

namespace Drupal\instaform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\TempStore\PrivateTempStoreFactory;

/**
 * A class to update and remove user image.
 */
class Editimage extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(MessengerInterface $msg, AccountInterface $account, EntityTypeManagerInterface $entity_type_manager, PrivateTempStoreFactory $tempstore_private) {
    $this->messenger = $msg;
    $this->account = $account;
    $this->entityTypeManager = $entity_type_manager;
    $this->tempstore_private = $tempstore_private;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('current_user'),
      $container->get('entity_type.manager'),
      $container->get('tempstore.private')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'editform';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['imagefile'] = [
      '#title' => $this->t('Upload Photo'),
      '#type' => 'managed_file',
      '#upload_location' => 'public://pictures/2022-03/',
      '#attributes' => [
        'class' => ['imagefile'],
      ],
    ];

    $form['actions']['remove'] = [
      '#type' => 'submit',
      '#value' => $this->t('Remove current photo'),
      '#attributes' => [
        'class' => ['removeimage'],
      ],
      '#submit' => ['::removeImage'],
    ];

    $form['actions']['cancel'] = [
      '#type' => 'button',
      '#value' => $this->t('Cancel'),
      '#attributes' => [
        'class' => ['cancelform'],
        'onClick' => ['history.go(-1); event.preventDefault()'],
      ],
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#attributes' => [
        'class' => ['submitimage'],
      ],
      '#submit' => ['::submitImage'],
    ];

    $form['#attached']['library'][] = 'instaform/global-styling';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitImage(array &$form, FormStateInterface $form_state) {

    $photo = $form_state->getValue('imagefile');
    $file = $this->entityTypeManager->getStorage('file')->load($photo[0]);
    $file->setPermanent();
    $uid = $this->account->id();
    $user = $this->entityTypeManager->getStorage('user')->load($uid);
    $user->set('user_picture', $file);
    $user->save();
    $form_state->setRedirect('insta.my_form');
  }

  /**
   * {@inheritdoc}
   */
  public function removeImage(array &$form, FormStateInterface $form_state) {
    $uid = $this->account->id();
    $user = $this->entityTypeManager->getStorage('user')->load($uid);
    $user->set('user_picture', NULL);
    $user->save();

    $form_state->setRedirect('insta.my_form');
  }

}
