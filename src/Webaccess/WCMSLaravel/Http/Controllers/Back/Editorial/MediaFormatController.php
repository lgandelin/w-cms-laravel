<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Structures\MediaFormatStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MediaFormatController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.editorial.media_formats.index', [
            'media_formats' => \App::make('GetMediaFormatsInteractor')->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.editorial.media_formats.create');
    }

    public function store()
    {
        $mediaFormatStructure = new MediaFormatStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
        ]);

        try {
            $mediaFormatID = \App::make('CreateMediaFormatInteractor')->run($mediaFormatStructure);

            return \Redirect::route('back_media_formats_edit', array('mediaFormatID' => $mediaFormatID));
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.editorial.media_formats.create', [
                'error' => $e->getMessage(),
                'media_format' => $mediaFormatStructure
            ]);
        }
    }

    public function edit($mediaFormatID)
    {
        try {
            $mediaFormat = \App::make('GetMediaFormatInteractor')->getMediaFormatByID($mediaFormatID, true);
            return view('w-cms-laravel::back.editorial.media_formats.edit', [
                'media_format' => $mediaFormat,
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_media_formats_index');
        }
    }

    public function update()
    {
        $mediaFormatID = \Input::get('ID');
        $mediaFormatStructure = new MediaFormatStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
        ]);

        try {
            \App::make('UpdateMediaFormatInteractor')->run($mediaFormatID, $mediaFormatStructure);

            return \Redirect::route('back_media_formats_edit', array('ID' => $mediaFormatID));
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_media_formats_index');
        }
    }

    public function delete($mediaFormatID)
    {
        try {
            \App::make('DeleteMediaFormatInteractor')->run($mediaFormatID);
            return \Redirect::route('back_media_formats_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_media_formats_index');
        }
    }

}