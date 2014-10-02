<?php

namespace Webaccess\WCMSLaravel\Models;

class Area extends \Eloquent {

    protected $table = 'areas';
    protected $fillable = array('name', 'width', 'height', 'class', 'order');

    public function page()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\Page');
    }
}