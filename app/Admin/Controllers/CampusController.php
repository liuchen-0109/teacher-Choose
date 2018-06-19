<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Campus;
use App\CampusCategory;

class CampusController extends Controller
{
    /**
     * 校区列表页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pid = $request->pid ? $request->pid : "";
        $word = $request->word ? $request->word : "";
        $cates = CampusCategory::where('id', '=', 1)->with('allChildrenCategory')
            ->first();
        $collection = Campus::orderBy('created_at', 'desc')->with('getProvince')->with('getCity')->with('getDistrict')->with('parent');
        if ($pid) $collection->where('pid', '=', $pid);
        if ($word) $collection->where('name', 'like', "%" . $word . "%");
        $campus = $collection->paginate(10);
        return view('admin.campus.index', compact('campus', 'cates', 'pid', 'word'));
    }

    /**
     * 创建/修改校区
     * @param Request $request
     */
    public function create(Request $request)
    {
        $data = $request->all();
        if (!$data['pid']) json('请选择组织架构');
        if (!$data['address']) json('详细地址不能为空');
        if (!$data['province'] || !$data['city'] || !$data['district']) json('请选择省市区');
        if (!$data['lng'] || !$data['lat']) json('请标记地图位置');
        if (!$data['pid']) json('请输入联系电话');
        unset($data['_token']);
        if ($data['id']) {
            $campus = Campus::find($data['id']);
            $res = $campus->update($data);
        } else {
            $res = Campus::create($data);
        }
        if (!$res) json('操作失败');
        json('操作成功', 1);
    }

    /**
     * 获取校区数据
     * @param Campus $campus
     * @return string
     */
    public function info(Campus $campus)
    {
        return $campus->toJson();
    }

    /**删除操作
     * @param Campus $campus
     * @throws \Exception
     */
    public function delete(Campus $campus)
    {
        if ($campus->delete()) json('操作成功', 1);
        json('操作失败');
    }
}

