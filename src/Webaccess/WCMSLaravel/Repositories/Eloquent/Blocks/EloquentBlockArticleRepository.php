<?php

namespace Webaccess\WCMSLaravel\Repositories\Eloquent\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ArticleBlock as ArticleBlockEntity;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;
use Webaccess\WCMSLaravel\Models\Blocks\ArticleBlock;

class EloquentBlockArticleRepository
{
    public function getBlock(BlockModel $blockModel) {
        $block = new ArticleBlockEntity();
        if ($blockModel->blockable) {
            $block->setArticleID($blockModel->blockable->article_id);
        }

        return $block;
    }

    public function saveBlock(Block $block, BlockModel $blockModel) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new ArticleBlock();
        $blockable->article_id = $block->getArticleID();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
}
