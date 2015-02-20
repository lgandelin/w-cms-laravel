<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('areas', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('class')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('display')->nullable();
            $table->integer('page_id')->nullable();
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
        Schema::drop('areas');
	}

}
