<?php

namespace Webaccess\WCMSLaravel\Commands;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Theme;
use Illuminate\Console\Command;

class CreateThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:create {theme}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new theme';

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
        $themeName = $this->argument('theme');
        exec('mkdir -p themes && cd themes && curl -L -o w-cms-base-theme-develop.tar.gz https://github.com/lgandelin/w-cms-base-theme/archive/develop.tar.gz && tar xzf w-cms-base-theme-develop.tar.gz && mv w-cms-base-theme-develop ' . $themeName . ' && rm w-cms-base-theme-develop.tar.gz');

        $theme = new Theme();
        $theme->setIdentifier($themeName);

        Context::get('theme_repository')->createTheme($theme);
    }
}
