<?php

namespace Webaccess\WCMSLaravel\Models;

class Page extends \Eloquent {

	protected $table = 'w_cms_pages';
	protected $fillable = array('name', 'identifier', 'uri', 'lang_id', 'meta_title', 'meta_description', 'meta_keywords', 'is_master', 'master_page_id');
}