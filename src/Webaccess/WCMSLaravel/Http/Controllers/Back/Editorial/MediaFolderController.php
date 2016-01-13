<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use Illuminate\Support\Facades\Input;
use Webaccess\WCMSCore\Interactors\MediaFolders\CreateMediaFolderInteractor;
use Webaccess\WCMSCore\Interactors\MediaFolders\DeleteMediaFolderInteractor;
use Webaccess\WCMSCore\Interactors\MediaFolders\GetMediaFolderInteractor;
use Webaccess\WCMSCore\Interactors\MediaFolders\UpdateMediaFolderInteractor;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MediaFolderController extends AdminController
{
    public function store()
    {
        $mediaFolderStructure = new DataStructure([
            'name' => Input::get('name'),
            'parentID' => Input::get('parent_id'),
        ]);

        try {
            $mediaFolderID = (new CreateMediaFolderInteractor())->run($mediaFolderStructure);
            $mediaFolder = (new GetMediaFolderInteractor())->getMediaFolderByID($mediaFolderID, true);
            //return \Redirect::route('back_media_folders_edit', array('mediaFolderID' => $mediaFolderID));

            return \Response::json(
                array(
                    'mediaFolder' => $mediaFolder,
                    'success' => true
                )
            );
        } catch (\Exception $e) {
            /*return view('w-cms-laravel::back.editorial.media_folders.create', [
                'error' => $e->getMessage(),
                'media_folder' => $mediaFolderStructure
            ]);*/
        }
    }

    public function moveInMediaFolder()
    {
        try {
            $mediaFolderID = Input::get('mediaFolderID');
            $parentMediaFolderID = Input::get('parentMediaFolderID');

            $dataStructure = new DataStructure([
                'parentID' => $parentMediaFolderID,
            ]);

            (new UpdateMediaFolderInteractor())->run($mediaFolderID, $dataStructure);

            return response()->json(
                array(
                    '$mediaFolderID' => $mediaFolderID,
                )
            );
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update()
    {
        $mediaFolderID = Input::get('ID');
        $mediaFolderStructure = new DataStructure([
            'name' => Input::get('name'),
            'parentID' => Input::get('parent_id'),
        ]);

        try {
            (new UpdateMediaFolderInteractor())->run($mediaFolderID, $mediaFolderStructure);

            //return \Redirect::route('back_media_folders_edit', array('ID' => $mediaFolderID));
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            //return \Redirect::route('back_media_folders_index');
        }
    }

    public function delete()
    {
        $mediaFolderID = Input::get('ID');
        try {
            (new DeleteMediaFolderInteractor())->run($mediaFolderID);

            return \Response::json(
                array(
                    'mediaFolderID' => $mediaFolderID,
                    'success' => true
                )
            );

            //return \Redirect::route('back_media_folders_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            //return \Redirect::route('back_media_folders_index');
        }
    }

}