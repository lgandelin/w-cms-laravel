<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\ArticleCategories\GetArticleCategoriesInteractor;
use Webaccess\WCMSCore\Interactors\Articles\GetArticlesInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\Langs\GetLangInteractor;
use Webaccess\WCMSCore\Interactors\MediaFormats\GetMediaFormatsInteractor;
use Webaccess\WCMSCore\Interactors\Medias\GetMediasInteractor;
use Webaccess\WCMSCore\Interactors\Menus\GetMenusInteractor;
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
		//try {
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

            Context::addTo('block_variables', 'page', $page);
            Context::addTo('block_variables', 'menus', (new GetMenusInteractor())->getAll($this->getLangID(), true));
            Context::addTo('block_variables', 'articles', (new GetArticlesInteractor())->getAll(null, null, null, $this->getLangID(), true));
            Context::addTo('block_variables', 'article_categories', (new GetArticleCategoriesInteractor())->getAll($this->getLangID(), true));
            Context::addTo('block_variables', 'global_blocks', (new GetBlocksInteractor())->getGlobalBlocks(true));
            Context::addTo('block_variables', 'medias', (new GetMediasInteractor())->getAll(true));
            Context::addTo('block_variables', 'media_formats', (new GetMediaFormatsInteractor())->getAll(true));

            $params = Context::get('block_variables');
            $params['block_types'] = Context::get('block_type')->findAll(true);

		    return view('w-cms-laravel::back.editorial.pages.edit', $params);

		/*} catch (\Exception $e) {
			\Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
		}*/
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