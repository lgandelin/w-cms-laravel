<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\BlockType;
use Webaccess\WCMSLaravel\Models\BlockType as BlockTypeModel;

class EloquentBlockTypeRepository
{
    public function findAll()
    {
        return BlockTypeModel::orderBy('order', 'asc')->get();
    }

    public function createBlockType(BlockType $blockType)
    {
        $blockTypeModel = new BlockTypeModel();
        $blockTypeModel->code = $blockType->getCode();
        $blockTypeModel->name = $blockType->getName();
        $blockTypeModel->content_view = $blockType->getContentView();
        $blockTypeModel->front_view = $blockType->getFrontView();
        $blockTypeModel->order = $blockType->getOrder();

        $blockTypeModel->save();

        return $blockTypeModel->id;
    }

    public function getBlockTypeByCode($code) {
        return BlockTypeModel::where('code', '=', $code)->first();
    }
} 