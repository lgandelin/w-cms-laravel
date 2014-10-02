<?php

namespace Webaccess\WCMSLaravel\Models;

class Block extends \Eloquent {

    protected $table = 'blocks';
    protected $fillable = array('name', 'width', 'height', 'class', 'type', 'order', 'html', 'menu_id');

    public function area()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\Area');
    }
}