<?php

namespace Webaccess\WCMSLaravel\Helpers;

use Webaccess\WCMSCore\Interactors\Themes\GetThemeInteractor;

class ShortcutHelper
{
    public static function get_uploads_folder()
    {
        return env('W_CMS_UPLOADS_FOLDER', 'uploads/');
    }

    public static function getTheme()
    {
        try {
            if (!\Cache::has('current-theme') || env('CACHE_ENABLED') === false) {
                $theme = (new GetThemeInteractor())->getThemeSelected(true);

                if (env('CACHE_ENABLED')) {
                    \Cache::put('current-theme', $theme->identifier, env('CACHE_DURATION'));
                }

                return $theme ? $theme->identifier : false;
            } else {
                return \Cache::get('current-theme');
            }
        } catch(\Exception $e) {
            dd($e->getMessage());
        }

        return false;
    }
}