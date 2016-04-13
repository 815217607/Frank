<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFriendlyLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendly_link', function (Blueprint $table) {
            $table->increments('id');
            $table->string("fl_title");//标题
            $table->string("fl_ico");//图标
            $table->string("fl_url");//友链地址
            $table->integer('fl_state')->default(0);
            $table->integer('fl_sort')->default(0);
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
        Schema::drop('friendly_link');
    }
}
