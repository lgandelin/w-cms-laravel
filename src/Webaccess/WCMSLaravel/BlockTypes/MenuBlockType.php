<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

use CMS\Entities\Block;
use CMS\Entities\Blocks\MenuBlock;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\MenuBlock as MenuBlockModel;

class MenuBlockType
{
    public function __construct() {
        $this->code = 'menu';
        $this->name = trans('w-cms-laravel::blocks.navigation_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.content.menu';
        $this->template_view = 'w-cms-laravel::back.editorial.pages.blocks.templates.menu';
        $this->front_view = 'blocks.standard.menu';
        $this->order = 2;
    }

    public function getEntityFromModelMethod(BlockModel $blockModel) {
        $block = new MenuBlock();
        if ($blockModel->blockable) {
            $block->setMenuID($blockModel->blockable->menu_id);
        }
        return $block;
    }

    public function getUpdateContentMethod(BlockModel $blockModel, Block $block) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new MenuBlockModel();
        $blockable->menu_id = $block->getMenuID();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
} 