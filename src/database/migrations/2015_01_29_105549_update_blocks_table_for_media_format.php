<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlocksTableForMediaFormat extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('w_cms_blocks', function($table) {
            $table->string('media_format_id')->after('media_link')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('w_cms_blocks', function($table) {
            $table->dropColumn('media_format_id');
        });
	}

}
