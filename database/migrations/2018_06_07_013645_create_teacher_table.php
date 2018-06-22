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
            $table->increments('id')->comment('自增id');
            $table->string('name',50)->comment('姓名');
            $table->string('job_number',32)->default(0)->comment('工号');
            $table->string('mobile',15)->default('')->comment('电话');
            $table->integer('campus')->unsigned()->default(0)->comment('校区ID');
            $table->string('headimg_url',150)->default('')->comment('头像地址');
            $table->text('photos')->nullable()->comment('生活照片');
            $table->text('voices')->nullable()->comment('语音介绍地址');
            $table->string('email',50)->default('')->comment('邮箱');
            $table->enum('work_status',['全职','兼职','特聘','专职'])->comment('岗位性质');
            $table->enum('level',['A','B','C','D'])->comment('级别');
            $table->unsignedTinyInteger('extend')->default(0)->comment('扩展');
            $table->unsignedTinyInteger('logic')->default(0)->comment('逻辑');
            $table->unsignedTinyInteger('base')->default(0)->comment('基础');
            $table->unsignedTinyInteger('habit')->default(0)->comment('习惯');
            $table->unsignedTinyInteger('planning')->default(0)->comment('规划');
            $table->unsignedTinyInteger('strict')->default(0)->comment('严格');
            $table->unsignedTinyInteger('interaction')->default(0)->comment('互动');
            $table->unsignedTinyInteger('humor')->default(0)->comment('幽默');
            $table->unsignedTinyInteger('excellence')->default(0)->comment('专业');
            $table->unsignedTinyInteger('passion')->default(0)->comment('激情');
            $table->string('emergency_contact',150)->default('')->comment('紧急联系人');
            $table->string('contact_mobile',150)->default('')->comment('联系人电话');
            $table->string('address',255)->default('')->comment('详情住址');
            $table->enum('sex',['男','女'])->comment('性别');
            $table->unsignedTinyInteger('age')->default(0)->comment('年龄');
            $table->date('birthday')->nullable()->comment('生日');
            $table->string('nation',50)->default('')->comment('民族');
            $table->string('political_status',50)->default('')->comment('政治面貌');
            $table->enum('is_married',['已婚','未婚'])->comment('婚姻状况');
            $table->string('native_place',150)->default('')->comment('籍贯');
            $table->string('domicile',150)->default('')->comment('户籍所在地');
            $table->string('id_number',32)->default('')->comment('身份证');
            $table->date('experience_age')->comment('教师年限');
            $table->string('college',150)->default('')->comment('毕业院校');
            $table->string('department',150)->default('')->comment('专业');
            $table->enum('education',['小学','初中','高中及中专','大专','本科','硕士','博士','博士后'])->comment('专业');
            $table->text('describe')->nullable()->comment('教师简介');
            $table->text('particular')->nullable()->comment('教学特点');
            $table->text('achievement')->nullable()->comment('教学成果');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态');
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
        Schema::dropIfExists('teacher');

    }
}
