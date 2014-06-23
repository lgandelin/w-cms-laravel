<?php

namespace Webaccess\WCMSLaravel\Repositories;

class EloquentPageRepository implements \CMS\Repositories\PageRepositoryInterface {

	public function findByIdentifier($identifier)
	{
		$pageDB = \Webaccess\WCMSLaravel\Models\Page::where('identifier', '=', $identifier)->first();
			
		if ($pageDB) {
			$page = new \CMS\Entities\Page();
			$page->setName($pageDB->name);
			$page->setUri($pageDB->uri);
			$page->setIdentifier($pageDB->identifier);
			$page->setText($pageDB->text);
			$page->setMetaTitle($pageDB->meta_title);
			$page->setMetaDescription($pageDB->meta_description);
			$page->setMetaKeywords($pageDB->meta_keywords);

			return $page;
		}
		
		return false;
	}

	public function findByUri($uri)
	{
		$pageDB = \Webaccess\WCMSLaravel\Models\Page::where('uri', '=', $uri)->first();

		if ($pageDB) {
			$page = new \CMS\Entities\Page();
			$page->setName($pageDB->name);
			$page->setUri($pageDB->uri);
			$page->setIdentifier($pageDB->identifier);
			$page->setText($pageDB->text);
			$page->setMetaTitle($pageDB->meta_title);
			$page->setMetaDescription($pageDB->meta_description);
			$page->setMetaKeywords($pageDB->meta_keywords);

			return $page;
		}

		return false;
	}

	public function findAll()
	{
		$pagesDB = \Webaccess\WCMSLaravel\Models\Page::get();

		$pages = [];
		foreach ($pagesDB as $i => $pageDB) {
			$page = new \CMS\Entities\Page();
			$page->setName($pageDB->name);
			$page->setUri($pageDB->uri);
			$page->setIdentifier($pageDB->identifier);
			$page->setText($pageDB->text);
			$page->setMetaTitle($pageDB->meta_title);
			$page->setMetaDescription($pageDB->meta_description);
			$page->setMetaKeywords($pageDB->meta_keywords);
		
			$pages[]= $page;
		}

		return $pages;
	}

	public function createPage(\CMS\Entities\Page $page)
	{
		$pageDB = new \Webaccess\WCMSLaravel\Models\Page();
		$pageDB->name = $page->getName();
		$pageDB->identifier = $page->getIdentifier();
		$pageDB->uri = $page->getUri();
		$pageDB->text = $page->getText();

		$pageDB->meta_title = $page->getMetaTitle();
		$pageDB->meta_description = $page->getMetaDescription();
		$pageDB->meta_keywords = $page->getMetaKeywords();

		return $pageDB->save();
	}

	public function updatePage(\CMS\Entities\Page $page)
	{
		$pageDB = \Webaccess\WCMSLaravel\Models\Page::where('identifier', '=', $page->getIdentifier())->first();
		$pageDB->name = $page->getName();
		$pageDB->uri = $page->getUri();
		$pageDB->text = $page->getText();

		$pageDB->meta_title = $page->getMetaTitle();
		$pageDB->meta_description = $page->getMetaDescription();
		$pageDB->meta_keywords = $page->getMetaKeywords();

		return $pageDB->save();
	}

	public function deletePage(\CMS\Entities\Page $page)
	{
		$pageDB = \Webaccess\WCMSLaravel\Models\Page::where('identifier', '=', $page->getIdentifier())->first();
		
		return $pageDB->delete();
	}
}