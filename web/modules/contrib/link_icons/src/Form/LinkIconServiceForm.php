<?php

namespace Drupal\link_icons\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a form for editing link icon services.
 *
 * @package Drupal\link_icons\Form
 */
class LinkIconServiceForm extends EntityForm {

  /**
   * Array of hostnames.
   *
   * @var array
   */
  protected $hostnames;

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /*
     * @var \Drupal\link_icons\Entity\LinkIconServiceInterface $service
     */
    $service = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $service->label(),
      '#description' => $this->t("Name of the link icon service."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $service->id(),
      '#machine_name' => [
        'exists' => '\Drupal\link_icons\Entity\LinkIconService::load',
      ],
      '#disabled' => !$service->isNew(),
    ];

    // Gather the quantity of hostnames in the form already.
    $quantity = $form_state->get('quantity');
    // We have to ensure that there is at least one name field.
    if ($quantity === NULL) {
      $quantity = is_array($service->get('hostnames')) ? count($service->get('hostnames')) : 1;
      $form_state->set('quantity', $quantity);
    }

    $form['#tree'] = TRUE;
    $form['hostnames_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Hostnames'),
      '#prefix' => '<div id="hostnames-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];

    for ($i = 0; $i < $quantity; $i++) {
      $form['hostnames_fieldset']['hostname'][$i] = [
        '#type' => 'textfield',
        '#title' => $this->t('Hostname'),
        '#default_value' => $service->get('hostnames')[$i] ?: '',
        '#maxlength' => 255,
        '#description' => $this->t("The end of the hostname in the URL of the link, ex. 'google.com'"),
      ];
    }
    $form['hostnames_fieldset']['hostname'][0]['#required'] = TRUE;

    $form['hostnames_fieldset']['actions'] = [
      '#type' => 'actions',
    ];
    $form['hostnames_fieldset']['actions']['add_hostname'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add another'),
      '#submit' => ['::addOne'],
      '#ajax' => [
        'callback' => '::addmoreCallback',
        'wrapper' => 'hostnames-fieldset-wrapper',
      ],
    ];
    // If there is more than one name, add the remove button.
    if ($quantity > 1) {
      $form['hostnames_fieldset']['actions']['remove_hostname'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove last'),
        '#submit' => ['::removeCallback'],
        '#ajax' => [
          'callback' => '::addmoreCallback',
          'wrapper' => 'hostnames-fieldset-wrapper',
        ],
      ];
    }

    $form['class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Class'),
      '#default_value' => $service->get('class') ?: '',
      '#maxlength' => 255,
      '#description' => $this->t("The HTML class name to use when generating the link icon, ex. 'google', will default to the machine name (above) if empty"),
      '#required' => FALSE,
    ];

    $form['icon'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Icon name'),
      '#default_value' => $service->get('icon') ?: '',
      '#maxlength' => 255,
      '#size' => 20,
      '#description' => $this->t("The main Font Awesome icon ID to use when generating the link icon, without any preceeding 'fa-', ex. 'google'"),
      '#required' => TRUE,
    ];

    $form['icon_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Icon style'),
      '#default_value' => $service->get('icon_style') ?: '',
      '#description' => $this->t("The main Font Awesome icon style to use when generating the link icon, ex. 'solid' or 'brand'"),
      '#required' => TRUE,
      '#options' => [
        'solid' => $this->t('Solid'),
        'regular' => $this->t('Regular'),
        'light' => $this->t('Light'),
        'duotone' => $this->t('Duotone'),
        'brand' => $this->t('Brand'),
      ],
    ];

    $form['icon_square'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Square icon name'),
      '#default_value' => $service->get('icon_square') ?: '',
      '#maxlength' => 255,
      '#size' => 20,
      '#description' => $this->t("A square Font Awesome icon ID to use when generating the link icon, without any preceeding 'fa-', ex. 'google-plus-square'"),
      '#required' => FALSE,
    ];

    $form['icon_circle'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Circular icon name'),
      '#default_value' => $service->get('icon_circle') ?: '',
      '#maxlength' => 255,
      '#size' => 20,
      '#description' => $this->t("A circular Font Awesome icon ID to use when generating the link icon, without any preceeding 'fa-', ex. 'google-plus-circle'"),
      '#required' => FALSE,
    ];

    $form['color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Icon colour'),
      '#default_value' => $service->get('color') ?: '',
      '#maxlength' => 255,
      '#size' => 20,
      '#description' => $this->t("The CSS 'color' to use when generating the link icon, ex. 'black', '#000000' or 'rgb(0, 0, 0)'"),
      '#required' => FALSE,
    ];

    return $form;
  }

  /**
   * Callback for both ajax-enabled buttons.
   *
   * Selects and returns the fieldset with the names in it.
   */
  public function addmoreCallback(array &$form, FormStateInterface $form_state) {
    return $form['hostnames_fieldset'];
  }

  /**
   * Submit handler for the "add-one-more" button.
   *
   * Increments the max counter and causes a rebuild.
   */
  public function addOne(array &$form, FormStateInterface $form_state) {
    $hostname_field = $form_state->get('quantity');
    $add_button = $hostname_field + 1;
    $form_state->set('quantity', $add_button);
    $form_state->setRebuild();
  }

  /**
   * Submit handler for the "remove one" button.
   *
   * Decrements the max counter and causes a form rebuild.
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $hostname_field = $form_state->get('quantity');
    if ($hostname_field > 1) {
      $remove_button = $hostname_field - 1;
      $form_state->set('quantity', $remove_button);
    }
    $form_state->setRebuild();
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $hostnames = [];
    for ($x = 0; $x < $form_state->get('quantity'); $x++) {
      $hostnames[] = $form['hostnames_fieldset']['hostname'][$x]['#value'];
    }
    $this->entity->hostnames = $hostnames;

    $link_icon_service = $this->entity;
    $status = $link_icon_service->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label link icon service.', [
          '%label' => $link_icon_service->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Updated the %label link icon service.', [
          '%label' => $link_icon_service->label(),
        ]));
    }
    return $form_state->setRedirectUrl($link_icon_service->toUrl('collection'));
  }

}
