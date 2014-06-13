<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteTable extends Migration {

	public function up()
	{
		Schema::create('websites', function($table) {
		    $table->increments('id');
		    $table->string('name');
		    $table->string('url');
		    $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('websites');
	}

}