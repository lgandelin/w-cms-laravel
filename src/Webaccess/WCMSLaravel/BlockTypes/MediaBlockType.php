<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

use CMS\Entities\Block;
use CMS\Entities\Blocks\MediaBlock;
use CMS\Structures\Blocks\MediaBlockStructure;
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
        $this->getBlockStructureMethod = function() {
            return new MediaBlockStructure();
        };
        $this->getBlockStructureForUpdateMethod = function($arguments) {
            return new MediaBlockStructure([
                'media_id' => isset($arguments['media_id']) ? $arguments['media_id'] : null,
                'media_link' => isset($arguments['media_link']) ? $arguments['media_link'] : null,
                'media_format_id' => isset($arguments['media_format_id']) ? $arguments['media_format_id'] : null,
            ]);
        };
    }
}
