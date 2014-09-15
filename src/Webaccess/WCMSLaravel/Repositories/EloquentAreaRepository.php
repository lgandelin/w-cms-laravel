<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Structures\AreaStructure;
use CMS\Repositories\AreaRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Area as AreaModel;
use Webaccess\WCMSLaravel\Models\Page as PageModel;

class EloquentAreaRepository implements AreaRepositoryInterface {

    public function findByID($areaID)
    {
        $areaDB = AreaModel::find($areaID);

        if ($areaDB) {
            $areaStructure = new AreaStructure();
            $areaStructure->ID = $areaDB->id;
            $areaStructure->name = $areaDB->name;
            $areaStructure->width = $areaDB->width;
            $areaStructure->height = $areaDB->height;
            $areaStructure->class = $areaDB->class;
            $areaStructure->page_id = $areaDB->page_id;

            return $areaStructure;
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

    public function createArea(AreaStructure $areaStructure)
    {
        $areaDB = new AreaModel();
        $areaDB->name = $areaStructure->name;
        $areaDB->width = $areaStructure->identifier;
        $areaDB->height = $areaStructure->uri;
        $areaDB->class = $areaStructure->text;
        $areaDB->page_id = $areaStructure->page_id;

        return $areaDB->save();
    }

    public function updateArea($areaID, AreaStructure $areaStructure)
    {
        $areaDB = AreaModel::find($areaID);
        $areaDB->name = $areaStructure->name;
        $areaDB->width = $areaStructure->identifier;
        $areaDB->height = $areaStructure->uri;
        $areaDB->class = $areaStructure->text;

        return $areaDB->save();
    }


    public function deleteArea($areaID)
    {
        $areaDB = AreaModel::find($areaID);

        return $areaDB->delete();
    }

} 