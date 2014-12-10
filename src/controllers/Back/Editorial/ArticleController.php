<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\ArticleStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class ArticleController extends AdminController
{
    public function index()
    {
        $articles = \App::make('GetArticlesInteractor')->getAll(true);
        foreach ($articles as $article) {
            if ($article->author_id) {
                $article->author = \App::make('GetUserInteractor')->getUserByID($article->author_id, true);
            }

            if ($article->category_id) {
                $article->category = \App::make('GetArticleCategoryInteractor')->getArticleCategoryByID($article->category_id, true);
            }
        }

        $this->layout = \View::make('w-cms-laravel::back.editorial.articles.index', [
            'articles' => $articles,
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.articles.create', [
            'article_categories' => \App::make('GetArticleCategoriesInteractor')->getAll(true),
            'pages' => \App::make('GetPagesInteractor')->getAll(true)
        ]);
    }

    public function store()
    {
        $publicationDate = \DateTime::createFromFormat('d/m/Y H:i', \Input::get('publication_date'));
        $articleStructure = new ArticleStructure([
            'title' => \Input::get('title'),
            'summary' => \Input::get('summary'),
            'text' => \Input::get('text'),
            'category_id' => \Input::get('category_id'),
            'author_id' => \Input::get('author_id'),
            'page_id' => \Input::get('page_id'),
            'publication_date' => $publicationDate->format('Y-m-d H:i:s'),
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
                'article' => \App::make('GetArticleInteractor')->getArticleByID($articleID, true),
                'article_categories' => \App::make('GetArticleCategoriesInteractor')->getAll(true),
                'pages' => \App::make('GetPagesInteractor')->getAll(true)
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_articles_index');
        }
    }

    public function update()
    {
        $articleID = \Input::get('ID');
        $publicationDate = \DateTime::createFromFormat('d/m/Y H:i', \Input::get('publication_date'));
        $articleStructure = new ArticleStructure([
            'title' => \Input::get('title'),
            'summary' => \Input::get('summary'),
            'text' => \Input::get('text'),
            'category_id' => \Input::get('category_id'),
            'author_id' => \Input::get('author_id'),
            'page_id' => \Input::get('page_id'),
            'publication_date' => $publicationDate->format('Y-m-d H:i:s'),
        ]);

        try {
            \App::make('UpdateArticleInteractor')->run($articleID, $articleStructure);
            return \Redirect::route('back_articles_index');
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.editorial.articles.edit', [
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