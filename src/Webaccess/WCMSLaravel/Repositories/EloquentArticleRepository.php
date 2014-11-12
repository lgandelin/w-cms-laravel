<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Article;
use CMS\Repositories\ArticleRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Article as ArticleModel;

class EloquentArticleRepository implements ArticleRepositoryInterface
{
    public function findByID($contentID)
    {
        if ($contentModel = ArticleModel::find($contentID))
            return self::createArticleFromModel($contentModel);

        return false;
    }

    public function findByTitle($contentTitle)
    {
        if ($contentModel = ArticleModel::where('title', '=', $contentTitle)->first())
            return self::createArticleFromModel($contentModel);

        return false;
    }

    public function findAll()
    {
        $contentModels = ArticleModel::get();

        $contents = [];
        foreach ($contentModels as $contentModel)
            $contents[]= self::createArticleFromModel($contentModel);

        return $contents;
    }

    public function createArticle(Article $content)
    {
        $contentModel = new ArticleModel();
        $contentModel->title = $content->getTitle();
        $contentModel->summary = $content->getSummary();
        $contentModel->text = $content->getText();
        $contentModel->author_id = $content->getAuthorID();
        $contentModel->publication_date = $content->getPublicationDate();

        return $contentModel->save();
    }

    public function updateArticle(Article $content)
    {
        $contentModel = ArticleModel::find($content->getID());
        $contentModel->title = $content->getTitle();
        $contentModel->summary = $content->getSummary();
        $contentModel->text = $content->getText();
        $contentModel->author_id = $content->getAuthorID();
        $contentModel->publication_date = $content->getPublicationDate();

        return $contentModel->save();
    }

    public function deleteArticle($contentID)
    {
        $contentModel = ArticleModel::where('id', '=', $contentID)->first();

        return $contentModel->delete();
    }

    private static function createArticleFromModel(ArticleModel $contentModel)
    {
        $content = new Article();
        $content->setID($contentModel->id);
        $content->setTitle($contentModel->title);
        $content->setSummary($contentModel->summary);
        $content->setText($contentModel->text);
        $content->setAuthorID($contentModel->author_id);
        $content->setPublicationDate($contentModel->publication_date);

        return $content;
    }
}