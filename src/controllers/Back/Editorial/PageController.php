<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

class PageController extends \Illuminate\Routing\Controller {

	public function __construct()
	{
		$this->pageManager = new \CMS\Services\PageManager(new \Webaccess\WCMSLaravel\Repositories\EloquentPageRepository());
	}

	public function index()
	{
		$this->layout = \View::make('w-cms-laravel::back.editorial.pages.index', array(
			'pages' => $this->pageManager->getAll()
			)
		);
	}

	public function create()
	{
		$page = \CMS\Services\PageManager::createPageObject('New page', '/new-page');
		$this->layout = \View::make('w-cms-laravel::back.editorial.pages.create', array(
			'page' => $page
			)
		);
	}

	public function store()
	{
		$page = \CMS\Services\PageManager::createPageObject(
			\Input::get('name'),
			\Input::get('uri'),
			\Input::get('identifier'),
			\Input::get('text')
		);
		$page->setMetaTitle(\Input::get('meta_title'));
		$page->setMetaDescription(\Input::get('meta_description'));
		$page->setMetaKeywords(\Input::get('meta_keywords'));
		
		try {
			$this->pageManager->createPage($page);
			return \Redirect::route('back_pages_index');
		} catch (Exception $e) {
			 var_dump($e->getMessage());
		}
	}

	public function edit($identifier = null)
	{
		$page = $this->pageManager->getByIdentifier($identifier);

		if ($page) {
			$this->layout = \View::make('w-cms-laravel::back.editorial.pages.edit', array(
				'page' => $page)
			);
		} else
			var_dump('The page was not found');
	}

	public function update()
	{
		$identifier = \Input::get('identifier');
		$page = $this->pageManager->getByIdentifier($identifier);
			
		if ($page) {
			$page->setName(\Input::get('name'));
			$page->setUri(\Input::get('uri'));
			$page->setText(\Input::get('text'));
			$page->setMetaTitle(\Input::get('meta_title'));
			$page->setMetaDescription(\Input::get('meta_description'));
			$page->setMetaKeywords(\Input::get('meta_keywords'));
			
			$page->setMetaTitle(\Input::get('meta_title'));
			$page->setMetaDescription(\Input::get('meta_description'));
			$page->setMetaKeywords(\Input::get('meta_keywords'));

			try {
				$this->pageManager->updatePage($page);
				return \Redirect::route('back_pages_index');
			} catch (Exception $e) {
				 var_dump($e->getMessage());
			}
		} else
			var_dump('The page was not found');
	}

	public function delete($identifier = null)
	{
		$page = $this->pageManager->getByIdentifier($identifier);

		if ($page) {
			try {
				$this->pageManager->deletePage($page);
			} catch (Exception $e) {
				 var_dump($e->getMessage());
			}
		} else
			var_dump('The page was not found');

		return \Redirect::route('back_pages_index');
	}

	public function duplicate($identifier = null)
	{
		$page = $this->pageManager->getByIdentifier($identifier);

		if ($page) {
			$pageCopy = \CMS\Services\PageManager::duplicatePageObject($page);

			try {
				$this->pageManager->createPage($pageCopy);
			} catch (Exception $e) {
				 var_dump($e->getMessage());
			}
		} else {
			var_dump('The page was not found');
		}

		return \Redirect::route('back_pages_index');
	}

}