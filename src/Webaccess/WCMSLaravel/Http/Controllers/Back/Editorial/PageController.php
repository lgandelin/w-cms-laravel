<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use Illuminate\Support\Facades\Input;
use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\BlockTypes\GetBlockTypesInteractor;
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
use Webaccess\WCMSCore\Interactors\Versions\DeletePageVersionInteractor;
use Webaccess\WCMSCore\Interactors\Versions\PublishPageVersionInteractor;
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
		    'name' => Input::get('name'),
		    'uri' => $lang->prefix . Input::get('uri'),
		    'lang_id' => $this->getLangID(),
		    'identifier' => Input::get('identifier'),
            'master_page_id' => Input::get('master_page_id'),
            'is_master' => Input::get('is_master'),
            'is_visible' => Input::get('is_visible'),
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
            $currentVersion = Context::get('version_repository')->findByID($page->versionID);
            $draftVersion = Context::get('version_repository')->findByID($page->draftVersionID);
            $areas = (new GetAreasInteractor())->getByPageIDAndVersionNumber($pageID, $draftVersion->getNumber(), true);

            if ($areas) {
                foreach ($areas as $area) {
                    $area->blocks = (new GetBlocksInteractor())->getAllByAreaID($area->ID, true);
                    foreach ($area->blocks as $block) {
                        if ($block->type->back_controller) {
                            $block->back_content = (new $block->type->back_controller)->index($block);
                        } elseif ($block->type->back_view) {
                            $block->back_content = view($block->type->back_view, ['block' => $block])->render();
                        }
                    }
                    $page->areas[]= $area;
                }
            }

            $blockTypes = (new GetBlockTypesInteractor())->getAll(true);
            foreach ($blockTypes as $blockType) {
                if ($blockType->back_controller) {
                    $blockType->back_content = (new $blockType->back_controller)->index(new DataStructure());
                } elseif ($blockType->back_view) {
                    $blockType->back_content = view($blockType->back_view)->render();
                }
            }

            $versionsObjects = Context::get('version_repository')->findByPageID($pageID);
            $versions = [];
            foreach ($versionsObjects as $version) {
                $versions[]= $version->toStructure();
            }

		    return view('w-cms-laravel::back.editorial.pages.edit', [
                'block_types' => $blockTypes,
                'medias' => (new GetMediasInteractor())->getAll(true),
                'media_formats' => (new GetMediaFormatsInteractor())->getAll(true),
                'page' => $page,
                'versions' => $versions,
                'current_version' => $currentVersion->toStructure(),
                'draft_version' => $draftVersion->toStructure(),
            ]);
		} catch (\Exception $e) {
			\Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
		}
	}

    public function update_infos()
    {
        $pageID = Input::get('ID');
        $pageStructure = new DataStructure([
            'name' => Input::get('name'),
            'identifier' => Input::get('identifier'),
            'is_master' => Input::get('is_master'),
            'is_visible' => Input::get('is_visible'),
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
        $pageID = Input::get('ID');
        $pageStructure = new DataStructure([
            'uri' => Input::get('uri'),
            'meta_title' => Input::get('meta_title'),
            'meta_description' => Input::get('meta_description'),
            'meta_keywords' => Input::get('meta_keywords'),
            'is_indexed' => filter_var(Input::get('is_indexed'), FILTER_VALIDATE_BOOLEAN)
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
            \Cache::forget(Input::get('uri'));
        }
    }

    public function publish_page_version($pageID, $versionNumber)
    {
        try {
            (new PublishPageVersionInteractor())->run($pageID, $versionNumber);
            return \Redirect::route('back_pages_edit', array('page_id' => $pageID));
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
        }
    }

    public function delete_page_version($pageID, $versionNumber)
    {
        try {
            (new DeletePageVersionInteractor())->run($pageID, $versionNumber);
            return \Redirect::route('back_pages_edit', array('page_id' => $pageID));
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
        }
    }
}