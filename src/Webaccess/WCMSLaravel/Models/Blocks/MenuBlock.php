<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\MenuBlock as MenuBlockEntity;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;

class MenuBlock extends \Eloquent
{
    protected $table = 'blocks_menu';
    protected $fillable = array('menu_id');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity(BlockModel $blockModel) {
        $block = new MenuBlockEntity();
        if ($blockModel->blockable) {
            $block->setMenuID($blockModel->blockable->menu_id);
        }
        return $block;
    }

    public function updateContent(BlockModel $blockModel, Block $block) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new self();
        $blockable->menu_id = $block->getMenuID();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
}