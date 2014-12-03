<?php

namespace Webaccess\WCMSLaravel\Models;

class Block extends \Eloquent {

    protected $table = 'blocks';
    protected $fillable = array('name', 'width', 'height', 'class', 'type', 'order', 'display', 'html', 'menu_id', 'view_file', 'article_id', 'article_list_category_id', 'article_list_order', 'article_list_number');

    public function area()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\Area');
    }
}