<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

class ArticleBlockType
{
    public function __construct() {
        $this->code = 'article';
        $this->name = trans('w-cms-laravel::blocks.article_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.article';
        $this->front_view = 'blocks.standard.article';
        $this->model_class = '\Webaccess\WCMSLaravel\Models\Blocks\ArticleBlock';
        $this->order = 5;
    }
}
