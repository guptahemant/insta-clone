<?php

namespace Drupal\instaform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Drupal\Component\Serialization\Json;
use Drupal\Core\TempStore\PrivateTempStoreFactory;

/**
 * A class to create form to edit user's data.
 */
class UserEditForm extends FormBase {

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
    return 'usereditform';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $uid = $this->account->id();
    if ($uid) {
      $user = $this->entityTypeManager->getStorage('user')->load($uid);
      $name = $user->get('name')->value;
      $fullname = $user->get('field_full_name')->value;
      $bio = $user->get('field_bio')->value;
      $mail = $user->get('mail')->value;

      $phone = $user->get('field_phone')->value;
      $website = $user->get('field_website')->value;

      $picture = $user->user_picture->entity->getFileName();

      if (!$user->user_picture->isEmpty()) {
        $pic = $picture;
      }
      else {
        $pic = '';
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
        'src' => ['../sites/default/files/pictures/2022-03/' . $pic],
      ],
    ];

    $form['userfile']['userdatafile'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'userdatafile',
      ],
    ];

    $form['userfile']['userdatafile']['namedisplay'] = [
      '#title' => $this->t('%name', ['%name' => $name]),
      '#type' => 'item',
    ];

    $form['userfile']['userdatafile']['file_example_fid'] = [
      '#type' => 'link',
      '#title' => $this->t('Change Profile photo'),
      '#attributes' => [
        'class' => ['use-ajax', 'button', 'button--small', 'profile-link'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode([
          'width' => 400,
          'title' => 'Change Profile Photo',
        ]),
      ],
      '#url' => Url::fromRoute('profile.image_edit'),
    ];

    $form['namediv'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'inputdiv',
      ],
    ];
    $form['namediv']['namelabel'] = [
      '#title' => $this->t('Name'),
      '#type' => 'item',
      '#attributes' => [
        'class' => 'label',
      ],
    ];

    $form['namediv']['name'] = [
      '#type' => 'container',
    ];
    $form['namediv']['name']['nameblock'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Name'),
      '#default_value' => (isset($fullname)) ? $this->t('%fullname', ['%fullname' => $fullname]) : '',
    ];
    $form['namediv']['name']['namedesc'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => "Help people discover your account by using the name that you're known by: either your full name, nickname or business name.",
    ];
    $form['namediv']['name']['namedescr'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => "You can only change your name twice within 14 days.",
    ];

    $form['usernamediv'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'inputdiv',
      ],
    ];
    $form['usernamediv']['usernamelabel'] = [
      '#type' => 'item',
      '#title' => $this->t('Username'),
    ];
    $form['usernamediv']['username'] = [
      '#type' => 'container',
    ];
    $form['usernamediv']['username']['usernameblock'] = [
      '#type' => 'textfield',
      '#default_value' => (isset($name)) ? $this->t('%name', ['%name' => $name]) : '',
      '#placeholder' => $this->t('Username'),
    ];
    $form['usernamediv']['username']['userdesc'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => "In most cases, you'll be able to change your username back to $name for another 14 days.",
    ];

    $form['websitediv'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'inputdiv',
      ],
    ];
    $form['websitediv']['websitelabel'] = [
      '#type' => 'item',
      '#title' => $this->t('Website'),
    ];
    $form['websitediv']['website'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Website'),
      '#default_value' => (isset($website)) ? $this->t('%website', ['%website' => $website]) : '',
    ];

    $form['biodiv'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'inputdiv',
      ],
    ];
    $form['biodiv']['bionamelabel'] = [
      '#type' => 'item',
      '#title' => $this->t('Bio'),
    ];
    $form['biodiv']['bioname'] = [
      '#type' => 'container',
    ];
    $form['biodiv']['bioname']['bionameblock'] = [
      '#type' => 'textarea',
      '#default_value' => (isset($bio)) ? $this->t('@bio', ['@bio' => $bio]) : '',
    ];
    $form['biodiv']['bioname']['biodesc'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => "<h4>Personal information</h4><p>Provide your personal information, even if the account is used for a business, pet or something else. This won't be part of your public profile.</p>",
    ];

    $form['emaildiv'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'inputdiv',
      ],
    ];
    $form['emaildiv']['emaillabel'] = [
      '#type' => 'item',
      '#title' => $this->t('Email Address'),

    ];
    $form['emaildiv']['email'] = [
      '#type' => 'email',
      '#placeholder' => $this->t('Email Address'),
      '#default_value' => (isset($mail)) ? $this->t('%mail', ['%mail' => $mail]) : '',
    ];

    $form['phonenodiv'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => 'inputdiv',
      ],
    ];
    $form['phonenodiv']['phonelabel'] = [
      '#type' => 'item',
      '#title' => $this->t('Phone number'),
    ];
    $form['phonenodiv']['phoneno'] = [
      '#type' => 'tel',
      '#placeholder' => $this->t('Phone number'),
      '#default_value' => (isset($phone)) ? $this->t('%phone', ['%phone' => $phone]) : '',
    ];

    $form['candidate_copy'] = [
      '#type' => 'checkboxes',
      '#options' => ['suggestions' => $this->t('Include your account when recommending similar accounts that people might want to follow')],
      '#title' => $this->t('Similar account suggestions'),
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#attributes' => [
        'class' => ['submituserform'],
      ],
    ];
    $form['#attached']['library'][] = 'instaform/global-styling';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $value = $form_state->getUserInput();
    $fullname = $value['nameblock'];
    $name = $value['usernameblock'];
    $bio = $value['bionameblock'];
    $mail = $value['email'];
    $website = $value['website'];
    $phone = $value['phoneno'];

    $uid = $this->account->id();
    $user = $this->entityTypeManager->getStorage('user')->load($uid);

    $user->field_full_name->value = $fullname;
    $user->name->value = $name;
    $user->field_bio->value = $bio;
    $user->mail->value = $mail;
    $user->field_website->value = $website;
    $user->field_phone->value = $phone;

    $user->save();

  }

}
