<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Page;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\PageStructure;
use Webaccess\WCMSLaravel\Models\Page as PageModel;

class EloquentPageRepository implements PageRepositoryInterface {

    public function findByID($pageID)
    {
        $pageDB = PageModel::find($pageID);

        if ($pageDB) {
            $pageStructure = new PageStructure();
            $pageStructure->ID = $pageDB->id;
            $pageStructure->name = $pageDB->name;
            $pageStructure->uri = $pageDB->uri;
            $pageStructure->identifier = $pageDB->identifier;
            $pageStructure->text = $pageDB->text;
            $pageStructure->meta_title = $pageDB->meta_title;
            $pageStructure->meta_description = $pageDB->meta_description;
            $pageStructure->meta_keywords = $pageDB->meta_keywords;

            return $pageStructure;
        }

        return false;
    }

	public function findByIdentifier($pageIdentifier)
	{
		$pageDB = PageModel::where('identifier', '=', $pageIdentifier)->first();
			
		if ($pageDB) {
            $pageStructure = new PageStructure();
            $pageStructure->ID = $pageDB->id;
            $pageStructure->name = $pageDB->name;
            $pageStructure->uri = $pageDB->uri;
            $pageStructure->identifier = $pageDB->identifier;
            $pageStructure->text = $pageDB->text;
            $pageStructure->meta_title = $pageDB->meta_title;
            $pageStructure->meta_description = $pageDB->meta_description;
            $pageStructure->meta_keywords = $pageDB->meta_keywords;

			return $pageStructure;
		}
		
		return false;
	}

	public function findByUri($pageURI)
	{
		$pageDB = PageModel::where('uri', '=', $pageURI)->first();

		if ($pageDB) {
            $pageStructure = new PageStructure();
            $pageStructure->ID = $pageDB->id;
            $pageStructure->name = $pageDB->name;
            $pageStructure->uri = $pageDB->uri;
            $pageStructure->identifier = $pageDB->identifier;
            $pageStructure->text = $pageDB->text;
            $pageStructure->meta_title = $pageDB->meta_title;
            $pageStructure->meta_description = $pageDB->meta_description;
            $pageStructure->meta_keywords = $pageDB->meta_keywords;

			return $pageStructure;
		}

		return false;
	}

	public function findAll()
	{
		$pagesDB = PageModel::get();

		$pages = [];
		foreach ($pagesDB as $i => $pageDB) {
            $pageStructure = new PageStructure();
            $pageStructure->ID = $pageDB->id;
            $pageStructure->name = $pageDB->name;
            $pageStructure->uri = $pageDB->uri;
            $pageStructure->identifier = $pageDB->identifier;
            $pageStructure->text = $pageDB->text;
            $pageStructure->meta_title = $pageDB->meta_title;
            $pageStructure->meta_description = $pageDB->meta_description;
            $pageStructure->meta_keywords = $pageDB->meta_keywords;
		
			$pages[]= $pageStructure;
		}

		return $pages;
	}

	public function createPage(PageStructure $pageStructure)
	{
		$pageDB = new PageModel();
		$pageDB->name = $pageStructure->name;
		$pageDB->identifier = $pageStructure->identifier;
		$pageDB->uri = $pageStructure->uri;
		$pageDB->text = $pageStructure->text;
		$pageDB->meta_title = $pageStructure->meta_title;
		$pageDB->meta_description = $pageStructure->meta_description;
		$pageDB->meta_keywords = $pageStructure->meta_keywords;

		return $pageDB->save();
	}

	public function updatePage($pageID, PageStructure $pageStructure)
	{
		$pageDB = PageModel::find($pageID);
		$pageDB->name = $pageStructure->name;
        $pageDB->identifier = $pageStructure->identifier;
		$pageDB->uri = $pageStructure->uri;
		$pageDB->text = $pageStructure->text;
		$pageDB->meta_title = $pageStructure->meta_title;
		$pageDB->meta_description = $pageStructure->meta_description;
		$pageDB->meta_keywords = $pageStructure->meta_keywords;

		return $pageDB->save();
	}

	public function deletePage($pageID)
	{
		$pageDB = PageModel::find($pageID);
		
		return $pageDB->delete();
	}
	
}