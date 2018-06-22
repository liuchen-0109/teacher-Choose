<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Excel;
use LaravelExcel;
use App\Schedule;
class ExcelController extends Controller
{
    /**
     * 列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $collection = new Excel();
        //是否进行筛选
        $year = $request->year ? $request->year : "";
        $season = $request->season ? $request->season : "";
        $type = $request->type ? $request->type : "";
        if ($year) $collection = $collection->where('year', '=', $year);
        if ($season) $collection = $collection->where('season', '=', $season);
        if ($type) $collection = $collection->where('type', '=', $type);
        $excels = $collection->orderBy('year', 'asc')->orderBy('season', 'asc')->paginate(10);
        $d = intval(date('Y', time()));
        $years = [$d, $d + 1, $d + 2];
        return view('/admin/excel/index', compact('excels', 'year', 'season', 'type', 'years'));
    }

    public function create(Request $request)
    {
        $name = md5($request->year . $request->season . $request->type);
        $data = [
            'name' => $name,
            'year' => $request->year,
            'season' => $request->season,
            'type' => $request->type,
        ];
        $old = Excel::where('name', '=', $name)->delete();
        $res = Excel::create($data);

        if (!$res) json('操作失败');

        Schedule::where('excel_md5','=',$name)->delete();
        if($request->season == '暑期'){
            $this->save_data2(public_path() . $request->name,$name,$request->type,$request->season,$request->year);
        }else{
            $this->save_data(public_path() . $request->name,$name,$request->type,$request->season,$request->year);
        }
        $count = Schedule::where('excel_md5','=',$name)->distinct('teacher_name')->count('teacher_name');
        $res->count = $count;
        $res->update();
        json('操作成功', 1);
    }

    /**
     * 检测是否已存在该课表
     * @param Request $request
     */
    public function check(Request $request)
    {
        $name = md5($request->year . $request->season . $request->type);
        $old = Excel::where('name', '=', $name)->first();
        if ($old) json('已存在');
        json('不存在', 1);
    }

    /**
     * 春秋季课表Excel解析
     * @param $file
     * @param $excel_md5
     * @param $type
     */
    public function save_data($file,$excel_md5,$type,$season,$year)
    {
        LaravelExcel::load($file, function ($reader)use ($excel_md5,$type,$season,$year) {
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
                            if ($index >0 && $v) {
                                $sql_data = array();
                                $sql_data['teacher_name'] = trim($name);
                                preg_match('/#.*#/',$v,$strArr);
                                $sql_data['campus_name']= $strArr?trim($strArr[0],'#'):'';
                                $sql_data['remark'] = str_replace("#", "", $v);
                                $sql_data['time'] = $index.','.($k-1);
                                $sql_data['type'] = $type;
                                $sql_data['excel_md5'] = $excel_md5;
                                $sql_data['season'] = $season;
                                $sql_data['year'] = $year;
                                $sql_data['is_teaching'] = '有课';
                                Schedule::create($sql_data);
                            }elseif($index >0 && !$v){
                                $sql_data = array();
                                $sql_data['teacher_name'] = trim($name);
                                $sql_data['time'] = $index.','.($k-1);
                                $sql_data['type'] = $type;
                                $sql_data['excel_md5'] = $excel_md5;
                                $sql_data['season'] = $season;
                                $sql_data['year'] = $year;
                                $sql_data['is_teaching'] = '无课';
                                Schedule::create($sql_data);
                            }
                        }
                    }
                }
            }
        });
    }

    /**
     * 暑期课表Excel解析
     * @param $file
     * @param $excel_md5
     * @param $type
     */
    public function save_data2($file,$excel_md5,$type,$season,$year){
        LaravelExcel::load($file, function ($reader)use($excel_md5,$type,$season,$year) {
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
            foreach ($arr as $key => $items) {
                foreach ($items as $k => $item) {
                    $name = $items[0][0];
                    if ($k > 0 && $name) {
                        foreach ($item as $index => $v) {
                            if ($index >=1 && $v) {
                                $sql_data = array();
                                $sql_data['teacher_name'] = trim($name);
                                preg_match('/#.*#/',$v,$strArr);
                                $sql_data['campus_name']= $strArr?trim($strArr[0],'#'):'';
                                $sql_data['remark'] = str_replace("#", "", $v);
                                $sql_data['time'] = $index.','.$k;
                                $sql_data['type'] = $type;
                                $sql_data['excel_md5'] = $excel_md5;
                                $sql_data['season'] = $season;
                                $sql_data['year'] = $year;
                                $sql_data['is_teaching'] = '有课';
                                Schedule::create($sql_data);
                            }else if($index >=1 && !$v && trim($name)){
                                $sql_data = array();
                                $sql_data['teacher_name'] = trim($name);
                                $sql_data['time'] = $index.','.$k;
                                $sql_data['type'] = $type;
                                $sql_data['excel_md5'] = $excel_md5;
                                $sql_data['season'] = $season;
                                $sql_data['year'] = $year;
                                $sql_data['is_teaching'] = '无课';
                                Schedule::create($sql_data);

                            }
                        }
                    }
                }
            }
        });
    }
    public function delete(Excel $excel)
    {
        $excel_md5 = md5($excel->year . $excel->season . $excel->type);
        $res = $excel->delete();
        if (!$res) json('操作失败');
        Schedule::where('excel_md5','=',$excel_md5)->delete();
        json('操作成功', 1);
    }

    public function changeStatus(Excel $excel)
    {
        $excel_md5 = md5($excel->year . $excel->season . $excel->type);
        if ($excel->status == 1) {
            $excel->status = 0;
            Schedule::where('excel_md5','=',$excel_md5)->update(array('status'=>0));
        } else {
            $excel->status = 1;
            Schedule::where('excel_md5','=',$excel_md5)->update(array('status'=>1));

        }
        $excel->save();
        return redirect()->back();
    }
}
