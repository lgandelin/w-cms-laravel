<?php

namespace Webaccess\WCMSLaravel\Commands\Themes;

use Illuminate\Console\Command;
use Webaccess\WCMSCore\Interactors\Themes\SelectThemeInteractor;

class SelectThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'w-cms:theme_select {theme}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select the given theme';

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

        try {
            (new SelectThemeInteractor())->run($themeIdentifier);
            $this->info('Theme "' . $themeIdentifier . '" selected successfully !');
        } catch(\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
