<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

class ViewBlock extends \Eloquent
{
    protected $table = 'blocks_view';
    protected $fillable = array('view_path');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }
}