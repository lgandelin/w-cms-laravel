<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front;

use Illuminate\Routing\Controller;
use Webaccess\WCMSLaravel\Facades\Shortcut;

class FrontController extends Controller
{
    public function __construct()
    {
        \View::addNamespace($this->getTheme(), base_path() . '/themes/' . $this->getTheme() . '/views');
        \Lang::addNamespace($this->getTheme(), base_path() . '/themes/' . $this->getTheme() . '/langs');
    }

    public function index($uri = null)
    {
        return view($this->getTheme() . '::pages.index', [
            'page' => \App::make('GetPageContentInteractor')->run(($uri != '/') ? '/' . $uri : '/')
        ]);
    }

    protected function getTheme()
    {
        return Shortcut::get_theme();
    }
} 