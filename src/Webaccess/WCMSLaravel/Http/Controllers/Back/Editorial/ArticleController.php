<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Structures\ArticleStructure;
use CMS\Structures\Blocks\ArticleBlockStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class ArticleController extends AdminController
{
    public function index()
    {
        $articles = \App::make('GetArticlesInteractor')->getAll($this->getLangID(), true);
        foreach ($articles as $article) {
            if ($article->author_id) {
                $article->author = \App::make('GetUserInteractor')->getUserByID($article->author_id, true);
            }

            if ($article->category_id) {
                $article->category = \App::make('GetArticleCategoryInteractor')->getArticleCategoryByID($article->category_id, true);
            }

            if ($article->page_id) {
                $article->page = \App::make('GetPageInteractor')->getPageByID($article->page_id, true);
            }

        }

        return view('w-cms-laravel::back.editorial.articles.index', [
            'articles' => $articles,
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.editorial.articles.create', [
            'article_categories' => \App::make('GetArticleCategoriesInteractor')->getAll($this->getLangID(), true),
            'pages' => \App::make('GetPagesInteractor')->getAll(true),
            'medias' => \App::make('GetMediasInteractor')->getAll(true),
        ]);
    }

    public function store()
    {
        $publicationDate = \DateTime::createFromFormat('d/m/Y H:i', \Input::get('publication_date'));
        $articleStructure = new ArticleStructure([
            'title' => \Input::get('title'),
            'summary' => \Input::get('summary'),
            'text' => \Input::get('text'),
            'lang_id' => $this->getLangID(),
            'category_id' => \Input::get('category_id'),
            'author_id' => \Input::get('author_id'),
            'page_id' => \Input::get('page_id'),
            'media_id' => \Input::get('media_id'),
            'publication_date' => $publicationDate->format('Y-m-d H:i:s'),
        ]);

        try {
            $articleID = \App::make('CreateArticleInteractor')->run($articleStructure);
            return \Redirect::route('back_articles_edit', array('articleID' => $articleID));
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.editorial.articles.create', [
                'error' => $e->getMessage(),
                'article' => $articleStructure
            ]);
        }
    }

    public function edit($articleID)
    {
        try {
            return view('w-cms-laravel::back.editorial.articles.edit', [
                'article' => \App::make('GetArticleInteractor')->getArticleByID($articleID, true),
                'article_categories' => \App::make('GetArticleCategoriesInteractor')->getAll($this->getLangID(), true),
                'master_pages' => \App::make('GetPagesInteractor')->getMasterPages(true),
                'medias' => \App::make('GetMediasInteractor')->getAll(true),
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
            'media_id' => \Input::get('media_id'),
            'publication_date' => $publicationDate->format('Y-m-d H:i:s'),
        ]);
        try {
            \App::make('UpdateArticleInteractor')->run($articleID, $articleStructure);

            //Create associated page
            if (\Input::get('create_associated_page') && \Input::get('page_id')) {
                $pageStructure = \App::make('GetPageInfoFromMasterInteractor')->getPageStructure(\Input::get('page_id'), \Input::get('title'));

                //Replace "ghost" block with the article block
                $articleStructure = new ArticleBlockStructure([
                    'article_id' => $articleID
                ]);
                $pageID = \App::make('CreatePageFromMasterInteractor')->run($pageStructure, $articleStructure);

                $articleStructure = new ArticleStructure([
                    'page_id' => $pageID
                ]);
                \App::make('UpdateArticleInteractor')->run($articleID, $articleStructure);
            }
            return \Redirect::route('back_articles_index');
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.editorial.articles.edit', [
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