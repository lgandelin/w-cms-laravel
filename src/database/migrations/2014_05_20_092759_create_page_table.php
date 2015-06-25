<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('w_cms_pages', function($table) {
		    $table->increments('id');

		    $table->string('name')->nullable();
		    $table->string('identifier')->nullable();
		    $table->string('uri')->nullable();
		    $table->text('text')->nullable();
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
		Schema::drop('w_cms_pages');
	}

}
