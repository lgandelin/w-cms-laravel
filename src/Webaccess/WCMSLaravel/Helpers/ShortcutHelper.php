<?php

namespace Webaccess\WCMSLaravel\Helpers;

use Webaccess\WCMSCore\Context;

class ShortcutHelper
{
    public static function get_uploads_folder()
    {
        return env('W_CMS_UPLOADS_FOLDER', 'uploads/');
    }

    public static function get_theme()
    {
        return Context::get('theme')->findSelectedThemeIdentifier();
    }
} 