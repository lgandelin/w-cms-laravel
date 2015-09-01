<?php

namespace Webaccess\WCMSLaravel\Repositories\Eloquent;

use CMS\Context;
use CMS\Entities\Block;
use CMS\Repositories\BlockRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;

class EloquentBlockRepository implements BlockRepositoryInterface
{
    public function findByID($blockID)
    {
        if ($blockModel = BlockModel::find($blockID)) {
            return self::createBlockFromModel($blockModel);
        }

        return false;
    }

    public function findByAreaID($areaID)
    {
        $blocksModel = BlockModel::where('area_id', '=', $areaID)->orderBy('order', 'asc')->get();

        $blocks = [];
        foreach ($blocksModel as $blockModel)
            $blocks[]= self::createBlockFromModel($blockModel);

        return $blocks;
    }

    public function findGlobalBlocks()
    {
        $blocksModel = BlockModel::where('is_global', '=', true)->get();

        $blocks = [];
        foreach ($blocksModel as $blockModel)
            $blocks[]= self::createBlockFromModel($blockModel);

        return $blocks;
    }

    public function findChildBlocks($blockID)
    {
        $blocksModel = BlockModel::where('master_block_id', '=', $blockID)->get();

        $blocks = [];
        foreach ($blocksModel as $blockModel)
            $blocks[]= self::createBlockFromModel($blockModel);

        return $blocks;
    }

    public function findAll()
    {
        $blockModels = BlockModel::table('blocks')->orderBy('order', 'asc')->get();

        $blocks = [];
        foreach ($blockModels as $blockModel)
            $blocks[]= self::createBlockFromModel($blockModel);

        return $blocks;
    }

    public function createBlock(Block $block)
    {
        $blockModel = new BlockModel();
        $blockModel->name = $block->getName();
        $blockModel->width = $block->getWidth();
        $blockModel->height = $block->getHeight();
        $blockModel->class = $block->getClass();
        $blockModel->alignment = $block->getAlignment();
        $blockModel->order = $block->getOrder();
        $blockModel->type = $block->getType();
        $blockModel->area_id = $block->getAreaID();
        $blockModel->display = $block->getDisplay();
        $blockModel->is_global = $block->getIsGlobal();
        $blockModel->master_block_id = $block->getMasterBlockID();
        $blockModel->is_master = $block->getIsMaster();
        $blockModel->is_ghost = $block->getIsGhost();

        $blockModel->save();

        return $blockModel->id;
    }

    public function updateBlock(Block $block)
    {
        $blockModel = BlockModel::find($block->getID());
        $blockModel->name = $block->getName();
        $blockModel->width = $block->getWidth();
        $blockModel->height = $block->getHeight();
        $blockModel->class = $block->getClass();
        $blockModel->alignment = $block->getAlignment();
        $blockModel->order = $block->getOrder();
        $blockModel->area_id = $block->getAreaID();
        $blockModel->display = $block->getDisplay();
        $blockModel->is_global = $block->getIsGlobal();
        $blockModel->master_block_id = $block->getMasterBlockID();
        $blockModel->is_master = $block->getIsMaster();
        $blockModel->is_ghost = $block->getIsGhost();

        Context::get('block_' . $blockModel->type)->saveBlock($block, $blockModel);

        return $blockModel->save();
    }

    public function updateBlockType(Block $block)
    {
        $blockModel = BlockModel::find($block->getID());
        $blockModel->type = $block->getType();
        if ($blockModel->blockable)
            $blockModel->blockable->delete();

        return $blockModel->save();
    }

    public function deleteBlock($blockID)
    {
        $blockModel = BlockModel::find($blockID);

        return $blockModel->delete();
    }

    private static function createBlockFromModel(BlockModel $blockModel)
    {
        $block = Context::get('block_' . $blockModel->type)->getBlock($blockModel);

        $block->setID($blockModel->id);
        $block->setName($blockModel->name);
        $block->setWidth($blockModel->width);
        $block->setHeight($blockModel->height);
        $block->setClass($blockModel->class);
        $block->setAlignment($blockModel->alignment);
        $block->setOrder($blockModel->order);
        $block->setType($blockModel->type);
        $block->setAreaID($blockModel->area_id);
        $block->setDisplay($blockModel->display);
        $block->setIsGlobal($blockModel->is_global);
        $block->setMasterBlockID($blockModel->master_block_id);
        $block->setIsMaster($blockModel->is_master);
        $block->setIsGhost($blockModel->is_ghost);

        return $block;

        return false;
    }
} 