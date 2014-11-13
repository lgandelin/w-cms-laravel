<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\ArticleCategory;
use CMS\Repositories\ArticleCategoryRepositoryInterface;
use Webaccess\WCMSLaravel\Models\ArticleCategory as ArticleCategoryModel;

class EloquentArticleCategoryRepository implements ArticleCategoryRepositoryInterface
{
    public function findByID($contentID)
    {
        if ($contentModel = ArticleCategoryModel::find($contentID))
            return self::createArticleCategoryFromModel($contentModel);

        return false;
    }

    public function findAll()
    {
        $contentModels = ArticleCategoryModel::get();

        $contents = [];
        foreach ($contentModels as $contentModel)
            $contents[]= self::createArticleCategoryFromModel($contentModel);

        return $contents;
    }

    public function createArticleCategory(ArticleCategory $content)
    {
        $contentModel = new ArticleCategoryModel();
        $contentModel->name = $content->getName();
        $contentModel->description = $content->getDescription();

        return $contentModel->save();
    }

    public function updateArticleCategory(ArticleCategory $content)
    {
        $contentModel = ArticleCategoryModel::find($content->getID());
        $contentModel->name = $content->getName();
        $contentModel->description = $content->getDescription();

        return $contentModel->save();
    }

    public function deleteArticleCategory($contentID)
    {
        $contentModel = ArticleCategoryModel::where('id', '=', $contentID)->first();

        return $contentModel->delete();
    }

    private static function createArticleCategoryFromModel(ArticleCategoryModel $contentModel)
    {
        $content = new ArticleCategory();
        $content->setID($contentModel->id);
        $content->setName($contentModel->name);
        $content->setDescription($contentModel->description);

        return $content;
    }
}