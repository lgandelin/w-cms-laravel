<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_cms_blocks', function($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('class')->nullable();
            $table->integer('order')->nullable();
            $table->string('type')->nullable();
            $table->text('html')->nullable();
            $table->integer('menu_id')->nullable();
            $table->string('view_file')->nullable();
            $table->boolean('display')->nullable();
            $table->integer('area_id')->nullable();
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
        Schema::drop('w_cms_blocks');
    }

}
