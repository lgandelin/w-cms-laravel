<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\MediaFormats\GetMediaFormatsInteractor;
use Webaccess\WCMSCore\Interactors\Medias\GetMediasInteractor;

class MediaBlockController
{
    public function getBackView(DataStructure $block)
    {
        return view('w-cms-laravel::back.editorial.pages.blocks.media', [
            'block' => $block,
            'medias' => (new GetMediasInteractor())->getAll(true),
            'media_formats' => (new GetMediaFormatsInteractor())->getAll(true),
        ])->render();
    }
} 