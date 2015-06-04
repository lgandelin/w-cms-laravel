<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front;

use CMS\Interactors\Pages\GetPageContentInteractor;
use Illuminate\Routing\Controller;
use Webaccess\WCMSLaravel\Facades\Shortcut;

class FrontController extends Controller
{
    public function index($uri = null)
    {
        $uri = ($uri != '/') ? '/' . $uri : '/';

        return view(Shortcut::get_theme() . '::pages.index', [
            'page' => (new GetPageContentInteractor())->run($uri, true)
        ]);
    }
}