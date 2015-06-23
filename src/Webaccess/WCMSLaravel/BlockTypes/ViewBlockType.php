<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

class ViewBlockType
{
    public function __construct() {
        $this->code = 'view';
        $this->name = trans('w-cms-laravel::blocks.view_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.content.view';
        $this->front_view = 'blocks.standard.view';
        $this->model_class = '\Webaccess\WCMSLaravel\Models\Blocks\ViewBlock';
        $this->order = 3;
    }
}
