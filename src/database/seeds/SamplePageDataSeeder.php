<?php

use Illuminate\Database\Seeder;
use Webaccess\WCMSLaravel\Models\Area;
use Webaccess\WCMSLaravel\Models\Block;
use Webaccess\WCMSLaravel\Models\Blocks\HTMLBlock;
use Webaccess\WCMSLaravel\Models\Blocks\MenuBlock;
use Webaccess\WCMSLaravel\Models\Menu;
use Webaccess\WCMSLaravel\Models\MenuItem;
use Webaccess\WCMSLaravel\Models\Page;

class SamplePageDataSeeder extends Seeder {

    public function run()
    {
        $page = $this->createSamplePage('Home page', 'home', '/', 1);
        $area1 = $this->createSampleArea('Header Area', 12, 1, 1, $page->id);
        $area2 = $this->createSampleArea('Content Area', 12, 1, 1, $page->id);
        $menu = $this->createSampleMenu('Header Menu', 'header-menu', 1);

        $block = $this->createSampleBlock('Menu Block', 'menu', 12, 1, 1, $area1->id);
        $this->setMenu($block, $menu->id);

        $block = $this->createSampleBlock('HTML Block', 'html', 12, 1, 2, $area2->id);
        $this->setHTML($block, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum libero mauris, imperdiet at rutrum vitae, placerat mollis est. Praesent commodo ornare diam, nec rhoncus quam accumsan sit amet. Donec aliquet tortor vitae lectus sodales mattis. Nullam eget feugiat nisi. Morbi placerat volutpat dui, at euismod urna viverra sit amet. Proin rutrum, libero ac maximus pulvinar, odio mi tempus sem, eu cursus elit dui volutpat risus. Duis condimentum congue quam, ac tincidunt mi dignissim in. Aenean non porta metus. Praesent eleifend metus sed eros vehicula, ac pharetra magna luctus.</p>');

        $block = $this->createSampleBlock('HTML Block 2', 'html', 6, 1, 3, $area2->id);
        $this->setHTML($block, '<p>Aenean arcu eros, sodales cursus volutpat vitae, mattis ut arcu. Quisque nec sagittis arcu. Morbi tempor tortor eu tellus tristique, vitae condimentum sapien convallis. Quisque lacinia enim eros, sit amet dignissim arcu lobortis viverra. Morbi sed sapien fermentum, molestie augue id, elementum urna.</p>');

        $block = $this->createSampleBlock('HTML Block 3', 'html', 6, 1, 4, $area2->id);
        $this->setHTML($block, '<p>Integer hendrerit sollicitudin dui a ultrices. Integer ullamcorper vel nisl sed luctus. Duis massa risus, porta sit amet venenatis in, scelerisque ut enim. Suspendisse rutrum mattis mauris in cursus. Etiam vel pellentesque justo. Donec interdum felis ac condimentum pretium.</p>');
    }

    private function createSampleBlock($name, $type, $width, $height, $order, $areaID)
    {
        $block = new Block();
        $block->name = $name;
        $block->type = $type;
        $block->width = $width;
        $block->height = $height;
        $block->order = $order;
        $block->area_id = $areaID;
        $block->display = 1;
        $block->save();

        return $block;
    }

    private function setHTML($block, $html)
    {
        $blockContent = new HTMLBlock();
        $blockContent->html = $html;
        $blockContent->save();
        $blockContent->block()->save($block);

        $this->command->info('Block [' . $block->name . '] saved successfully!');
    }

    private function setMenu($block, $menuID)
    {
        $blockContent = new MenuBlock();
        $blockContent->menu_id = $menuID;
        $blockContent->save();
        $blockContent->block()->save($block);

        $this->command->info('Block [' . $block->name . '] saved successfully!');
    }

    private function createSampleMenu($name, $identifier, $langID)
    {
        $menu = new Menu();
        $menu->name = $name;
        $menu->identifier = $identifier;
        $menu->lang_id = $langID;
        $menu->save();

        for ($i = 0; $i < 3; $i++) {
            $menuItem = new MenuItem();
            $menuItem->label = 'Item ' . $i;
            $menuItem->order = $i;
            $menuItem->page_id = 1;
            $menuItem->menu_id = $menu->id;
            $menuItem->display = 1;
            $menuItem->save();
        }

        return $menu;
    }

    private function createSamplePage($name, $identifier, $uri, $langID)
    {
        $page = new Page();
        $page->name = $name;
        $page->identifier = $identifier;
        $page->uri = $uri;
        $page->lang_id = $langID;
        $page->save();

        return $page;
    }

    private function createSampleArea($name, $width, $height, $order, $pageID)
    {
        $area = new Area();
        $area->name = $name;
        $area->width = $width;
        $area->height = $height;
        $area->order = $order;
        $area->display = 1;
        $area->page_id = $pageID;
        $area->save();

        return $area;
    }
}