<?php

namespace Webaccess\WCMSLaravel\Commands\BlockTypes;

use Illuminate\Console\Command;
use Webaccess\WCMSCore\Interactors\BlockTypes\GetBlockTypesInteractor;

class ListBlockTypesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'w-cms:block_type_list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List available block types';

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
        try {
            $blockTypes = (new GetBlockTypesInteractor())->getAll(true);
            if (is_array($blockTypes) && sizeof($blockTypes) > 0) {
                foreach ($blockTypes as $i => $blockType)
                    $this->info(($i + 1) . ' - ' . $blockType->name . ' [' . $blockType->code . ']');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
