<?php

namespace Webaccess\WCMSLaravel\Helpers;

use Webaccess\WCMSLaravel\Facades\Shortcut;

class Theme
{
    public static function load()
    {
        $themeFolder = base_path() . '/themes/' . Shortcut::get_theme();
        if (is_dir($themeFolder)) {
            \View::addNamespace(Shortcut::get_theme(), $themeFolder . '/views');
            \Lang::addNamespace(Shortcut::get_theme(), $themeFolder . '/lang');
        } else {
            throw new \Exception('The theme folder [' . Shortcut::get_theme() . '] is missing in ' . base_path() . '/themes/');
        }
    }
}
