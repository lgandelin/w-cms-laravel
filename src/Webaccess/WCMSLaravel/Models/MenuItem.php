<?php

namespace Webaccess\WCMSLaravel\Models;

class MenuItem extends \Eloquent {

    protected $table = 'w_cms_menu_items';
    protected $fillable = array('label', 'order');

    public function page()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\Page');
    }

}