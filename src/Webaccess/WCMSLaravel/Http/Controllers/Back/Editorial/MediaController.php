<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use Webaccess\WCMSCore\Interactors\MediaFolders\GetMediaFolderInteractor;
use Webaccess\WCMSCore\Interactors\MediaFolders\GetMediaFoldersInteractor;
use Webaccess\WCMSCore\Interactors\MediaFormats\GetMediaFormatInteractor;
use Webaccess\WCMSCore\Interactors\MediaFormats\GetMediaFormatsInteractor;
use Webaccess\WCMSCore\Interactors\Medias\CreateMediaInteractor;
use Webaccess\WCMSCore\Interactors\Medias\DeleteMediaInteractor;
use Webaccess\WCMSCore\Interactors\Medias\GetMediaInteractor;
use Webaccess\WCMSCore\Interactors\Medias\GetMediasInteractor;
use Webaccess\WCMSCore\Interactors\Medias\UpdateMediaInteractor;
use Webaccess\WCMSCore\DataStructure;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Webaccess\WCMSLaravel\Facades\Shortcut;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MediaController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.editorial.medias.index', [
            //'medias' => (new GetMediasInteractor())->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function getAll()
    {
        try {
            $mediaFolderID = \Input::get('mediaFolderID');
            $breadcrumb = [];
            if ($mediaFolderID) {
                $mediaFolder = (new GetMediaFolderInteractor())->getMediaFolderByID($mediaFolderID, true);
                $folder = clone $mediaFolder;

                while ($folder->parentID != 0) {
                    $folder = (new GetMediaFolderInteractor())->getMediaFolderByID($folder->parentID, true);
                    array_unshift($breadcrumb, $folder);
                }
            }
            array_unshift($breadcrumb, ['ID' => 0, 'name' => 'Root']);

            return response()->json(
                array(
                    'medias' => array_merge(
                        (new GetMediaFoldersInteractor())->getAllByMediaFolder($mediaFolderID, true),
                        (new GetMediasInteractor())->getAllByMediaFolder($mediaFolderID, true)
                    ),
                    'mediaFolder' => (isset($mediaFolder) ? $mediaFolder : null),
                    'breadcrumb' => $breadcrumb,
                )
            );
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function moveInMediaFolder()
    {
        try {
            $mediaID = \Input::get('mediaID');
            $mediaFolderID = \Input::get('mediaFolderID');

            $dataStructure = new DataStructure([
                'mediaFolderID' => $mediaFolderID,
            ]);

            (new UpdateMediaInteractor())->run($mediaID, $dataStructure);

            return response()->json(
                array(
                    'mediaID' => $mediaID,
                )
            );
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function create()
    {
        return view('w-cms-laravel::back.editorial.medias.create');
    }

    public function store()
    {
        $fileName = basename(\Input::get('fileName'));

        $mediaStructure = new DataStructure([
            'name' => \Input::get('name'),
            'alt' => \Input::get('alt'),
            'title' => \Input::get('title'),
            'mediaFolderID' => \Input::get('mediaFolderID'),
        ]);

        try {
            if ($mediaID = (new CreateMediaInteractor())->run($mediaStructure)) {
                if (!is_dir($this->getMediaFolder($mediaID))) {
                    mkdir($this->getMediaFolder($mediaID));
                }
                File::move(public_path() . '/' . Shortcut::get_uploads_folder() . 'temp/' . $fileName, $this->getMediaFolder($mediaID) . $fileName);

                $mediaStructure = new DataStructure([
                    'fileName' => basename($fileName),
                ]);
                (new UpdateMediaInteractor())->run($mediaID, $mediaStructure);

                $media = (new GetMediaInteractor())->getMediaByID($mediaID, null, true);

                //Media formats
                $mediaFormats = (new GetMediaFormatsInteractor())->getAll(true);
                if (is_array($mediaFormats) && sizeof($mediaFormats) > 0) {
                    foreach ($mediaFormats as $mediaFormat) {
                        $media = (new GetMediaInteractor())->getMediaByID($mediaID, null, true);
                        $fileName = $media->fileName;
                        $newFileName = $mediaFormat->width . '_' . $mediaFormat->height . '_' . $fileName;

                        $manager = new ImageManager();
                        $image = $manager->make($this->getMediaFolder($mediaID) . $fileName);
                        $image->resize($mediaFormat->width, $mediaFormat->height)
                            ->save($this->getMediaFolder($mediaID) . $newFileName);
                    }
                }
            }

            return response()->json(
                array(
                    'media' => (isset($media) ? $media : null),
                )
            );
        } catch (\Exception $e) {
            /*return view('w-cms-laravel::back.editorial.medias.create', [
                'error' => $e->getMessage(),
                'media' => $mediaStructure
            ]);*/
        }
    }

    public function edit($mediaID)
    {
        try {
            $media = (new GetMediaInteractor())->getMediaByID($mediaID, null, true);

            return view('w-cms-laravel::back.editorial.medias.edit', [
                'media' => $media,
                'media_formats' => (new GetMediaFormatsInteractor())->getAll(true)
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_medias_index');
        }
    }

    public function update()
    {
        $mediaID = \Input::get('ID');
        $fileName = \Input::get('file_name');

        if (!$fileName && \Input::file('image')) {
            $type = preg_replace('/image\//', '', \Input::file('image')->getMimeType());
            $fileName = $mediaID . '.' . $type;
        }

        $oldMedia = (new GetMediaInteractor())->getMediaByID($mediaID, null, true);

        $mediaStructure = new DataStructure([
            'name' => \Input::get('name'),
            'fileName' => $fileName,
            'alt' => \Input::get('alt'),
            'title' => \Input::get('title'),
        ]);

        try {
            (new UpdateMediaInteractor())->run($mediaID, $mediaStructure);

            //Rename file
            if ($fileName != $oldMedia->fileName) {
                File::move($this->getMediaFolder($mediaID) . $oldMedia->fileName, $this->getMediaFolder($mediaID) . $fileName);

                $mediaFormats = (new GetMediaFormatsInteractor())->getAll(true);
                if (is_array($mediaFormats) && sizeof($mediaFormats) > 0) {
                    foreach ($mediaFormats as $mediaFormat) {
                        File::move($this->getMediaFolder($mediaID) . $mediaFormat->width . '_' . $mediaFormat->height . '_' . $oldMedia->fileName, $this->getMediaFolder($mediaID) . $mediaFormat->width . '_' . $mediaFormat->height . '_' . $fileName);
                    }
                }
            }

            return \Redirect::route('back_medias_edit', array('ID' => $mediaID));
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_medias_index');
        }
    }

    public function delete()
    {
        $mediaID = \Input::get('ID');
        try {
            (new DeleteMediaInteractor())->run($mediaID);

            array_map('unlink', glob($this->getMediaFolder($mediaID) . '*'));
            rmdir($this->getMediaFolder($mediaID));

            return response()->json(
                array(
                    'success' => true,
                    'mediaID' => $mediaID,
                )
            );

            //return \Redirect::route('back_medias_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            //return \Redirect::route('back_medias_index');
        }
    }

    /*public function upload()
    {
        $mediaID = \Input::get('ID');
        $fileName = \Input::file('image')->getClientOriginalName();

        $mediaStructure = new DataStructure([
            'fileName' => $fileName,
        ]);

        try {
            (new UpdateMediaInteractor())->run($mediaID, $mediaStructure);
            $mediaFormatsImages = $this->uploadImage($mediaID, $fileName);

            return \Response::json(
                array(
                    'image' => asset(Shortcut::get_uploads_folder() . $mediaID . '/' . $fileName),
                    'fileName' => $fileName,
                    'media_format_images' => $mediaFormatsImages
                )
            );
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Response::json(
                array(
                    'fileName' => $e->getMessage(),
                )
            );
        }
    }*/

    public function upload()
    {
        $fileName = \Input::file('image')->getClientOriginalName();

        try {
            \Input::file('image')->move(public_path() . '/' . Shortcut::get_uploads_folder() . 'temp/', $fileName);

            return \Response::json(
                array(
                    'fileName' => asset(Shortcut::get_uploads_folder() . 'temp/' . $fileName),
                    'baseFileName' => basename($fileName),
                )
            );
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Response::json(
                array(
                    'fileName' => $e->getMessage(),
                )
            );
        }
    }

    public function create_and_upload()
    {
        $fileName = \Input::file('image')->getClientOriginalName();

        $mediaStructure = new DataStructure([
            'name' => \Input::get('name'),
            'alt' => \Input::get('alt'),
            'title' => \Input::get('title'),
            'fileName' => $fileName,
        ]);

        try {
            $mediaID = (new CreateMediaInteractor())->run($mediaStructure);
            $this->uploadImage($mediaID, $fileName);

            return \Response::json(
                array(
                    'image' => asset(Shortcut::get_uploads_folder() . $mediaID . '/' . $fileName),
                    'fileName' => $fileName,
                    'media_id' => $mediaID
                )
            );
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.editorial.medias.create', [
                'error' => $e->getMessage(),
                'media' => $mediaStructure
            ]);
        }
    }

    public function crop()
    {
        $mediaID = \Input::get('ID');
        $mediaFormatID = \Input::get('media_format_id');
        $width = \Input::get('width');
        $height = \Input::get('height');
        $x = \Input::get('x');
        $y = \Input::get('y');

        $media = (new GetMediaInteractor())->getMediaByID($mediaID, null, true);
        $mediaFormat = (new GetMediaFormatInteractor())->getMediaFormatByID($mediaFormatID, true);

        $fileName = $media->fileName;
        $newFileName = $mediaFormat->width . '_' . $mediaFormat->height . '_' . $fileName;

        //Delete old image
        if (file_exists($this->getMediaFolder($mediaID) . $newFileName)) {
            unlink($this->getMediaFolder($mediaID) . $newFileName);
        }

        $manager = new ImageManager();
        $image = $manager->make($this->getMediaFolder($mediaID) . $fileName);
        $image->crop($width, $height, $x, $y)
            ->resize($mediaFormat->width, $mediaFormat->height)
            ->save($this->getMediaFolder($mediaID) . $newFileName);

        return \Response::json(array('image' => asset(Shortcut::get_uploads_folder() . $mediaID . '/' . $newFileName), 'fileName' => $newFileName));
    }

    private function getMediaFolder($mediaID)
    {
        return public_path() . '/' . Shortcut::get_uploads_folder() . $mediaID . '/';
    }

    private function uploadImage($mediaID, $fileName)
    {
        $mediaFormatsImages = [];
        //Upload new image
        if (\Input::file('image')) {
            array_map('unlink', glob($this->getMediaFolder($mediaID) . '*'));
            \Input::file('image')->move($this->getMediaFolder($mediaID), $fileName);

            //Upload image foreach media format
            $mediaFormats = (new GetMediaFormatsInteractor())->getAll(true);
            if (is_array($mediaFormats) && sizeof($mediaFormats) > 0) {
                foreach ($mediaFormats as $mediaFormat) {

                    $manager = new ImageManager();
                    $image = $manager->make($this->getMediaFolder($mediaID) . $fileName);

                    if ($image->width() >= $mediaFormat->width) {
                        $image->resize($mediaFormat->width, $mediaFormat->height);
                    }

                    $newFileName = $mediaFormat->width . '_' . $mediaFormat->height . '_' . $fileName;
                    $image->save($this->getMediaFolder($mediaID) . $newFileName);


                    $mediaFormatsImages[] = array('media_format_id' => $mediaFormat->ID, 'image' => asset(Shortcut::get_uploads_folder() . $mediaID . '/' . $newFileName));
                }
            }
        }

        return $mediaFormatsImages;
    }
}