<?php

namespace Webaccess\WCMSLaravel\Models\Blocks;

class ArticleBlock extends \Eloquent
{
    protected $table = 'blocks_article';
    protected $fillable = array('article_id');

    public function block() {
        return $this->morphOne('\Webaccess\WCMSLaravel\Models\Block', 'blockable');
    }
}