<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

class MediaBlockType
{
    public function __construct() {
        $this->code = 'media';
        $this->name = trans('w-cms-laravel::blocks.media_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.media';
        $this->front_view = 'blocks.standard.media';
        $this->order = 4;
    }
}
