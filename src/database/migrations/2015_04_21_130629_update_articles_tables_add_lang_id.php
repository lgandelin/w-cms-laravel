<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateArticlesTablesAddLangId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('articles', function($table) {
            $table->integer('lang_id')->after('text')->nullable();
        });

        Schema::table('article_categories', function($table) {
            $table->integer('lang_id')->after('description')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('articles', function($table) {
            $table->dropColumn('lang_id');
        });

        Schema::table('article_categories', function($table) {
            $table->dropColumn('lang_id');
        });
	}

}
