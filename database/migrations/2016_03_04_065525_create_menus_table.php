<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('pid')->nullable()->default(0);//父级ID
            $table->string('menu_name');//菜单名称
            $table->string('lang_key')->nullable();//语言key
            $table->string('url')->nullable();//菜单路由地址
            $table->char('rank',1)->default('D');//支持级别D允许P权限允许T高级权限允
            $table->bigInteger('permission_id')->nullable();//权限ID
            $table->string('grade')->nullable();//级别值000_0001一级菜单ID_二级ID
            $table->integer('state')->default(0);//是否显示在菜单上
            $table->integer('url_falg')->default(0);//是否采用路由名称
            $table->integer('lang_falg')->default(0);//是否启用国际化
            $table->string('active')->nullable();//路由选择器


            $table->string('platform')->default(1);//平台0web前台，1为web运营后台
            $table->string('sort')->default();//排序
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
        Schema::drop('menus');
    }
}
