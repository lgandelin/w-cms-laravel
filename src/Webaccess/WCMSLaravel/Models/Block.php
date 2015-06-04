<?php

namespace Webaccess\WCMSLaravel\Models;

class Block extends \Eloquent {

    protected $table = 'blocks';
    protected $fillable = array('name', 'width', 'height', 'class', 'alignment', 'type', 'order', 'display', 'is_global', 'master_block_id', 'is_master', 'menu_id', 'view_file', 'article_id', 'article_list_category_id', 'article_list_order', 'article_list_number', 'block_reference_id', 'media_id', 'media_link', 'media_format_id');

    public function area()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\Area');
    }

    public function blockable()
    {
        return $this->morphTo();
    }
}