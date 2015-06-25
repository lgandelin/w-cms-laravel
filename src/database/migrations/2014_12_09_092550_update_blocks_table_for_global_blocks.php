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
        Schema::table('w_cms_blocks', function($table) {
            $table->boolean('is_global')->after('area_id')->nullable();
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
        Schema::table('w_cms_blocks', function($table)
        {
            $table->dropColumn('is_global');
            $table->dropColumn('block_reference_id');
        });
	}

}
