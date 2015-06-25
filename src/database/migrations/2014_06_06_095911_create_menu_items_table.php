<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_cms_menu_items', function($table) {
            $table->increments('id');
            $table->string('label')->nullable();
            $table->integer('order')->nullable();
            $table->integer('page_id')->nullable();
            $table->string('external_url')->nullable();
            $table->string('class')->nullable();
            $table->integer('menu_id')->nullable();
            $table->boolean('display')->nullable();
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
        Schema::drop('w_cms_menu_items');
    }

}