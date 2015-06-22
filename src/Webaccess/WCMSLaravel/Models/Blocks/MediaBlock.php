<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\MediaBlock as MediaBlockEntity;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;

class MediaBlock extends \Eloquent
{
    protected $table = 'blocks_media';
    protected $fillable = array('media_id', 'media_link', 'media_format_id');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity(BlockModel $blockModel) {
        $block = new MediaBlockEntity();
        if ($blockModel->blockable) {
            $block->setMediaID($blockModel->blockable->media_id);
            $block->setMediaLink($blockModel->blockable->media_link);
            $block->setMediaFormatID($blockModel->blockable->media_format_id);
        }
        return $block;
    }

    public function updateContent(BlockModel $blockModel, Block $block) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new self();
        $blockable->media_id = $block->getMediaID();
        $blockable->media_link = $block->getMediaLink();
        $blockable->media_format_id = $block->getMediaFormatID();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
}