<?php

namespace Webaccess\WCMSLaravel\Repositories\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ViewBlock as ViewBlockEntity;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\ViewBlock;

class EloquentBlockViewRepository
{
    public function getBlock(BlockModel $blockModel) {
        $block = new ViewBlockEntity();
        if ($blockModel->blockable) {
            $block->setViewPath($blockModel->blockable->view_path);
        }

        return $block;
    }

    public function saveBlock(BlockModel $blockModel, Block $block) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new ViewBlock();
        $blockable->view_path = $block->getViewPath();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
} 