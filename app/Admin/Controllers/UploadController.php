<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload_img(Request $request){
        if(!$request->hasFile('file')) json('文件不存在');
        $file = $request->file('file');
        $ext = $request->file->extension();
        if($ext == 'jpg' || $ext == 'jepg'){
            $ext = 'jpg';
        }else if($ext == 'png'){
            $ext = 'png';
        }else if($ext == 'mp3' || $ext == 'mpga'){
            $ext = 'mp3';
        }
        $file_name =  md5($request['name'].time().rand(0,999)).'.'.$ext;
        // 新文件名
        $path = $file->storeAs(date('Ymd'),$file_name);
        if(!$path) json('上传失败');
        json(['path'=>'/uploads/'.date('Ymd').'/'.$file_name],1);


    }
    #上传图片#
    public function loadimg(){

        $body = I('get.body');
        $thumb = I('get.thumb'); //是否缩略图
        if($body == 1){
            $filed = I('post.filed');
            if($filed){
                // 移动端编辑器上传
                //匹配出图片的格式
                if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $filed, $result)){
                    $type = $result[2];
                    $file = 'Public/uploads/images/'.date('Y-m-d').'/'.md5(NOW_TIME).'.'.$type;
                    if (file_put_contents($file, base64_decode(str_replace($result[1], '', $filed)))){
                        exit($file);
                    }else{
                        exit('保存图片失败！');
                    }
                }else{
                    exit('上传失败!');
                }
            }
            //百度编辑器上传
            $type = $_REQUEST['type'];
            $editorId=$_GET['editorid'];
            $p  =   $this->upload('images/'.date('Y-m-d'),array('ext'=>'png,jpg,gif,jpeg,bmp'));
            if(is_array($p)){//成功!
                die(json_encode(array('error'=>0,'url'=>$p['file'])));
                //$status = 'SUCCESS';
            }else{//失败
                //$status = $p;
                die(json_encode(array('error'=>1,'message'=>$p)));
            }
            // if($type == "ajax"){
            // 	die($p['file']);
            // }else{
            // 	die("<script>parent.UM.getEditor('". $editorId ."').getWidgetCallback('image')('" . $p['file'] . "','" . $status . "')</script>");
            // }
        }
        if($thumb){
            $p	=	$this->upload('images/'.date('Y-m-d'),array('ext'=>'png,jpg,gif,jpeg','thumb'=>2,'width'=>320,'height'=>220,'del'=>false));
        }else{
            $p	=	$this->upload('images/'.date('Y-m-d'),array('ext'=>'png,jpg,gif,jpeg'));
        }
        if(is_array($p)){//成功!
            json($p,1);
        }else{//失败
            json($p);
        }
    }
}
