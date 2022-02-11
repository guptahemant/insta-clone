<?php

namespace Drupal\dino_roar\Jurassic;
use Drupal\Core\Http\KernelEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class DinoListener implements EventSubscriberInterface{

// Also Tell Drupal that we have Event Subscriber by registering this class as a service.
    
    // Pass exactly one argument.
    public function onKernerRequest(RequestEvent $event)
    {
        # code...
        // var_dump($event);
        // die;
        $request = $event->getRequest();
        $shouldRoar = $request->query->get('roar');
        if($shouldRoar)
        {
            var_dump('ROOOOOAAAAARRRRRRRR');
            die; 
        }
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}

