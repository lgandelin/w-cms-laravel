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
        if (isset($this->blockTypes[$code]))
            return $this->blockTypes[$code];

        return null;
    }

    public function getFrontView($code) {
        if ($blockType = $this->getBlockType($code))
            return $blockType->front_view;

        return false;
    }

    public function getContentView($code) {
        if ($blockType = $this->getBlockType($code))
            return $blockType->content_view;

        return null;
    }

    public function getTemplateView($code) {
        if ($blockType = $this->getBlockType($code))
            return $blockType->template_view;

        return null;
    }

    public function getUpdateContentMethod($code) {
        if ($blockType = $this->getBlockType($code))
            return $blockType->getUpdateContentMethod;

        return null;
    }

    public function getBlockStructureForUpdateMethod($code) {
        if ($blockType = $this->getBlockType($code))
            return $blockType->getBlockStructureForUpdateMethod;

        return null;
    }

    public function getEntityFromModelMethod($code) {
        if ($blockType = $this->getBlockType($code))
            return $blockType->getEntityFromModelMethod;

        return null;
    }

    public function getBlockStructureMethod($code) {
        if ($blockType = $this->getBlockType($code))
            return $blockType->getBlockStructureMethod;

        return null;
    }

    public function getBlockTypes()
    {
        usort($this->blockTypes, function ($a, $b) {
            return strcmp($a->order, $b->order);
        });

        return $this->blockTypes;
    }
}
