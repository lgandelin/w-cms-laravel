<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticleListBlocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('blocks', function($table) {
            $table->integer('article_id')->after('display')->nullable();
            $table->integer('article_list_category_id')->after('article_id')->nullable();
            $table->integer('article_list_number')->after('article_list_category_id')->nullable();
            $table->string('article_list_order')->after('article_list_number')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('blocks', function($table)
        {
            $table->dropColumn('article_id');
            $table->dropColumn('article_list_category_id');
            $table->dropColumn('article_list_number');
            $table->dropColumn('article_list_order');
        });
	}

}
