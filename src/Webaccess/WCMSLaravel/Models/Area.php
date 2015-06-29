<?php

namespace Webaccess\WCMSLaravel\Models;

class Area extends \Eloquent {

    protected $table = 'w_cms_areas';
    protected $fillable = array('name', 'width', 'height', 'class', 'order', 'display', 'is_master', 'master_area_id');

    public function page()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\Page');
    }
}