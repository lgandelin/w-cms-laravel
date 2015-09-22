<?php

namespace Webaccess\WCMSLaravel\Helpers;

use Webaccess\WCMSCore\Interactors\Themes\GetThemeInteractor;

class ShortcutHelper
{
    public static function get_uploads_folder()
    {
        return env('W_CMS_UPLOADS_FOLDER', 'uploads/');
    }

    public static function get_theme()
    {
        try {
            return (new GetThemeInteractor())->getThemeSelected(true)->identifier;
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return false;
    }
}