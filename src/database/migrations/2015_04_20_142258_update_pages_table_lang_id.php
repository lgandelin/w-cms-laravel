<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePagesTableLangId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('w_cms_pages', function($table) {
            $table->integer('lang_id')->after('uri')->nullable();
            $table->dropColumn('text');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('w_cms_pages', function($table) {
            $table->dropColumn('media_format_id');
        });
	}

}
