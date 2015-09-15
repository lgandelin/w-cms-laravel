<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\BlockForms;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Articles\GetArticlesInteractor;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class ArticleBlockFormController extends AdminController
{
    public function getForm(DataStructure $block)
    {
        return view('w-cms-laravel::back.editorial.pages.blocks.article', [
            'block' => $block,
            'articles' => (new GetArticlesInteractor())->getAll(null, null, null, $this->getLangID(), true),
        ])->render();
    }
}
