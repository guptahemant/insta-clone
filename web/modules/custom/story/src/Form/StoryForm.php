<?php

namespace Drupal\story\Form;

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
class StoryForm extends FormBase {
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
   * To Save The file.
   *
   * @var Drupal\Core\State\State
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
  public function getFormId() {
    return 'story_form';
  }

  /**
   * {@inheritdoc}
   *
   * @RenderElement("html_tag");
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $public_store = 'public://multifield_images/';

    $form['story_file'] = [
      '#type' => 'managed_file',
      '#upload_validators' => [
        'file_validate_extensions' => ['zip ZIP jpeg jpg png gif'],
      ],
      '#attributes' => [
        'class' => ['storyfile'],
        'id' => ['imagefornode'],
      ],
      '#upload_location' => $public_store,
    ];
    $form['button'] = [
      '#type' => 'submit',
      '#value' => $this->t('submit'),
      '#attributes' => [
        'class' => ['storysubmit'],
      ],
    ];

    $form['#attached']['library'][] = 'story/global-styling';
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $story = $form_state->getValue('story_file');
    $file = $this->entityTypeManager->getStorage('file')->load($story[0]);
    $file->setPermanent();
    $file->save();

    $node = $this->entityTypeManager->getStorage('node')->create([
      'type' => 'story',
      'title' => ' ',
    ]);
    $node->field_images[] = [
      'target_id' => $file->id(),
      'alt' => '  ',
      'title' => 'Title',
    ];
    $node->enforceIsNew();
    $node->save();
    $form_state->setRedirect('<front>');

  }

}
