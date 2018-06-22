<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload_img','\App\Admin\Controllers\UploadController@upload_img');
Route::post('/upload/delete','\App\Admin\Controllers\UploadController@delete');
Route::post('/upload_excel','\App\Admin\Controllers\UploadController@upload_excel');

Route::post('/campusList','\App\Http\Controllers\ApiController@campusList');
Route::post('/excelList','\App\Http\Controllers\ApiController@excelList');
Route::post('/teacherList','\App\Http\Controllers\ApiController@teacherList');
Route::post('/teacherDetail','\App\Http\Controllers\ApiController@teacherDetail');
Route::post('/teacherSchedule','\App\Http\Controllers\ApiController@teacherSchedule');
Route::post('/login','\App\Http\Controllers\ApiController@login');
Route::post('/selectTeacher','\App\Http\Controllers\ApiController@selectTeacher');

Route::group(['middleware'=>'web_api'],function(){
}
);
