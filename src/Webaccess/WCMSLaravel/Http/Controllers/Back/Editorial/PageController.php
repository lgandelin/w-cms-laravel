<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\Langs\GetLangInteractor;
use Webaccess\WCMSCore\Interactors\MediaFormats\GetMediaFormatsInteractor;
use Webaccess\WCMSCore\Interactors\Medias\GetMediasInteractor;
use Webaccess\WCMSCore\Interactors\Pages\CreatePageFromMasterInteractor;
use Webaccess\WCMSCore\Interactors\Pages\CreatePageInteractor;
use Webaccess\WCMSCore\Interactors\Pages\DeletePageInteractor;
use Webaccess\WCMSCore\Interactors\Pages\DuplicatePageInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPagesInteractor;
use Webaccess\WCMSCore\Interactors\Pages\UpdatePageInteractor;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class PageController extends AdminController
{
	public function index()
	{
		return view('w-cms-laravel::back.editorial.pages.index', [
			'pages' => (new GetPagesInteractor())->getAll($this->getLangID(), true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
		]);
	}

	public function create()
	{
		return view('w-cms-laravel::back.editorial.pages.create', [
            //'master_pages' => (new GetPagesInteractor())->getMasterPages(true),
            'master_pages' => [],
        ]);
	}

	public function store()
	{
        $lang = (new GetLangInteractor())->getLangByID($this->getLangID(), true);
        $pageStructure = new DataStructure([
		    'name' => \Input::get('name'),
		    'uri' => $lang->prefix . \Input::get('uri'),
		    'lang_id' => $this->getLangID(),
		    'identifier' => \Input::get('identifier'),
            'master_page_id' => \Input::get('master_page_id'),
            'is_master' => \Input::get('is_master')
		]);

		try {
            if ($pageStructure->master_page_id)
                $pageID = (new CreatePageFromMasterInteractor())->run($pageStructure);
            else
                $pageID = (new CreatePageInteractor())->run($pageStructure);

			return \Redirect::route('back_pages_edit', array('pageID' => $pageID));
		} catch (\Exception $e) {
			return view('w-cms-laravel::back.editorial.pages.create', [
				'error' => $e->getMessage(),
				'page' => $pageStructure
			]);
		}
	}

	public function edit($pageID)
	{
		try {
            $page = (new GetPageInteractor())->getPageByID($pageID, true);
            $areas = (new GetAreasInteractor())->getAll($pageID, true);

            if ($areas) {
                foreach ($areas as $area) {
                    $area->blocks = (new GetBlocksInteractor())->getAllByAreaID($area->ID, true);
                    foreach ($area->blocks as $i => $block) {
                        if (isset($block->type->back_controller) && $block->type->back_controller != '') {
                            $block->form = (new $block->type->back_controller)->getForm($block);
                        }

                        $area->blocks[$i]= $block;
                    }
                    $page->areas[]= $area;
                }
            }

		    return view('w-cms-laravel::back.editorial.pages.edit', [
                'block_types' => Context::get('block_type_repository')->findAll(true),
                'medias' => (new GetMediasInteractor())->getAll(true),
                'media_formats' => (new GetMediaFormatsInteractor())->getAll(true),
                'page' => $page,
            ]);
		} catch (\Exception $e) {
			\Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
		}
	}

    public function update_infos()
    {
        $pageID = \Input::get('ID');
        $pageStructure = new DataStructure([
            'name' => \Input::get('name'),
            'identifier' => \Input::get('identifier'),
            'is_master' => \Input::get('is_master'),
        ]);

        try {
            (new UpdatePageInteractor())->run($pageID, $pageStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_seo()
    {
        $pageID = \Input::get('ID');
        $pageStructure = new DataStructure([
            'uri' => \Input::get('uri'),
            'meta_title' => \Input::get('meta_title'),
            'meta_description' => \Input::get('meta_description'),
            'meta_keywords' => \Input::get('meta_keywords')
        ]);

        try {
            (new UpdatePageInteractor())->run($pageID, $pageStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete($pageID)
    {
        try {
            (new DeletePageInteractor())->run($pageID);
            return \Redirect::route('back_pages_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
        }
    }

    public function duplicate($pageID)
    {
        try {
            (new DuplicatePageInteractor())->run($pageID);
            return \Redirect::route('back_pages_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
        }
    }

    public function clear_cache()
    {
        if (env('CACHE_ENABLED')) {
            \Cache::forget(\Input::get('uri'));
        }
    }
}