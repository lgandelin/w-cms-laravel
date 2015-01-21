<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Media;
use CMS\Repositories\MediaRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Media as MediaModel;

class EloquentMediaRepository implements MediaRepositoryInterface
{
    public function findByID($mediaID)
    {
        if ($mediaModel = MediaModel::find($mediaID))
            return self::createMediaFromModel($mediaModel);

        return false;
    }

    public function findAll()
    {
        $mediaModels = MediaModel::get();

        $medias = [];
        foreach ($mediaModels as $mediaModel)
            $medias[]= self::createMediaFromModel($mediaModel);

        return $medias;
    }

    public function createMedia(Media $media)
    {
        $mediaModel = new MediaModel();
        $mediaModel->name = $media->getName();
        $mediaModel->path = $media->getPath();

        $mediaModel->save();

        return $mediaModel->id;
    }

    public function updateMedia(Media $media)
    {
        $mediaModel = MediaModel::find($media->getID());
        $mediaModel->name = $media->getName();
        $mediaModel->path = $media->getPath();

        return $mediaModel->save();
    }

    public function deleteMedia($mediaID)
    {
        $mediaModel = MediaModel::where('id', '=', $mediaID)->first();

        return $mediaModel->delete();
    }

    private static function createMediaFromModel(MediaModel $mediaModel)
    {
        $media = new Media();
        $media->setID($mediaModel->id);
        $media->setName($mediaModel->name);
        $media->setPath($mediaModel->path);

        return $media;
    }
}