<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\CampusCategory;

/**
 * 校区分类控制器
 * Class CampusCategoryController
 * @package App\Admin\Controllers
 */

class CampusCategoryController extends Controller
{
    /**
     * 首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $cates = CampusCategory::where('id','=',1)->with('allChildrenCategory')
            ->first();
        return view('admin.campusCategory.index',compact('cates'));
    }

    /**
     * 创建分类
     * @param Request $request
     */
    public function create(Request $request){
        //验证数据
        $data = $request->all();
       $data['pid'] = $request['pid']?$request['pid']:1;
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

    /**
     *获取数据
     * @param CampusCategory $campusCategory
     * @return string
     */
    public function info(CampusCategory $campusCategory){
        return  $campusCategory->toJson();
    }

    /**
     * 删除分类
     * @param CampusCategory $campusCategory
     * @throws \Exception
     */
    public function delete(CampusCategory $campusCategory){
        if(CampusCategory::where('pid','=',$campusCategory->id)->count()) json('含有子分类，请处理子分类后在进行此操作');
        $res = $campusCategory->delete();
        if (!$res) json('操作失败');
        json('操作成功', 1);
    }
}
