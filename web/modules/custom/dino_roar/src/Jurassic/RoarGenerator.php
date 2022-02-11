<?php

namespace Drupal\dino_roar\Jurassic;

use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

class RoarGenerator
{
   private $keyValueFactory;
   private $useCache;
         // Adding configuration to a service - useCache.
    public function __construct(KeyValueFactoryInterface $keyValueFactory , $useCache)
    {
        $this->keyValueFactory = $keyValueFactory;
        $this->useCache = $useCache;
    }

    public function getRoar($length)
    {
        $key = 'roar_'.$length;
        $store = $this->keyValueFactory->get('dino');
        // Adding configuration to a service.     
        if($this->useCache && $store->has($key))
        {
            return $store->get($key);
        }
        sleep(2);
        $string =  'R'.str_repeat('O', $length).'AR';
        // Adding configuration to a service.
        if($this->useCache)
        {
            $store->set($key, $string);
        }
        return $string;
    }
}