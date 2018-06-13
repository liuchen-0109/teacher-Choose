<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\CampusCategory;

class CampusCategoryController extends Controller
{
    public function index(Request $request){
        $cates = CampusCategory::where('id','=',1)->with('allChildrenCategory')
            ->first();
        return view('admin.campusCategory.index',compact('cates', 'word'));
    }

    public function create(Request $request){
        //验证数据
        $data = $request->all();
        if(!$data['pid']) json('父级分类不能为空');
        if(!$data['name']) json('名称不能为空');
        if($data['pid'] == 1 ){
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

    public function info(CampusCategory $campusCategory){
        return  $campusCategory->toJson();
    }

    public function delete(CampusCategory $campusCategory){
        if(CampusCategory::where('pid','=',$campusCategory->id)->count()) json('含有子分类，请处理子分类后在进行此操作');
        $res = $campusCategory->delete();
        if (!$res) json('操作失败');
        json('操作成功', 1);
    }
}
