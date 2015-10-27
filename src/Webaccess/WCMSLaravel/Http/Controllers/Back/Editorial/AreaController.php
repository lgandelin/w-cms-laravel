<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use Webaccess\WCMSCore\Interactors\Areas\CreateAreaInteractor;
use Webaccess\WCMSCore\Interactors\Areas\DeleteAreaInteractor;
use Webaccess\WCMSCore\Interactors\Areas\GetAreaInteractor;
use Webaccess\WCMSCore\Interactors\Areas\UpdateAreaInteractor;
use Webaccess\WCMSCore\DataStructure;
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
            list($areaID, $newPageVersion) = (new CreateAreaInteractor())->run($areaStructure);
            $area = (new GetAreaInteractor())->getAreaByID($areaID, true);

            return json_encode(array('success' => true, 'area' => $area->toArray(), 'new_page_version' => $newPageVersion));
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
            $newPageVersion = (new UpdateAreaInteractor())->run($areaID, $areaStructure);
            return json_encode(array('success' => true, 'new_page_version' => $newPageVersion));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_order()
    {
        $newPageVersion = false;
        $areas = json_decode(\Input::get('areas'));
        for ($i = 0; $i < sizeof($areas); $i++) {
            $areaID = preg_replace('/a-/', '', $areas[$i]);

            $areaStructure = new DataStructure([
                'order' => $i + 1,
            ]);

            try {
                if ((new UpdateAreaInteractor())->run($areaID, $areaStructure)) {
                    $newPageVersion = true;
                }
            } catch (\Exception $e) {
                return json_encode(array('success' => false, 'error' => $e->getMessage()));
            }
        }

        return json_encode(array('success' => true, 'new_page_version' => $newPageVersion));
    }

    public function display()
    {
        try {
            $areaID = \Input::get('ID');
            $areaStructure = new DataStructure([
                'display'=> \Input::get('display')
            ]);

            $newPageVersion = (new UpdateAreaInteractor())->run($areaID, $areaStructure);
            return json_encode(array('success' => true, 'new_page_version' => $newPageVersion));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete()
    {
        $areaID = \Input::get('ID');

        try {
            $newPageVersion = (new DeleteAreaInteractor())->run($areaID);
            return json_encode(array('success' => true, 'new_page_version' => $newPageVersion));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
} 