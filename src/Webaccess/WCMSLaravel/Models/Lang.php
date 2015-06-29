<?php

namespace Webaccess\WCMSLaravel\Models;

class Lang extends \Eloquent {

    protected $table = 'w_cms_langs';
    protected $fillable = array('name', 'prefix', 'is_default');
}