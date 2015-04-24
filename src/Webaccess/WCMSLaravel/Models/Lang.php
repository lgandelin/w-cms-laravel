<?php

namespace Webaccess\WCMSLaravel\Models;

class Lang extends \Eloquent {

    protected $table = 'langs';
    protected $fillable = array('name', 'prefix', 'is_default');
}