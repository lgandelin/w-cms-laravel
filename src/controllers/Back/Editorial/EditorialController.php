<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use Webaccess\WCMSLaravel\Back\AdminController;

class EditorialController extends AdminController {

	public function index()
	{
		$this->layout = \View::make('w-cms-laravel::back.editorial.index', array());
	}
}