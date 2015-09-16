<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Medias\GetMediaInteractor;

class MediaBlockController
{
    public function index(DataStructure $block)
    {
        $block->media = (new GetMediaInteractor())->getMediaByID($block->mediaID, $block->mediaFormatID, true);

        return view(\Shortcut::get_theme() . '::blocks.standard.media', [
            'block' => $block,
        ])->render();
    }
}