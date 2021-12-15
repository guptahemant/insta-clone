<?php

namespace Drupal\link_icons\Form;

use Drupal\Core\Entity\EntityDeleteForm;

/**
 * Provides a form for deleting a date range format.
 *
 * @package Drupal\daterange_compact\Form
 */
class LinkIconServiceFormDelete extends EntityDeleteForm {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the link icon service %name?', ['%name' => $this->entity->label()]);
  }

}
