<?php

namespace Webaccess\WCMSLaravel\Helpers;

use Illuminate\Support\ServiceProvider;

class WCMSLaravelModuleServiceProvider extends ServiceProvider
{
    protected function initModule($module, $prefixFolder)
    {
        $themeFolder = 'themes/' . Theme::get() . '/';
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
                $prefixFolder . $config['moduleConfigFolder'] . 'config.php' => config_path('vendor/w-cms-laravel-' . $module . '.php')
            ], 'config');
        }

        if (is_dir($prefixFolder . $config['moduleViewsFolder'] . 'front')) {
            $this->publishes([
                $prefixFolder . $config['moduleViewsFolder'] . 'front' => $themeFolder . $config['themeViewsFolder'] . $module,
            ], 'front_views');
        }

        if (is_dir($prefixFolder . $config['moduleViewsFolder'] . 'back')) {
            $this->publishes([
                $prefixFolder . $config['moduleViewsFolder'] . 'back' => base_path('resources/views/vendor/' . $module),
            ], 'back_views');
        }

        if (is_dir($prefixFolder . $config['moduleLangsFolder'] . 'front')) {
            $this->publishes([
                $prefixFolder . $config['moduleLangsFolder'] . 'front' => $themeFolder . $config['themeLangsFolder'] . $module
            ], 'front_langs');
        }

        if (is_dir($prefixFolder . $config['moduleLangsFolder'] . 'back')) {
            $this->publishes([
                $prefixFolder . $config['moduleLangsFolder'] . 'back' => base_path('resources/lang/vendor/' . $module),
            ], 'back_langs');
        }

        if (is_dir($prefixFolder . $config['moduleAssetsFolder'] . 'front')) {
            $this->publishes([
                $prefixFolder . $config['moduleAssetsFolder'] . 'front' => $themeFolder . $config['themeAssetsFolder'] . $module
            ], 'front_assets');
        }

        if (is_dir($prefixFolder . $config['moduleAssetsFolder'] . 'back')) {
            $this->publishes([
                $prefixFolder . $config['moduleAssetsFolder'] . 'back' => base_path('resources/assets/vendor/' . $module),
            ], 'back_assets');
        }

        if (is_dir($prefixFolder . $config['moduleDatabaseFolder'])) {
            $this->publishes([
                $prefixFolder . $config['moduleDatabaseFolder'] => base_path('/database')
            ], 'database');
        }

        $themeFolder = base_path() . '/themes/' . Theme::get();
        \Lang::addNamespace('w-cms-laravel-' . $module, $themeFolder . '/lang/modules/' . $module);
        \Lang::addNamespace('w-cms-laravel-' . $module . '-back', base_path('resources/lang/vendor/' . $module . '/'));

        \View::addNamespace('w-cms-laravel-' . $module, $themeFolder . '/views/modules/' . $module);
        \View::addNamespace('w-cms-laravel-' . $module . '-back', base_path('resources/views/vendor/' . $module . '/'));
    }

    public function register()
    {

    }
}
