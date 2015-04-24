<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Article;
use CMS\Repositories\ArticleRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Article as ArticleModel;

class EloquentArticleRepository implements ArticleRepositoryInterface
{
    public function findByID($articleID)
    {
        if ($articleModel = ArticleModel::find($articleID))
            return self::createArticleFromModel($articleModel);

        return false;
    }

    public function findByTitle($articleTitle)
    {
        if ($articleModel = ArticleModel::where('title', '=', $articleTitle)->first())
            return self::createArticleFromModel($articleModel);

        return false;
    }

    public function findByPageID($pageID)
    {
        $articleModels = ArticleModel::where('page_id', '=', $pageID)->get();

        $articles = [];
        foreach ($articleModels as $articleModel)
            $articles[]= self::createArticleFromModel($articleModel);

        return $articles;
    }

    public function findAll($langID = null, $categoryID = null, $number = null, $order = 'desc')
    {
        if ($categoryID)
            $query = ArticleModel::where('category_id', '=', $categoryID);
        else
            $query = ArticleModel::whereRaw('1=1');

        if ($langID) {
            $query->where('lang_id', '=', $langID);
        }

        if ($number) {
            $query->take($number);
        }

        $query->orderBy('publication_date', $order);

        $articleModels = $query->get();

        $articles = [];
        foreach ($articleModels as $articleModel)
            $articles[]= self::createArticleFromModel($articleModel);

        return $articles;
    }

    public function createArticle(Article $article)
    {
        $articleModel = new ArticleModel();
        $articleModel->title = $article->getTitle();
        $articleModel->summary = $article->getSummary();
        $articleModel->text = $article->getText();
        $articleModel->lang_id = $article->getLangID();
        $articleModel->category_id = $article->getCategoryID();
        $articleModel->author_id = $article->getAuthorID();
        $articleModel->page_id = $article->getPageID();
        $articleModel->media_id = $article->getMediaID();
        $articleModel->publication_date = $article->getPublicationDate();
        $articleModel->save();

        return $articleModel->id;
    }

    public function updateArticle(Article $article)
    {
        $articleModel = ArticleModel::find($article->getID());
        $articleModel->title = $article->getTitle();
        $articleModel->summary = $article->getSummary();
        $articleModel->text = $article->getText();
        $articleModel->category_id = $article->getCategoryID();
        $articleModel->author_id = $article->getAuthorID();
        $articleModel->page_id = $article->getPageID();
        $articleModel->media_id = $article->getMediaID();
        $articleModel->publication_date = $article->getPublicationDate();

        return $articleModel->save();
    }

    public function deleteArticle($articleID)
    {
        $articleModel = ArticleModel::where('id', '=', $articleID)->first();

        return $articleModel->delete();
    }

    private static function createArticleFromModel(ArticleModel $articleModel)
    {
        $article = new Article();
        $article->setID($articleModel->id);
        $article->setTitle($articleModel->title);
        $article->setSummary($articleModel->summary);
        $article->setText($articleModel->text);
        $article->setLangID($articleModel->lang_id);
        $article->setCategoryID($articleModel->category_id);
        $article->setAuthorID($articleModel->author_id);
        $article->setPageID($articleModel->page_id);
        $article->setMediaID($articleModel->media_id);
        $article->setPublicationDate($articleModel->publication_date);

        return $article;
    }
}