<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\CampusCategory;
class CampusCategoryController extends Controller
{
    public function index(Request $request){
        $cates = CampusCategory::with('allChildrenCategory')->first();
//        dd($collection->toArray());
        //是否进行筛选
        $word = $request->word ? $request->word : "";
        if ($word) {
            $cates->where('name', 'like', '%' . $word . "%");
        }
        return view('admin.campusCategory.index',compact('cates', 'word'));
    }

    public function create(Request $request){
        //验证数据
        $data = $request->all();
        if(!$data['pid']) json('父级分类不能为空');
        if(!$data['name']) json('名称不能为空');
        if($data['pid'] == 0 ){
            $data['type'] = '大区';
        }else{
            $data['type'] = '城市';
        }
        unset($data['_token']);

        if($data['id']){
            $cate = CampusCategory::find($data['id']);
            $res = $cate->update($data);
        }else{
            $res = CampusCategory::create($data);
        }
        if(!$res) json('操作失败');
        json('操作成功',1);
    }
}
