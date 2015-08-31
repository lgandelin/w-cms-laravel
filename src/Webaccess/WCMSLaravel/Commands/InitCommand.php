<?php

namespace Webaccess\WCMSLaravel\Commands;

use Illuminate\Console\Command;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'w-cms:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the W CMS application';

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
        $this->call('migrate');
        $this->call('db:seed', array('--class' => 'DefaultLangsSeeder'));
        $this->call('db:seed', array('--class' => 'DefaultBlockTypesSeeder'));
        $this->call('db:seed', array('--class' => 'SamplePageDataSeeder'));

        $this->info('Application successfully initialized');
    }
}
