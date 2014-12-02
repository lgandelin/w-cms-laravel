<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\ArticleCategory;
use CMS\Repositories\ArticleCategoryRepositoryInterface;
use Webaccess\WCMSLaravel\Models\ArticleCategory as ArticleCategoryModel;

class EloquentArticleCategoryRepository implements ArticleCategoryRepositoryInterface
{
    public function findByID($articleCategoryID)
    {
        if ($articleCategoryModel = ArticleCategoryModel::find($articleCategoryID))
            return self::createArticleCategoryFromModel($articleCategoryModel);

        return false;
    }

    public function findAll()
    {
        $articleCategoryModels = ArticleCategoryModel::get();

        $articleCategorys = [];
        foreach ($articleCategoryModels as $articleCategoryModel)
            $articleCategorys[]= self::createArticleCategoryFromModel($articleCategoryModel);

        return $articleCategorys;
    }

    public function createArticleCategory(ArticleCategory $articleCategory)
    {
        $articleCategoryModel = new ArticleCategoryModel();
        $articleCategoryModel->name = $articleCategory->getName();
        $articleCategoryModel->description = $articleCategory->getDescription();

        $articleCategoryModel->save();

        return $articleCategoryModel->id;
    }

    public function updateArticleCategory(ArticleCategory $articleCategory)
    {
        $articleCategoryModel = ArticleCategoryModel::find($articleCategory->getID());
        $articleCategoryModel->name = $articleCategory->getName();
        $articleCategoryModel->description = $articleCategory->getDescription();

        return $articleCategoryModel->save();
    }

    public function deleteArticleCategory($articleCategoryID)
    {
        $articleCategoryModel = ArticleCategoryModel::where('id', '=', $articleCategoryID)->first();

        return $articleCategoryModel->delete();
    }

    private static function createArticleCategoryFromModel(ArticleCategoryModel $articleCategoryModel)
    {
        $articleCategory = new ArticleCategory();
        $articleCategory->setID($articleCategoryModel->id);
        $articleCategory->setName($articleCategoryModel->name);
        $articleCategory->setDescription($articleCategoryModel->description);

        return $articleCategory;
    }
}