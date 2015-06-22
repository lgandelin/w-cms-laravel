<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ArticleBlock as ArticleBlockEntity;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;

class ArticleBlock extends \Eloquent
{
    protected $table = 'blocks_article';
    protected $fillable = array('article_id');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity(BlockModel $blockModel) {
        $block = new ArticleBlockEntity();
        if ($blockModel->blockable) {
            $block->setArticleID($blockModel->blockable->article_id);
        }

        return $block;
    }

    public function updateContent(BlockModel $blockModel, Block $block) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new self();
        $blockable->article_id = $block->getArticleID();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
}