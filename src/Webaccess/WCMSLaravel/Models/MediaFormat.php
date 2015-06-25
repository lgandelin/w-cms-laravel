<?php

namespace Webaccess\WCMSLaravel\Models;

class MediaFormat extends \Eloquent {

    protected $table = 'w_cms_media_formats';
    protected $fillable = array('name', 'width', 'height');
}