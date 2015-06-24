<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

class MenuBlockType
{
    public function __construct() {
        $this->code = 'menu';
        $this->name = trans('w-cms-laravel::blocks.navigation_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.menu';
        $this->front_view = 'blocks.standard.menu';
        $this->order = 2;
    }
} 