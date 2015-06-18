<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ArticleListBlock;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\ArticleListBlock as ArticleListBlockModel;

class ArticleListBlockType
{
    public function __construct() {
        $this->code = 'article_list';
        $this->name = trans('w-cms-laravel::blocks.article_list_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.content.article_list';
        $this->template_view = 'w-cms-laravel::back.editorial.pages.blocks.templates.article_list';
        $this->front_view = 'blocks.standard.article_list';
        $this->order = 6;
        $this->getEntityFromModelMethod = function(BlockModel $blockModel) {
            $block = new ArticleListBlock();
            if ($blockModel->blockable) {
                $block->setArticleListCategoryID($blockModel->blockable->article_list_category_id);
                $block->setArticleListOrder($blockModel->blockable->article_list_order);
                $block->setArticleListNumber($blockModel->blockable->article_list_number);
            }

            return $block;
        };
        $this->getUpdateContentMethod = function(BlockModel $blockModel, Block $block) {
            $blockable = ($blockModel->blockable) ? $blockModel->blockable : new ArticleListBlockModel();
            $blockable->article_list_category_id = $block->getArticleListCategoryID();
            $blockable->article_list_order = $block->getArticleListOrder();
            $blockable->article_list_number = $block->getArticleListNumber();
            $blockable->save();
            $blockable->block()->save($blockModel);
        };
    }
} 