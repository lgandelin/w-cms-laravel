<?php

namespace Webaccess\WCMSLaravel\Commands\Themes;

use Webaccess\WCMSCore\DataStructure;
use Illuminate\Console\Command;
use Webaccess\WCMSCore\Interactors\Themes\CreateThemeInteractor;

class CreateThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'w-cms:theme_create {theme}';

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
        $themeIdentifier = $this->argument('theme');

        $themeStructure = new DataStructure();
        $themeStructure->identifier = $themeIdentifier;

        try {
            (new CreateThemeInteractor())->run($themeStructure);
            exec('mkdir -p themes && cd themes && curl -L -o w-cms-base-theme-develop.tar.gz https://github.com/lgandelin/w-cms-base-theme/archive/develop.tar.gz && tar xzf w-cms-base-theme-develop.tar.gz && mv w-cms-base-theme-develop ' . $themeIdentifier . ' && rm w-cms-base-theme-develop.tar.gz');
            $this->info('Theme "' . $themeIdentifier . '" created successfully !');
        } catch(\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
