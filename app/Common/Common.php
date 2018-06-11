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