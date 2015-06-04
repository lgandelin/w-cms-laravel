<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Interactors\Blocks\GetBlockInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Structures\Blocks\ArticleBlockStructure;
use CMS\Structures\Blocks\ArticleListBlockStructure;
use CMS\Structures\Blocks\GlobalBlockStructure;
use CMS\Structures\Blocks\MediaBlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class BlockController extends AdminController
{
    public function get_infos($blockID)
    {
        try {
            $block = (new GetBlockInteractor())->getBlockByID($blockID, true);

            return json_encode(array('success' => true, 'block' => $block->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function create()
    {
        $blockStructure = new HTMLBlockStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
            'type' => \Input::get('type'),
            'class' => \Input::get('class'),
            'alignment' => \Input::get('alignment'),
            'order' => 999,
            'is_master' => \Input::get('is_master'),
            'is_ghost' => \Input::get('is_ghost'),
            'area_id' => \Input::get('area_id'),
            'display' => 1
        ]);

        try {
            $blockID = (new CreateBlockInteractor())->run($blockStructure);
            $block = (new GetBlockInteractor())->getBlockByID($blockID, true);

            return json_encode(array('success' => true, 'block' => $block->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_content()
    {
        $blockID = \Input::get('ID');

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
        elseif (\Input::exists('block_reference_id'))
            $blockStructure = new GlobalBlockStructure([
                'block_reference_id' => (\Input::get('block_reference_id')) ? \Input::get('block_reference_id') : null,
                'type' => 'global'
            ]);
        elseif (\Input::exists('media_id'))
            $blockStructure = new MediaBlockStructure([
                'media_id' => (\Input::get('media_id')) ? \Input::get('media_id') : null,
                'media_link' => (\Input::get('media_link')) ? \Input::get('media_link') : null,
                'media_format_id' => (\Input::get('media_format_id')) ? \Input::get('media_format_id') : null,
                'type' => 'media'
            ]);

        try {
            (new UpdateBlockInteractor())->run($blockID, $blockStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_infos()
    {
        $blockID = \Input::get('ID');
        $block = (new GetBlockInteractor())->getBlockByID($blockID);

        $blockStructure = $block->getStructure();
        $blockStructure->name = \Input::get('name');
        $blockStructure->width = \Input::get('width');
        $blockStructure->height = \Input::get('height');
        $blockStructure->type = \Input::get('type');
        $blockStructure->class = \Input::get('class');
        $blockStructure->alignment = \Input::get('alignment');
        $blockStructure->is_master = \Input::get('is_master');
        $blockStructure->is_ghost = \Input::get('is_ghost');

        try {
            (new UpdateBlockInteractor())->run($blockID, $blockStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_order()
    {
        try {
            $blockID = \Input::get('block_id');
            $block = (new GetBlockInteractor())->getBlockByID($blockID);

            $blockStructure = $block->getStructure();
            $blockStructure->area_id = \Input::get('area_id');

            (new UpdateBlockInteractor())->run($blockID, $blockStructure);
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }

        $blocks = json_decode(\Input::get('blocks'));
        for ($i = 0; $i < sizeof($blocks); $i++) {
            $blockID = preg_replace('/b-/', '', $blocks[$i]);
            $block = (new GetBlockInteractor())->getBlockByID($blockID);

            $blockStructure = $block->getStructure();
            $blockStructure->order = $i + 1;

            try {
                (new UpdateBlockInteractor())->run($blockID, $blockStructure);
            } catch (\Exception $e) {
                return json_encode(array('success' => false, 'error' => $e->getMessage()));
            }
        }

        return json_encode(array('success' => true));
    }

    public function display()
    {
        try {
            $blockID = \Input::get('ID');
            $block = (new GetBlockInteractor())->getBlockByID($blockID);

            $blockStructure = $block->getStructure();
            $blockStructure->display = \Input::get('display');

            (new UpdateBlockInteractor())->run($blockID, $blockStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete()
    {
        $blockID = \Input::get('ID');

        try {
            (new DeleteBlockInteractor())->run($blockID);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
}