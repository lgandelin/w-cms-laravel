<?php

namespace Webaccess\WCMSLaravel\Models;

class MediaFormat extends \Eloquent {

    protected $table = 'media_formats';
    protected $fillable = array('name', 'width', 'height');
}