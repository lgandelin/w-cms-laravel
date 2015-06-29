<?php

namespace Webaccess\WCMSLaravel\Models;

class Article extends \Eloquent {

    protected $table = 'w_cms_articles';
    protected $fillable = array('title', 'summary', 'text', 'lang_id', 'page_id', 'media_id');

    public function author()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\User');
    }

    public function category()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\ArticleCategory');
    }
}