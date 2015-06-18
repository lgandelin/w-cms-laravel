<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

use CMS\Entities\Block;

class HTMLBlock extends \Eloquent
{
    protected $table = 'blocks_html';
    protected $fillable = array('html');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }

    public function getEntity() {
        $block = new \CMS\Entities\Blocks\HTMLBlock();
        $block->setHTML($this->html);

        return $block;
    }

    public function updateFromEntity(Block $block) {
        $this->html = $block->getHTML();
        $this->save();
    }
}