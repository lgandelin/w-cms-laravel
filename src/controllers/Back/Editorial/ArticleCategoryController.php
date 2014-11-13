<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\ArticleCategoryStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class ArticleCategoryController extends AdminController
{
    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.article_categories.index', [
            'article_categories' => \App::make('GetArticleCategoriesInteractor')->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.article_categories.create');
    }

    public function store()
    {
        $articleCategoryStructure = new ArticleCategoryStructure([
            'name' => \Input::get('name'),
            'description' => \Input::get('description'),
        ]);

        try {
            $articleCategoryID = \App::make('CreateArticleCategoryInteractor')->run($articleCategoryStructure);
            return \Redirect::route('back_article_categories_edit', array('articleID' => $articleCategoryID));
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.editorial.article_categories.create', [
                'error' => $e->getMessage(),
                'article_category' => $articleCategoryStructure
            ]);
        }
    }

    public function edit($articleCategoryID)
    {
        try {
            $this->layout = \View::make('w-cms-laravel::back.editorial.article_categories.edit', [
                'article_category' => \App::make('GetArticleCategoryInteractor')->getArticleCategoryByID($articleCategoryID, true)
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_article_categories_index');
        }
    }

    public function update()
    {
        $articleCategoryID = \Input::get('ID');
        $articleCategoryStructure = new ArticleCategoryStructure([
            'name' => \Input::get('name'),
            'description' => \Input::get('description'),
        ]);

        try {
            \App::make('UpdateArticleCategoryInteractor')->run($articleCategoryID, $articleCategoryStructure);
            return \Redirect::route('back_article_categories_index');
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.general.article-categories.edit', [
                'error' => $e->getMessage(),
                'article_category' => $articleCategoryStructure
            ]);
        }
    }

    public function delete($articleCategoryID)
    {
        try {
            \App::make('DeleteArticleCategoryInteractor')->run($articleCategoryID);
            return \Redirect::route('back_article_categories_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_article_categories_index');
        }
    }
}