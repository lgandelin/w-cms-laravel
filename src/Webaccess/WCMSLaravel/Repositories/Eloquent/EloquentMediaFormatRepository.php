<?php

namespace Webaccess\WCMSLaravel\Repositories\Eloquent;

use CMS\Entities\MediaFormat;
use CMS\Repositories\MediaFormatRepositoryInterface;
use Webaccess\WCMSLaravel\Models\MediaFormat as MediaFormatModel;

class EloquentMediaFormatRepository implements MediaFormatRepositoryInterface
{
    public function findByID($mediaFormatID)
    {
        if ($mediaFormatModel = MediaFormatModel::find($mediaFormatID))
            return self::createMediaFormatFromModel($mediaFormatModel);

        return false;
    }

    public function findAll()
    {
        $mediaFormatModels = MediaFormatModel::get();

        $mediaFormats = [];
        foreach ($mediaFormatModels as $mediaFormatModel)
            $mediaFormats[]= self::createMediaFormatFromModel($mediaFormatModel);

        return $mediaFormats;
    }

    public function createMediaFormat(MediaFormat $mediaFormat)
    {
        $mediaFormatModel = new MediaFormatModel();
        $mediaFormatModel->name = $mediaFormat->getName();
        $mediaFormatModel->width = $mediaFormat->getWidth();
        $mediaFormatModel->height = $mediaFormat->getHeight();

        $mediaFormatModel->save();

        return $mediaFormatModel->id;
    }

    public function updateMediaFormat(MediaFormat $mediaFormat)
    {
        $mediaFormatModel = MediaFormatModel::find($mediaFormat->getID());
        $mediaFormatModel->name = $mediaFormat->getName();
        $mediaFormatModel->width = $mediaFormat->getWidth();
        $mediaFormatModel->height = $mediaFormat->getHeight();

        return $mediaFormatModel->save();
    }

    public function deleteMediaFormat($mediaFormatID)
    {
        $mediaFormatModel = MediaFormatModel::where('id', '=', $mediaFormatID)->first();

        return $mediaFormatModel->delete();
    }

    private static function createMediaFormatFromModel(MediaFormatModel $mediaFormatModel)
    {
        $mediaFormat = new MediaFormat();
        $mediaFormat->setID($mediaFormatModel->id);
        $mediaFormat->setName($mediaFormatModel->name);
        $mediaFormat->setWidth($mediaFormatModel->width);
        $mediaFormat->setHeight($mediaFormatModel->height);

        return $mediaFormat;
    }
}