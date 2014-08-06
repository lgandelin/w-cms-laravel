<?php

namespace Webaccess\WCMSLaravel\Models;

class Menu extends \Eloquent {

    protected $table = 'menus';
    protected $fillable = array('name', 'identifier');

    public function items()
    {
        return $this->hasMany('Webaccess\WCMSLaravel\Models\MenuItem');
    }
    
}