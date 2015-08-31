<?php

namespace Webaccess\WCMSLaravel\Commands;

use Illuminate\Console\Command;

class PublishThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:publish {theme}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes the assets of a theme';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $theme = $this->argument('theme');
        $themeFolder = 'themes/' . $theme . '/';

        if (is_dir(base_path($themeFolder . 'assets/css'))) $this->recurse_copy(base_path($themeFolder . 'assets/css'), base_path('public/css'));
        if (is_dir(base_path($themeFolder . 'assets/img'))) $this->recurse_copy(base_path($themeFolder . 'assets/img'), base_path('public/img'));
        if (is_dir(base_path($themeFolder . 'assets/js'))) $this->recurse_copy(base_path($themeFolder . 'assets/js'), base_path('public/js'));

        $this->info('Theme assets deployed in public folder');
    }

    public function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
