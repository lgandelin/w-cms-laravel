<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\MediaStructure;
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
        $path = (\Input::file('image')) ? time() . '.jpg' : null;
        $mediaStructure = new MediaStructure([
            'name' => \Input::get('name'),
            'path' => $path
        ]);

        try {
            $mediaID = \App::make('CreateMediaInteractor')->run($mediaStructure);

            //Upload image
            \Input::file('image')->move('/var/www/cms-app/public/img/uploads/', $path);

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
        $path = (\Input::file('image')) ? $mediaID . '_' . time() . '.jpg' : null;
        $mediaStructure = new MediaStructure([
            'name' => \Input::get('name'),
            'path' => $path
        ]);

        try {
            \App::make('UpdateMediaInteractor')->run($mediaID, $mediaStructure);

            //Upload new image
            if (\Input::file('image')) {
                \Input::file('image')->move('/var/www/cms-app/public/img/uploads/', $path);
            }

            return \Redirect::route('back_medias_index');
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
}