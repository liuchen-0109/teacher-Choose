<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Schedule;

class TestController extends Controller
{
    public function index()
    {
        return view('admin.test.index');
    }

    public function test(Request $request)
    {
        echo "<pre>";
       
    }
}
