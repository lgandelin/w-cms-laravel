<?php

namespace Webaccess\WCMSLaravel\Commands\BlockTypes;

use Illuminate\Console\Command;
use Webaccess\WCMSCore\Interactors\BlockTypes\DeleteBlockTypeInteractor;

class DeleteBlockTypeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'w-cms:block_type_delete {code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a block type';

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
        $blockTypeCode = $this->argument('code');
        try {
            (new DeleteBlockTypeInteractor())->run($blockTypeCode);
            $this->info('Block type successfully deleted !');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
