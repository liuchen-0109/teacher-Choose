<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use LaravelExcel;
use App\Schedule;

class TestController extends Controller
{
    public function index()
    {
        return view('admin.test.index');
    }

    public function test(Request $request)
    {
        echo "<pre>";
        LaravelExcel::load($request['file'], function ($reader) {
            $info = $reader->getSheet(0);
            //分割第一块
            $results = array_chunk($info->toArray(), 7);
            foreach($results as $k=>$v){
                if(!$v[0][0]) unset($results[$k]);
            }
            //将数据整理
            $arr = array();
                foreach ($results as $res) {
                    $data = array();
                    foreach ($res as $r) {
                        $data[] = array_slice($r, 0, 8);
                    }
                    $arr[] = $data;
                }
            $all = array();
            foreach ($arr as $key => $items) {
                $name = $items[0][0];
                foreach ($items as $k => $item) {
                    if ($k >1) {
                        foreach ($item as $index => $v) {
                            if ($index >1 && $v) {
                                $sql_data = array();
                                $sql_data['teacher_name'] = trim($name);
                                preg_match('/#.*#/',$v,$strArr);
                                $sql_data['campus_name']= $strArr?trim($strArr[0],'#'):'';
                                $sql_data['remark'] = str_replace("#", "", $v);
                                $sql_data['time'] = $index.','.$k;
                                $sql_data['is_teaching'] = '有课';
                                dd($sql_data);
                            }
                        }
                    }
                }
            }
        });

    }
}
