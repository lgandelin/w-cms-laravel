<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

class ViewBlock extends \Eloquent
{
    protected $table = 'view_blocks';
    protected $fillable = array('view_path');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }
}