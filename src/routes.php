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
Route::get('/admin/editorial/pages/edit/{identifier}', array('as' => 'back_pages_edit', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@edit'));
Route::post('/admin/editorial/pages/update', array('as' => 'back_pages_update', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update'));
Route::get('/admin/editorial/pages/delete/{identifier}', array('as' => 'back_pages_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@delete'));
Route::get('/admin/editorial/pages/duplicate/{identifier}', array('as' => 'back_pages_duplicate', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@duplicate'));

//BACK > EDITORIAL > MENUS
Route::get('/admin/editorial/menus', array('as' => 'back_menus_index', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@index'));
Route::get('/admin/editorial/menus/create', array('as' => 'back_menus_create', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@create'));
Route::post('/admin/editorial/menus/store', array('as' => 'back_menus_store', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@store'));
Route::get('/admin/editorial/menus/edit/{identifier}', array('as' => 'back_menus_edit', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@edit'));
Route::post('/admin/editorial/menus/update', array('as' => 'back_menus_update', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@update'));
Route::get('/admin/editorial/menus/delete/{identifier}', array('as' => 'back_menus_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@delete'));
Route::get('/admin/editorial/menus/duplicate/{identifier}', array('as' => 'back_menus_duplicate', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\MenuController@duplicate'));

//BACK > GENERAL
Route::get('/admin/general', array('as' => 'back_general', 'uses' => 'Webaccess\WCMSLaravel\Back\General\GeneralController@index'));

//BACK > GENERAL > USERS

Route::get('/admin/general/users', array('as' => 'back_users_index', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@index'));
Route::get('/admin/general/users/create', array('as' => 'back_users_create', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@create'));
Route::post('/admin/general/users/store', array('as' => 'back_users_store', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@store'));
Route::get('/admin/general/users/edit/{ID}', array('as' => 'back_users_edit', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@edit'));
Route::post('/admin/general/users/update', array('as' => 'back_users_update', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@update'));
Route::get('/admin/general/users/delete/{ID}', array('as' => 'back_users_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\General\UserController@delete'));

//FRONT
Route::get('{uri?}', array('as' => 'front_page_index', 'uses' => 'Webaccess\WCMSLaravel\Front\IndexController@index'));