<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;

class ArticleBlock extends \Eloquent
{
    protected $table = 'blocks_article';
    protected $fillable = array('article_id');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity() {
        $block = new \CMS\Entities\Blocks\ArticleBlock();
        $block->setArticleID($this->article_id);

        return $block;
    }

    public function updateFromEntity(Block $block) {
        $this->article_id = $block->getArticleID();
        $this->save();
    }
}