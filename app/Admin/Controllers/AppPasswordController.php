<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\AppPassword as Password;

class AppPasswordController extends Controller
{
    public function setPassword()
    {
        Password::truncate();
        $password = rand(1111, 9999);
        $data['password'] = $password;
        $data['bcrypt_password'] = bcrypt($password);
        $r = Password::create($data);
        if (!$r) alert("更新失败", '/admin/home');
        alert("更新成功", '/admin/home');
    }


}