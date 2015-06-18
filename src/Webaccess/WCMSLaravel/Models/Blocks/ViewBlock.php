<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;

class ViewBlock extends \Eloquent
{
    protected $table = 'blocks_view';
    protected $fillable = array('view_path');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity() {
        $block = new \CMS\Entities\Blocks\ViewBlock();
        $block->setViewPath($this->view_path);

        return $block;
    }

    public function updateFromEntity(Block $block) {
        $this->view_path = $block->getViewPath();
        $this->save();
    }
}