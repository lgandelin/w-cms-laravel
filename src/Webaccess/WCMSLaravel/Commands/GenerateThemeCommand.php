<?php

namespace Webaccess\WCMSLaravel\Commands;

use Illuminate\Console\Command;

class GenerateThemeCommand extends Command
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
        exec('mkdir -p themes && cd themes && git clone -b develop https://github.com/lgandelin/w-cms-base-theme.git ' . $this->argument('theme'));
    }
}
