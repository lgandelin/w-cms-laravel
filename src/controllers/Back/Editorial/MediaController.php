<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\MediaStructure;
use Intervention\Image\ImageManager;
use Webaccess\WCMSLaravel\Back\AdminController;

class MediaController extends AdminController
{
    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.medias.index', [
            'medias' => \App::make('GetMediasInteractor')->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.medias.create');
    }

    public function store()
    {
        $fileName = \Input::file('image')->getClientOriginalName();
        $mediaStructure = new MediaStructure([
            'name' => \Input::get('name'),
            'path' => $fileName,
            'alt' => \Input::get('alt'),
            'title' => \Input::get('title'),
        ]);

        try {
            $mediaID = \App::make('CreateMediaInteractor')->run($mediaStructure);

            //Upload image
            if (\Input::file('image')) {
                $fileName = $mediaID . '.jpg';
                \Input::file('image')->move(public_path() . '/img/uploads/' . $mediaID . '/', $fileName);
            }

            return \Redirect::route('back_medias_edit', array('mediaID' => $mediaID));
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.editorial.medias.create', [
                'error' => $e->getMessage(),
                'media' => $mediaStructure
            ]);
        }
    }

    public function edit($mediaID)
    {
        try {
            $media = \App::make('GetMediaInteractor')->getMediaByID($mediaID, true);

            $this->layout = \View::make('w-cms-laravel::back.editorial.medias.edit', [
                'media' => $media,
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_medias_index');
        }
    }

    public function update()
    {
        $mediaID = \Input::get('ID');
        $type = preg_replace('/image\//', '', \Input::file('image')->getMimeType());
        $fileName = $mediaID . '.' . $type;
        $mediaStructure = new MediaStructure([
            'name' => \Input::get('name'),
            'path' => $fileName,
            'alt' => \Input::get('alt'),
            'title' => \Input::get('title'),
        ]);

        try {
            \App::make('UpdateMediaInteractor')->run($mediaID, $mediaStructure);

            //Upload new image
            if (\Input::file('image')) {
                array_map('unlink', glob(public_path() . '/img/uploads/' . $mediaID . '/*'));
                \Input::file('image')->move(public_path() . '/img/uploads/' . $mediaID . '/', $fileName);
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
            return \Redirect::route('back_medias_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_medias_index');
        }
    }

    public function upload()
    {
        $mediaID = \Input::get('ID');
        $type = preg_replace('/image\//', '', \Input::file('image')->getMimeType());
        $fileName = $mediaID . '.' . $type;

        $mediaStructure = new MediaStructure([
            'path' => $fileName,
        ]);

        try {
            \App::make('UpdateMediaInteractor')->run($mediaID, $mediaStructure);

            //Upload new image
            if (\Input::file('image')) {
                array_map('unlink', glob(public_path() . '/img/uploads/' . $mediaID . '/*'));
                \Input::file('image')->move(public_path() . '/img/uploads/' . $mediaID . '/', $fileName);

                //Upload image foreach media format
                $mediaFormats = \App::make('GetMediaFormatsInteractor')->getAll(true);
                if (is_array($mediaFormats) && sizeof($mediaFormats) > 0) {
                    foreach ($mediaFormats as $mediaFormat) {

                        $manager = new ImageManager();
                        $image = $manager->make(public_path() . '/img/uploads/' . $mediaID . '/' . $fileName)->resize($mediaFormat->width, $mediaFormat->height);

                        $newFileName = preg_replace('/' . $mediaID . '/', $mediaID . '_' . $mediaFormat->width . '_' . $mediaFormat->height, $fileName);
                        $image->save(public_path() . '/img/uploads/' . $mediaID . '/' . $newFileName);
                    }
                }
            }

            return \Response::json(array('image' => asset('img/uploads/' . $mediaID . '/' . $fileName)));
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return false;
        }

    }
}