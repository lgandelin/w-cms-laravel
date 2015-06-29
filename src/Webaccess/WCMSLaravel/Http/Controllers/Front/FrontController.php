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

        return view($theme . '::index', [
            'page' => (new GetPageContentInteractor())->run($uri, true),
            'theme' => $theme
        ]);
    }
}