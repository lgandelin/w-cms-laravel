<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use Webaccess\WCMSLaravel\Back\AdminController;

class PageController extends AdminController {

	public function __construct()
	{
		parent::__construct();
		$this->pageManager = new \CMS\Services\PageManager(new \Webaccess\WCMSLaravel\Repositories\EloquentPageRepository());
	}

	public function index()
	{
		$this->layout = \View::make('w-cms-laravel::back.editorial.pages.index', [
			'pages' => $this->pageManager->getAll()
		]);
	}

	public function create()
	{
		$this->layout = \View::make('w-cms-laravel::back.editorial.pages.create');
	}

	public function store()
	{
		$pageS = new \CMS\Structures\PageStructure([
		    'name' => \Input::get('name'),
		    'uri' => \Input::get('uri'),
		    'identifier' => \Input::get('identifier'),
		    'text' => \Input::get('text'),
		    'meta_title' => \Input::get('meta_title'),
		    'meta_description' => \Input::get('meta_description'),
		    'meta_keywords' => \Input::get('meta_keywords')
		]);
		
		try {
			$this->pageManager->createPage($pageS);
			return \Redirect::route('back_pages_index');
		} catch (\Exception $e) {
			 $this->layout = \View::make('w-cms-laravel::back.editorial.pages.create', [
				'error' => $e->getMessage(),
				'page' => $pageS
			]);
		}
	}

	public function edit($identifier)
	{
		$page = $this->pageManager->getByIdentifier($identifier);

		try {
		    $pageS = $this->pageManager->getByIdentifier($identifier);
		    $this->layout = \View::make('w-cms-laravel::back.editorial.pages.edit', [
		        'page' => $pageS
		    ]);
		} catch (\Exception $e) {
		     $this->layout = \View::make('w-cms-laravel::back.editorial.pages.edit', [
				'error' => $e->getMessage(),
				'page' => $pageS
             ]);
		}
	}

	public function update()
	{
		$pageS = new \CMS\Structures\PageStructure([
		    'name' => \Input::get('name'),
		    'uri' => \Input::get('uri'),
		    'identifier' => \Input::get('identifier'),
		    'text' => \Input::get('text'),
		    'meta_title' => \Input::get('meta_title'),
		    'meta_description' => \Input::get('meta_description'),
		    'meta_keywords' => \Input::get('meta_keywords')
		]);

		try {
		    $this->pageManager->updatePage($pageS);
		    return \Redirect::route('back_pages_index');
		} catch (\Exception $e) {
		     var_dump($e->getMessage());
		}
	}

	public function delete($identifier = null)
	{
		try {
            $this->pageManager->deletePage($identifier);
            return \Redirect::route('back_pages_index');
        } catch (\Exception $e) {
             var_dump($e->getMessage());
        }
	}

	public function duplicate($identifier = null)
	{
		try {
			$this->pageManager->duplicatePage($identifier);
            return \Redirect::route('back_pages_index');
        } catch (\Exception $e) {
             var_dump($e->getMessage());
        }
	}

}