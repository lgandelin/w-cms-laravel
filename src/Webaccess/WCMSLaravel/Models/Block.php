<?php

namespace Webaccess\WCMSLaravel\Models;

class Block extends \Eloquent {

    protected $table = 'blocks';
    protected $fillable = array('name', 'width', 'height', 'class', 'alignment', 'type', 'order', 'display', 'is_global', 'master_block_id', 'is_master', 'block_reference_id');

    public function area()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\Area');
    }

    public function blockable()
    {
        return $this->morphTo();
    }

    public function getEntity() {
        if ($this->blockable) {
            return $this->blockable->getEntity();
        }

        return false;
    }

    public function updateFromEntity(\CMS\Entities\Block $block) {
        if ($this->blockable) {
            return $this->blockable->updateFromEntity($block);
        }

        return false;
    }
}