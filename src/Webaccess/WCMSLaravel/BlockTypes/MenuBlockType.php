<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

class MenuBlockType
{
    public function __construct() {
        $this->code = 'menu';
        $this->name = trans('w-cms-laravel::blocks.navigation_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.content.menu';
        $this->template_view = 'w-cms-laravel::back.editorial.pages.blocks.templates.menu';
        $this->front_view = 'blocks.standard.menu';
        $this->model_class = '\Webaccess\WCMSLaravel\Models\Blocks\MenuBlock';
        $this->order = 2;
    }
} 