<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;
use CMS\Entities\Blocks\HTMLBlock as HTMLBlockEntity;
use Webaccess\WCMSLaravel\Models\Block as BlockModel;

class HTMLBlock extends \Eloquent
{
    protected $table = 'blocks_html';
    protected $fillable = array('html');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity(BlockModel $blockModel) {
        $block = new HTMLBlockEntity();
        if ($blockModel->blockable) {
            $block->setHTML($blockModel->blockable->html);
        }

        return $block;
    }
    
    public function updateContent(BlockModel $blockModel, Block $block) {
        $blockable = ($blockModel->blockable) ? $blockModel->blockable : new self();
        $blockable->html = $block->getHTML();
        $blockable->save();
        $blockable->block()->save($blockModel);
    }
}