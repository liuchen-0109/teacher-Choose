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
        $old = Excel::where('name', '=', $name)->first();
        if ($old) $old->delete();
        $res = Excel::create($data);

        if (!$res) json('操作失败');
        $this->save_data(public_path() . $request->name,$name);
        $count = Schedule::where('excel_md5','=',$name)->distinct('teacher_name')->count('teacher_name');
        $res->count = $count;
        $res->update();
        json('操作成功', 1);
    }

    public function check(Request $request)
    {
        $name = md5($request->year . $request->season . $request->type);
        $old = Excel::where('name', '=', $name)->first();
        if ($old) json('已存在');
        json('不存在', 1);
    }

    public function save_data($file,$excel_md5)
    {
        LaravelExcel::load($file, function ($reader) use ($excel_md5){
            $info = $reader->getSheet(0);
            $title = $info->getTitle();
            $results = array_chunk($info->toArray(), 7);
            foreach ($results as $result) {
                $name = mb_substr($result[0][0], 0, -5, 'utf-8');
                foreach ($result as $k => $v) {

                    if ($k == 1) continue;
                    if ($k > 1) {
                        foreach ($v as $index => $items) {
                            if ($index == 0) continue;
                            if ($items) {
                                $data = array();
                                $data['teacher_name'] = $name;
                                $data['campus_name'] = $items;
                                $data['time'] = $k - 1;
                                $data['day'] = $index;
                                $data['title'] = $title;
                                $data['excel_md5'] = $excel_md5;
                                Schedule::create($data);
                            }

                        }
                    }
                }
            }
        });
    }

    public function delete(Excel $excel)
    {
        $res = $excel->delete();
        if (!$res) json('操作失败');
        json('操作成功', 1);
    }

    public function changeStatus(Excel $excel)
    {
        if ($excel->status == 1) {
            $excel->status = 0;
        } else {
            $excel->status = 1;
        }
        $excel->save();
        return redirect()->back();
    }
}
