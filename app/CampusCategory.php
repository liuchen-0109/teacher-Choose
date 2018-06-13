<?php

namespace App;

class CampusCategory extends Model
{
    protected $table = 'campus_category';

    //包含多个子分类
    public function childCategory(){
        return $this->hasMany('App\CampusCategory','pid','id')->orderBy('created_at', 'asc');
    }

    //无限分类
    public function allChildrenCategory(){
        return $this->childCategory()->with('allChildrenCategory');
    }

    //属于一个父分类
    public function parentCategory(){
        return $this->belongsTo('App\CampusCategory','pid','id');
    }
}
