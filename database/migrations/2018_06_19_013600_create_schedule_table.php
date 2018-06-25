<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->increments('id')->comment('自增ID');
            $table->string('teacher_name' ,150)->default('')->comment('教师姓名');
            $table->string('excel_md5' ,100)->default('')->comment('表格加密');
            $table->string('campus_name' ,150)->default('')->comment('校区名');
            $table->string('remark' ,150)->default('')->comment('备注');
            $table->integer('year' )->unsigned()->default(2018)->comment('年份');
            $table->string('type',50 )->default('')->comment('学部');
            $table->enum('is_teaching',['有课','无课'] )->default('有课')->comment('是否有课');
            $table->tinyInteger('time' )->unsigned()->default(0)->comment('上课时间');
            $table->tinyInteger('status')->unsigned()->default(1)->comment('状态，1启用 0禁用');
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
        Schema::dropIfExists('schedule');
    }
}
