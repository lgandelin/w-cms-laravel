<?php

namespace Webaccess\WCMSLaravel\Models;

class Media extends \Eloquent {

    protected $table = 'medias';
    protected $fillable = array('name', 'alt', 'title', 'file_name');
}