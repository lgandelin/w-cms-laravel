<?php

namespace Webaccess\WCMSLaravel\Repositories\Eloquent\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\MediaBlock as MediaBlockEntity;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\MediaBlock;

class EloquentBlockMediaRepository
{
    public function getBlock(BlockModel $blockModel) {
        $block = new MediaBlockEntity();
        if ($blockModel->blockable) {
            $block->setMediaID($blockModel->blockable->media_id);
            $block->setMediaLink($blockModel->blockable->media_link);
            $block->setMediaFormatID($blockModel->blockable->media_format_id);
        }

        return $block;
    }

    public function saveBlock(Block $block, BlockModel $blockModel) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new MediaBlock();
        $blockable->media_id = $block->getMediaID();
        $blockable->media_link = $block->getMediaLink();
        $blockable->media_format_id = $block->getMediaFormatID();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
} 