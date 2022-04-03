<?php

namespace Drupal\webcam\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\State\State;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * A controller to capture and save image.
 */
class WebcamController extends ControllerBase {

  /**
   * To Load the file to database.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * To Save The file.
   *
   * @var Drupal\Core\File\FileSystemInterface
   */
  protected $filesystem;

  /**
   * To Save The file.
   *
   * @var Drupal\Core\State\State
   */
  protected $state;

  /**
   * To Save The file.
   *
   * @var Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Class constructor.
   */
  public function __construct(EntityTypeManagerInterface $entitytypemanager, FileSystemInterface $filesystem, State $state, RequestStack $requestStack) {
    $this->entityTypeManager = $entitytypemanager;
    $this->filesystem = $filesystem;
    $this->state = $state;
    $this->requestStack = $requestStack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
      // Load the service required to construct this class.
      $container->get('entity_type.manager'),
      $container->get('file_system'),
      $container->get('state'),
      $container->get('request_stack'),
    );

  }

  /**
   * Article status change.
   *
   * @Method("POST")
   */
  public function checkName(Request $request) {

    $img = \Drupal::request()->request->get('photo');

    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = 'public://capture/IMG.' . uniqid() . '.png';
    $this->filesystem->saveData($data, $file);
    $filestorage = $this->entityTypeManager->getStorage('file')->create([
      'uri' => $file,
    ]);
    $filestorage->setPermanent();
    $filestorage->save();
    $query = $this->entityTypeManager->getStorage('file')->loadMultiple();
    foreach ($query as $row) {

      $fid = $row->id();
    }
    $this->state->set('fid', $fid);

    return $fid;

  }

}
