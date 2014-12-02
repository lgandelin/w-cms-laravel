<?php

namespace Webaccess\WCMSLaravel\Models;

class Block extends \Eloquent {

    protected $table = 'blocks';
    protected $fillable = array('name', 'width', 'height', 'class', 'type', 'order', 'display', 'html', 'menu_id', 'view_file', 'article_id');

    public function area()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\Area');
    }
}