<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

class HTMLBlock extends \Eloquent
{
    protected $table = 'html_blocks';
    protected $fillable = array('html');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }
}