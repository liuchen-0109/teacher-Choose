<?php

namespace App\Http\Controllers;

use App\AppPassword;
use Illuminate\Http\Request;
use App\Campus;
use App\Excel;
use App\Teacher;
use App\Schedule;
use App\ApiToken;

class ApiController extends Controller
{
    public function index()
    {
        return view('web.login');
    }

    /**
     * 获取校区列表接口
     * @param Request $request
     * @return string
     */
    public function campusList(Request $request)
    {
        $lat = $request['lat'];
        $lng = $request['lng'];
        $field = ['id', 'name', 'photo', 'lng', 'lat', 'address'];
        if ($request['word']) {
            $campus = Campus::where('name', 'like', '%' . $request['word'] . '%')->
            orWhere('address', 'like', '%' . $request['word'] . '%')->get($field)->sortBy('distance');
        } else {
            $campus = Campus::all($field);
        }
        if (!$campus) error_json('校区列表接口');
        $campus_list = $campus->map(function ($item) use ($lat, $lng) {
            $item->distance = $this->get_distance(array($lng, $lat), array($item->lng, $item->lat));
            $item->is_checked = false;
            return $item;
        });
        $campus_list = $campus_list->sortBy('distance');
        $campus_list =  $campus_list->values()->all();
        return success_json($campus_list, '校区列表接口');
    }

    /**
     * 获取课表列表接口
     * @param Request $request
     */
    public function excelList(Request $request)
    {
        $field = ['id', 'name', 'year', 'season', 'type'];
        if ($request['id']) {
            $excel = Excel::find($request['id'], $field);
        } else {
            $excel = Excel::where('status', '=', 1)->orderBy('year', 'asc')->orderBy('season')->get($field);
        }
        if (!$excel) error_json('课表接口');
        success_json($excel, '课表接口');
    }

    /**
     * 教师列表接口
     * @param Request $request
     */
    public function teacherList(Request $request)
    {
        $field = ['name', 'college', 'experience_age', 'work_status', 'headimg_url', 'sex', 'id'];
        $collection = Teacher::where('status', '=', 1)->with('getSubject');
        //姓名模糊查询
        if ($request['name']) $collection = $collection->where('name', 'like', '%' . $request['name'] . '%');
        //教学科目
        if ($request['subject']) {
            $collection = $collection->whereHas('getSubject', function ($query) use ($request) {
                $query->where('subject', '=', $request['subject']);
            });
        }
        //能力和风格排序
        if ($request['style']) $collection = $collection->orderBy($request['style'], 'desc');
        if ($request['ability']) $collection = $collection->orderBy($request['ability'], 'desc');

        $teacher = $collection->get($field);
        $teacher->map(function ($item) {
            $item->experience_age = intval(date('Y', time()) - $item->experience_age) ?: 1;
            return $item;
        });
        if (!$teacher) error_json('教师列表接口');
        success_json($teacher, '教师列表接口');
    }

    /**
     * 教师详情接口
     * @param Request $request
     */
    public function teacherDetail(Request $request)
    {
        if (!$request['id']) error_json('教师详情接口', '教师ID参数缺失');
        $field = ['id', 'name', 'photos', 'voices', 'work_status', 'experience_age', 'college', 'describe', 'particular', 'achievement', 'voices', 'extend', 'logic', 'base', 'habit', 'planning', 'strict', 'interaction', 'humor', 'excellence', 'passion'];
        $teacher = Teacher::where('id', '=', $request['id'])->with('getSubject')->first($field);
        if (!$teacher) error_json('教师详情接口');
        $teacher->experience_age = intval(date('Y', time()) - $teacher->experience_age) ?: 1;
        success_json($teacher, '教师详情接口');

    }

    /**
     * 教师课程表接口
     * @param Request $request
     */
    public function teacherSchedule(Request $request)
    {
        if (!$request['name']) error_json('教师课表接口', '教师姓名参数缺失');
        $field = ['season', 'year', 'type', 'time', 'remark'];
        $season1 = Schedule::where(['teacher_name' => $request['name'], 'status' => 1, 'season' => '春季', 'is_teaching' => '有课'])->get($field)->groupBy('year');
        $season2 = Schedule::where(['teacher_name' => $request['name'], 'status' => 1, 'season' => '暑期', 'is_teaching' => '有课'])->get($field)->groupBy('year');
        $season3 = Schedule::where(['teacher_name' => $request['name'], 'status' => 1, 'season' => '秋季', 'is_teaching' => '有课'])->get($field)->groupBy('year');


        $array = array();
        if ($season1->isNotEmpty()){
            $arr1 = array();
            foreach($season1 as $k=>$v){
                $arr1['title'] =  $v[0]['year'].$v[0]['season'];
                $arr1['season'] =  $v[0]['season'];
                $arr1['schedule'] =  $v->toArray();
            }
            $array[] = $arr1;
        }
        if ($season2->isNotEmpty()){
            if ($season2->isNotEmpty()){
                $arr2 = array();
                foreach($season2 as $k=>$v){
                    $arr2['title'] =  $v[0]['year'].$v[0]['season'];
                    $arr2['season'] =  $v[0]['season'];
                    $arr2['schedule'] =  $v->toArray();
                }
                $array[] = $arr2;
            }
        }
        if ($season3->isNotEmpty()){
            if ($season2->isNotEmpty()){
                $arr3 = array();
                foreach($season3 as $k=>$v){
                    $arr3['title'] =  $v[0]['year'].$v[0]['season'];
                    $arr3['season'] =  $v[0]['season'];
                    $arr3['schedule'] =  $v->toArray();
                }
                $array[] = $arr3;
            }
        }
        if (!$array) error_json('教师课表接口');
        success_json($array, '教师课表接口');
    }

    /**
     * 根据课表筛选老师
     * @param Request $request
     * @return array
     */
    public function selectTeacher(Request $request)
    {
        if (!$request['excel_md5']) error_json('选择教师接口', '课表信息缺失');
        if (!$request['season']) error_json('选择教师接口', '学期信息缺失');
        if (!count($request['campus_array'])) error_json('选择教师接口', '校区信息缺失');
        if (!count($request['time'])) error_json('选择教师接口', '查询时间点缺失');
        //查询非制定校区老师
        $data = array();
        foreach ($request['time'] as $item) {
            $timeArr = $this->getTimeArray($item, $request['season']);
            $array1 = $this->getTeacherArray1($request['excel_md5'], $timeArr);
            $array2 = $this->getTeacherArray2($request['excel_md5'], $item, $timeArr, $request['campus_array']);
            $data[] = array_merge($array1, $array2);
        }
        if (!count($data)) success_json([], '教师查询接口');

        $teacher_array = array();
        foreach ($data as $v) {
            foreach ($v as $item) {
                if (!in_array($item, $teacher_array)) $teacher_array[] = $item;
            }
        }
        $field = ['name', 'college', 'experience_age', 'work_status', 'headimg_url', 'sex', 'id'];
//        $res = Teacher::whereIn('name', $teacher_array)->with('getSubject')->get($field);
        $collection = Teacher::whereIn('name', $teacher_array)->with('getSubject');
        if ($request['style']) $collection = $collection->orderBy($request['style'], 'desc');
        if ($request['ability']) $collection = $collection->orderBy($request['ability'], 'desc');
        $res = $collection->get($field);
        if (!$res) success_json($res, '教师查询接口');
        $res->map(function ($item) {
            $item->experience_age = intval(date('Y', time()) - $item->experience_age) ?: 1;
            return $item;
        });
        success_json($res, '教师查询接口');
    }

    /**
     * 筛选 所选时间段无课 但在指定校区中前后时间段有课的老师
     * @param $excel_md5
     * @param $time
     * @param $timeArr
     * @param $campus_array
     * @return array
     */
    protected function getTeacherArray2($excel_md5, $time, $timeArr, $campus_array)
    {
        $condition = [
            'excel_md5' => $excel_md5,
            'status' => 1,
        ];
        $data = [];
        foreach ($timeArr as $item) {
            $collection = Schedule::where($condition);
            if ($time == $item) {
                $teacher_arr = $collection->where('is_teaching', '=', '无课')->where('time', '=', $item)->get(['teacher_name']);
                $teacher_arr = $teacher_arr->map(function ($item) {
                    $item = $item->teacher_name;
                    return $item;
                });
            } else {
                $teacher_arr = $collection->where('is_teaching', '=', '有课')->where('time', '=', $item)->whereIn('campus_name', $campus_array)->get(['teacher_name']);

                $teacher_arr = $teacher_arr->map(function ($item) {
                    $item = $item->teacher_name;
                    return $item;
                });
            }
            $data[] = $teacher_arr->toArray();
        }

        //选择时间点和前后都无课的老师数组
        foreach ($data as $k => $v) {
            if ($k > 0) $teacher_array2 = $data[$k] = array_intersect($data[$k], $data[$k - 1]);
        }
        return $teacher_array2;
    }


    /**
     * 筛选所有校区中  所选时间段以及前后时间段都无课的老师
     * @param $excel_md5
     * @param $timeArr
     * @return array
     */
    protected function getTeacherArray1($excel_md5, $timeArr)
    {
        $condition = [
            'excel_md5' => $excel_md5,
            'status' => 1,
            'is_teaching' => '无课'
        ];
        $data = [];
        foreach ($timeArr as $item) {
            $collection = Schedule::where($condition);
            $teacher_arr = $collection->where('time', '=', $item)->get(['teacher_name']);
            $teacher_arr = $teacher_arr->map(function ($item) {
                $item = $item->teacher_name;
                return $item;
            });

            $data[] = $teacher_arr->toArray();
        }
        //选择时间点和前后都无课的老师数组
        foreach ($data as $k => $v) {
            if ($k > 0) $teacher_array1 = $data[$k] = array_intersect($data[$k], $data[$k - 1]);
        }
        return $teacher_array1;
    }

    protected function getTimeArray($time, $season)
    {
        $str_arr = explode(',', $time);
        if ($season == '暑期') {
            if ($str_arr[1] == 1) {
                $str_arr[1] = 2;
                $time2 = $str_arr;
                return array($time, implode(',', $time2));
            } elseif ($str_arr[1] == 4) {
                $str_arr[1] = 3;
                $time2 = $str_arr;
                return array($time, implode(',', $time2));
            } else if (1 < $str_arr[1] && $str_arr[1] < 4) {
                $temp = $str_arr;
                $temp[1] = $str_arr[1] - 1;
                $time2 = $temp;
                $temp[1] = $str_arr[1] + 1;
                $time3 = $temp;
                return array(implode(',', $time2), $time, implode(',', $time3));
            } else {
                error_json('教师查询接口', '时间点数据有误');
            }
        } else {
            if ($str_arr[1] == 1) {
                $str_arr[1] = 2;
                $time2 = $str_arr;
                return array($time, implode(',', $time2));
            } elseif ($str_arr[1] == 5) {
                $str_arr[1] = 4;
                $time2 = $str_arr;
                return array($time, implode(',', $time2));
            } else if (1 < $str_arr[1] && $str_arr[1] < 5) {
                $temp = $str_arr;
                $temp[1] = $str_arr[1] - 1;
                $time2 = $temp;
                $temp[1] = $str_arr[1] + 1;
                $time3 = $temp;
                return array(implode(',', $time2), $time, implode(',', $time3));
            } else {
                error_json('教师查询接口', '时间点数据有误');

            }
        }
    }

    /**
     * 计算两个经纬度之间距离
     * @param $from
     * @param $to
     * @param bool $km
     * @param int $decimal
     * @return float
     */
    function get_distance($from, $to, $km = true, $decimal = 2)
    {
        sort($from);
        sort($to);
        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $distance = $EARTH_RADIUS * 2 * asin(sqrt(pow(sin(($from[0] * pi() / 180 - $to[0] * pi() / 180) / 2), 2) + cos($from[0] * pi() / 180) * cos($to[0] * pi() / 180) * pow(sin(($from[1] * pi() / 180 - $to[1] * pi() / 180) / 2), 2))) * 1000;

        if ($km) {
            $distance = $distance / 1000;
        }

        return round($distance, $decimal);
    }

    public function login(Request $request)
    {
        if (!$request['password']) error_json('登录验证', '密码缺失', -1);
        $password = AppPassword::first();
        if (md5($request['password']) != $password->bcrypt_password) error_json('登录验证', '密码不正确', -1);
        $token = md5('vip' . $_SERVER['REQUEST_TIME'] . $request['password']);
        ApiToken::create([
            'token' => $token,
            'expire' => $_SERVER['REQUEST_TIME'] + 3600
        ]);
        success_json($token, '登录验证');
    }
}