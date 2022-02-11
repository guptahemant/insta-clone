<?php 

namespace Drupal\dino_roar\Controllers;

use Drupal\Core\Controller\ControllerBase;
// use Drupal\Core\Logger\LoggerChannelFactory;
// use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\dino_roar\Jurassic\RoarGenerator;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

// The class name will be same as the name of the file.

class RoarController extends ControllerBase
{
  private $roarGenerator;
// private $loggerFactory;

  public function __construct(RoarGenerator $roarGenerator)
  {
    $this->roarGenerator = $roarGenerator;  
//    $this->loggerFactory = $loggerFactory;
  } 

  public function roar($count)
  {    
  $roar = $this->roarGenerator->getRoar($count);
  //  $this->loggerFactory->get('default')
    //      ->debug($roar);
    //return new Response($roar);
    return [
      '#title' => $roar 
    ];
  }

  public static function create(ContainerInterface $container)
  {
    $roarGenerator = $container->get('dino_roar.roar_generator');
//    $loggerFactory = $container->get('logger.factory');
    return new static($roarGenerator);
  }
}