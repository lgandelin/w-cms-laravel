<?php

namespace Webaccess\WCMSLaravel\Commands;

use Illuminate\Console\Command;
use Webaccess\WCMSCore\Fixtures\BlockTypesFixtures;
use Webaccess\WCMSCore\Fixtures\LangsFixtures;
use Webaccess\WCMSCore\Fixtures\PagesFixtures;

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
        BlockTypesFixtures::run();
        LangsFixtures::run();
        PagesFixtures::run();

        $this->info('Application successfully initialized');
    }
}
