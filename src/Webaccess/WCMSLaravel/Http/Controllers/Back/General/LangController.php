<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\General;

use CMS\Structures\LangStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class LangController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.general.langs.index', [
            'langs' => \App::make('GetLangsInteractor')->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.general.langs.create');
    }

    public function store()
    {
        $langStructure = new LangStructure([
            'name' => \Input::get('name'),
            'prefix' => \Input::get('prefix'),
            'is_default' => \Input::get('is_default'),
        ]);
        
        try {
            $langStructure = \App::make('CreateLangInteractor')->run($langStructure);
            return \Redirect::route('back_langs_index');
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.general.langs.create', [
                'error' => $e->getMessage(),
                'lang' => $langStructure
            ]);
        }
    }

    public function edit($langID)
    {
        try {
            return view('w-cms-laravel::back.general.langs.edit', [
                'lang' => \App::make('GetLangInteractor')->getLangByID($langID, true)
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_langs_index');
        }
    }

    public function update()
    {
        $langID = \Input::get('ID');
        $langStructure = new LangStructure([
            'name' => \Input::get('name'),
            'prefix' => \Input::get('prefix'),
            'is_default' => \Input::get('is_default'),
        ]);

        try {
            \App::make('UpdateLangInteractor')->run($langID, $langStructure);
            return \Redirect::route('back_langs_index');
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.general.langs.edit', [
                'error' => $e->getMessage(),
                'lang' => $langStructure
            ]);
        }
    }

    public function delete($langID)
    {
        try {
            \App::make('DeleteLangInteractor')->run($langID);
            return \Redirect::route('back_langs_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_langs_index');
        }
    }
}