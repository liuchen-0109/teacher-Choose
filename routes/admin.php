<?php
/**
 * admin后台路由
 */

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login','\App\Admin\Controllers\LoginController@index')->name('login');
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');
    Route::get('/test', '\App\Admin\Controllers\TestController@index');
    Route::post('/test/excel', '\App\Admin\Controllers\TestController@test');
    Route::get('/password', '\App\Admin\Controllers\AppPasswordController@setPassword');

    Route::group(['middleware'=>'auth:admin'],function(){
        Route::get('/','\App\Admin\Controllers\HomeController@index');
        Route::get('/home','\App\Admin\Controllers\HomeController@index');
        Route::get('/index','\App\Admin\Controllers\HomeController@index');


        Route::group(['prefix'=>'user'],function() {
            Route::get('/index','\App\Admin\Controllers\UserController@index');
            Route::post('/create','\App\Admin\Controllers\UserController@create');
            Route::get('/delete/{adminUser}','\App\Admin\Controllers\UserController@delete');
            Route::post('/info/{adminUser}','\App\Admin\Controllers\UserController@info');
            Route::post('/changePassword/{adminUser}','\App\Admin\Controllers\UserController@changePassword');

        });

        Route::group(['prefix'=>'excel'],function() {
            Route::get('/index','\App\Admin\Controllers\ExcelController@index');
            Route::post('/create','\App\Admin\Controllers\ExcelController@create');
            Route::post('/check','\App\Admin\Controllers\ExcelController@check');
            Route::get('/delete/{excel}','\App\Admin\Controllers\ExcelController@delete');
            Route::get('/changeStatus/{excel}','\App\Admin\Controllers\ExcelController@changeStatus');
        });


        Route::group(['prefix'=>'teacher'],function(){
            Route::get('/index','\App\Admin\Controllers\TeacherController@index');//教师列表页
            Route::post('/create','\App\Admin\Controllers\TeacherController@create');//添加教师操作
            Route::get('/changeStatus/{teacher}','\App\Admin\Controllers\TeacherController@changeStatus');//修改教师状态
            Route::get('/delete/{teacher}','\App\Admin\Controllers\TeacherController@delete');//删除教师操作
            Route::any('/teacherInfo/{teacher}','\App\Admin\Controllers\TeacherController@teacherInfo');//查询教师信息操作
        });

        Route::group(['prefix'=>'campus'],function(){
            Route::get('/index','\App\Admin\Controllers\CampusController@index');
            Route::post('/create','\App\Admin\Controllers\CampusController@create');
            Route::post('/info/{campus}','\App\Admin\Controllers\CampusController@info');
            Route::post('/delete/{campus}','\App\Admin\Controllers\CampusController@delete');
        });

        Route::group(['prefix'=>'campusCategory'],function(){
            Route::get('/index','\App\Admin\Controllers\CampusCategoryController@index');//分类列表页
            Route::post('/create','\App\Admin\Controllers\CampusCategoryController@create');//创建分类
            Route::post('/info/{campusCategory}','\App\Admin\Controllers\CampusCategoryController@info');//查分类信息
            Route::get('/delete/{campusCategory}','\App\Admin\Controllers\CampusCategoryController@delete');//删除分类

        });
    });
});