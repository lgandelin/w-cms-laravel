<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

use CMS\Entities\Block;
use CMS\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\HTMLBlock as HTMLBlockModel;

class HTMLBlockType
{
    public function __construct() {
        $this->code = 'html';
        $this->name = trans('w-cms-laravel::blocks.html_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.content.html';
        $this->template_view = 'w-cms-laravel::back.editorial.pages.blocks.templates.html';
        $this->front_view = 'blocks.standard.html';
        $this->order = 1;
    }

    public function getEntityFromModelMethod(BlockModel $blockModel) {
        $block = new HTMLBlock();
        if ($blockModel->blockable) {
            $block->setHTML($blockModel->blockable->html);
        }
        return $block;
    }

    public function getUpdateContentMethod(BlockModel $blockModel, Block $block) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new HTMLBlockModel();
        $blockable->html = $block->getHTML();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
}
