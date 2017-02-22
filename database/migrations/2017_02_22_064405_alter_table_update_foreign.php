<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUpdateForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_logins', function (Blueprint $table) {
            //
            $table->dropForeign('social_logins_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('members')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_logins', function (Blueprint $table) {
            //
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->dropForeign('social_logins_user_id_foreign');
        });
    }
}
