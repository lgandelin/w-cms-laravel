<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front;

use Illuminate\Routing\Controller;
use Webaccess\WCMSLaravel\Facades\Shortcut;

class IndexController extends Controller {

    public function __construct()
    {
        \View::addNamespace(Shortcut::get_theme(), base_path() . '/themes/' . Shortcut::get_theme() . '/views');
        \Lang::addNamespace(Shortcut::get_theme(), base_path() . '/themes/' . Shortcut::get_theme() . '/langs');
    }

	public function index($uri = null)
	{
		return view(Shortcut::get_theme() . '::pages.index', [
			'page' => \App::make('GetPageContentInteractor')->run(($uri != '/') ? '/' . $uri : '/')
		]);
	}
}