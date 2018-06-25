<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excel', function (Blueprint $table) {
            $table->increments('id')->comment('自增ID');
            $table->string('name',50)->default('')->comment('excel加密后名称');
            $table->integer('count' )->unsigned()->default(0)->comment('老师数量');
            $table->integer('year' )->unsigned()->default(2018)->comment('年份');
            $table->enum('season',['春季','暑期','秋季'] )->default('春季')->comment('学期');
            $table->string('type',50 )->default('')->comment('学部');
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
        Schema::dropIfExists('excel');
    }
}
