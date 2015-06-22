<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksArticleListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blocks_article_list', function($table) {
            $table->increments('id');
            $table->integer('article_list_category_id')->nullable();
            $table->integer('article_list_number')->nullable();
            $table->string('article_list_order')->nullable();
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blocks_article_list');
	}

}
