<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Excel;
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
        Excel::load($request['file'], function ($reader) {
            $info = $reader->getSheet(0);
            //分割第一块
            $results = array_chunk($info->toArray(), 5);
            //将数据整理
            $arr = array();
            for ($i = 1; $i <= 3; $i++) {
                foreach ($results as $res) {
                    $data = array();
                    foreach ($res as $r) {
                        $data[] = array_slice($r, 5 * ($i - 1), 5);
                    }
                    $arr[] = $data;
                }
            }
            $all = array();
            foreach ($arr as $key => $items) {
                $sql_data = array();
                foreach ($items as $k => $item) {
                    if ($k > 0) {
                        foreach ($item as $index => $v) {
                            if ($index >=1 && $v) {
                                $sql_data['teacher_name'] = $items[0][0];
                                $sql_data['campus_name'] = $v;
                                $sql_data['time'] = $index.$k;
                                $all[] = $sql_data;
                            }
                        }
                    }
                }
            }
            dd($all);
        });

    }
}
