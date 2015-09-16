<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Medias\GetMediaInteractor;

class MediaBlockController
{
    public function index(DataStructure $block)
    {
        if (isset($block->mediaID)) {
            $block->media = (new GetMediaInteractor())->getMediaByID($block->mediaID, $block->mediaFormatID, true);
        }

        return view('w-cms-laravel::back.editorial.pages.blocks.media', [
            'block' => $block,
        ])->render();
    }
} 