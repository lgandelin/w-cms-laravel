<?php

namespace Webaccess\WCMSLaravel\Models;

class Page extends \Eloquent {

	protected $table = 'pages';
	protected $fillable = array('name', 'identifier', 'uri', 'text', 'meta_title', 'meta_description', 'meta_keywords');
}