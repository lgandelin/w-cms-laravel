<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlocksTableAddBlockableType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('w_cms_blocks', function($table) {
            $table->integer('blockable_id')->after('type')->nullable();
            $table->string('blockable_type')->after('blockable_id')->nullable();
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
            $table->dropColumn('blockable_id');
            $table->dropColumn('blockable_type');
        });
	}

}
