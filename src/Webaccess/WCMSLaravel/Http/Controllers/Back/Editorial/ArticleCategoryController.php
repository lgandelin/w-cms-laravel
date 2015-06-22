<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Interactors\ArticleCategories\CreateArticleCategoryInteractor;
use CMS\Interactors\ArticleCategories\DeleteArticleCategoryInteractor;
use CMS\Interactors\ArticleCategories\GetArticleCategoriesInteractor;
use CMS\Interactors\ArticleCategories\GetArticleCategoryInteractor;
use CMS\Interactors\ArticleCategories\UpdateArticleCategoryInteractor;
use CMS\DataStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class ArticleCategoryController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.editorial.article_categories.index', [
            'article_categories' => (new GetArticleCategoriesInteractor())->getAll($this->getLangID(), true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.editorial.article_categories.create');
    }

    public function store()
    {
        $articleCategoryStructure = new DataStructure([
            'name' => \Input::get('name'),
            'description' => \Input::get('description'),
            'lang_id' => $this->getLangID(),
        ]);

        try {
            $articleCategoryID = (new CreateArticleCategoryInteractor())->run($articleCategoryStructure);
            return \Redirect::route('back_article_categories_edit', array('articleID' => $articleCategoryID));
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.editorial.article_categories.create', [
                'error' => $e->getMessage(),
                'article_category' => $articleCategoryStructure
            ]);
        }
    }

    public function edit($articleCategoryID)
    {
        try {
            return view('w-cms-laravel::back.editorial.article_categories.edit', [
                'article_category' => (new GetArticleCategoryInteractor())->getArticleCategoryByID($articleCategoryID, true),
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_article_categories_index');
        }
    }

    public function update()
    {
        $articleCategoryID = \Input::get('ID');
        $articleCategoryStructure = new DataStructure([
            'name' => \Input::get('name'),
            'description' => \Input::get('description'),
        ]);

        try {
            (new UpdateArticleCategoryInteractor())->run($articleCategoryID, $articleCategoryStructure);
            return \Redirect::route('back_article_categories_index');
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.general.article-categories.edit', [
                'error' => $e->getMessage(),
                'article_category' => $articleCategoryStructure
            ]);
        }
    }

    public function delete($articleCategoryID)
    {
        try {
            (new DeleteArticleCategoryInteractor())->run($articleCategoryID);
            return \Redirect::route('back_article_categories_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_article_categories_index');
        }
    }
}