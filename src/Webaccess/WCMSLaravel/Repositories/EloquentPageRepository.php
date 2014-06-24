<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Page;
use CMS\Repositories\PageRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Page as PageModel;

class EloquentPageRepository implements PageRepositoryInterface {

	public function findByIdentifier($identifier)
	{
		$pageDB = PageModel::where('identifier', '=', $identifier)->first();
			
		if ($pageDB) {
			$page = new Page();
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
		$pageDB = PageModel::where('uri', '=', $uri)->first();

		if ($pageDB) {
			$page = new Page();
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
		$pagesDB = PageModel::get();

		$pages = [];
		foreach ($pagesDB as $i => $pageDB) {
			$page = new Page();
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

	public function createPage(Page $page)
	{
		$pageDB = new PageModel();
		$pageDB->name = $page->getName();
		$pageDB->identifier = $page->getIdentifier();
		$pageDB->uri = $page->getUri();
		$pageDB->text = $page->getText();

		$pageDB->meta_title = $page->getMetaTitle();
		$pageDB->meta_description = $page->getMetaDescription();
		$pageDB->meta_keywords = $page->getMetaKeywords();

		return $pageDB->save();
	}

	public function updatePage(Page $page)
	{
		$pageDB = PageModel::where('identifier', '=', $page->getIdentifier())->first();
		$pageDB->name = $page->getName();
		$pageDB->uri = $page->getUri();
		$pageDB->text = $page->getText();

		$pageDB->meta_title = $page->getMetaTitle();
		$pageDB->meta_description = $page->getMetaDescription();
		$pageDB->meta_keywords = $page->getMetaKeywords();

		return $pageDB->save();
	}

	public function deletePage(Page $page)
	{
		$pageDB = PageModel::where('identifier', '=', $page->getIdentifier())->first();
		
		return $pageDB->delete();
	}
	
}