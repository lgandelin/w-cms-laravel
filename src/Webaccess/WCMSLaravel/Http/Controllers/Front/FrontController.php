<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front;

use CMS\Interactors\Pages\GetPageContentInteractor;
use Illuminate\Routing\Controller;
use Webaccess\WCMSLaravel\Helpers\Theme;

class FrontController extends Controller
{
    public function __construct()
    {
        Theme::load();
    }

    public function index($uri = null)
    {
        $uri = ($uri != '/') ? '/' . $uri : '/';
        $theme = Theme::get();

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
}