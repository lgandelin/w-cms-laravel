<?php

namespace Webaccess\WCMSLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Shortcut extends Facade
{
    public static function get_theme()
    {
        return env('W_CMS_THEME');
    }

    protected static function getFacadeAccessor()
    {
        return 'shortcut';
    }
}
