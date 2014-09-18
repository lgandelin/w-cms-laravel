<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Area;
use CMS\Structures\AreaStructure;
use CMS\Repositories\AreaRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Area as AreaModel;
use Webaccess\WCMSLaravel\Models\Page as PageModel;

class EloquentAreaRepository implements AreaRepositoryInterface {

    public function findByID($areaID)
    {
        $areaDB = AreaModel::find($areaID);

        if ($areaDB) {
            $area = new Area();
            $area->setID($areaDB->id);
            $area->setName($areaDB->name);
            $area->setWidth($areaDB->width);
            $area->setHeight($areaDB->height);
            $area->setClass($areaDB->class);
            $area->setPageID($areaDB->page_id);

            return $area;
        }

        return false;
    }

    public function findByPageID($pageID)
    {
        $areasDB = AreaModel::where('page_id', '=', $pageID)->get();

        $areas = [];
        foreach ($areasDB as $i => $areaDB) {
            $areaStructure = new AreaStructure();
            $areaStructure->ID = $areaDB->id;
            $areaStructure->name = $areaDB->name;
            $areaStructure->width = $areaDB->width;
            $areaStructure->height = $areaDB->height;
            $areaStructure->class = $areaDB->class;
            $areaStructure->page_id = $areaDB->page_id;

            $areas[]= $areaStructure;
        }

        return $areas;
    }

    public function findAll()
    {
        $areasDB = AreaModel::get();

        $areas = [];
        foreach ($areasDB as $i => $areaDB) {
            $areaStructure = new AreaStructure();
            $areaStructure->ID = $areaDB->id;
            $areaStructure->name = $areaDB->name;
            $areaStructure->width = $areaDB->width;
            $areaStructure->height = $areaDB->height;
            $areaStructure->class = $areaDB->class;
            $areaStructure->page_id = $areaDB->page_id;

            $areas[]= $areaStructure;
        }

        return $areas;
    }

    public function createArea(Area $area)
    {
        $areaDB = new AreaModel();
        $areaDB->name = $area->getName();
        $areaDB->width = $area->getWidth();
        $areaDB->height = $area->getHeight();
        $areaDB->class = $area->getClass();
        $areaDB->page_id = $area->getPageID();

        $areaDB->save();

        return $areaDB->id;
    }

    public function updateArea(Area $area)
    {
        $areaDB = AreaModel::find($area->getID());
        $areaDB->name = $area->getName();
        $areaDB->width = $area->getWidth();
        $areaDB->height = $area->getHeight();
        $areaDB->class = $area->getClass();

        return $areaDB->save();
    }


    public function deleteArea($areaID)
    {
        $areaDB = AreaModel::find($areaID);

        return $areaDB->delete();
    }

} 