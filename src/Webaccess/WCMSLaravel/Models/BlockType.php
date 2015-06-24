<?php

namespace Webaccess\WCMSLaravel\Models;

class BlockType extends \Eloquent {

    protected $table = 'block_types';
    protected $fillable = array('code', 'name', 'content_view', 'front_view', 'order');
}