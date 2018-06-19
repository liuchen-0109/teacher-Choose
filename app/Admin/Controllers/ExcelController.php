<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Excel;

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
        if($year) $collection = $collection->where('year','=',$year);
        if($season) $collection = $collection->where('season','=',$season);
        if($type) $collection = $collection->where('type','=',$type);
        $excels = $collection->orderBy('year','asc')->orderBy('season','asc')->paginate(10);
        $d = intval(date('Y',time()));
        $years = [$d,$d+1,$d+2];
        return view('/admin/excel/index', compact('excels','year','season','type','years'));
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
        json('操作成功', 1);
    }

    public function check(Request $request){
        $name = md5($request->year . $request->season . $request->type);
        $old = Excel::where('name', '=', $name)->first();
        if($old) json('已存在');
        json('不存在',1);
    }

    public function  delete(Excel $excel){
        $res = $excel->delete();
        if(!$res) json('操作失败');
        json('操作成功',1);
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
