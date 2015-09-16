<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Articles\GetArticleInteractor;

class ArticleBlockController
{
    public function index(DataStructure $block) {
        if ($block->articleID) {
            $block->article = (new GetArticleInteractor())->getArticleByID($block->articleID, true);
        }

        return view(\Shortcut::get_theme() . '::blocks.standard.article', [
            'block' => $block,
        ])->render();
    }
}