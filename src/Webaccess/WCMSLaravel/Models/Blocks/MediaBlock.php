<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

class MediaBlock extends \Eloquent
{
    protected $table = 'blocks_media';
    protected $fillable = array('media_id', 'media_link', 'media_format_id');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }
}