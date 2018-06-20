<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_relation', function (Blueprint $table) {
            $table->increments('id')->comment('自增ID');
            $table->integer('teacher_id' )->unsigned()->default(0)->comment('教师ID');
            $table->enum('subject',['数学','语文','英语','物理','化学'] )->default(0)->comment('学科ID');
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
        Schema::dropIfExists('subject_relation');
    }
}
