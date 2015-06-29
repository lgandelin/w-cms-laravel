<?php

namespace Webaccess\WCMSLaravel\Helpers;

class ShortcutHelper
{
    public static function get_uploads_folder()
    {
        return env('W_CMS_UPLOADS_FOLDER', 'uploads/');
    }
} 