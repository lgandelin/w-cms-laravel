<?php

namespace Webaccess\WCMSLaravel\Models;

class Menu extends \Eloquent {

    protected $table = 'w_cms_menus';
    protected $fillable = array('name', 'identifier', 'lang_id');

    public function items()
    {
        return $this->hasMany('Webaccess\WCMSLaravel\Models\MenuItem');
    }
    
}