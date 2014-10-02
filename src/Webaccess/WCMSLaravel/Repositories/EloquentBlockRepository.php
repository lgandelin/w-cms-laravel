<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Block;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Blocks\MenuBlock;
use CMS\Entities\Blocks\ViewFileBlock;
use CMS\Structures\BlockStructure;
use CMS\Repositories\BlockRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;

class EloquentBlockRepository implements BlockRepositoryInterface {

    public function findByID($blockID)
    {
        $blockDB = BlockModel::find($blockID);

        if ($blockDB) {
            if ($blockDB->type == 'html') {
                $block = new HTMLBlock();
                $block->setHTML($blockDB->html);
            } elseif ($blockDB->type == 'menu') {
                $block = new MenuBlock();
                $block->setMenuID($blockDB->menu_id);
            } elseif ($blockDB->type == 'view_file') {
                $block = new ViewFileBlock();
                $block->setViewFile($blockDB->view_file);
            } else
                $block = new Block();

            $block->setID($blockDB->id);
            $block->setName($blockDB->name);
            $block->setWidth($blockDB->width);
            $block->setHeight($blockDB->height);
            $block->setClass($blockDB->class);
            $block->setOrder($blockDB->order);
            $block->setType($blockDB->type);
            $block->setAreaID($blockDB->area_id);
            $block->setDisplay($blockDB->display);

            return $block;
        }

        return false;
    }

    public function findByAreaID($areaID)
    {
        $blocksDB = BlockModel::where('area_id', '=', $areaID)->orderBy('order', 'asc')->get();

        $blocks = [];
        foreach ($blocksDB as $i => $blockDB) {
            $blockStructure = new BlockStructure();
            $blockStructure->ID = $blockDB->id;
            $blockStructure->name = $blockDB->name;
            $blockStructure->width = $blockDB->width;
            $blockStructure->height = $blockDB->height;
            $blockStructure->class = $blockDB->class;
            $blockStructure->order = $blockDB->order;
            $blockStructure->type = $blockDB->type;
            $blockStructure->area_id = $blockDB->area_id;
            $blockStructure->display = $blockDB->display;
            if ($blockDB->type == 'html') $blockStructure->html = $blockDB->html;
            if ($blockDB->type == 'menu') $blockStructure->menu_id = $blockDB->menu_id;
            if ($blockDB->type == 'view_file') $blockStructure->view_file = $blockDB->view_file;

            $blocks[]= $blockStructure;
        }

        return $blocks;
    }

    public function findAll()
    {
        $blocksDB = BlockModel::table('blocks')->orderBy('order', 'asc')->get();

        $blocks = [];
        foreach ($blocksDB as $i => $blockDB) {
            $blockStructure = new BlockStructure();
            $blockStructure->ID = $blockDB->id;
            $blockStructure->name = $blockDB->name;
            $blockStructure->width = $blockDB->width;
            $blockStructure->height = $blockDB->height;
            $blockStructure->class = $blockDB->class;
            $blockStructure->order = $blockDB->order;
            $blockStructure->type = $blockDB->type;
            $blockStructure->area_id = $blockDB->area_id;
            $blockStructure->display = $blockDB->display;
            if ($blockDB->type == 'html') $blockStructure->html = $blockDB->html;
            if ($blockDB->type == 'menu') $blockStructure->menu_id = $blockDB->menu_id;
            if ($blockDB->type == 'view_file') $blockStructure->view_file = $blockDB->view_file;

            $blocks[]= $blockStructure;
        }

        return $blocks;
    }

    public function createBlock(Block $block)
    {
        $blockDB = new BlockModel();
        $blockDB->name = $block->getName();
        $blockDB->width = $block->getWidth();
        $blockDB->height = $block->getHeight();
        $blockDB->class = $block->getClass();
        $blockDB->order = $block->getOrder();
        $blockDB->type = $block->getType();
        $blockDB->area_id = $block->getAreaID();
        $blockDB->display = $block->getDisplay();

        $blockDB->save();

        return $blockDB->id;
    }

    public function updateBlock(Block $block)
    {
        $blockDB = BlockModel::find($block->getID());
        $blockDB->name = $block->getName();
        $blockDB->width = $block->getWidth();
        $blockDB->height = $block->getHeight();
        $blockDB->class = $block->getClass();
        $blockDB->order = $block->getOrder();
        $blockDB->area_id = $block->getAreaID();
        $blockDB->display = $block->getDisplay();
        if ($blockDB->type == 'html') $blockDB->html = $block->getHTML();
        if ($blockDB->type == 'menu') $blockDB->menu_id = $block->getMenuID();
        if ($blockDB->type == 'view_file') $blockDB->view_file = $block->getViewFile();

        return $blockDB->save();
    }

    public function updateBlockType(Block $block)
    {
        $blockDB = BlockModel::find($block->getID());
        $blockDB->type = $block->getType();

        return $blockDB->save();
    }

    public function deleteBlock($blockID)
    {
        $blockDB = BlockModel::find($blockID);

        return $blockDB->delete();
    }

} 