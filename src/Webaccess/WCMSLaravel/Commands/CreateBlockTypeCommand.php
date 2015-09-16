<?php

namespace Webaccess\WCMSLaravel\Commands;

use Illuminate\Console\Command;
use Webaccess\WCMSCore\Fixtures\BlockTypesFixtures;

class CreateBlockTypeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'w-cms:create_block_type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new block type';

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
        $code = $this->ask('Enter the "code" field');
        $name = $this->ask('Enter the "name" field');
        $entity = $this->ask('Enter the "entity" namespace (ex: CMS\Blocks\MyBlock');

        $backController = null;
        if ($this->confirm('Do you need a "back controller" field ? [y|n]')) {
            $backController = $this->ask('Enter the "back controller" namespace');
        }

        $backView = null;
        if ($this->confirm('Do you need a "back view" field ? [y|n]')) {
            $backView = $this->ask('Enter the "back view" field');
        }

        $frontController = null;
        if ($this->confirm('Do you need a "front controller" field ? [y|n]')) {
            $frontController = $this->ask('Enter the "front controller" namespace');
        }

        $frontView = null;
        if ($this->confirm('Do you need a "front view" field ? [y|n]')) {
            $frontView = $this->ask('Enter the "front view" field');
        }

        BlockTypesFixtures::addBlockType($code, $name, $entity, $backController, $backView, $frontController, $frontView, null);
        $this->info('Block type successfully inserted !');
    }
}
