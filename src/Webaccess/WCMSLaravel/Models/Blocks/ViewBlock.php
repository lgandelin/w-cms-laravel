<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ViewBlock as ViewBlockEntity;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;

class ViewBlock extends \Eloquent
{
    protected $table = 'blocks_view';
    protected $fillable = array('view_path');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity(BlockModel $blockModel) {
        $block = new ViewBlockEntity();
        if ($blockModel->blockable) {
            $block->setViewPath($blockModel->blockable->view_path);
        }
        return $block;
    }

    public function updateContent(BlockModel $blockModel, Block $block) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new self();
        $blockable->view_path = $block->getViewPath();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
}