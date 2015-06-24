<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

class HTMLBlockType
{
    public function __construct() {
        $this->code = 'html';
        $this->name = trans('w-cms-laravel::blocks.html_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.html';
        $this->front_view = 'blocks.standard.html';
        $this->order = 1;
    }
}
