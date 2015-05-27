<?php

namespace Webaccess\WCMSLaravel\Helpers;

class BlockTypeHelper
{
    private $blockTypes;

    public function __construct()
    {
        $this->blockTypes = [];
    }

    public function addBlockType($blockType) {
        $this->blockTypes[$blockType['code']]= $blockType;
    }

    public function getContentView($blockTypeCode) {
        return $this->blockTypes[$blockTypeCode]['content_view'];
    }

    public function getBlockTypes()
    {
        usort($this->blockTypes, function ($a, $b) {
            return strcmp($a['order'], $b['order']);
        });

        return $this->blockTypes;
    }
}
