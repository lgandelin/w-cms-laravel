<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Interactors\MediaFormats\GetMediaFormatInteractor;
use CMS\Interactors\MediaFormats\GetMediaFormatsInteractor;
use CMS\Interactors\Medias\CreateMediaInteractor;
use CMS\Interactors\Medias\DeleteMediaInteractor;
use CMS\Interactors\Medias\GetMediaInteractor;
use CMS\Interactors\Medias\GetMediasInteractor;
use CMS\Interactors\Medias\UpdateMediaInteractor;
use CMS\DataStructure;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Webaccess\WCMSLaravel\Facades\Shortcut;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MediaController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.editorial.medias.index', [
            'medias' => (new GetMediasInteractor())->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.editorial.medias.create');
    }

    public function store()
    {
        $mediaStructure = new DataStructure([
            'name' => \Input::get('name'),
            'alt' => \Input::get('alt'),
            'title' => \Input::get('title'),
        ]);

        try {
            $mediaID = (new CreateMediaInteractor())->run($mediaStructure);

            return \Redirect::route('back_medias_edit', array('mediaID' => $mediaID));
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.editorial.medias.create', [
                'error' => $e->getMessage(),
                'media' => $mediaStructure
            ]);
        }
    }

    public function edit($mediaID)
    {
        try {
            $media = (new GetMediaInteractor())->getMediaByID($mediaID, true);

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

        $oldMedia = (new GetMediaInteractor())->getMediaByID($mediaID, true);

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

    public function delete($mediaID)
    {
        try {
            (new DeleteMediaInteractor())->run($mediaID);

            array_map('unlink', glob($this->getMediaFolder($mediaID) . '*'));
            rmdir($this->getMediaFolder($mediaID));

            return \Redirect::route('back_medias_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_medias_index');
        }
    }

    public function upload()
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

        $media = (new GetMediaInteractor())->getMediaByID($mediaID, true);
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