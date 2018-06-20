<?php

namespace App;

class Campus extends Model
{
    protected $table = 'campus';

    public function parent(){
        return $this->belongsTo(\App\CampusCategory::class,'pid','id');
    }


    public function getProvince(){
        return $this->belongsTo(\App\Location::class,'province','id');
    }
    public function getCity(){
        return $this->belongsTo(\App\Location::class,'city','id');
    }

    public function getDistrict(){
        return $this->belongsTo(\App\Location::class,'district','id');
    }
}
