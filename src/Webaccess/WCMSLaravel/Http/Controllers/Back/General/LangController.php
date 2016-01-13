<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\General;

use Illuminate\Support\Facades\Input;
use Webaccess\WCMSCore\Interactors\Langs\CreateLangInteractor;
use Webaccess\WCMSCore\Interactors\Langs\DeleteLangInteractor;
use Webaccess\WCMSCore\Interactors\Langs\GetLangInteractor;
use Webaccess\WCMSCore\Interactors\Langs\GetLangsInteractor;
use Webaccess\WCMSCore\Interactors\Langs\UpdateLangInteractor;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class LangController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.general.langs.index', [
            'langs' => (new GetLangsInteractor())->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.general.langs.create');
    }

    public function store()
    {
        $langStructure = new DataStructure([
            'name' => Input::get('name'),
            'prefix' => Input::get('prefix'),
            'code' => Input::get('code'),
            'is_default' => Input::get('is_default'),
        ]);
        
        try {
            $langStructure = (new CreateLangInteractor())->run($langStructure);
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
                'lang' => (new GetLangInteractor())->getLangByID($langID, true)
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_langs_index');
        }
    }

    public function update()
    {
        $langID = Input::get('ID');
        $langStructure = new DataStructure([
            'name' => Input::get('name'),
            'prefix' => Input::get('prefix'),
            'code' => Input::get('code'),
            'is_default' => Input::get('is_default'),
        ]);

        try {
            (new UpdateLangInteractor())->run($langID, $langStructure);
            return \Redirect::route('back_langs_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_langs_index');
        }
    }

    public function delete($langID)
    {
        try {
            (new DeleteLangInteractor())->run($langID);
            return \Redirect::route('back_langs_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_langs_index');
        }
    }

    public function change($langID)
    {
        \Session::put('lang_id', $langID);

        return \Redirect::to(\URL::previous());
    }
}