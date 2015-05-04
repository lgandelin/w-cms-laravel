<?php

namespace Webaccess\WCMSLaravel\Helpers;

class ShortcutHelper
{
    public static function get_uploads_folder()
    {
        return env('W_CMS_UPLOADS_FOLDER', 'uploads/');
    }

    public static function get_theme()
    {
        return env('W_CMS_THEME', 'w-cms-base-theme');
    }
} 