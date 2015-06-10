<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ArticleBlock;
use CMS\Structures\Blocks\ArticleBlockStructure;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\ArticleBlock as ArticleBlockModel;

class ArticleBlockType
{
    public function __construct() {
        $this->code = 'article';
        $this->name = trans('w-cms-laravel::blocks.article_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.content.article';
        $this->template_view = 'w-cms-laravel::back.editorial.pages.blocks.templates.article';
        $this->front_view = 'partials.blocks.article';
        $this->order = 5;
        $this->getEntityFromModelMethod = function(BlockModel $blockModel) {
            $block = new ArticleBlock();
            if ($blockModel->blockable) {
                $block->setArticleID($blockModel->blockable->article_id);
            }
            return $block;
        };
        $this->getUpdateContentMethod = function(BlockModel $blockModel, Block $block) {
            $blockable = ($blockModel->blockable) ? $blockModel->blockable : new ArticleBlockModel();
            $blockable->article_id = $block->getArticleID();
            $blockable->save();
            $blockable->block()->save($blockModel);
        };
        $this->getBlockStructureMethod = function() {
            return new ArticleBlockStructure();
        };
        $this->getBlockStructureForUpdateMethod = function($arguments) {
            return new ArticleBlockStructure([
                'article_id' => isset($arguments['article_id']) ? $arguments['article_id'] : null,
                'type' => $arguments['type']
            ]);
        };
    }
} 