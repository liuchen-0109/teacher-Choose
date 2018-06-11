<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Teacher;

class TeacherController extends Controller
{
    /**
     * 用户列表页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $collection = Teacher::where('status', '>=', 0)->orderBy(
            'created_at', 'desc');

        //是否进行筛选
        $word = $request->word ? $request->word : "";
        $compus = $request->compus ? $request->compus : "";
        $subject = $request->subject ? $request->subject : "";
        if ($word) {
            if (is_numeric($word)) {
                $collection->where('mobile', '=', $word);
            } else {
                $collection->where('name', 'like', '%' . $word . "%");
            }
        }
        if ($compus) $collection->where('compus', '=', $compus);
        if ($subject) $collection->where('subject', '=', $subject);
        $teachers = $collection->paginate(10);
        return view('/admin/teacher/index', compact('teachers', 'word', 'compus', 'subject'));
    }

    /**
     * 创建用户
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        //验证输入数据
        $this->checkData($request->all());

        $param = $request->all();
        if (!$request->id) {
            unset($request->id);
            $res = Teacher::create($param);
        } else {
            $teacher = Teacher::find($request->id);
            $res = $teacher->update($param);
        }


        if (!$res) json('操作失败');
        json('操作成功', 1);

    }

    /**
     * 删除教师
     * @param Teacher $teacher
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Teacher $teacher)
    {
        $res = $teacher->delete();
        if (!$res) json('操作失败');
        json('操作成功', 1);
    }

    /**
     * 修改教师状态
     * @param Teacher $teacher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus(Teacher $teacher)
    {
        if ($teacher->status == 1) {
            $teacher->status = 0;
        } else {
            $teacher->status = 1;
        }

        $teacher->save();
        return redirect()->back();
    }

    public function teacherInfo(Teacher $teacher)
    {
        return $data = $teacher->toJson();
    }

    /**
     * 验证输入数据
     * @param $request
     */
    public function checkData($request)
    {
        if (!$request['name']) json('姓名不能为空');
        if (!$request['job_number']) json('工号不能为空');
        if (!$request['subject']) json('科目不能为空');
        if (!$request['mobile']) json('手机不能为空');
        if (!$request['compus']) json('校区不能为空');
        if (!$request['email']) json('邮箱不能为空');
        if (!$request['work_status']) json('岗位性质不能为空');
        if (!$request['level']) json('级别不能为空');
        if ($request['extend'] < 0 || $request['extend'] > 10) json('扩展字段不合法');
        if ($request['logic'] < 0 || $request['logic'] > 10) json('逻辑不能为空');
        if ($request['base'] < 0 || $request['base'] > 10) json('基础不能为空');
        if ($request['habit'] < 0 || $request['habit'] > 10) json('习惯不能为空');
        if ($request['planning'] < 0 || $request['planning'] > 10) json('规划不能为空');
        if ($request['strict'] < 0 || $request['strict'] > 10) json('严格不能为空');
        if ($request['interaction'] < 0 || $request['interaction'] > 10) json('互动不能为空');
        if ($request['humor'] < 0 || $request['humor'] > 10) json('幽默不能为空');
        if ($request['excellence'] < 0 || $request['excellence'] > 10) json('专业不能为空');
        if ($request['passion'] < 0 || $request['passion'] > 10) json('激情不能为空');
        if (!$request['emergency_contact']) json('联系人不能为空');
        if (!$request['contact_mobile']) json('联系人电弧不能为空');
        if (!$request['address']) json('详细住址不能为空');
        if (!$request['sex']) json('性别不能为空');
        if (!$request['age']) json('年龄不能为空');
        if (!$request['age'] < 0 || $request['age'] > 100) json('年龄输入不合法');
        if (!$request['birthday']) json('生日不能为空');
        if (!$request['nation']) json('民族不能为空');
        if (!$request['political_status']) json('政治面貌不能为空');
        if (!$request['is_married']) json('婚姻状况不能为空');
        if (!$request['native_place']) json('籍贯不能为空');
        if (!$request['domicile']) json('户籍所在地不能为空');
        if (!$request['id_number']) json('身份证不能为空');
        if (!$request['experience_age']) json('教师年限不能为空');
        if (!$request['experience_age'] < 0 || $request['age'] > 100) json('教师年限输入不合法');
        if (!$request['college']) json('毕业院校不能为空');
        if (!$request['department']) json('专业院校不能为空');
        if (!$request['education']) json('最高学历不能为空');
    }
}
