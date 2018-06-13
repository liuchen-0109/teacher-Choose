<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatecampusCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campus_category', function (Blueprint $table) {
            $table->increments('id')->comment('自增ID');
            $table->string('name','150')->default('')->comment('名称');
            $table->integer('pid')->default(0)->comment('上级ID');
            $table->enum('type',['总部','大区','城市']);
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
        Schema::dropIfExists('campus_category');

    }
}
