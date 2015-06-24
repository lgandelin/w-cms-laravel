<?php

namespace Webaccess\WCMSLaravel\Commands;

use CMS\Context;
use CMS\Interactors\Users\CreateUserInteractor;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use CMS\Entities\BlockType;

class CreateStandardBlockTypesCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'block_types:create_standard_types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user in the database and generates a password';

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
    public function fire()
    {
        $blockTypes = [
            ['code' => 'html', 'name' => 'Block HTML', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.html', 'front_view' => 'blocks.standard.html', 'order' => 1],
            ['code' => 'menu', 'name' => 'Block Menu', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.menu', 'front_view' => 'blocks.standard.menu', 'order' => 2],
            ['code' => 'article', 'name' => 'Block Article', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.article', 'front_view' => 'blocks.standard.article', 'order' => 3],
            ['code' => 'article_list', 'name' => 'Block Article list', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.article_list', 'front_view' => 'blocks.standard.article_list', 'order' => 4],
            ['code' => 'media', 'name' => 'Block Media', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.media', 'front_view' => 'blocks.standard.media', 'order' => 5],
            ['code' => 'view', 'name' => 'Block View', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.view', 'front_view' => 'blocks.standard.view', 'order' => 6],
        ];

        foreach ($blockTypes as $type) {
            $blockType = new BlockType();
            $blockType->setCode($type['code']);
            $blockType->setName($type['name']);
            $blockType->setContentView($type['content_view']);
            $blockType->setFrontView($type['front_view']);
            $blockType->setOrder($type['order']);

            if (Context::getRepository('block_type')->createBlockType($blockType)) {
                $this->info('Block type "' . $blockType->getCode() . '" successfully created');
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            //array('login', InputArgument::REQUIRED, 'The user login'),
        );
    }

}
