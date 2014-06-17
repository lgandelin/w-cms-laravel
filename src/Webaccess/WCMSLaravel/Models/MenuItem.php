<?php

namespace Webaccess\WCMSLaravel\Models;

class MenuItem extends \Eloquent {

    protected $table = 'menu_items';
    protected $fillable = array('label', 'order');

}