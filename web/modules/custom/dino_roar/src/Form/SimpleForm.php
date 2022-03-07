<?php

namespace Drupal\dino_roar\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\dino_roar\Form\validateForm;
use Drupal\Core\Url;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

 
/**
* Implements a simple registration form.
*/
class SimpleForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'simple_form_id';
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container ){
    return new static(
      $container->get('tempstore.private')
    );
  }  

  /**
   * Private temporary storage factory.
   *
   * @var \Drupal\Core\TempStore\PrivateTempStoreFactory
   */
  private $tempStoreFactory;

  public function __construct(PrivatetempstoreFactory $tempStoreFactory) {
    $this->tempstoreFactory = $tempStoreFactory;
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['Fname'] = array (
      '#title' => t('First Name'),
      '#type' => 'textfield',
      '#size' => 25,
      '#required' => TRUE,
      '#placeholder' => t('First Name'),
      '#markup' => $this->t('The book asdad'),
      '#description' => t('First Name'),
    );

    // $form['Lname'] = array (
    //   '#title' => t('Second Name'),
    //   '#type' => 'textfield',
    //   '#size' => 25,
    //   '#required' => FALSE,
    //   '#placeholder' => t('Second Name'),
    //   '#description' => t('Second Name'),
    // );

    $form['email'] = array (
      '#title' => $this->t('Email Address'),
      '#type' => 'textfield',
      '#size' => 25,
      '#required' => TRUE,
      '#placeholder' => t('Email Address'),
      '#description' => t(''),
//      '#default_value' => $title ? $title : 'Default-JATINGUPTA'
    );

    $form['password'] = array (
      '#title' => t('Password'),
      '#type' => 'password',
      '#size' => 25,
      '#required' => TRUE,
      '#placeholder' => t('Password'),
      '#description' => t('Password'),
    );

    //  $form['Confirm_password'] = array (
    //    '#title' => t('Confirm Password'),
    //    '#type' => 'textfield',
    //    '#size' => 25,
    //    '#required' => TRUE,
    //    '#placeholder' => t('Confirm Password'),
    //    '#description' => t('Confirm Password'),
    //  );

    // $form['checkbox_yes'] = array (
    //   '#type' => 'checkbox',
    //   '#title' => 'Yes',
    //   '#description' => $this->t('Allow the use of a title with fewer.'),
    // );

    // $form['checkbox_no'] = array (
    //   '#type' => 'checkbox',
    //   '#title' => 'No',
    //   '#description' => $this->t('Allow the use of a title with fewer.'),
    // );

    // Dropdown Select Box
    // $form['direction'] = [
    //   '#title' => $this->t('Choose :'),
    //   '#type' => 'select',
    //   '#options' => [
    //     'right' => $this->t(Right),
    //     'left' => $this->t(Left),
    //   ],
    // ];
    
    
    // Redirecting to another web page.
    // In the below line(93), theredirecting path will be considered from the route.
    //  $url = \Drupal\Core\Url::fromRoute('dino_validate');
    
    // $form['actions'] = [
    //   // $form['#action'] = $url->toString(),
    // ];

//   $form['#action'] = Url::fromUri('internal:/' . 'validateForm')->toString();  

    $form['submit'] = array (
      '#type' => 'submit',
      '#value' => t('submit'),
    );
  

    return $form;
  }
  
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('Fname'); 
    $this->messenger()->addStatus($this->t('Your name is %title',['%title'=>$title]));
    // Retrieve previously saved data from the tempstore if it exists.
    $tempstore = \Drupal::service('tempstore.private')->get('dino_roar');
    $tempstore->set('title', $title);
    $tempstoreName = $tempstore->get('title');
    $this->messenger()->addStatus($this->t('Your temp store name is %title',['%title'=>$tempstoreName]));
    
    // if($form_state->getValue('checkbox_yes'))  {
    //   $checkbox = $form_state->getValue('checkbox_yes');
    // }
    // else {
    //   $checkbox = $form_state->getValue('checkbox_no');
    // }
    // $this->messenger()->addStatus($this->t('Selected value is %checkbox',['%checkbox'=>$checkbox]));
    // dump($form_state);
    // die;
  }
}