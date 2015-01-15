<?php

namespace Webaccess\WCMSLaravel\Models;

class Page extends \Eloquent {

	protected $table = 'pages';
	protected $fillable = array('name', 'identifier', 'uri', 'meta_title', 'meta_description', 'meta_keywords', 'is_master', 'master_page_id');
	
}