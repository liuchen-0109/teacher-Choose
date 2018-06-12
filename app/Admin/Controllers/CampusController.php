<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\CampusCategory;
class CampusController extends Controller{

    public function index(){
        $cates = CampusCategory::with('allChildrenCategory')->first();
        return view('admin.campus.index',compact('cates'));
    }
}

