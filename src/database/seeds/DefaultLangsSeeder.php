<?php

use CMS\Entities\Lang;
use CMS\Context;
use Illuminate\Database\Seeder;

class DefaultLangsSeeder extends Seeder {

    public function run()
    {
        $langs = [
            ['code' => 'en', 'name' => 'English', 'prefix' => '', 'is_default' => true],
            ['code' => 'fr', 'name' => 'Français', 'prefix' => '/fr', 'is_default' => false],
        ];

        foreach ($langs as $l) {
            $lang = new Lang();
            $lang->setCode($l['code']);
            $lang->setName($l['name']);
            $lang->setPrefix($l['prefix']);
            $lang->setIsDefault($l['is_default']);

            Context::getRepository('lang')->createLang($lang);
            $this->command->info('Lang [' . $lang->getCode() . '] inserted successfully !');
        }
    }
}