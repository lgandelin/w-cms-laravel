<?php

namespace Webaccess\WCMSLaravel\Listeners;

use CMS\Events\DeleteAreaEvent;
use Illuminate\Support\Facades\Log;

class DeleteAreaListener
{
    public function onDeleteArea(DeleteAreaEvent $event)
    {
        $area = $event->getArea();

        Log::info('Area successfully deleted : ID=' . $area->getID() . ' - Name=' . $area->getName());
    }
} 