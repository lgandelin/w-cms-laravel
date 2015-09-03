<?php

namespace Webaccess\WCMSLaravel\Helpers;

class Theme
{
    public static function load()
    {
        $theme = self::get();
        $themeFolder = base_path() . '/themes/' . $theme;
        if (is_dir($themeFolder)) {
            \View::addNamespace($theme, $themeFolder . '/views');
            \Lang::addNamespace($theme, $themeFolder . '/lang');
        } else {
            throw new \Exception('The theme folder [' . $theme . '] is missing in ' . base_path() . '/themes/');
        }
    }

    public static function get()
    {
        return 'my-theme';
    }
}
