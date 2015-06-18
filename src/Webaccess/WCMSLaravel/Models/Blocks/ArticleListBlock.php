<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;

class ArticleListBlock extends \Eloquent
{
    protected $table = 'blocks_article_list';
    protected $fillable = array('article_list_category_id', 'article_list_order', 'article_list_number');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity() {
        $block = new \CMS\Entities\Blocks\ArticleListBlock();
        $block->setArticleListCategoryID($this->article_list_category_id);
        $block->setArticleListOrder($this->article_list_order);
        $block->setArticleListNumber($this->article_list_number);

        return $block;
    }

    public function updateFromEntity(Block $block) {
        $this->article_list_category_id = $block->getArticleListCategoryID();
        $this->article_list_order = $block->getArticleListOrder();
        $this->article_list_number = $block->getArticleListNumber();
        $this->save();
    }
}