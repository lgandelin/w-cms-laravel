<?php

//BACK > LOGIN
Route::get('/admin', array('as' => 'back', 'uses' => 'Webaccess\WCMSLaravel\Back\DashboardController@index'));
Route::get('/admin/login', array('as' => 'back_login', 'uses' => 'Webaccess\WCMSLaravel\Back\DashboardController@login_index'));
Route::post('/admin/login_attempt', array('as' => 'back_login_attempt', 'uses' => 'Webaccess\WCMSLaravel\Back\DashboardController@login'));
Route::get('/admin/logout', array('as' => 'back_logout', 'uses' => 'Webaccess\WCMSLaravel\Back\DashboardController@logout'));

//BACK > EDITORIAL
Route::get('/admin/editorial', array('as' => 'back_editorial', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\EditorialController@index'));

//BACK > EDITORIAL > PAGES
Route::get('/admin/editorial/pages', array('as' => 'back_pages_index', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@index'));
Route::get('/admin/editorial/pages/create', array('as' => 'back_pages_create', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@create'));
Route::post('/admin/editorial/pages/store', array('as' => 'back_pages_store', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@store'));
Route::get('/admin/editorial/pages/edit/{pageID}', array('as' => 'back_pages_edit', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@edit'));
Route::post('/admin/editorial/pages/update', array('as' => 'back_pages_update', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update'));
Route::post('/admin/editorial/pages/update_page_infos', array('as' => 'back_pages_update_infos', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update_infos'));
Route::post('/admin/editorial/pages/update_page_seo', array('as' => 'back_pages_update_seo', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update_seo'));
Route::get('/admin/editorial/pages/delete/{pageID}', array('as' => 'back_pages_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@delete'));
Route::get('/admin/editorial/pages/duplicate/{pageID}', array('as' => 'back_pages_duplicate', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@duplicate'));

//BACK > EDITORIAL > PAGES > AREAS
Route::get('/admin/editorial/areas/get_infos/{areaID?}', array('as' => 'back_areas_get_infos', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\AreaController@get_infos'));
Route::post('/admin/editorial/areas/update_area_infos', array('as' => 'back_areas_update_infos', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\AreaController@update_infos'));
Route::post('/admin/editorial/areas/create_area', array('as' => 'back_areas_create', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\AreaController@create'));
Route::post('/admin/editorial/areas/delete_area', array('as' => 'back_areas_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\AreaController@delete'));
Route::post('/admin/editorial/areas/update_areas_order', array('as' => 'back_areas_update_order', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\AreaController@update_order'));
Route::post('/admin/editorial/areas/display_area', array('as' => 'back_areas_display', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\AreaController@display'));

//BACK > EDITORIAL > PAGES > BLOCKS
Route::get('/admin/editorial/blocks/get_infos/{blockID?}', array('as' => 'back_blocks_get_infos', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\BlockController@get_infos'));
Route::post('/admin/editorial/blocks/create', array('as' => 'back_blocks_create', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\BlockController@create'));
Route::post('/admin/editorial/blocks/update_content', array('as' => 'back_blocks_update_content', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\BlockController@update_content'));
Route::post('/admin/editorial/blocks/update_infos', array('as' => 'back_blocks_update_infos', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\BlockController@update_infos'));
Route::post('/admin/editorial/blocks/delete', array('as' => 'back_blocks_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\BlockController@delete'));
Route::post('/admin/editorial/blocks/update_order', array('as' => 'back_blocks_update_order', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\BlockController@update_order'));
Route::post('/admin/editorial/blocks/display', array('as' => 'back_blocks_display', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\BlockController@display'));

//BACK > EDITORIAL > MENUS
Route::get('/admin/editorial/menus', array('as' => 'back_menus_index', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@index'));
Route::get('/admin/editorial/menus/create', array('as' => 'back_menus_create', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@create'));
Route::post('/admin/editorial/menus/store', array('as' => 'back_menus_store', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@store'));
Route::get('/admin/editorial/menus/edit/{menuID}', array('as' => 'back_menus_edit', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@edit'));
Route::post('/admin/editorial/menus/update', array('as' => 'back_menus_update', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@update'));
Route::get('/admin/editorial/menus/delete/{menuID}', array('as' => 'back_menus_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@delete'));
Route::get('/admin/editorial/menus/duplicate/{menuID}', array('as' => 'back_menus_duplicate', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@duplicate'));

Route::post('/admin/editorial/menu_items/create', array('as' => 'back_menu_items_create', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuItemController@create'));
Route::post('/admin/editorial/menu_items/update', array('as' => 'back_menu_items_update', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuItemController@update'));
Route::post('/admin/editorial/menu_items/delete', array('as' => 'back_menu_items_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuItemController@delete'));

//BACK > GENERAL
Route::get('/admin/general', array('as' => 'back_general', 'uses' => 'Webaccess\WCMSLaravel\Back\General\GeneralController@index'));

//BACK > GENERAL > USERS

Route::get('/admin/general/users', array('as' => 'back_users_index', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@index'));
Route::get('/admin/general/users/create', array('as' => 'back_users_create', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@create'));
Route::post('/admin/general/users/store', array('as' => 'back_users_store', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@store'));
Route::get('/admin/general/users/edit/{id}', array('as' => 'back_users_edit', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@edit'));
Route::post('/admin/general/users/update', array('as' => 'back_users_update', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@update'));
Route::get('/admin/general/users/delete/{id}', array('as' => 'back_users_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@delete'));

//FRONT
Route::get('{uri?}', array('as' => 'front_page_index', 'uses' => 'Webaccess\WCMSLaravel\Front\IndexController@index'));