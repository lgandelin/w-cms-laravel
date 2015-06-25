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
        $config['moduleViewsFolder'] = 'resources/views/';
        $config['moduleLangsFolder'] = 'resources/lang/';
        $config['moduleDatabaseFolder'] = 'database/';
        $config['moduleAssetsFolder'] = 'resources/assets/';
        $config['themeViewsFolder'] = 'views/modules/';
        $config['themeLangsFolder'] = 'lang/modules/';
        $config['themeAssetsFolder'] = 'assets/modules/';

        if (is_dir($prefixFolder . $config['moduleConfigFolder'])) {
            $this->publishes([
                $prefixFolder . $config['moduleConfigFolder'] . 'config.php' => config_path('vendor/w-cms-laravel-' . $moduleName . '.php')
            ], 'config');
        }

        if (is_dir($prefixFolder . $config['moduleViewsFolder'] . 'front')) {
            $this->publishes([
                $prefixFolder . $config['moduleViewsFolder'] . 'front' => $themeFolder . $config['themeViewsFolder'] . $moduleName,
            ], 'front_views');
        }

        if (is_dir($prefixFolder . $config['moduleViewsFolder'] . 'back')) {
            $this->publishes([
                $prefixFolder . $config['moduleViewsFolder'] . 'back' => base_path('resources/views/vendor/' . $moduleName),
            ], 'back_views');
        }

        if (is_dir($prefixFolder . $config['moduleLangsFolder'] . 'front')) {
            $this->publishes([
                $prefixFolder . $config['moduleLangsFolder'] . 'front' => $themeFolder . $config['themeLangsFolder'] . $moduleName
            ], 'front_langs');
        }

        if (is_dir($prefixFolder . $config['moduleLangsFolder'] . 'back')) {
            $this->publishes([
                $prefixFolder . $config['moduleLangsFolder'] . 'back' => base_path('resources/lang/vendor/' . $moduleName),
            ], 'back_langs');
        }

        if (is_dir($prefixFolder . $config['moduleAssetsFolder'] . 'front')) {
            $this->publishes([
                $prefixFolder . $config['moduleAssetsFolder'] . 'front' => $themeFolder . $config['themeAssetsFolder'] . $moduleName
            ], 'front_assets');
        }

        if (is_dir($prefixFolder . $config['moduleAssetsFolder'] . 'back')) {
            $this->publishes([
                $prefixFolder . $config['moduleAssetsFolder'] . 'back' => base_path('resources/assets/vendor/' . $moduleName),
            ], 'back_assets');
        }

        if (is_dir($prefixFolder . $config['moduleDatabaseFolder'])) {
            $this->publishes([
                $prefixFolder . $config['moduleDatabaseFolder'] => base_path('/database')
            ], 'database');
        }

        Module::load($moduleName);
    }

    public function register()
    {

    }
}
