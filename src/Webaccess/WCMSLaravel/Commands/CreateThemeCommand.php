<?php

namespace Webaccess\WCMSLaravel\Commands;

use Illuminate\Console\Command;
use Webaccess\WCMSLaravel\Models\Website;

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
        $theme = $this->argument('theme');
        exec('mkdir -p themes && cd themes && git clone -b develop https://github.com/lgandelin/w-cms-base-theme.git ' . $theme);
        if (!$website = Website::first()) {
            $website = new Website();
        }
        $website->theme = $theme;
        $website->save();
    }
}
