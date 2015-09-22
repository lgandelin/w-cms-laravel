<?php

namespace Webaccess\WCMSLaravel\Commands;

use Illuminate\Console\Command;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Fixtures\BlockTypesFixtures;
use Webaccess\WCMSCore\Interactors\BlockTypes\CreateBlockTypeInteractor;

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
        $blockTypeStructure = new DataStructure();

        $blockTypeStructure->code = $this->ask('Enter the "code" field');
        $blockTypeStructure->name = $this->ask('Enter the "name" field');
        $blockTypeStructure->entity = $this->ask('Enter the "entity" namespace (ex: CMS\Blocks\MyBlock');

        $blockTypeStructure->back_controller = null;
        if ($this->confirm('Do you need a "back controller" field ? [y|n]')) {
            $blockTypeStructure->back_controller = $this->ask('Enter the "back controller" namespace');
        }

        $blockTypeStructure->back_view = null;
        if ($this->confirm('Do you need a "back view" field ? [y|n]')) {
            $blockTypeStructure->back_view = $this->ask('Enter the "back view" field');
        }

        $blockTypeStructure->front_controller = null;
        if ($this->confirm('Do you need a "front controller" field ? [y|n]')) {
            $blockTypeStructure->front_controller = $this->ask('Enter the "front controller" namespace');
        }

        $blockTypeStructure->front_view = null;
        if ($this->confirm('Do you need a "front view" field ? [y|n]')) {
            $blockTypeStructure->front_view = $this->ask('Enter the "front view" field');
        }

        try {
            (new CreateBlockTypeInteractor())->run($blockTypeStructure);
            $this->info('Block type successfully inserted !');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
