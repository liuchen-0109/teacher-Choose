<?php

namespace App;

class Teacher extends Model
{
    protected $table = 'teacher';

    //存入json
    public function setPhotosAttribute($value)
    {
        $this->attributes['photos'] = json_encode($value);
    }

    public function getPhotosAttribute($value)
    {
        return json_decode($value);
    }


    //存入json
    public function setVoicesAttribute($value)
    {
        $this->attributes['voices'] = json_encode($value);
    }
    public function getVoicesAttribute($value)
    {
        return json_decode($value);

    }
}
