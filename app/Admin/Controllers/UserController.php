<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\AdminUser;

class UserController extends Controller
{
    /**
     * 用户列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = AdminUser::where('name', '!=', 'admin')->orderBy('created_at', 'desc')->paginate(10);
        return view('/admin/user/index', compact('users'));
    }

    /**
     * 创建用户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $data['name'] = $request['name'];
        $data['password'] = bcrypt($request['password']);
        $data['user_name'] = $request['user_name'];
        $data['mobile'] = $request['mobile'];
        $data['type'] = $request['type'];
        if ($request['id']) {
            $user = AdminUser::find($request['id']);
            if ($user->name != $data['name']) {
                if (AdminUser::where('name', '=', $request['name'])->first()) json('已存在同名管理员！');
            }
            $res = $user->update($data);
        } else {
            if (AdminUser::where('name', '=', $request['name'])->first()) json('已存在同名管理员！');
            $res = AdminUser::create($data);
        }

        if (!$res) json('操作失败');
        json('操作成功', 1);
    }

    public function delete(AdminUser $adminUser)
    {
        $res = $adminUser->delete();
        if (!$res) json('操作失败');
        json('操作成功', 1);
    }

    public function info(AdminUser $adminUser)
    {
        return $adminUser->toJson();
    }

    public function changePassword(AdminUser $adminUser, Request $request)
    {
        $user = request(['name', 'password']);
        if (false == \Auth::guard('admin')->attempt($user)) {
            json('密码输入不正确');

        }
        $adminUser->password = bcrypt($request['newpassword']);
        if($request['newpassword'] != $request['repassword']) json('两次密码输入不一致');
        $res =  $adminUser->save();
        if(!$res) json('操作失败');
        json('操作成功',1);
    }

    /*
     * 角色的权限
     */
    public function role(\App\AdminUser $user)
    {
        $roles = \App\AdminRole::all();
        $myRoles = $user->roles;
        return view('/admin/user/role', compact('roles', 'myRoles', 'user'));
    }

    /*
     * 保存权限
     */
    public function storeRole(\App\AdminUser $user)
    {
        $this->validate(request(), [
            'roles' => 'required|array'
        ]);

        $roles = \App\AdminRole::find(request('roles'));
        $myRoles = $user->roles;

        // 对已经有的权限
        $addRoles = $roles->diff($myRoles);
        foreach ($addRoles as $role) {
            $user->roles()->save($role);
        }

        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $role) {
            $user->deleteRole($role);
        }
        return back();
    }
}
