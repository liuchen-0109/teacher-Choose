<?php

namespace App;

class Teacher extends Model
{
    protected $table = 'teacher';

    public function getCampus()
    {
        return $this->belongsTo(\App\Campus::class, 'campus', 'id');
    }

    public function getSubject()
    {
        return $this->hasMany(\App\SubjectRelation::class,'teacher_id','id');
    }

    /**
     * json格式处理photos字段
     * @param $value
     */
    public function setPhotosAttribute($value)
    {
        $this->attributes['photos'] = json_encode($value);
    }

    /**
     * 解析phohos字段
     * @param $value
     * @return mixed
     */
    public function getPhotosAttribute($value)
    {
        return json_decode($value);
    }


    /**
     * json格式处voices字段
     * @param $value
     */
    public function setVoicesAttribute($value)
    {
        $this->attributes['voices'] = json_encode($value);
    }

    /**
     * 解析voices字段
     * @param $value
     * @return mixed
     */
    public function getVoicesAttribute($value)
    {
        return json_decode($value);

    }
}
