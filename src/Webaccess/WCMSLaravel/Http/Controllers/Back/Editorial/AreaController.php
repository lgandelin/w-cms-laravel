<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Areas\DeleteAreaInteractor;
use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\DataStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class AreaController extends AdminController
{
    public function get_infos($areaID)
    {
        try {
            $area = (new GetAreaInteractor())->getAreaByID($areaID, true);

            return json_encode(array('success' => true, 'area' => $area->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function create()
    {
        $areaStructure = new DataStructure();
        foreach (\Input::all() as $key => $value) {
            $areaStructure->$key = $value;
        }

        try {
            $areaID = (new CreateAreaInteractor())->run($areaStructure);
            $area = (new GetAreaInteractor())->getAreaByID($areaID, true);

            return json_encode(array('success' => true, 'area' => $area->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_infos()
    {
        $areaID = \Input::get('ID');

        $areaStructure = new DataStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
            'class' => \Input::get('class'),
            'is_master' => \Input::get('is_master'),
        ]);

        try {
            (new UpdateAreaInteractor())->run($areaID, $areaStructure);
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

            $areaStructure = new DataStructure([
                'order' => $i + 1,
            ]);

            try {
                (new UpdateAreaInteractor())->run($areaID, $areaStructure);
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
            $areaStructure = new DataStructure([
                'display'=> \Input::get('display')
            ]);

            (new UpdateAreaInteractor())->run($areaID, $areaStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete()
    {
        $areaID = \Input::get('ID');

        try {
            (new DeleteAreaInteractor())->run($areaID);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
} 