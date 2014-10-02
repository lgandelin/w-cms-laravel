<?php

//BACK

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
Route::post('/admin/editorial/pages/update_page_infos', array('as' => 'back_pages_update_page_infos', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update_page_infos'));
Route::post('/admin/editorial/pages/update_page_seo', array('as' => 'back_pages_update_page_seo', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update_page_seo'));
Route::get('/admin/editorial/pages/delete/{pageID}', array('as' => 'back_pages_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@delete'));
Route::get('/admin/editorial/pages/duplicate/{pageID}', array('as' => 'back_pages_duplicate', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@duplicate'));

//BACK > EDITORIAL > PAGES > AREAS
Route::get('/admin/editorial/pages/get_area_infos/{areaID?}', array('as' => 'back_pages_get_area_infos', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@get_area_infos'));
Route::post('/admin/editorial/pages/update_area_infos', array('as' => 'back_pages_update_area_infos', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update_area_infos'));
Route::post('/admin/editorial/pages/create_area', array('as' => 'back_pages_create_area', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@create_area'));
Route::post('/admin/editorial/pages/delete_area', array('as' => 'back_pages_delete_area', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@delete_area'));
Route::post('/admin/editorial/pages/update_areas_order', array('as' => 'back_pages_update_areas_order', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update_areas_order'));

//BACK > EDITORIAL > PAGES > BLOCKS
Route::get('/admin/editorial/pages/get_block_infos/{blockID?}', array('as' => 'back_pages_get_block_infos', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@get_block_infos'));
Route::post('/admin/editorial/pages/create_block', array('as' => 'back_pages_create_block', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@create_block'));
Route::post('/admin/editorial/pages/update_block_content', array('as' => 'back_pages_update_block_content', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update_block_content'));
Route::post('/admin/editorial/pages/update_block_infos', array('as' => 'back_pages_update_block_infos', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update_block_infos'));
Route::post('/admin/editorial/pages/delete_block', array('as' => 'back_pages_delete_block', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@delete_block'));
Route::post('/admin/editorial/pages/update_blocks_order', array('as' => 'back_pages_update_blocks_order', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update_blocks_order'));

//BACK > EDITORIAL > MENUS
Route::get('/admin/editorial/menus', array('as' => 'back_menus_index', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@index'));
Route::get('/admin/editorial/menus/create', array('as' => 'back_menus_create', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@create'));
Route::post('/admin/editorial/menus/store', array('as' => 'back_menus_store', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@store'));
Route::get('/admin/editorial/menus/edit/{menuID}', array('as' => 'back_menus_edit', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@edit'));
Route::post('/admin/editorial/menus/update', array('as' => 'back_menus_update', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@update'));
Route::get('/admin/editorial/menus/delete/{menuID}', array('as' => 'back_menus_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@delete'));
Route::get('/admin/editorial/menus/duplicate/{menuID}', array('as' => 'back_menus_duplicate', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@duplicate'));

Route::post('/admin/editorial/menus/add_item', array('as' => 'back_menus_add_item', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@add_item'));
Route::post('/admin/editorial/menus/update_item', array('as' => 'back_menus_update_item', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@update_item'));
Route::post('/admin/editorial/menus/delete_item', array('as' => 'back_menus_delete_item', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@delete_item'));

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