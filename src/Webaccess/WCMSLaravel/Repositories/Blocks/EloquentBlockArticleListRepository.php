<?php

namespace Webaccess\WCMSLaravel\Repositories\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ArticleListBlock as ArticleListBlockEntity;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\ArticleListBlock;

class EloquentBlockArticleListRepository
{
    public function getBlock(BlockModel $blockModel) {
        $block = new ArticleListBlockEntity();
        if ($blockModel->blockable) {
            $block->setArticleListCategoryID($blockModel->blockable->article_list_category_id);
            $block->setArticleListOrder($blockModel->blockable->article_list_order);
            $block->setArticleListNumber($blockModel->blockable->article_list_number);
        }

        return $block;
    }

    public function saveBlock(BlockModel $blockModel, Block $block) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new ArticleListBlock();
        $blockable->article_list_category_id = $block->getArticleListCategoryID();
        $blockable->article_list_order = $block->getArticleListOrder();
        $blockable->article_list_number = $block->getArticleListNumber();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
}
