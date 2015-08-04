<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWCMSTables extends Migration {

	public function up()
	{
		Schema::create('w_cms_websites', function($table) {
		    $table->increments('id');
		    $table->string('name')->nullable();
		    $table->string('url')->nullable();
		    $table->string('theme')->nullable();
		    $table->timestamps();
		});

        Schema::create('w_cms_pages', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('identifier')->nullable();
            $table->string('uri')->nullable();
            $table->integer('lang_id')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->integer('master_page_id')->nullable();
            $table->boolean('is_master')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_users', function($table) {
            $table->increments('id');
            $table->string('login')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('remember_token', 64)->nullable();
            $table->boolean('is_admin')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_menus', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('identifier')->nullable();
            $table->integer('lang_id')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_menu_items', function($table) {
            $table->increments('id');
            $table->string('label')->nullable();
            $table->integer('order')->nullable();
            $table->integer('page_id')->nullable();
            $table->string('external_url')->nullable();
            $table->string('class')->nullable();
            $table->integer('menu_id')->nullable();
            $table->boolean('display')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_areas', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('class')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('display')->nullable();
            $table->integer('master_area_id')->nullable();
            $table->boolean('is_master')->nullable();
            $table->integer('page_id')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_blocks', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('class')->nullable();
            $table->string('alignment')->nullable();
            $table->integer('order')->nullable();
            $table->string('type')->nullable();
            $table->integer('blockable_id')->nullable();
            $table->string('blockable_type')->nullable();
            $table->boolean('display')->nullable();
            $table->integer('area_id')->nullable();
            $table->integer('master_block_id')->nullable();
            $table->boolean('is_master')->nullable();
            $table->boolean('is_ghost')->nullable();
            $table->boolean('is_global')->nullable();
            $table->integer('block_reference_id')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_articles', function($table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('summary')->nullable();
            $table->text('text')->nullable();
            $table->integer('lang_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('author_id')->nullable();
            $table->integer('page_id')->nullable();
            $table->integer('media_id')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_article_categories', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('lang_id')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_medias', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('file_name')->nullable();
            $table->string('alt')->nullable();
            $table->string('title')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_media_formats', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_langs', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('prefix')->nullable();
            $table->string('code')->nullable();
            $table->boolean('is_default')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_blocks_html', function($table) {
            $table->increments('id');
            $table->text('html')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_blocks_menu', function($table) {
            $table->increments('id');
            $table->integer('menu_id')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_blocks_view', function($table) {
            $table->increments('id');
            $table->string('view_path')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_blocks_article', function($table) {
            $table->increments('id');
            $table->integer('article_id')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_blocks_media', function($table) {
            $table->increments('id');
            $table->integer('media_id')->nullable();
            $table->string('media_link')->nullable();
            $table->integer('media_format_id')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_blocks_article_list', function($table) {
            $table->increments('id');
            $table->integer('article_list_category_id')->nullable();
            $table->integer('article_list_number')->nullable();
            $table->string('article_list_order')->nullable();
            $table->timestamps();
        });

        Schema::create('w_cms_block_types', function($table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('content_view')->nullable();
            $table->string('front_view')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('w_cms_websites');
        Schema::drop('w_cms_pages');
        Schema::drop('w_cms_users');
        Schema::drop('w_cms_menus');
        Schema::drop('w_cms_menu_items');
        Schema::drop('w_cms_areas');
        Schema::drop('w_cms_blocks');
        Schema::drop('w_cms_articles');
        Schema::drop('w_cms_article_categories');
        Schema::drop('w_cms_medias');
        Schema::drop('w_cms_media_formats');
        Schema::drop('w_cms_langs');
        Schema::drop('w_cms_blocks_html');
        Schema::drop('w_cms_blocks_menu');
        Schema::drop('w_cms_blocks_view');
        Schema::drop('w_cms_blocks_article');
        Schema::drop('w_cms_blocks_media');
        Schema::drop('w_cms_blocks_article_list');
        Schema::drop('w_cms_block_types');
	}

}