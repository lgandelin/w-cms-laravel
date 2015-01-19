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
        if ($areaModel = AreaModel::find($areaID))
            return self::createAreaFromModel($areaModel);

        return false;
    }

    public function findByPageID($pageID)
    {
        $areaModels = AreaModel::where('page_id', '=', $pageID)->orderBy('order', 'asc')->get();

        $areas = [];
        foreach ($areaModels as $areaModel)
            $areas[]= self::createAreaFromModel($areaModel);

        return $areas;
    }

    public function findAll()
    {
        $areaModels = AreaModel::table('areas')->orderBy('order', 'asc')->get();

        $areas = [];
        foreach ($areaModels as $i => $areaModel)
            $areas[]= self::createAreaFromModel($areaModel);

        return $areas;
    }

    public function findChildAreas($areaID)
    {
        $areasModel = AreaModel::where('master_area_id', '=', $areaID)->get();

        $areas = [];
        foreach ($areasModel as $areaModel)
            $areas[]= self::createAreaFromModel($areaModel);

        return $areas;
    }

    public function createArea(Area $area)
    {
        $areaModel = new AreaModel();
        $areaModel->name = $area->getName();
        $areaModel->width = $area->getWidth();
        $areaModel->height = $area->getHeight();
        $areaModel->class = $area->getClass();
        $areaModel->order = $area->getOrder();
        $areaModel->page_id = $area->getPageID();
        $areaModel->display = $area->getDisplay();
        $areaModel->is_master = $area->getIsMaster();
        $areaModel->master_area_id = $area->getMasterAreaID();

        $areaModel->save();

        return $areaModel->id;
    }

    public function updateArea(Area $area)
    {
        $areaModel = AreaModel::find($area->getID());
        $areaModel->name = $area->getName();
        $areaModel->width = $area->getWidth();
        $areaModel->height = $area->getHeight();
        $areaModel->order = $area->getOrder();
        $areaModel->class = $area->getClass();
        $areaModel->display = $area->getDisplay();
        $areaModel->is_master = $area->getIsMaster();
        $areaModel->master_area_id = $area->getMasterAreaID();

        return $areaModel->save();
    }

    public function deleteArea($areaID)
    {
        $areaModel = AreaModel::find($areaID);

        return $areaModel->delete();
    }

    private static function createAreaFromModel($areaModel)
    {
        $area = new Area();
        $area->setID($areaModel->id);
        $area->setName($areaModel->name);
        $area->setWidth($areaModel->width);
        $area->setHeight($areaModel->height);
        $area->setClass($areaModel->class);
        $area->setOrder($areaModel->order);
        $area->setPageID($areaModel->page_id);
        $area->setDisplay($areaModel->display);
        $area->setIsMaster($areaModel->is_master);
        $area->setMasterAreaID($areaModel->master_area_id);

        return $area;
    }

} 