<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Structure;

use CMS\Structures\Blocks\ArticleBlockStructure;
use CMS\Structures\Blocks\ArticleListBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\MediaBlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;
use CMS\Structures\BlockStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class BlockController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.structure.blocks.index', [
            'blocks' => \App::make('GetBlocksInteractor')->getGlobalBlocks(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.structure.blocks.create', [
            'menus' => \App::make('GetMenusInteractor')->getAll(true),
            'articles' => \App::make('GetArticlesInteractor')->getAll(true),
            'article_categories' => \App::make('GetArticleCategoriesInteractor')->getAll(true),
            'medias' => \App::make('GetMediasInteractor')->getAll(true),
            'media_formats' => \App::make('GetMediaFormatsInteractor')->getAll(true),
        ]);
    }

    public function store()
    {
        $blockStructure = new HTMLBlockStructure();
        $blockStructure->name = \Input::get('name');
        $blockStructure->class = \Input::get('class');

        try {
            $blockID = \App::make('CreateBlockInteractor')->run($blockStructure);

            if (\Input::exists('menu_id'))
                $blockStructure = new MenuBlockStructure([
                    'menu_id' => (\Input::get('menu_id')) ? \Input::get('menu_id') : null,
                    'type' => 'menu'
                ]);
            elseif (\Input::exists('html'))
                $blockStructure = new HTMLBlockStructure([
                    'html' => (\Input::get('html')) ? \Input::get('html') : null,
                    'type' => 'html'
                ]);
            elseif (\Input::exists('view_file'))
                $blockStructure = new ViewFileBlockStructure([
                    'view_file' => (\Input::get('view_file')) ? \Input::get('view_file') : null,
                    'type' => 'view_file'
                ]);
            elseif (\Input::exists('article_id'))
                $blockStructure = new ArticleBlockStructure([
                    'article_id' => (\Input::get('article_id')) ? \Input::get('article_id') : null,
                    'type' => 'article'
                ]);
            elseif (\Input::exists('article_list_category_id') || \Input::exists('article_list_order') || \Input::exists('article_list_number'))
                $blockStructure = new ArticleListBlockStructure([
                    'article_list_category_id' => (\Input::get('article_list_category_id')) ? \Input::get('article_list_category_id') : null,
                    'article_list_order' => (\Input::get('article_list_order')) ? \Input::get('article_list_order') : null,
                    'article_list_number' => (\Input::get('article_list_number')) ? \Input::get('article_list_number') : null,
                    'type' => 'article_list'
                ]);
            elseif (\Input::exists('media_id'))
                $blockStructure = new MediaBlockStructure([
                    'media_id' => (\Input::get('media_id')) ? \Input::get('media_id') : null,
                    'media_link' => (\Input::get('media_link')) ? \Input::get('media_link') : null,
                    'type' => 'media'
                ]);

            $blockStructure->is_global = true;

            try {
                \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
                return \Redirect::route('back_global_blocks_edit', array('ID' => $blockID));
            } catch (\Exception $e) {
                \Session::flash('error', $e->getMessage());
                return \Redirect::route('back_global_blocks_index');
            }

        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_global_blocks_index');
        }
    }

    public function edit($blockID)
    {
        try {
            $block = \App::make('GetBlockInteractor')->getBlockByID($blockID, true);
            if ($block instanceof MediaBlockStructure && $block->media_id) {
                $block->media = \App::make('GetMediaInteractor')->getMediaByID($block->media_id, true);
            }

            return view('w-cms-laravel::back.structure.blocks.edit', [
                'block' => $block,
                'menus' => \App::make('GetMenusInteractor')->getAll(true),
                'articles' => \App::make('GetArticlesInteractor')->getAll(true),
                'article_categories' => \App::make('GetArticleCategoriesInteractor')->getAll(true),
                'medias' => \App::make('GetMediasInteractor')->getAll(true),
                'media_formats' => \App::make('GetMediaFormatsInteractor')->getAll(true),
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_global_blocks_index');
        }
    }

    public function update()
    {
        $blockID = \Input::get('ID');

        $blockStructure = new HTMLBlockStructure();
        if (\Input::exists('menu_id'))
            $blockStructure = new MenuBlockStructure([
                'menu_id' => (\Input::get('menu_id')) ? \Input::get('menu_id') : null,
                'type' => 'menu'
            ]);
        elseif (\Input::exists('html'))
            $blockStructure = new HTMLBlockStructure([
                'html' => (\Input::get('html')) ? \Input::get('html') : null,
                'type' => 'html'
            ]);
        elseif (\Input::exists('view_file'))
            $blockStructure = new ViewFileBlockStructure([
                'view_file' => (\Input::get('view_file')) ? \Input::get('view_file') : null,
                'type' => 'view_file'
            ]);
        elseif (\Input::exists('article_id'))
            $blockStructure = new ArticleBlockStructure([
                'article_id' => (\Input::get('article_id')) ? \Input::get('article_id') : null,
                'type' => 'article'
            ]);
        elseif (\Input::exists('article_list_category_id') || \Input::exists('article_list_order') || \Input::exists('article_list_number'))
            $blockStructure = new ArticleListBlockStructure([
                'article_list_category_id' => (\Input::get('article_list_category_id')) ? \Input::get('article_list_category_id') : null,
                'article_list_order' => (\Input::get('article_list_order')) ? \Input::get('article_list_order') : null,
                'article_list_number' => (\Input::get('article_list_number')) ? \Input::get('article_list_number') : null,
                'type' => 'article_list'
            ]);
        elseif (\Input::exists('media_id'))
            $blockStructure = new MediaBlockStructure([
                'media_id' => (\Input::get('media_id')) ? \Input::get('media_id') : null,
                'media_link' => (\Input::get('media_link')) ? \Input::get('media_link') : null,
                'media_format_id' => (\Input::get('media_format_id')) ? \Input::get('media_format_id') : null,
                'type' => 'media'
            ]);

        $blockStructure->ID = $blockID;
        $blockStructure->name = \Input::get('name');
        $blockStructure->class = \Input::get('class');

        try {
            \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
            return \Redirect::route('back_global_blocks_edit', array('ID' => $blockID));
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_global_blocks_index');
        }
    }

    public function delete($blockID)
    {
        try {
            \App::make('DeleteBlockInteractor')->run($blockID);
            return \Redirect::route('back_global_blocks_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_global_blocks_index');
        }
    }
}