<?php

namespace Webaccess\WCMSLaravel\Helpers;

use Illuminate\Support\ServiceProvider;
use Webaccess\WCMSLaravel\Facades\Shortcut;

class WCMSLaravelModuleServiceProvider extends ServiceProvider
{
    protected function initModule($moduleName, $prefixFolder)
    {
        $themeFolder = 'themes/' . Shortcut::get_theme() . '/';
        $config['moduleConfigFolder'] = 'config/';
        $config['moduleViewsFolder'] = 'resources/views';
        $config['moduleLangsFolder'] = 'resources/lang';
        $config['moduleAssetsFolder'] = 'resources/assets';
        $config['themeViewsFolder'] = 'views/modules/';
        $config['themeLangsFolder'] = 'lang/modules/';
        $config['themeAssetsFolder'] = 'assets/modules/';

        $this->publishes([
            $prefixFolder . $config['moduleConfigFolder'] . 'config.php' => config_path('vendor/w-cms-laravel-' . $moduleName . '.php')
        ], 'config');

        $this->publishes([
            $prefixFolder . $config['moduleViewsFolder'] => $themeFolder . $config['themeViewsFolder'] . $moduleName,
        ], 'views');

        $this->publishes([
            $prefixFolder . $config['moduleLangsFolder'] => $themeFolder . $config['themeLangsFolder'] . $moduleName
        ], 'langs');

        $this->publishes([
            $prefixFolder . $config['moduleAssetsFolder'] => $themeFolder . $config['themeAssetsFolder'] . $moduleName
        ], 'assets');

        Module::load($moduleName);
    }

    public function register()
    {

    }
}
