<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('user_id')->comment('用户id');
            $table->string('name',20)->nullable()->comment('用户名称');
            $table->char('user_tel', 11)->nullable()->comment('手机号');
            $table->char('user_pwd', 32)->nullable()->comment('用户密码');
            $table->string('address',100)->nullable()->comment('地址');
            $table->string('user_head',100)->nullable()->comment('头像');
            $table->dateTime('addtime')->nullable()->comment('添加时间');
            $table->tinyInteger('is_frozen')->nullable()->comment('状态');
            $table->string('curriculum',30)->nullable()->comment('我的课程');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
