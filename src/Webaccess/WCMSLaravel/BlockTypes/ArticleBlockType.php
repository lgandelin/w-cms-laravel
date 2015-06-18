<?php

namespace Webaccess\WCMSLaravel\BlockTypes;

class ArticleBlockType
{
    public function __construct() {
        $this->code = 'article';
        $this->name = trans('w-cms-laravel::blocks.article_block');
        $this->content_view = 'w-cms-laravel::back.editorial.pages.blocks.content.article';
        $this->template_view = 'w-cms-laravel::back.editorial.pages.blocks.templates.article';
        $this->front_view = 'blocks.standard.article';
        $this->order = 5;
    }
} 