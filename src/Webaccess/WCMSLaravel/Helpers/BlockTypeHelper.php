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
        $this->blockTypes[$blockType->code]= $blockType;
    }

    public function get($code) {
        if (isset($this->blockTypes[$code]))
            return $this->blockTypes[$code];

        return null;
    }

    public function getAll()
    {
        usort($this->blockTypes, function ($a, $b) {
            return ($a->order < $b->order);
        });

        return $this->blockTypes;
    }
}
