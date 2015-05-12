<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front;

use Illuminate\Routing\Controller;
use Webaccess\WCMSLaravel\Facades\Shortcut;

class FrontController extends Controller
{
    public function index($uri = null)
    {
        return view(Shortcut::get_theme() . '::pages.index', [
            'page' => \App::make('GetPageContentInteractor')->run(($uri != '/') ? '/' . $uri : '/')
        ]);
    }
}