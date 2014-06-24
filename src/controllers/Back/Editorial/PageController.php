<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Services\PageManager;
use CMS\Structures\PageStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class PageController extends AdminController {

	public function __construct(PageManager $pageManager)
	{
		parent::__construct();
		$this->pageManager = $pageManager;
	}

	public function index()
	{
		$this->layout = \View::make('w-cms-laravel::back.editorial.pages.index', [
			'pages' => $this->pageManager->getAll(),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
		]);
	}

	public function create()
	{
		$this->layout = \View::make('w-cms-laravel::back.editorial.pages.create');
	}

	public function store()
	{
		$pageS = new PageStructure([
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
			\Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
		}
	}

	public function update()
	{
		$pageS = new PageStructure([
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
			$this->layout = \View::make('w-cms-laravel::back.editorial.pages.edit', [
				'error' => $e->getMessage(),
				'page' => $pageS
			]);
		}
	}

	public function delete($identifier = null)
	{
		try {
            $this->pageManager->deletePage($identifier);
            return \Redirect::route('back_pages_index');
        } catch (\Exception $e) {
			\Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
        }
	}

	public function duplicate($identifier = null)
	{
		try {
			$this->pageManager->duplicatePage($identifier);
            return \Redirect::route('back_pages_index');
        } catch (\Exception $e) {
			\Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
        }
	}

}