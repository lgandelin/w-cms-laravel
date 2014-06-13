<?php

use Webaccess\WCMSLaravel\Models\Website;
use Webaccess\WCMSLaravel\Models\Page;

class WCMSSeeder extends Seeder {

    public function run()
    {
        //WEBSITE
        Website::create(array(
        	'name' => 'CMS',
        	'url' => 'http://cms.dev',
        ));

        //PAGES
        Page::create(array(
        	'name' => 'Home Page',
            'identifier' => 'home',
        	'uri' => '/',
        	'text' => '<p>Proin gravida faucibus erat, in ornare turpis pellentesque et. Donec nec facilisis neque. Pellentesque tincidunt enim faucibus sapien venenatis, sit amet viverra neque elementum. Duis lorem ipsum, vestibulum in sagittis id, vestibulum sit amet purus. Nam vehicula sem in dapibus adipiscing. Vivamus iaculis imperdiet metus, nec viverra lacus ultricies at. Ut sed interdum ipsum, eget sollicitudin enim. Proin nec leo eros. Sed pharetra, orci in feugiat viverra, erat dolor imperdiet lacus, id venenatis ante orci quis nisi. Donec vitae quam et leo dictum laoreet. Quisque in suscipit metus, at pulvinar tortor. Sed condimentum massa ligula, auctor convallis turpis feugiat ac. Pellentesque tincidunt ipsum vel mollis pretium.</p>'
        ));

        Page::create(array(
        	'name' => 'Content page 1',
            'identifier' => 'content-page-1',
        	'uri' => '/content-page-1',
        	'text' => '<p>Morbi scelerisque in sapien id pharetra. Pellentesque viverra bibendum fringilla. Morbi faucibus euismod elementum. In sed euismod neque. Nullam aliquet diam sed eleifend ornare. Sed bibendum felis quis libero vestibulum, nec volutpat leo semper. Sed facilisis diam eget eleifend dictum. In nec hendrerit nunc. Aenean et tellus vel elit adipiscing porttitor. Vestibulum non accumsan est. Integer ac massa nec ante condimentum convallis. Nam sit amet mauris auctor, feugiat risus ac, laoreet diam.</p>'
        ));

        Page::create(array(
        	'name' => 'Content page 2',
            'identifier' => 'content-page-2',
        	'uri' => '/content-page-2',
        	'text' => '<p>Proin justo sapien, eleifend non ligula sit amet, tempus tristique urna. Ut cursus condimentum libero at tempor. Nullam pulvinar, nisl feugiat semper vehicula, libero ligula gravida sem, et elementum libero mi et eros. Vestibulum dictum facilisis urna ac pharetra. Sed id elit ligula. Quisque ut tempor magna. Maecenas viverra convallis est, vel cursus magna tempor eget. Donec nec magna fermentum, rhoncus magna vel, auctor nibh. Sed tortor mauris, viverra quis est eget, ullamcorper suscipit libero.</p>'
        ));

        Page::create(array(
            'name' => 'Page not found',
            'identifier' => '404',
            'uri' => '/404',
            'text' => '<p>Sorry, the page you are looking for was not found.</p>'
        ));
    }

}