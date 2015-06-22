<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ArticleListBlock as ArticleListBlockEntity;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;

class ArticleListBlock extends \Eloquent
{
    protected $table = 'blocks_article_list';
    protected $fillable = array('article_list_category_id', 'article_list_order', 'article_list_number');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity(BlockModel $blockModel) {
        $block = new ArticleListBlockEntity();
        if ($blockModel->blockable) {
            $block->setArticleListCategoryID($blockModel->blockable->article_list_category_id);
            $block->setArticleListOrder($blockModel->blockable->article_list_order);
            $block->setArticleListNumber($blockModel->blockable->article_list_number);
        }
        return $block;
    }

    public function updateContent(BlockModel $blockModel, Block $block) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new self();
        $blockable->article_list_category_id = $block->getArticleListCategoryID();
        $blockable->article_list_order = $block->getArticleListOrder();
        $blockable->article_list_number = $block->getArticleListNumber();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
}