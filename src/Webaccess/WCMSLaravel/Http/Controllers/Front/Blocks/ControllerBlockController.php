<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks;

use Webaccess\WCMSCore\DataStructure;

class ControllerBlockController
{
    public function index(DataStructure $block) {
        if ($block->classPath && $block->method) {
            $class = $block->classPath;
            $method = $block->method;
            $controller = new $class();

            $block->content = $controller->$method();
        }

        return view(\Shortcut::get_theme() . '::blocks.standard.controller', [
            'block' => $block,
        ])->render();
    }
}
