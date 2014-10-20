<?php

namespace Webaccess\WCMSLaravel\Models;

class Article extends \Eloquent {

    protected $table = 'articles';
    protected $fillable = array('title', 'summary', 'text');

    public function author()
    {
        return $this->hasOne('Webaccess\WCMSLaravel\Models\User');
    }
}