<?php

namespace Webaccess\WCMSLaravel\Models;

class ArticleCategory extends \Eloquent {

    protected $table = 'article_categories';
    protected $fillable = array('name', 'description');

}