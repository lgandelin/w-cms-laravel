<?php

namespace Webaccess\WCMSLaravel\Commands\Themes;

use Illuminate\Console\Command;
use Webaccess\WCMSCore\Interactors\Themes\DeleteThemeInteractor;

class DeleteThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'w-cms:theme_delete {theme}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a theme';

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
            (new DeleteThemeInteractor())->run($themeIdentifier);
            exec('rm -r  themes/' . $themeIdentifier);
            $this->info('Theme "' . $themeIdentifier . '" deleted successfully !');
        } catch(\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
