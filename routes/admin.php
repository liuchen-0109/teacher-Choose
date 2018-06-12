<?php
/**
 * admin后台路由
 */

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login','\App\Admin\Controllers\LoginController@index')->name('login');
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');

    Route::group(['middleware'=>'auth:admin'],function(){
        Route::get('/','\App\Admin\Controllers\HomeController@index');

        Route::group(['prefix'=>'teacher'],function(){
            Route::get('/index','\App\Admin\Controllers\TeacherController@index');//教师列表页
            Route::post('/create','\App\Admin\Controllers\TeacherController@create');//添加教师操作
            Route::get('/changeStatus/{teacher}','\App\Admin\Controllers\TeacherController@changeStatus');//修改教师状态
            Route::get('/delete/{teacher}','\App\Admin\Controllers\TeacherController@delete');//删除教师操作
            Route::get('/teacherInfo/{teacher}','\App\Admin\Controllers\TeacherController@teacherInfo');//删除教师操作
        });

        Route::group(['prefix'=>'campus'],function(){
            Route::get('/index','\App\Admin\Controllers\CampusController@index');
        });

        Route::group(['prefix'=>'campusCategory'],function(){
            Route::get('/index','\App\Admin\Controllers\CampusCategoryController@index');
            Route::post('/create','\App\Admin\Controllers\CampusCategoryController@create');
        });
    });
});