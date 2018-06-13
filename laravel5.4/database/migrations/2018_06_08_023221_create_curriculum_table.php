<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum', function (Blueprint $table) {
            $table->increments('curriculum_id')->comment('课程id');
            $table->string('curriculum_name',50)->nullable()->comment('课程名称');
            $table->string('curriculum_title',50)->nullable()->comment('课程标题');
            $table->string('curriculum_desc',100)->nullable()->comment('课程时间介绍');
            $table->string('curriculum_time',100)->nullable()->comment('课程时间');
            $table->string('tea_id',20)->nullable()->comment('授课教师id,用逗号分隔');
            $table->string('curriculum_notice',30)->nullable()->comment('课程公告');
            $table->integer('curriculum_price')->nullable()->comment('课程价格');
            $table->integer('curriculum_num')->nullable()->comment('购买数量');
            $table->integer('curriculum_stock')->nullable()->comment('库存');
            $table->dateTime('add_time')->nullable()->comment('创建时间');
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
