<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Context;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\ArticleCategories\GetArticleCategoriesInteractor;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Langs\GetLangInteractor;
use CMS\Interactors\MediaFormats\GetMediaFormatsInteractor;
use CMS\Interactors\Medias\GetMediasInteractor;
use CMS\Interactors\Menus\GetMenusInteractor;
use CMS\Interactors\Pages\CreatePageFromMasterInteractor;
use CMS\Interactors\Pages\CreatePageInteractor;
use CMS\Interactors\Pages\DeletePageInteractor;
use CMS\Interactors\Pages\DuplicatePageInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMS\Interactors\Pages\UpdatePageInteractor;
use CMS\DataStructure;
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
            'master_pages' => (new GetPagesInteractor())->getMasterPages(true),
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
                        $area->blocks[$i]= $block;
                    }
                    $page->areas[]= $area;
                }
            }

            \App::make('BlockTypesVariable')->addVariable('page', $page);
            \App::make('BlockTypesVariable')->addVariable('menus', (new GetMenusInteractor())->getAll($this->getLangID(), true));
            \App::make('BlockTypesVariable')->addVariable('articles', (new GetArticlesInteractor())->getAll(null, null, null, $this->getLangID(), true));
            \App::make('BlockTypesVariable')->addVariable('article_categories', (new GetArticleCategoriesInteractor())->getAll($this->getLangID(), true));
            \App::make('BlockTypesVariable')->addVariable('global_blocks', (new GetBlocksInteractor())->getGlobalBlocks(true));
            \App::make('BlockTypesVariable')->addVariable('medias', (new GetMediasInteractor())->getAll(true));
            \App::make('BlockTypesVariable')->addVariable('media_formats', (new GetMediaFormatsInteractor())->getAll(true));

            $params = \App::make('BlockTypesVariable')->getVariables();
            $params['block_types'] = Context::getRepository('block_type')->findAll();

		    return view('w-cms-laravel::back.editorial.pages.edit', $params);

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
}