<?php

namespace Drupal\hashtags\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field\Entity\FieldConfig;
use Drupal\Core\Url;

/**
 * {@inheritdoc}
 */
class ConfirmDeleteForm extends ConfirmFormBase {
  /**
   * The Entity type property.
   *
   * @var string
   */
  private $entityType;

  /**
   * The Entity bundle property.
   *
   * @var string
   */
  private $bundle;

  /**
   * Returns the question to ask the user.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   The form question. The page title will be set to this value.
   */
  public function getQuestion() {
    $entity_type_label = _hashtags_get_entity_type_label($this->entityType);
    $bundle_label = _hashtags_get_bundle_label($this->entityType, $this->bundle);
    $source = $this->entityType !== $this->bundle ?
                  ($entity_type_label . ' > ' . $bundle_label) :
                  $entity_type_label;
    return $this->t("Are you sure you want to remove hashtags for <em>@source</em>?", ['@source' => $source]);
  }

  /**
   * Returns the route to go to if the user cancels the action.
   *
   * @return \Drupal\Core\Url
   *   A URL object.
   */
  public function getCancelUrl() {
    return new Url('hashtags.manager_form');
  }

  /**
   * {@inheritdoc}
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   Return translated string.
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'hashtags_delete_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form,
                              FormStateInterface $form_state,
                              $entity_type = '',
  $bundle = '') {
    $this->entityType = $entity_type;
    $this->bundle = $bundle;

    return parent::buildForm($form, $form_state);
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $hashtags_field_name = \Drupal::config('hashtags.settings')
      ->get('hashtags_taxonomy_terms_field_name');
    $hashtags_field = FieldConfig::loadByName($this->entityType,
                                       $this->bundle,
                                       $hashtags_field_name);
    if (!empty($hashtags_field)) {
      $hashtags_field->delete();
      \Drupal::messenger()->addMessage('Hashtags field has been removed.');
      $activated_text_fields = _hashtags_get_activated_text_fields($this->entityType, $this->bundle);
      foreach ($activated_text_fields as $field_name) {
        $text_field = \Drupal::entityTypeManager()
          ->getStorage('field_config')
          ->load("{$this->entityType}.{$this->bundle}.{$field_name}");
        if (!empty($text_field)) {
          $text_field->unsetThirdPartySetting('hashtags', 'hashtags_activate');
          $text_field->save();
          \Drupal::messenger()->addMessage("Hashtags has been diactivated for {$field_name} field.");
        }
      }
    }
    $form_state->setRedirectUrl(new Url('hashtags.manager_form'));
  }

}
