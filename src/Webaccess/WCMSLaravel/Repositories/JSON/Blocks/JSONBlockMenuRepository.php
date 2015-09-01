<?php

namespace Webaccess\WCMSLaravel\Repositories\JSON\Blocks;

use CMS\Entities\Blocks\MenuBlock;

class JSONBlockMenuRepository
{
    public function getBlock($blockData) {
        $block = new MenuBlock();
        if (isset($blockData['menu_id'])) {
            $block->setMenuID($blockData['menu_id']);
        }

        return $block;
    }
}
