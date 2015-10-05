<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front;

use Webaccess\WCMSCore\Interactors\Pages\GetPageContentInteractor;
use Illuminate\Routing\Controller;
use Webaccess\WCMSLaravel\Helpers\ShortcutHelper;

class FrontController extends Controller
{
    public function __construct()
    {
        self::loadTheme();
    }

    public function index($uri = null)
    {
        $uri = ($uri != '/') ? '/' . $uri : '/';

        if (!\Cache::has($uri) || env('CACHE_ENABLED') === false) {
            $page = (new GetPageContentInteractor())->run($uri, true);

            if (env('CACHE_ENABLED')) {
                \Cache::put($uri, $page, env('CACHE_DURATION'));
            }
        } else {
            $page = \Cache::get($uri);
        }
        $theme = ShortcutHelper::getTheme();

        return view($theme . '::index', [
            'page' => $page,
            'theme' => $theme
        ]);
    }

    public static function loadTheme()
    {
        if (!$themeIdentifier = ShortcutHelper::getTheme()) {
            throw new \Exception('No selected theme found');
        }

        $themeFolder = base_path() . '/themes/' . $themeIdentifier;
        if (is_dir($themeFolder)) {
            \View::addNamespace($themeIdentifier, $themeFolder . '/views');
            \Lang::addNamespace($themeIdentifier, $themeFolder . '/lang');
        } else {
            throw new \Exception('The theme folder [' . $themeIdentifier . '] is missing in ' . base_path() . '/themes/');
        }
    }
}