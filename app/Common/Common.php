<?php
/**
 * JSON 格式输出
 * @param $data
 * @param int $code
 */
function json($data,$code = 0){
    if(is_array($data)){
        $data['ret'] = $code;
        exit(json_encode($data));
    }else{
        $a['msg'] = $data;
        $a['ret'] = $code;
        exit(json_encode($a));
    }
}

function success_json($data,$title,$msg = '操作成功',$code='1'){
    $array = [
        'code'=>$code,
        'msg'=>$msg,
        'title'=>$title,
      'data'=>$data,
    ];
    exit(json_encode($array));
}

function error_json($title,$msg = '操作失败',$code='0'){
    $array = [
        'code'=>$code,
        'msg'=>$msg,
        'title'=>$title,
    ];
    exit(json_encode($array));

}

/**直接请求输出
 * @param $msg
 * @param string $url
 */
function alert($msg,$url = ''){
    header("Content-type: text/html; charset=utf-8");
    if($url == ''){
        exit("<script>alert('".$msg."');history.go(-1);</script>");
    }else{
        if($url == 'close'){
            exit("<script>alert('".$msg."');window.opener=null;window.close();</script>");
        }else if($url == 'stop'){
            exit("<script>alert('".$msg."');</script>");
        }else{
            exit("<script>alert('".$msg."');location.href='".$url."';</script>");
        }
    }
}