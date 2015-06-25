<?php

namespace Webaccess\WCMSLaravel\Helpers;

class Module
{
    public static function load($module)
    {
        $themeFolder = base_path() . '/themes/' . Theme::get();
        \Lang::addNamespace('w-cms-laravel-' . $module, $themeFolder . '/lang/modules/' . $module);
        \Lang::addNamespace('w-cms-laravel-' . $module . '-back', base_path('resources/lang/vendor/' . $module . '/'));

        \View::addNamespace('w-cms-laravel-' . $module, $themeFolder . '/views/modules/' . $module);
        \View::addNamespace('w-cms-laravel-' . $module . '-back', base_path('resources/views/vendor/' . $module . '/'));
    }
}
