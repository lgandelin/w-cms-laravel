<?php

namespace Webaccess\WCMSLaravel\Events;

use Webaccess\WCMSCore\Events\EventInterface;
use Webaccess\WCMSCore\Events\EventManagerInterface;
use Illuminate\Support\Facades\Event;

class CMSLaravelEventManager implements EventManagerInterface
{
    public function fireEvent(EventInterface $event)
    {
        Event::fire($event->getName(), array($event));
    }

    public function addListener($eventName, $listener, $priority = 0)
    {
        Event::listen($eventName, $listener, $priority);
    }
}
