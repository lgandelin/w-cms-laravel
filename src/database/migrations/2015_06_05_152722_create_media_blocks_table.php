<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaBlocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('w_cms_blocks_media', function($table) {
            $table->increments('id');
            $table->integer('media_id')->nullable();
            $table->string('media_link')->nullable();
            $table->integer('media_format_id')->nullable();
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
		Schema::drop('w_cms_blocks_media');
	}

}
