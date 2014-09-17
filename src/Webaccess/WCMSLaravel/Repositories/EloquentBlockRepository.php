<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Block;
use CMS\Entities\Blocks\HTMLBlock;
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
            } else
                $block = new Block();

            $block->setID($blockDB->id);
            $block->setName($blockDB->name);
            $block->setWidth($blockDB->width);
            $block->setHeight($blockDB->height);
            $block->setClass($blockDB->class);
            $block->setType($blockDB->type);
            $block->setAreaID($blockDB->area_id);

            return $block;
        }

        return false;
    }

    public function findByAreaID($areaID)
    {
        $blocksDB = BlockModel::where('area_id', '=', $areaID)->get();

        $blocks = [];
        foreach ($blocksDB as $i => $blockDB) {
            $blockStructure = new BlockStructure();
            $blockStructure->ID = $blockDB->id;
            $blockStructure->name = $blockDB->name;
            $blockStructure->width = $blockDB->width;
            $blockStructure->height = $blockDB->height;
            $blockStructure->class = $blockDB->class;
            $blockStructure->type = $blockDB->type;
            $blockStructure->html = $blockDB->html;
            $blockStructure->area_id = $blockDB->area_id;

            $blocks[]= $blockStructure;
        }

        return $blocks;
    }

    public function findAll()
    {
        $blocksDB = BlockModel::get();

        $blocks = [];
        foreach ($blocksDB as $i => $blockDB) {
            $blockStructure = new BlockStructure();
            $blockStructure->ID = $blockDB->id;
            $blockStructure->name = $blockDB->name;
            $blockStructure->width = $blockDB->width;
            $blockStructure->height = $blockDB->height;
            $blockStructure->class = $blockDB->class;
            $blockStructure->type = $blockDB->type;
            if ($blockDB->type == 'html')
                $blockStructure->html = $blockDB->html;
            $blockStructure->area_id = $blockDB->area_id;

            $blocks[]= $blockStructure;
        }

        return $blocks;
    }

    public function createBlock(BlockStructure $blockStructure)
    {
        $blockDB = new BlockModel();
        $blockDB->name = $blockStructure->name;
        $blockDB->width = $blockStructure->width;
        $blockDB->height = $blockStructure->height;
        $blockDB->class = $blockStructure->class;
        if ($blockDB->type == 'html')
            $blockDB->html = $blockStructure->html;
        $blockDB->area_id = $blockStructure->area_id;

        return $blockDB->save();
    }

    public function updateBlock(Block $block)
    {
        $blockDB = BlockModel::find($block->getID());
        $blockDB->name = $block->getName();
        $blockDB->width = $block->getWidth();
        $blockDB->height = $block->getHeight();
        $blockDB->class = $block->getClass();
        $blockDB->type = $block->getType();

        if ($blockDB->type == 'html')
            $blockDB->html = $block->getHTML();

        return $blockDB->save();
    }

    public function deleteBlock($blockID)
    {
        $blockDB = BlockModel::find($blockID);

        return $blockDB->delete();
    }

} 