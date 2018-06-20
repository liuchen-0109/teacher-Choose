<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campus', function (Blueprint $table) {
            $table->increments('id')->comment('自增ID');
            $table->string('name', '150')->default('')->comment('校区名称');
            $table->integer('pid')->unsigned()->default(0)->comment('所属区域');
            $table->integer('province')->unsigned()->default(0)->comment('省');
            $table->integer('city')->unsigned()->default(0)->comment('市');
            $table->integer('district')->unsigned()->default(0)->comment('区');
            $table->string('lng', 32)->default('')->comment('经度');
            $table->string('lat', 32)->default('')->comment('纬度');
            $table->string('address', 255)->default('')->comment('详细地址');
            $table->string('tel', 15)->default('')->comment('电话');
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
        Schema::dropIfExists('campus');
    }
}
