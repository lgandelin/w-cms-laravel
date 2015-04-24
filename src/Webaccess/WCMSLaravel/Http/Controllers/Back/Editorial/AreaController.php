<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Structures\AreaStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class AreaController extends AdminController
{
    public function get_infos($areaID)
    {
        try {
            $area = \App::make('GetAreaInteractor')->getAreaByID($areaID, true);

            return json_encode(array('success' => true, 'area' => $area->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function create()
    {
        $areaStructure = new AreaStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
            'class' => \Input::get('class'),
            'order' => 999,
            'is_master' => \Input::get('is_master'),
            'page_id' => \Input::get('page_id'),
        ]);

        try {
            $areaID = \App::make('CreateAreaInteractor')->run($areaStructure);
            $area = \App::make('GetAreaInteractor')->getAreaByID($areaID, true);

            return json_encode(array('success' => true, 'area' => $area->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_infos()
    {
        $areaID = \Input::get('ID');

        $areaStructure = new AreaStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
            'class' => \Input::get('class'),
            'is_master' => \Input::get('is_master'),
        ]);

        try {
            \App::make('UpdateAreaInteractor')->run($areaID, $areaStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_order()
    {
        $areas = json_decode(\Input::get('areas'));
        for ($i = 0; $i < sizeof($areas); $i++) {
            $areaID = preg_replace('/a-/', '', $areas[$i]);

            $areaStructure = new AreaStructure([
                'order' => $i + 1,
            ]);

            try {
                \App::make('UpdateAreaInteractor')->run($areaID, $areaStructure);
            } catch (\Exception $e) {
                return json_encode(array('success' => false, 'error' => $e->getMessage()));
            }
        }

        return json_encode(array('success' => true));
    }

    public function display()
    {
        try {
            $areaID = \Input::get('ID');
            $areaStructure = new AreaStructure([
                'display'=> \Input::get('display')
            ]);

            \App::make('UpdateAreaInteractor')->run($areaID, $areaStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete()
    {
        $areaID = \Input::get('ID');

        try {
            \App::make('DeleteAreaInteractor')->run($areaID);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
} 