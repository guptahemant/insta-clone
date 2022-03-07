<?php

namespace Drupal\dino_roar\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\core\Link;


/**
 * This example uses Ajax for one dropdown based on the value of another.
 */

  class ajaxForm extends FormBase {
   /**
    * {@inheritdoc} 
    */

    public function getFormId() {
        return 'ajax_form_api';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
      $form['name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Enter your name'),
        '#description' => $this->t('Enter your name'),
        '#prefix' => '<h2 id="name-result"></h2>',
      ];
    
      $form['actions'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
        '#ajax' => [
          'callback' => '::checkName',
          'progress' => [
            'type' => 'throbber',
            'message' => 'Loading',
          ],
        ],
      ];
      return $form;
    }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if(count($name) <= 5){
        $form['abcd'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#ajax' => [
              'callback' => '::checkName',
              'progress' => [
                'type' => 'throbber',
                'message' => 'Loading',
              ],
            ],
          ];
    }  
    else {

    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * Callback for submit action example.
   */
  public function checkName(array $form, FormStateInterface $form_state) {
    $ajax_response = new AjaxResponse();

    $name = $form_state->getValue('name');
    $ajax_response->addCommand(new HtmlCommand('#name-result', $name));

    return $ajax_response;
  }


   
    // public function getFormId() {
    //   return ajax_api_form_id();
    // }

    // /**
    // * {@inheritdoc} 
    // */

    // public function buildForm(array $form, FormStateInterface $form_state) {
        
    //   $instrument_family_options = static::getFirstDropdownOptions();
    //   if (empty($form_state->getValue('instrument_family_dropdown'))) {
    //     // Use a default value.
    //     $selected_family = key($instrument_family_options);
    //   }
    //   else {
    //     $selected_family = $form_state->getValue('instrument_family_dropdown');
    //   }
      
    //   $form['instrument_family_fieldset'] = [
    //     '#type' => 'fieldset',
    //     '#title' => $this->t('Choose an instrument family'),
    //   ];


    //   $form['instrument_family_fieldset']['instrument_family_dropdown'] = [
    //     '#type' => 'select',
    //     '#title' => $this->t('Instrument Type'),
    //     '#options' => $instrument_family_options,
    //     '#default_value' => $selected_family,
    //     // Bind an Ajax callback to the element.
    //     '#ajax' => [
    //       // Name of the method to call. This will be responsible for returning
    //       // a response, and will be called after submitForm() when processing an
    //       // Ajax request.
    //       'callback' => '::instrumentDropdownCallback',
    //       'wrapper' => 'instrument-fieldset-container',
    //       // The 'event' key can be used to determine what event will trigger the
    //       // Ajax request. Generally this can be left blank and Drupal will figure
    //       // out a sane default depending on the element type. However, you can
    //       // use this to specify any valid jQuery event such as, 'mousedown', 
    //       // 'blur', or 'submit'.
    //       'event' => 'change',
    //     ],
    //   ];

    //   $form['instrument_family_fieldset']['choose_family'] = [
    //     '#type' => 'submit',
    //     '#value' => $this->t('Choose'),
    //     // This hides the button using the #states system. Because #states relies
    //     // on JavaScript, if it's not available this button won't be hidden.
    //     // You could also do this using CSS or custom JS.
    //     '#states' => [
    //       'visible' => ['body' => ['value' => TRUE]],
    //     ],
    //   ];
    //   $form['instrument_fieldset_container'] = [
    //     '#type' => 'container',
    //     // Note that the ID here matches with the 'wrapper' value use for the
    //     // instrument family field's #ajax property.
    //     '#attributes' => ['id' => 'instrument-fieldset-container'],
    //   ];
      
    //   $form['instrument_fieldset_container']['instrument_fieldset'] = [
    //     '#type' => 'fieldset',
    //     '#title' => $this->t('Choose an instrument'),
    //   ];
      
    //   $form['instrument_fieldset_container']['instrument_fieldset']['instrument_dropdown'] = [
    //     '#type' => 'select',
    //     '#title' => $instrument_family_options[$selected_family] . ' ' . $this->t('Instruments'),
    //     // When the form is rebuilt during Ajax processing, the $selected_family
    //     // variable will contain the current value of the instrument family field
    //     // and so the options will change here to reflect that.
    //     '#options' => static::getSecondDropdownOptions($selected_family),
    //     '#default_value' => !empty($form_state->getValue('instrument_dropdown')) ? $form_state->getValue('instrument_dropdown') : '',
    //   ];

    //   // This submit button triggers a normal (non Ajax) submission of the form.
    //   $form['instrument_fieldset_container']['instrument_fieldset']['submit'] = [
    //     '#type' => 'submit',
    //     '#value' => $this->t('Submit'),
    //   ];

    //   if ($selected_family == 'none') {
    //     // Change the field title to provide user with some feedback on why the
    //     // field is disabled.
    //     $form['instrument_fieldset_container']['instrument_fieldset']['instrument_dropdown']['#title'] = $this->t('You must choose an instrument family first.');
    //     $form['instrument_fieldset_container']['instrument_fieldset']['instrument_dropdown']['#disabled'] = TRUE;
    //     $form['instrument_fieldset_container']['instrument_fieldset']['submit']['#disabled'] = TRUE;
    //   }
  
    //   return $form;
    // }
    // public function submitForm(array &$form, FormStateInterface $form_state) {
    //     // Figure out what element triggered the form submission. If it was the
    //     // main "Submit" button, process the form as per usual. If it's anything else
    //     // like the #ajax on the select field, set the rebuild flag so that the form
    //     // is rebuilt before executing the Ajax callback.
    //     $trigger = (string) $form_state->getTriggeringElement()['#value'];
    //     if ($trigger == 'Submit') {
    //       // Process submitted form data.
    //       $this->messenger->addStatus($this->t('Your values have been submitted. Instrument family: @family, Instrument: @instrument', [
    //         '@family' => $form_state->getValue('instrument_family_dropdown'),
    //         '@instrument' => $form_state->getValue('instrument_dropdown'),
    //       ]));
    //     }
    //     else {
    //       // Rebuild the form. This causes buildForm() to be called again before the
    //       // associated Ajax callback. Allowing the logic in buildForm() to execute
    //       // and update the $form array so that it reflects the current state of
    //       // the instrument family select list.
    //       $form_state->setRebuild();
    //     }
    //   }

    //   public function instrumentDropdownCallback(array $form, FormStateInterface $form_state) {
    //     return $form['instrument_fieldset_container'];
    //   }

    //   public static function getFirstDropdownOptions() {
    //     return [
    //       'none' => 'none',
    //       'String' => 'String',
    //       'Woodwind' => 'Woodwind',
    //       'Brass' => 'Brass',
    //       'Percussion' => 'Percussion',
    //     ];
    //   }

    //   public static function getSecondDropdownOptions($key = '') {
    //     switch ($key) {
    //       case 'String':
    //         $options = [
    //           'Violin' => 'Violin',
    //           'Viola' => 'Viola',
    //           'Cello' => 'Cello',
    //           'Double Bass' => 'Double Bass',
    //         ];
    //         break;
    
    //       case 'Woodwind':
    //         $options = [
    //           'Flute' => 'Flute',
    //           'Clarinet' => 'Clarinet',
    //           'Oboe' => 'Oboe',
    //           'Bassoon' => 'Bassoon',
    //         ];
    //         break;
    
    //       case 'Brass':
    //         $options = [
    //           'Trumpet' => 'Trumpet',
    //           'Trombone' => 'Trombone',
    //           'French Horn' => 'French Horn',
    //           'Euphonium' => 'Euphonium',
    //         ];
    //         break;
    
    //       case 'Percussion':
    //         $options = [
    //           'Bass Drum' => 'Bass Drum',
    //           'Timpani' => 'Timpani',
    //           'Snare Drum' => 'Snare Drum',
    //           'Tambourine' => 'Tambourine',
    //         ];
    //         break;
    
    //       default:
    //         $options = ['none' => 'none'];
    //         break;
    //     }
    //     return $options;
    //   }
    
 }