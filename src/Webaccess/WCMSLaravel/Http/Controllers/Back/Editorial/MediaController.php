<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Structures\MediaStructure;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MediaController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.editorial.medias.index', [
            'medias' => \App::make('GetMediasInteractor')->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.editorial.medias.create');
    }

    public function store()
    {
        $mediaStructure = new MediaStructure([
            'name' => \Input::get('name'),
            'alt' => \Input::get('alt'),
            'title' => \Input::get('title'),
        ]);

        try {
            $mediaID = \App::make('CreateMediaInteractor')->run($mediaStructure);

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
            $media = \App::make('GetMediaInteractor')->getMediaByID($mediaID, true);

            return view('w-cms-laravel::back.editorial.medias.edit', [
                'media' => $media,
                'media_formats' => \App::make('GetMediaFormatsInteractor')->getAll(true)
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

        $oldMedia = \App::make('GetMediaInteractor')->getMediaByID($mediaID, true);

        $mediaStructure = new MediaStructure([
            'name' => \Input::get('name'),
            'file_name' => $fileName,
            'alt' => \Input::get('alt'),
            'title' => \Input::get('title'),
        ]);

        try {
            \App::make('UpdateMediaInteractor')->run($mediaID, $mediaStructure);

            //Rename file
            if ($fileName != $oldMedia->file_name) {
                File::move($this->getMediaFolder($mediaID) . $oldMedia->file_name, $this->getMediaFolder($mediaID) . $fileName);

                $mediaFormats = \App::make('GetMediaFormatsInteractor')->getAll(true);
                if (is_array($mediaFormats) && sizeof($mediaFormats) > 0) {
                    foreach ($mediaFormats as $mediaFormat) {
                        File::move($this->getMediaFolder($mediaID) . $mediaFormat->width . '_' . $mediaFormat->height . '_' . $oldMedia->file_name, $this->getMediaFolder($mediaID) . $mediaFormat->width . '_' . $mediaFormat->height . '_' . $fileName);
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
            \App::make('DeleteMediaInteractor')->run($mediaID);

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

        $mediaStructure = new MediaStructure([
            'file_name' => $fileName,
        ]);

        $mediaFormatsImages = array();

        try {
            \App::make('UpdateMediaInteractor')->run($mediaID, $mediaStructure);

            //Upload new image
            if (\Input::file('image')) {
                array_map('unlink', glob($this->getMediaFolder($mediaID) . '*'));
                \Input::file('image')->move($this->getMediaFolder($mediaID), $fileName);

                //Upload image foreach media format
                $mediaFormats = \App::make('GetMediaFormatsInteractor')->getAll(true);
                if (is_array($mediaFormats) && sizeof($mediaFormats) > 0) {
                    foreach ($mediaFormats as $mediaFormat) {

                        $manager = new ImageManager();
                        $image = $manager->make($this->getMediaFolder($mediaID) . $fileName);

                        if ($image->width() >= $mediaFormat->width) {
                            $image->resize($mediaFormat->width, $mediaFormat->height);
                        }

                        $newFileName = $mediaFormat->width . '_' . $mediaFormat->height . '_' . $fileName;
                        $image->save($this->getMediaFolder($mediaID) . $newFileName);


                        $mediaFormatsImages[]= array('media_format_id' => $mediaFormat->ID, 'image' => asset('img/uploads/' . $mediaID . '/' . $newFileName));
                    }
                }
            }

            return \Response::json(
                array(
                    'image' => asset('img/uploads/' . $mediaID . '/' . $fileName),
                    'file_name' => $fileName,
                    'media_format_images' => $mediaFormatsImages
                )
            );
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Response::json(
                array(
                    'file_name' => $e->getMessage(),
                )
            );
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

        $media = \App::make('GetMediaInteractor')->getMediaByID($mediaID, true);
        $mediaFormat = \App::make('GetMediaFormatInteractor')->getMediaFormatByID($mediaFormatID, true);

        $fileName = $media->file_name;
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

        return \Response::json(array('image' => asset('img/uploads/' . $mediaID . '/' . $newFileName), 'file_name' => $newFileName));
    }

    private function getMediaFolder($mediaID)
    {
        return public_path() . '/img/uploads/' . $mediaID . '/';
    }
}