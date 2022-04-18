<?php

namespace Drupal\webcam\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\File\FileUrlGenerator;
use Drupal\Core\Extension\ExtensionList;
use Drupal\Core\State\State;

/**
 * A class to create form for creating node.
 */
class NodeWithCapture extends FormBase {

  /**
   * To Get the Current user details.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * To Load the file to database.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * To Load the file to database.
   *
   * @var \Drupal\Core\State\State
   */
  protected $state;

  /**
   * Class constructor.
   */
  public function __construct(AccountInterface $account, EntityTypeManagerInterface $entity_type_manager, FileUrlGenerator $fileUrlGenerator, ExtensionList $extensionList, State $state) {
    $this->account = $account;
    $this->entityTypeManager = $entity_type_manager;
    $this->fileUrlGenerator = $fileUrlGenerator;
    $this->extensionList = $extensionList;
    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
      // Load the service required to construct this class.
      $container->get('current_user'),
      $container->get('entity_type.manager'),
      $container->get('file_url_generator'),
      $container->get('extension.list.module'),
      $container->get('state'),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected $step = 1;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'multi_step_form';
  }

  /**
   * {@inheritdoc}
   *
   * @RenderElement("html_tag");
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $uid = $this->account->id();

    if ($uid) {

      $user = $this->entityTypeManager->getStorage('user')->load($uid);

      $picture = $user->user_picture->entity->getFileUri();
      $var = $this->fileUrlGenerator->generateString($picture);

      $name = $user->getAccountName();
    }
    $public_store = 'public://multifield_images/';
    $public = $this->fileUrlGenerator->generateString($public_store);
    $form['prefix'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => ['ajax_form_multistep_form'],
      ],
    ];

    if ($this->step == 1) {
      $fid = $this->state->get('fid');

      $public_store = 'public://capture/';
      $public = $this->fileUrlGenerator->generateString($public_store);
      $file = $this->entityTypeManager->getStorage('file')->load($fid);

      $uri = $file->getFileName();

      $form['prefix']['flex2'] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => ['flex2'],
        ],
      ];
      $form['prefix']['flex2']['my_file2'] = [
        '#type' => 'html_tag',
        '#tag' => 'img',
        '#attributes' => [
          'class' => ['nodeimage'],
          'src' => [$public . '/' . $uri],
        ],
      ];
      $form['prefix']['flex2']['data'] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => ['data'],
        ],
      ];
      $form['prefix']['flex2']['data']['current'] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => ['profilefield'],
        ],
        [
          '#type' => 'html_tag',
          '#tag' => 'img',
          '#attributes' => [
            'class' => ['picimage'],
            'src' => [$var],
          ],
        ],
        [
          '#type' => 'html_tag',
          '#tag' => 'div',
          '#attributes' => [
            'class' => ['profname'],
          ],
          '#value' => $name,
        ],
      ];
      $form['prefix']['flex2']['data']['body'] = [
        '#type' => 'textarea',
        '#required' => TRUE,
        '#default_value' => $form_state->getValue('body', ''),
        '#attributes' => [
          'class' => ['textbody'],
        ],
        '#placeholder' => 'Write a caption...',
      ];

      $form['prefix']['flex2']['data']['accesstitle'] = [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#value' => 'Accessibility  <i class="fas fa-angle-down"></i>',
        '#attributes' => [
          'class' => ['access-title'],
          'id' => ['accesstitle'],
        ],
      ];
      $form['prefix']['flex2']['data']['accessible'] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => ['accessibility'],
          'id' => ['accessibility'],
        ],
      ];
      $form['prefix']['flex2']['data']['accessible']['head'] = [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#attributes' => [
          'class' => ['access1'],
          'id' => ['access1'],
        ],
        '#value' => '<h2>Accessibility</h2>
        <i class="fas fa-angle-up"></i>',
      ];
      $form['prefix']['flex2']['data']['accessible']['para-text'] = [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#value' => '<p>Alt text describes your photos for people with visual impairments. Alt text will be automatically created for your photos or you can choose to write your own.</p>',
      ];
      $form['prefix']['flex2']['data']['accessible']['collapse'] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => ['collapse'],
        ],
      ];
      $form['prefix']['flex2']['data']['accessible']['collapse']['image'] = [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#attributes' => [
          'class' => ['alttext'],
        ],
        [
          '#type' => 'html_tag',
          '#tag' => 'img',
          '#attributes' => [
            'src' => [$public . '/' . $uri],
          ],
        ],
      ];
      $form['prefix']['flex2']['data']['accessible']['collapse']['textfield'] = [
        '#type' => 'textfield',
        '#placeholder' => ' Write alt Text',
      ];
      $form['buttons']['forward'] = [
        '#type' => 'submit',
        '#value' => $this->t('Share'),
        '#attributes' => [
          'class' => ['submitbutton'],
        ],
        '#ajax' => [
          'wrapper' => 'ajax_form_multistep_form',
          'callback' => '::ajaxFormMultistepFormAjaxCallback',
          'event' => 'click',
        ],
      ];
    }

    $module = $this->extensionList->getPath('createpost');

    if ($this->step == 2) {
      $form['prefix']['message-title'] = [
        '#type' => 'container',
        [
          '#type' => 'html_tag',
          '#tag' => 'img',
          '#attributes' => [
            'src' => [$module . '/inline-images/10a8cbeb94ba.gif'],
          ],
        ],
        '#attributes' => [
          'class' => ['complete'],
        ],
        '#value' => $this->t('Your post has been shared'),
      ];
    }

    $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $form['#attached']['library'][] = 'core/jquery.form';
    $form['#attached']['library'][] = 'webcam/global-styling';
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    if ($this->step == 1) {
      $fid = $this->state->get('fid');
      $body = $form_state->getValue('body');
      $alt = $form_state->getValue('textfield');

      $this->state->delete('fid');
      $node = $this->entityTypeManager->getStorage('node')->create([
        'type' => 'article',
        'title' => ' ',
      ]);
      $node->field_image[] = [
        'target_id' => $fid,
        'alt' => $alt,
        'title' => 'Title',
      ];
      $node->body[] = [
        'value' => $body,
        'format' => 'basic_html',
      ];
      $node->enforceIsNew();
      $node->save();
      $form_state->setRedirect('<front>');

    }

    $this->step++;
    $form_state->setRebuild();

  }

  /**
   * A Ajax callback to return the form.
   */
  public function ajaxFormMultistepFormAjaxCallback(
        array &$form,
        FormStateInterface $form_state
    ) {
    return $form;
  }

}
