<?php

namespace Webaccess\WCMSLaravel\Models;

class Website extends \Eloquent {

	protected $table = 'websites';
	protected $fillable = array('name', 'url');
	
}