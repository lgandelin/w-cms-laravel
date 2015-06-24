<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

class ArticleListBlockType
{
    public function __construct() {
        $this->code = 'article_list';
        $this->name = trans('w-cms-laravel::blocks.article_list_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.article_list';
        $this->front_view = 'blocks.standard.article_list';
        $this->model_class = '\Webaccess\WCMSLaravel\Models\Blocks\ArticleListBlock';
        $this->order = 6;
    }
}