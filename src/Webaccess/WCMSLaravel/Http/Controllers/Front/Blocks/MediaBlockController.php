<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Medias\GetMediaInteractor;

class MediaBlockController
{
    public function index(DataStructure $block)
    {
        if ($block->mediaID) {
            $block->media = (new GetMediaInteractor())->getMediaByID($block->mediaID, $block->mediaFormatID, true);
        }

        return view(\Shortcut::getTheme() . '::blocks.standard.media', [
            'block' => $block,
        ])->render();
    }
}