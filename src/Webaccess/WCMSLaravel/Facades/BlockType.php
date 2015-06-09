<?php

namespace Webaccess\WCMSLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class BlockType extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'block_type';
    }
}
