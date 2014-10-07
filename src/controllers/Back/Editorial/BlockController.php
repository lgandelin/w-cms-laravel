<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\BlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class BlockController extends AdminController
{
    public function get_infos($blockID)
    {
        try {
            $block = \App::make('GetBlockInteractor')->getBlockByID($blockID, true);

            return json_encode(array('success' => true, 'block' => $block->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function create()
    {
        $blockStructure = new BlockStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
            'type' => \Input::get('type'),
            'class' => \Input::get('class'),
            'order' => 999,
            'area_id' => \Input::get('area_id'),
        ]);

        try {
            $blockID = \App::make('CreateBlockInteractor')->run($blockStructure);
            $block = \App::make('GetBlockInteractor')->getBlockByID($blockID, true);

            return json_encode(array('success' => true, 'block' => $block->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_content()
    {
        $blockID = \Input::get('ID');

        if ($menuID = \Input::get('menu_id'))
            $blockStructure = new MenuBlockStructure([
                'menu_id' => $menuID,
                'type' => 'menu'
            ]);
        elseif ($html = \Input::get('html'))
            $blockStructure = new HTMLBlockStructure([
                'html' => $html,
                'type' => 'html'
            ]);
        elseif ($viewFile = \Input::get('view_file'))
            $blockStructure = new ViewFileBlockStructure([
                'view_file' => $viewFile,
                'type' => 'view_file'
            ]);

        try {
            \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_infos()
    {
        $blockID = \Input::get('ID');

        $blockStructure = new BlockStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
            'type' => \Input::get('type'),
            'class' => \Input::get('class')
        ]);

        try {
            \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_order()
    {
        try {
            $blockID = \Input::get('block_id');
            $blockStructure = new BlockStructure([
                'area_id' => \Input::get('area_id')
            ]);

            \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }

        $blocks = json_decode(\Input::get('blocks'));
        for ($i = 0; $i < sizeof($blocks); $i++) {
            $blockID = preg_replace('/b-/', '', $blocks[$i]);

            $blockStructure = new BlockStructure([
                'order' => $i + 1,
            ]);

            try {
                \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
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
            $blockStructure = new BlockStructure([
                'display'=> \Input::get('display')
            ]);

            \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete()
    {
        $blockID = \Input::get('ID');

        try {
            \App::make('DeleteBlockInteractor')->run($blockID);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
}