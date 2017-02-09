<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username', 128);
            $table->string('picture')->nullable();
            $table->string('password', 64);
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->string('confirmation_code');
            $table->tinyInteger('confirmed')->default(1);
            $table->rememberToken();
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('members');
    }
}
