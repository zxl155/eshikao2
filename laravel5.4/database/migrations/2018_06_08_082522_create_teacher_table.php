<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher', function (Blueprint $table) {
            $table->increments('tea_id')->comment('教师id');
            $table->string('tea_name',20)->nullable()->comment('教师名称');
            $table->string('tea_head',100)->nullable()->comment('教师头像');
            $table->string('tea_title',30)->nullable()->comment('教师称号');
            $table->text('tea_desc')->nullable()->comment('教师简介');
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
