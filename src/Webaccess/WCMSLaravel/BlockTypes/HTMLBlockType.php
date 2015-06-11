<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

use CMS\Entities\Block;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Structures\Blocks\HTMLBlockStructure;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\HTMLBlock as HTMLBlockModel;

class HTMLBlockType
{
    public function __construct() {
        $this->code = 'html';
        $this->name = trans('w-cms-laravel::blocks.html_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.content.html';
        $this->template_view = 'w-cms-laravel::back.editorial.pages.blocks.templates.html';
        $this->front_view = 'partials.blocks.html';
        $this->order = 1;
        $this->getEntityFromModelMethod = function(BlockModel $blockModel) {
            $block = new HTMLBlock();
            if ($blockModel->blockable) {
                $block->setHTML($blockModel->blockable->html);
            }

            return $block;
        };
        $this->getUpdateContentMethod = function(BlockModel $blockModel, Block $block) {
            $blockable = ($blockModel->blockable) ? $blockModel->blockable : new HTMLBlockModel();
            $blockable->html = $block->getHTML();
            $blockable->save();
            $blockable->block()->save($blockModel);
        };
        $this->getBlockStructureMethod = function() {
            return new HTMLBlockStructure();
        };
        $this->getBlockStructureForUpdateMethod = function($arguments) {
            return new HTMLBlockStructure([
                'html' => isset($arguments['html']) ? $arguments['html'] : null,
            ]);
        };
    }
}
