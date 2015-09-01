<?php

namespace Webaccess\WCMSLaravel\Repositories\Blocks;

use CMS\Entities\Blocks\HTMLBlock as HTMLBlockEntity;

class JSONBlockHtmlRepository
{
    public function getBlock($blockJSON) {
        $block = new HTMLBlockEntity();
        $block->setHTML($blockJSON->html);

        return $block;
    }
} 