<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

use CMS\Entities\Block;
use CMS\Entities\Blocks\MediaBlock;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\MediaBlock as MediaBlockModel;

class MediaBlockType
{
    public function __construct() {
        $this->code = 'media';
        $this->name = trans('w-cms-laravel::blocks.media_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.content.media';
        $this->template_view = 'w-cms-laravel::back.editorial.pages.blocks.templates.media';
        $this->front_view = 'blocks.standard.media';
        $this->order = 4;
        $this->getEntityFromModelMethod = function(BlockModel $blockModel) {
            $block = new MediaBlock();
            if ($blockModel->blockable) {
                $block->setMediaID($blockModel->blockable->media_id);
                $block->setMediaLink($blockModel->blockable->media_link);
                $block->setMediaFormatID($blockModel->blockable->media_format_id);
            }

            return $block;
        };
        $this->getUpdateContentMethod = function(BlockModel $blockModel, Block $block) {
            $blockable = ($blockModel->blockable) ? $blockModel->blockable : new MediaBlockModel();
            $blockable->media_id = $block->getMediaID();
            $blockable->media_link = $block->getMediaLink();
            $blockable->media_format_id = $block->getMediaFormatID();
            $blockable->save();
            $blockable->block()->save($blockModel);
        };
    }
}
