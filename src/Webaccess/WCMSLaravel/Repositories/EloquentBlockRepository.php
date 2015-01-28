<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Block;
use CMS\Entities\Blocks\ArticleBlock;
use CMS\Entities\Blocks\ArticleListBlock;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Blocks\GlobalBlock;
use CMS\Entities\Blocks\MediaBlock;
use CMS\Entities\Blocks\MenuBlock;
use CMS\Entities\Blocks\ViewFileBlock;
use CMS\Repositories\BlockRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;

class EloquentBlockRepository implements BlockRepositoryInterface
{
    public function findByID($blockID)
    {
        if ($blockModel = BlockModel::find($blockID))
            return self::createBlockFromModel($blockModel);

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
        $blockModel->order = $block->getOrder();
        $blockModel->area_id = $block->getAreaID();
        $blockModel->display = $block->getDisplay();
        $blockModel->is_global = $block->getIsGlobal();
        $blockModel->master_block_id = $block->getMasterBlockID();
        $blockModel->is_master = $block->getIsMaster();
        $blockModel->is_ghost = $block->getIsGhost();
        if ($blockModel->type == 'html') $blockModel->html = $block->getHTML();
        if ($blockModel->type == 'menu') $blockModel->menu_id = $block->getMenuID();
        if ($blockModel->type == 'view_file') $blockModel->view_file = $block->getViewFile();
        if ($blockModel->type == 'article') $blockModel->article_id = $block->getArticleID();
        if ($blockModel->type == 'article_list') {
            $blockModel->article_list_category_id = $block->getArticleListCategoryID();
            $blockModel->article_list_order = $block->getArticleListOrder();
            $blockModel->article_list_number = $block->getArticleListNumber();
        }
        if ($blockModel->type == 'global') $blockModel->block_reference_id = $block->getBlockReferenceID();
        if ($blockModel->type == 'media') {
            $blockModel->media_id = $block->getMediaID();
            $blockModel->media_link = $block->getMediaLink();
        }

        return $blockModel->save();
    }

    public function updateBlockType(Block $block)
    {
        $blockModel = BlockModel::find($block->getID());
        $blockModel->type = $block->getType();

        return $blockModel->save();
    }

    public function deleteBlock($blockID)
    {
        $blockModel = BlockModel::find($blockID);

        return $blockModel->delete();
    }

    private static function createBlockFromModel($blockModel)
    {
        if ($blockModel->type == 'html') {
            $block = new HTMLBlock();
            $block->setHTML($blockModel->html);
        } elseif ($blockModel->type == 'menu') {
            $block = new MenuBlock();
            $block->setMenuID($blockModel->menu_id);
        } elseif ($blockModel->type == 'view_file') {
            $block = new ViewFileBlock();
            $block->setViewFile($blockModel->view_file);
        } elseif ($blockModel->type == 'article') {
            $block = new ArticleBlock();
            $block->setArticleID($blockModel->article_id);
        } elseif ($blockModel->type == 'article_list') {
            $block = new ArticleListBlock();
            $block->setArticleListCategoryID($blockModel->article_list_category_id);
            $block->setArticleListOrder($blockModel->article_list_order);
            $block->setArticleListNumber($blockModel->article_list_number);
        } elseif ($blockModel->type == 'global') {
            $block = new GlobalBlock();
            $block->setBlockReferenceID($blockModel->block_reference_id);
        } elseif ($blockModel->type == 'media') {
            $block = new MediaBlock();
            $block->setMediaID($blockModel->media_id);
            $block->setMediaLink($blockModel->media_link);
        } else {
            throw new \Exception('Block type not found');
        }

        $block->setID($blockModel->id);
        $block->setName($blockModel->name);
        $block->setWidth($blockModel->width);
        $block->setHeight($blockModel->height);
        $block->setClass($blockModel->class);
        $block->setOrder($blockModel->order);
        $block->setType($blockModel->type);
        $block->setAreaID($blockModel->area_id);
        $block->setDisplay($blockModel->display);
        $block->setIsGlobal($blockModel->is_global);
        $block->setMasterBlockID($blockModel->master_block_id);
        $block->setIsMaster($blockModel->is_master);
        $block->setIsGhost($blockModel->is_ghost);

        return $block;
    }
} 