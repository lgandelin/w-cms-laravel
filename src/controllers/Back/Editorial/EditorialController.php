<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

class EditorialController extends \Illuminate\Routing\Controller {

	public function index()
	{
		$this->layout = \View::make('w-cms-laravel::back.editorial.index', array());
	}
}