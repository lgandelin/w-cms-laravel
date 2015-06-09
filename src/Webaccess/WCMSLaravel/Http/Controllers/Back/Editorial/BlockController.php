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
use CMS\Structures\Blocks\ViewBlockStructure;
use Webaccess\CMS\Structures\Blocks\GalleryBlockStructure;
use Webaccess\WCMSLaravel\Facades\BlockType;
use Webaccess\WCMSLaravel\Helpers\BlockTypeHelper;
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
        $method = \App::make('block_type')->getBlockStructureMethod(\Input::get('type'));
        $blockStructure = call_user_func($method);
        $blockStructure->name = \Input::get('name');
        $blockStructure->width = \Input::get('width');
        $blockStructure->height = \Input::get('height');
        $blockStructure->type = \Input::get('type');
        $blockStructure->class = \Input::get('class');
        $blockStructure->alignment = \Input::get('alignment');
        $blockStructure->order = 999;
        $blockStructure->is_master = \Input::get('is_master');
        $blockStructure->is_ghost = \Input::get('is_ghost');
        $blockStructure->area_id = \Input::get('area_id');
        $blockStructure->display = 1;

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

        $method= \App::make('block_type')->getBlockStructureForUpdateMethod(\Input::get('type'));
        $arguments = [\Input::all()];
        $blockStructure = call_user_func_array($method, $arguments);

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