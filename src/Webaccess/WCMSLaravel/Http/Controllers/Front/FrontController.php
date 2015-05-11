<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front;

use Illuminate\Routing\Controller;
use Webaccess\WCMSLaravel\Facades\Shortcut;

class FrontController extends Controller
{
    public function __construct()
    {
        $this->loadTheme();
    }

    public function index($uri = null)
    {
        return view(Shortcut::get_theme() . '::pages.index', [
            'page' => \App::make('GetPageContentInteractor')->run(($uri != '/') ? '/' . $uri : '/')
        ]);
    }

    private function loadTheme()
    {
        $themeFolder = base_path() . '/themes/' . Shortcut::get_theme();
        if (is_dir($themeFolder)) {
            \View::addNamespace(Shortcut::get_theme(), $themeFolder . '/views');
            \Lang::addNamespace(Shortcut::get_theme(), $themeFolder . '/langs');
        } else {
            throw new \Exception('The theme folder [' . Shortcut::get_theme() . '] is missing in ' . base_path() . '/themes/');
        }
    }
}