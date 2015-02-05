<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMediasTableForAltTitle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('medias', function($table) {
            $table->string('alt')->after('file_name')->nullable();
            $table->string('title')->after('alt')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('medias', function($table) {
            $table->dropColumn('alt');
            $table->dropColumn('title');
        });
	}

}
