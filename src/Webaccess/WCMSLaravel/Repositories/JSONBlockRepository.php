<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Block;
use CMS\Repositories\BlockRepositoryInterface;

class JSONBlockRepository implements BlockRepositoryInterface
{
    function __construct()
    {
        $this->json = '/data/www/data/blocks.json';
        $this->counter = 1;
        $this->blocks = [];

        $this->loadFromJSON();
    }

    public function findByID($blockID)
    {
        foreach ($this->blocks as $block) {
            if ($blockID == $block->getID()) {
                return $block;
            }
        }

        return false;
    }

    public function findByAreaID($areaID)
    {
        $blocks = [];
        foreach ($this->blocks as $block) {
            if ($areaID == $block->getAreaID()) {
                $blocks[]= $block;
            }
        }

        return $blocks;
    }

    public function findGlobalBlocks()
    {
        return [];
    }

    public function findChildBlocks($blockID)
    {
        return [];
    }

    public function findAll()
    {
        return $this->blocks;
    }

    public function createBlock(Block $block)
    {
        $this->counter++;
        $block->setID($this->counter);
        $this->blocks[]= $block;
        $this->writeToJSON();

        return $this->counter;
    }

    public function updateBlock(Block $block)
    {
        foreach ($this->blocks as $i => $blockJSON) {
            if ($block->getID() == $blockJSON->getID()) {
                $this->blocks[$i] = $block;
            }
        }

        $this->writeToJSON();
    }

    public function deleteBlock($blockID)
    {
        foreach ($this->blocks as $i => $blockJSON) {
            if ($blockJSON->getID() == $blockID) {
                unset($this->blocks[$i]);
            }
        }

        $this->writeToJSON();
    }

    private function writeToJSON()
    {
        $blocks = [];
        foreach ($this->blocks as $block) {
            $blocks[]= [
                'id' => $block->getID(),
                'name' => $block->getName(),
                'width' => $block->getWidth(),
                'height' => $block->getHeight(),
                'class' => $block->getClass(),
                'alignment' => $block->getAlignment(),
                'order' => $block->getOrder(),
                'type' => $block->getType(),
                'display' => $block->getDisplay(),
                'area_id' => $block->getAreaID(),
            ];
        }

        file_put_contents($this->json, json_encode([$this->counter, $blocks]));
    }

    private function loadFromJSON()
    {
        $string = file_get_contents($this->json);
        $data = json_decode($string, true);

        if ($data) {
            $this->counter = $data[0];
            $blocks = $data[1];

            if (is_array($blocks) && sizeof($blocks) > 0) {
                foreach ($blocks as $blockData) {
                    $block = new Block();
                    foreach ($blockData as $property => $value) {
                        $method = 'set' . ucfirst(str_replace('_', '', $property));
                        $block->$method($value);
                    }

                    $this->blocks[] = $block;
                }
            }
        }
    }
}