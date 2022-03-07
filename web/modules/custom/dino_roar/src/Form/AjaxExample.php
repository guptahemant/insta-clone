<?php 

namespace Drupal\dino_roar\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Submit a form without a page reload.
 */
class AjaxExample extends FormBase {

  /**
   * {@inheritdoc}
   */
  
    public function getFormId() {
      return 'ajax_api_form_id';
    }

    /**
    * {@inheritdoc} 
    */

    public function buildForm(array $form, FormStateInterface $form_state) {
        
      $instrument_family_options = static::getFirstDropdownOptions();
      if (empty($form_state->getValue('instrument_family_dropdown'))) {
        // Use a default value.
        $selected_family = key($instrument_family_options);
      }
      else {
        $selected_family = $form_state->getValue('instrument_family_dropdown');
      }
      
      $form['instrument_family_fieldset'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Choose an instrument family'),
      ];


      $form['instrument_family_fieldset']['instrument_family_dropdown'] = [
        '#type' => 'select',
        '#title' => $this->t('Instrument Type'),
        '#options' => $instrument_family_options,
        '#default_value' => $selected_family,
        // Bind an Ajax callback to the element.
        '#ajax' => [
          // Name of the method to call, and will be called after submitForm() when processing an
          // Ajax request.
          'callback' => '::instrumentDropdownCallback',
          'wrapper' => 'instrument-fieldset-container',
          'event' => 'change',
        ],
      ];

      $form['instrument_family_fieldset']['choose_family'] = [
        '#type' => 'submit',
        '#value' => $this->t('Choose'),
        '#states' => [
          'visible' => ['body' => ['value' => TRUE]],
        ],
      ];
      $form['instrument_fieldset_container'] = [
        '#type' => 'container',
        // Note that the ID here matches with the 'wrapper' value use for the
        // instrument family field's #ajax property.
        '#attributes' => ['id' => 'instrument-fieldset-container'],
      ];
      
      $form['instrument_fieldset_container']['instrument_fieldset'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Choose an instrument'),
      ];
      
      $form['instrument_fieldset_container']['instrument_fieldset']['instrument_dropdown'] = [
        '#type' => 'select',
        '#title' => $instrument_family_options[$selected_family] . ' ' . $this->t('Instruments'),
        // When the form is rebuilt after dropdown selected, the options will change here f=on the second dropdown.
        '#options' => static::getSecondDropdownOptions($selected_family),
        '#default_value' => !empty($form_state->getValue('instrument_dropdown')) ? $form_state->getValue('instrument_dropdown') : '',
      ];

      $form['instrument_fieldset_container']['instrument_fieldset']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
      ];

      if ($selected_family == 'none') {
        // Change the field title to provide user with some feedback on why the field is disabled.
        $form['instrument_fieldset_container']['instrument_fieldset']['instrument_dropdown']['#title'] = $this->t('You must choose an instrument family first.');
        $form['instrument_fieldset_container']['instrument_fieldset']['instrument_dropdown']['#disabled'] = TRUE;
        $form['instrument_fieldset_container']['instrument_fieldset']['submit']['#disabled'] = TRUE;
      }
  
      return $form;
    }
    public function submitForm(array &$form, FormStateInterface $form_state) {
      $trigger = (string) $form_state->getTriggeringElement()['#value'];
        if ($trigger == 'Submit') {
          // Process submitted form data.
          $this->messenger->addStatus($this->t('Your values have been submitted. Instrument family: @family, Instrument: @instrument', [
            '@family' => $form_state->getValue('instrument_family_dropdown'),
            '@instrument' => $form_state->getValue('instrument_dropdown'),
          ]));
        }
        else {
          $form_state->setRebuild();
        }
      }

      public function instrumentDropdownCallback(array $form, FormStateInterface $form_state) {
        return $form['instrument_fieldset_container'];
      }

      public static function getFirstDropdownOptions() {
        return [
          'none' => 'none',
          'String' => 'String',
          'Woodwind' => 'Woodwind',
          'Brass' => 'Brass',
          'Percussion' => 'Percussion',
        ];
      }

      public static function getSecondDropdownOptions($key = '') {
        switch ($key) {
          case 'String':
            $options = [
              'Violin' => 'Violin',
              'Viola' => 'Viola',
              'Cello' => 'Cello',
              'Double Bass' => 'Double Bass',
            ];
            break;
    
          case 'Woodwind':
            $options = [
              'Flute' => 'Flute',
              'Clarinet' => 'Clarinet',
              'Oboe' => 'Oboe',
              'Bassoon' => 'Bassoon',
            ];
            break;
    
          case 'Brass':
            $options = [
              'Trumpet' => 'Trumpet',
              'Trombone' => 'Trombone',
              'French Horn' => 'French Horn',
              'Euphonium' => 'Euphonium',
            ];
            break;
    
          case 'Percussion':
            $options = [
              'Bass Drum' => 'Bass Drum',
              'Timpani' => 'Timpani',
              'Snare Drum' => 'Snare Drum',
              'Tambourine' => 'Tambourine',
            ];
            break;
    
          default:
            $options = ['none' => 'none'];
            break;
        }
        return $options;
      }
}
  