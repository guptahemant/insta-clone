<?php

namespace Drupal\signupform\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'article' block.
 *
 * @Block(
 *   id = "signup_block",
 *   admin_label = @Translation("Sign up block"),
 *   category = @Translation("Custom sign up block example")
 * )
 */
class Signupblock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The form builder service.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, FormBuilderInterface $form_builder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    // Instantiate this block class.
    return new static($configuration, $plugin_id, $plugin_definition,
      // Load the service required to construct this class.
      $container->get('form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = $this->formBuilder->getForm('Drupal\signupform\Form\Personform');

    return $form;
  }

}
