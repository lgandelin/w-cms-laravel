<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ViewBlock;
use CMS\Structures\Blocks\ViewBlockStructure;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\ViewBlock as ViewBlockModel;

class ViewBlockType
{
    public function __construct() {
        $this->code = 'view';
        $this->name = trans('w-cms-laravel::blocks.view_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.content.view';
        $this->template_view = 'w-cms-laravel::back.editorial.pages.blocks.templates.view';
        $this->front_view = 'partials.blocks.view';
        $this->order = 3;
        $this->getEntityFromModelMethod = function(BlockModel $blockModel) {
            $block = new ViewBlock();
            if ($blockModel->blockable) {
                $block->setViewPath($blockModel->blockable->view_path);
            }

            return $block;
        };
        $this->getUpdateContentMethod = function(BlockModel $blockModel, Block $block) {
            $blockable = ($blockModel->blockable) ? $blockModel->blockable : new ViewBlockModel();
            $blockable->view_path = $block->getViewPath();
            $blockable->save();
            $blockable->block()->save($blockModel);
        };
        $this->getBlockStructureMethod = function() {
            return new ViewBlockStructure();
        };
        $this->getBlockStructureForUpdateMethod = function($arguments) {
            return new ViewBlockStructure([
                'view_path' => isset($arguments['view_path']) ? $arguments['view_path'] : null,
            ]);
        };
    }
}
