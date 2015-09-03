<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use Webaccess\WCMSCore\Interactors\MediaFormats\CreateMediaFormatInteractor;
use Webaccess\WCMSCore\Interactors\MediaFormats\DeleteMediaFormatInteractor;
use Webaccess\WCMSCore\Interactors\MediaFormats\GetMediaFormatInteractor;
use Webaccess\WCMSCore\Interactors\MediaFormats\GetMediaFormatsInteractor;
use Webaccess\WCMSCore\Interactors\MediaFormats\UpdateMediaFormatInteractor;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MediaFormatController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.editorial.media_formats.index', [
            'media_formats' => (new GetMediaFormatsInteractor())->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.editorial.media_formats.create');
    }

    public function store()
    {
        $mediaFormatStructure = new DataStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
        ]);

        try {
            $mediaFormatID = (new CreateMediaFormatInteractor())->run($mediaFormatStructure);

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
            $mediaFormat = (new GetMediaFormatInteractor())->getMediaFormatByID($mediaFormatID, true);
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
        $mediaFormatStructure = new DataStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
        ]);

        try {
            (new UpdateMediaFormatInteractor())->run($mediaFormatID, $mediaFormatStructure);

            return \Redirect::route('back_media_formats_edit', array('ID' => $mediaFormatID));
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_media_formats_index');
        }
    }

    public function delete($mediaFormatID)
    {
        try {
            (new DeleteMediaFormatInteractor())->run($mediaFormatID);
            return \Redirect::route('back_media_formats_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_media_formats_index');
        }
    }

}