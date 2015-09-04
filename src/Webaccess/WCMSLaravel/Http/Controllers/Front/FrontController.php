<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front;

use Webaccess\WCMSCore\Interactors\Pages\GetPageContentInteractor;
use Illuminate\Routing\Controller;
use Webaccess\WCMSLaravel\Helpers\Theme;

class FrontController extends Controller
{
    public function __construct()
    {
        self::loadTheme();
    }

    public function index($uri = null)
    {
        $uri = ($uri != '/') ? '/' . $uri : '/';
        $theme = \Shortcut::get_theme();

        if (!\Cache::has($uri) || env('CACHE_ENABLED') === false) {
            $page = (new GetPageContentInteractor())->run($uri, true);

            if (env('CACHE_ENABLED')) {
                \Cache::put($uri, $page, 24 * 60);
            }
        } else {
            $page = \Cache::get($uri);
        }

        return view($theme . '::index', [
            'page' => $page,
            'theme' => $theme
        ]);
    }

    public static function loadTheme()
    {
        $theme = \Shortcut::get_theme();
        $themeFolder = base_path() . '/themes/' . $theme;
        if (is_dir($themeFolder)) {
            \View::addNamespace($theme, $themeFolder . '/views');
            \Lang::addNamespace($theme, $themeFolder . '/lang');
        } else {
            throw new \Exception('The theme folder [' . $theme . '] is missing in ' . base_path() . '/themes/');
        }
    }
}