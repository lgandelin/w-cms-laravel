<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Interactors\ArticleCategories\GetArticleCategoriesInteractor;
use CMS\Interactors\ArticleCategories\GetArticleCategoryInteractor;
use CMS\Interactors\Articles\CreateArticleInteractor;
use CMS\Interactors\Articles\DeleteArticleInteractor;
use CMS\Interactors\Articles\GetArticleInteractor;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Interactors\Articles\UpdateArticleInteractor;
use CMS\Interactors\Medias\GetMediasInteractor;
use CMS\Interactors\Pages\CreatePageFromMasterInteractor;
use CMS\Interactors\Pages\GetPageInfoFromMasterInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMS\Interactors\Users\GetUserInteractor;
use CMS\Structures\DataStructure;
use CMS\Structures\Blocks\ArticleBlockStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class ArticleController extends AdminController
{
    public function index()
    {
        $articles = (new GetArticlesInteractor())->getAll(null, null, null, $this->getLangID(), true);
        foreach ($articles as $article) {
            if ($article->authorID) {
                $article->author = (new GetUserInteractor())->getUserByID($article->authorID, true);
            }

            if ($article->categoryID) {
                $article->category = (new GetArticleCategoryInteractor())->getArticleCategoryByID($article->categoryID, true);
            }

            if ($article->pageID) {
                $article->page = (new GetPageInteractor())->getPageByID($article->pageID, true);
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
            'article_categories' => (new GetArticleCategoriesInteractor())->getAll($this->getLangID(), true),
            'pages' => (new GetPagesInteractor())->getAll(true),
            'medias' => (new GetMediasInteractor())->getAll(true),
        ]);
    }

    public function store()
    {
        $publicationDate = \DateTime::createFromFormat('d/m/Y H:i', \Input::get('publication_date'));
        $articleStructure = new DataStructure([
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
            $articleID = (new CreateArticleInteractor())->run($articleStructure);
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
                'article' => (new GetArticleInteractor())->getArticleByID($articleID, true),
                'article_categories' => (new GetArticleCategoriesInteractor())->getAll($this->getLangID(), true),
                'master_pages' => (new GetPagesInteractor())->getMasterPages(true),
                'medias' => (new GetMediasInteractor())->getAll(true),
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
        $articleStructure = new DataStructure([
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
            (new UpdateArticleInteractor())->run($articleID, $articleStructure);

            //Create associated page
            if (\Input::get('create_associated_page') && \Input::get('page_id')) {
                $pageStructure = (new GetPageInfoFromMasterInteractor())->getPageStructure(\Input::get('page_id'), \Input::get('title'));

                //Replace "ghost" block with the article block
                $articleStructure = new ArticleBlockStructure([
                    'article_id' => $articleID
                ]);
                $pageID = (new CreatePageFromMasterInteractor())->run($pageStructure, $articleStructure);

                $articleStructure = new DataStructure([
                    'pageID' => $pageID
                ]);
                (new UpdateArticleInteractor())->run($articleID, $articleStructure);
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
            (new DeleteArticleInteractor())->run($articleID);
            return \Redirect::route('back_articles_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_articles_index');
        }
    }
}