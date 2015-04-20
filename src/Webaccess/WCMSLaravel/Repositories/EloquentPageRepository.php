<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Page;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\PageStructure;
use Webaccess\WCMSLaravel\Models\Page as PageModel;

class EloquentPageRepository implements PageRepositoryInterface {

    public function findByID($pageID)
    {
        if ($pageModel = PageModel::find($pageID))
            return self::createPageFromModel($pageModel);

        return false;
    }

	public function findByIdentifier($pageIdentifier)
	{
		if ($pageModel = PageModel::where('identifier', '=', $pageIdentifier)->first())
            return self::createPageFromModel($pageModel);
		
		return false;
	}

	public function findByUri($pageURI)
	{
		if ($pageModel = PageModel::where('uri', '=', $pageURI)->first())
            return self::createPageFromModel($pageModel);

		return false;
	}

	public function findAll($langID = null)
	{
        $pageModels = PageModel::get();
        if ($langID) {
            $pageModels = PageModel::where('lang_id', '=', $langID)->get();
        }

		$pages = [];
		foreach ($pageModels as $pageModel)
			$pages[]= self::createPageFromModel($pageModel);

		return $pages;
	}

    public function findMasterPages()
    {
        $pageModels = PageModel::where('is_master', '=', 1)->get();

        $pages = [];
        foreach ($pageModels as $pageModel)
            $pages[]= self::createPageFromModel($pageModel);

        return $pages;
    }

    public function findChildPages($pageID)
    {
        $pageModels = PageModel::where('master_page_id', '=', $pageID)->get();

        $pages = [];
        foreach ($pageModels as $pageModel)
            $pages[]= self::createPageFromModel($pageModel);

        return $pages;
    }

	public function createPage(Page $page)
	{
		$pageModel = new PageModel();
		$pageModel->name = $page->getName();
		$pageModel->identifier = $page->getIdentifier();
		$pageModel->uri = $page->getURI();
		$pageModel->lang_id = $page->getLangID();
		$pageModel->meta_title = $page->getMetaTitle();
		$pageModel->meta_description = $page->getMetaDescription();
		$pageModel->meta_keywords = $page->getMetaKeywords();
		$pageModel->is_master = $page->getIsMaster();
        $pageModel->master_page_id = $page->getMasterPageID();

		$pageModel->save();

        return $pageModel->id;
	}

	public function updatePage(Page $page)
	{
		$pageModel = PageModel::find($page->getID());
        $pageModel->name = $page->getName();
        $pageModel->identifier = $page->getIdentifier();
        $pageModel->uri = $page->getURI();
        $pageModel->meta_title = $page->getMetaTitle();
        $pageModel->meta_description = $page->getMetaDescription();
        $pageModel->meta_keywords = $page->getMetaKeywords();
        $pageModel->is_master = $page->getIsMaster();
        $pageModel->master_page_id = $page->getMasterPageID();

		return $pageModel->save();
	}

	public function deletePage($pageID)
	{
		$pageModel = PageModel::find($pageID);
		
		return $pageModel->delete();
	}

    private static function createPageFromModel(PageModel $pageModel)
    {
        $page = new Page();
        $page->setID($pageModel->id);
        $page->setName($pageModel->name);
        $page->setIdentifier($pageModel->identifier);
        $page->setURI($pageModel->uri);
        $page->setMetaTitle($pageModel->meta_title);
        $page->setMetaDescription($pageModel->meta_description);
        $page->setMetaKeywords($pageModel->meta_keywords);
        $page->setIsMaster($pageModel->is_master);
        $page->setMasterPageID($pageModel->master_page_id);

        return $page;
    }
}