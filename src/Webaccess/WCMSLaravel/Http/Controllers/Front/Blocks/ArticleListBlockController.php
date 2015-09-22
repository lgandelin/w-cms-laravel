<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Articles\GetArticlesInteractor;
use Webaccess\WCMSCore\Interactors\Medias\GetMediaInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;

class ArticleListBlockController
{
    public function index(DataStructure $block)
    {
        $block->articles = (new GetArticlesInteractor())->getAll($block->article_list_category_id, $block->article_list_number, $block->article_list_order, null, true);

        foreach ($block->articles as $article) {
            if ($article->pageID)
                $article->page = (new GetPageInteractor())->getPageByID($article->pageID, true);

            if ($article->mediaID)
                $article->media = (new GetMediaInteractor())->getMediaByID($article->mediaID, null, true);
        }

        return view(\Shortcut::getTheme() . '::blocks.standard.article_list', [
            'block' => $block,
        ])->render();
    }
} 