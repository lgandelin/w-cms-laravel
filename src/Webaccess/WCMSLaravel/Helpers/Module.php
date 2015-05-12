<?php

namespace Webaccess\WCMSLaravel\Helpers;

use Webaccess\WCMSLaravel\Facades\Shortcut;

class Module
{
    public static function load($moduleName)
    {
        $themeFolder = base_path() . '/themes/' . Shortcut::get_theme();
        \Lang::addNamespace('w-cms-laravel-' . $moduleName, $themeFolder . '/lang/modules/' . $moduleName);
        \View::addNamespace('w-cms-laravel-' . $moduleName, $themeFolder . '/views/modules/' . $moduleName);
    }
}
