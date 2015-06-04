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

    public function getContentView($code) {
        return $this->blockTypes[$code]['content_view'];
    }

    public function getUpdateContentFunction($code) {
        return $this->blockTypes[$code]['update_content_function'];
    }

    public function getEntityFromModelFunction($code) {
        return $this->blockTypes[$code]['get_entity_from_model_function'];
    }

    public function getBlockTypes()
    {
        usort($this->blockTypes, function ($a, $b) {
            return strcmp($a['order'], $b['order']);
        });

        return $this->blockTypes;
    }
}
