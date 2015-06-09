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

    public function getBlockType($code) {
        return $this->blockTypes[$code];
    }

    public function getContentView($code) {
        return $this->getBlockType($code)->content_view;
    }

    public function getUpdateContentMethod($code) {
        return $this->getBlockType($code)->getUpdateContentMethod;
    }

    public function getBlockStructureForUpdateMethod($code) {
        return $this->getBlockType($code)->getBlockStructureForUpdateMethod;
    }

    public function getEntityFromModelMethod($code) {
        return $this->getBlockType($code)->getEntityFromModelMethod;
    }

    public function getBlockStructureMethod($code) {
        return $this->getBlockType($code)->getBlockStructureMethod;
    }

    public function getBlockTypes()
    {
        usort($this->blockTypes, function ($a, $b) {
            return strcmp($a->order, $b->order);
        });

        return $this->blockTypes;
    }

    public function getFrontView($code) {
        return $this->getBlockType($code)->front_view;
    }
}
