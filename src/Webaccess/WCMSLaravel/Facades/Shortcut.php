<?php

namespace Webaccess\WCMSLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Shortcut extends Facade
{
    public static function get_theme()
    {
    }

    protected static function getFacadeAccessor()
    {
        return 'shortcut';
    }
}
