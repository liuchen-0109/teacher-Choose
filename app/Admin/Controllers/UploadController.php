<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Excel;
class UploadController extends Controller
{
    /**
     * 上传
     * @param Request $request
     */
    public function upload_img(Request $request){
        if(!$request->hasFile('file')) json('文件不存在');
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $file_name =  md5($request['name'].time().rand(0,999)).'.'.$ext;
        // 新文件名
        $path = $file->storeAs(date('Ymd'),$file_name);
        if(!$path) json('上传失败');
        json(['path'=>'/uploads/'.date('Ymd').'/'.$file_name],1);
    }

    /**
     * 删除文件
     * @param Request $request
     */
    public function delete(Request $request){
        dd(public_path().$request['url']);
        @unlink(public_path().$request['url']);
    }

    /**
     * 上传excel
     * @param Request $request
     */
    public function upload_excel(Request $request){
        if(!$request->hasFile('file')) json('文件不存在');
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $allow = array('xls','xlsx');
        if(!in_array($ext,$allow)) json('上传文件格式不正确');
        $file_name =  md5($request['name'].time().rand(0,999)).'.'.$ext;
        // 新文件名
        $path = $file->storeAs(date('Ymd'),$file_name);
        if(!$path) json('上传失败');
        Excel::load($file, function($reader) {
            $data = $reader->all();
            foreach($data as $items){
                foreach($items as $item ){
                    dd($item);
                }
            };
        });
        json(['path'=>'/uploads/'.date('Ymd').'/'.$file_name],1);
    }
}
