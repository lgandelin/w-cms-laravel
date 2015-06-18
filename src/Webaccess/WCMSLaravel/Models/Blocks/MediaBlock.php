<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;

class MediaBlock extends \Eloquent
{
    protected $table = 'blocks_media';
    protected $fillable = array('media_id', 'media_link', 'media_format_id');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity() {
        $block = new \CMS\Entities\Blocks\MediaBlock();
        $block->setMediaID($this->media_id);
        $block->setMediaLink($this->media_link);
        $block->setMediaFormatID($this->media_format_id);

        return $block;
    }

    public function updateFromEntity(Block $block) {
        $this->media_id = $block->getMediaID();
        $this->media_link = $block->getMediaLink();
        $this->media_format_id = $block->getMediaFormatID();
        $this->save();
    }
}