<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Excel;
use Excel as LaravelExcel;
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
            $this->save_data2(public_path() . $request->name,$name,$request->type);
        }else{
            $this->save_data(public_path() . $request->name,$name,$request->type);
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
    public function save_data($file,$excel_md5,$type)
    {
        LaravelExcel::load($file, function ($reader) use ($excel_md5,$type){
            $info = $reader->getSheet(0);
            $results = array_chunk($info->toArray(), 7);
            foreach ($results as $result) {
                $name = mb_substr($result[0][0], 0, -5, 'utf-8');
                foreach ($result as $k => $v) {

                    if ($k == 1) continue;
                    if ($k > 0) {
                        foreach ($v as $index => $items) {
                            if ($index == 0) continue;
                            if ($items) {
                                $data = array();
                                $data['teacher_name'] = $name;
                                $data['campus_name'] = $items;
                                $data['time'] = $index.($k - 1);
                                $data['type'] = $type;
                                $data['excel_md5'] = $excel_md5;
                                Schedule::create($data);
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
    public function save_data2($file,$excel_md5,$type){
        LaravelExcel::load($file, function ($reader)use($excel_md5,$type) {
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
                $sql_data = array();
                foreach ($items as $k => $item) {
                    if ($k > 0) {
                        foreach ($item as $index => $v) {
                            if ($index >=1 && $v) {
                                $sql_data['teacher_name'] = $items[0][0];
                                $sql_data['campus_name'] = $v;
                                $sql_data['time'] = $index.$k;
                                $sql_data['type'] = $type;
                                $sql_data['excel_md5'] = $excel_md5;
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
