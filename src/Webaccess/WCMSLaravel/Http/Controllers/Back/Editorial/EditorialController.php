<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class EditorialController extends AdminController
{
	public function index()
	{
		return view('w-cms-laravel::back.editorial.index');
	}
}