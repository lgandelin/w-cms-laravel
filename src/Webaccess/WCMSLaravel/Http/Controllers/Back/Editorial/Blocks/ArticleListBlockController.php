<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\ArticleCategories\GetArticleCategoriesInteractor;

class ArticleListBlockController
{
    public function getBackView(DataStructure $block)
    {
        return view('w-cms-laravel::back.editorial.pages.blocks.article_list', [
            'block' => $block,
            'article_categories' => (new GetArticleCategoriesInteractor())->getAll($this->getLangID(), true),
        ])->render();
    }
}
