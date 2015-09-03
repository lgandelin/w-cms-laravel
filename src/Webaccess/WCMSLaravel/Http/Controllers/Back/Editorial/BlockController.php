<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use Webaccess\WCMSCore\Interactors\Blocks\CreateBlockInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\DeleteBlockInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlockInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\UpdateBlockInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\UpdateBlockTypeInteractor;
use Webaccess\WCMSCore\DataStructure;
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
        $blockStructure = new DataStructure();
        foreach (\Input::all() as $key => $value) {
            $blockStructure->$key = $value;
        }

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

        $blockStructure = (new GetBlockInteractor())->getBlockByID($blockID, true);
        foreach (\Input::all() as $key => $value) {
            $blockStructure->$key = $value;
        }

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

        //Update block type if necessary
        (new UpdateBlockTypeInteractor())->run($blockID, \Input::get('type'));

        //Update block infos
        $blockStructure = (new GetBlockInteractor())->getBlockByID($blockID, true);
        foreach (\Input::all() as $key => $value) {
            $blockStructure->$key = $value;
        }

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
            $blockStructure = (new GetBlockInteractor())->getBlockByID($blockID, true);
            $blockStructure->area_id = \Input::get('area_id');

            (new UpdateBlockInteractor())->run($blockID, $blockStructure);
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }

        $blocks = json_decode(\Input::get('blocks'));
        for ($i = 0; $i < sizeof($blocks); $i++) {
            $blockID = preg_replace('/b-/', '', $blocks[$i]);
            $blockStructure = (new GetBlockInteractor())->getBlockByID($blockID, true);
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
            $blockStructure = (new GetBlockInteractor())->getBlockByID($blockID, true);
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