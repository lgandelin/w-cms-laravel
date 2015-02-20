<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FeatureMasterPages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('blocks', function($table) {
            $table->integer('master_block_id')->after('area_id')->nullable();
            $table->boolean('is_master')->after('master_block_id')->nullable();
            $table->boolean('is_ghost')->after('is_master')->nullable();
        });

        Schema::table('areas', function($table) {
            $table->integer('master_area_id')->after('display')->nullable();
            $table->boolean('is_master')->after('master_area_id')->nullable();
        });

        Schema::table('pages', function($table) {
            $table->integer('master_page_id')->after('meta_keywords')->nullable();
            $table->boolean('is_master')->after('master_page_id')->nullable();
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
            $table->dropColumn('master_block_id');
            $table->dropColumn('is_master');
            $table->dropColumn('is_ghost');
        });

        Schema::table('areas', function($table)
        {
            $table->dropColumn('master_area_id');
            $table->dropColumn('is_master');
        });

        Schema::table('pages', function($table)
        {
            $table->dropColumn('master_page_id');
            $table->dropColumn('is_master');
        });
	}

}
