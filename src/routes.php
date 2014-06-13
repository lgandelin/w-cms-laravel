<?php

//BACK
Route::get('/admin/editorial', array('as' => 'back_editorial', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\EditorialController@index'));
Route::get('/admin/editorial/pages', array('as' => 'back_pages_index', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@index'));
Route::get('/admin/editorial/pages/create', array('as' => 'back_pages_create', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@create'));
Route::post('/admin/editorial/pages/store', array('as' => 'back_pages_store', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@store'));
Route::get('/admin/editorial/pages/edit/{identifier}', array('as' => 'back_pages_edit', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@edit'));
Route::post('/admin/editorial/pages/update', array('as' => 'back_pages_update', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@update'));
Route::get('/admin/editorial/pages/delete/{identifier}', array('as' => 'back_pages_delete', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@delete'));
Route::get('/admin/editorial/pages/duplicate/{identifier}', array('as' => 'back_pages_duplicate', 'uses' => 'Webaccess\WCMSLaravel\Back\Editorial\PageController@duplicate'));

//FRONT
Route::get('{uri?}', array('as' => 'front_page_index', 'uses' => 'Webaccess\WCMSLaravel\Front\IndexController@index'));