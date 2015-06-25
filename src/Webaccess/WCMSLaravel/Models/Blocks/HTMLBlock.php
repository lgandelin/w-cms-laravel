<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

class HTMLBlock extends \Eloquent
{
    protected $table = 'w_cms_blocks_html';
    protected $fillable = array('html');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }
}
