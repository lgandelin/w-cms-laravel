<?php

namespace Webaccess\WCMSLaravel\Repositories\Eloquent;

use CMS\Entities\Lang;
use CMS\Repositories\LangRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Lang as LangModel;

class EloquentLangRepository implements LangRepositoryInterface
{
    public function findByID($langID)
    {
        if ($langModel = LangModel::find($langID))
            return self::createLangFromModel($langModel);

        return false;
    }

    public function findAll()
    {
        $langModels = LangModel::get();

        $langs = [];
        foreach ($langModels as $langModel)
            $langs[]= self::createLangFromModel($langModel);

        return $langs;
    }

    public function createLang(Lang $lang)
    {
        $langModel = new LangModel();
        $langModel->name = $lang->getName();
        $langModel->prefix = $lang->getPrefix();
        $langModel->code = $lang->getCode();
        $langModel->is_default = $lang->getIsDefault();

        $langModel->save();

        return $langModel->id;
    }

    public function updateLang(Lang $lang)
    {
        $langModel = LangModel::find($lang->getID());
        $langModel->name = $lang->getName();
        $langModel->prefix = $lang->getPrefix();
        $langModel->code = $lang->getCode();
        $langModel->is_default = $lang->getIsDefault();

        return $langModel->save();
    }

    public function deleteLang($langID)
    {
        $langModel = LangModel::where('id', '=', $langID)->first();

        return $langModel->delete();
    }

    public function findDefautLangID()
    {
        $langModel = LangModel::where('is_default', '=', 1)->first();

        return $langModel->id;
    }

    private static function createLangFromModel(LangModel $langModel)
    {
        $lang = new Lang();
        $lang->setID($langModel->id);
        $lang->setName($langModel->name);
        $lang->setPrefix($langModel->prefix);
        $lang->setCode($langModel->code);
        $lang->setIsDefault($langModel->is_default);

        return $lang;
    }
}