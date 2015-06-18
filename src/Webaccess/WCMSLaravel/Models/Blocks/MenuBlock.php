<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;

class MenuBlock extends \Eloquent
{
    protected $table = 'blocks_menu';
    protected $fillable = array('menu_id');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity() {
        $block = new \CMS\Entities\Blocks\MenuBlock();
        $block->setMenuID($this->menu_id);

        return $block;
    }

    public function updateFromEntity(Block $block) {
        $this->menu_id = $block->getMenuID();
        $this->save();
    }
}