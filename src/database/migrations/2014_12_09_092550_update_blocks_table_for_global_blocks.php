<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlocksTableForGlobalBlocks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('blocks', function($table) {
            $table->boolean('is_global')->after('article_list_order')->nullable();
            $table->integer('block_reference_id')->after('is_global')->nullable();
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
            $table->dropColumn('is_global');
            $table->dropColumn('block_reference_id');
        });
	}

}
