<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\ArticleStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class ArticleController extends AdminController
{
    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.articles.index', [
            'articles' => \App::make('GetArticlesInteractor')->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.articles.create');
    }

    public function store()
    {
        $articleStructure = new ArticleStructure([
            'title' => \Input::get('title'),
            'summary' => \Input::get('summary'),
            'text' => \Input::get('text'),
            'author_id' => \Input::get('author_id'),
        ]);

        try {
            $articleID = \App::make('CreateArticleInteractor')->run($articleStructure);
            return \Redirect::route('back_articles_edit', array('articleID' => $articleID));
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.editorial.articles.create', [
                'error' => $e->getMessage(),
                'article' => $articleStructure
            ]);
        }
    }

    public function edit($articleID)
    {
        try {
            $this->layout = \View::make('w-cms-laravel::back.editorial.articles.edit', [
                'article' => \App::make('GetArticleInteractor')->getArticleByID($articleID, true)
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_articles_index');
        }
    }

    public function update()
    {
        $articleID = \Input::get('ID');
        $articleStructure = new ArticleStructure([
            'title' => \Input::get('title'),
            'summary' => \Input::get('summary'),
            'text' => \Input::get('text'),
            'author_id' => \Input::get('author_id'),
        ]);

        try {
            \App::make('UpdateArticleInteractor')->run($articleID, $articleStructure);
            return \Redirect::route('back_articles_index');
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.general.articles.edit', [
                'error' => $e->getMessage(),
                'article' => $articleStructure
            ]);
        }
    }

    public function delete($articleID)
    {
        try {
            \App::make('DeleteArticleInteractor')->run($articleID);
            return \Redirect::route('back_articles_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_articles_index');
        }
    }
}