<?php

namespace Webaccess\WCMSLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Shortcut extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shortcut';
    }
}
