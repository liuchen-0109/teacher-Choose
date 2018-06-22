<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\AppPassword;
class HomeController extends Controller
{
    public function index()
    {
        $password = AppPassword::first();
        return view('/admin/home/index',compact('password'));
    }

    public function weather()
    {
//        $city_data = $this->getCity();
//        $city = $city_data['city'];

        header("Content-type:text/html;charset=utf-8");
        // 百度获取天气情况

        $url = "https://www.sojson.com/open/api/weather/json.shtml?city=郑州";     //获取数据的请求地址
        $result = json_decode($this->getData($url), true);

        echo "<pre>";
        echo "天气预报信息<br/>";
        print_r($result);
        echo "<br/>天气预报信息";
        exit();

    }

    /*
       * 用GET方式获取指定URL的数据
       */
    function getData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }



    function getClientIP()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach ($arr AS $ip) {
                    $ip = trim($ip);
                    if ($ip != 'unknown') {
                        $realip = $ip;
                        break;
                    }
                }
                if(!isset($realip)){
                    $realip = "0.0.0.0";
                }
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                if (isset($_SERVER['REMOTE_ADDR'])) {
                    $realip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $realip = '0.0.0.0';
                }
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
        preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
        $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
        return $realip;
    }
//获取所在城市
    public function getCity()
    {
// 获取当前位置所在城市
        $getIp = $this->getClientIP();
        $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=2TGbi6zzFm5rjYKqPPomh9GBwcgLW5sS&ip={$getIp}&coor=bd09ll");
        $json = json_decode($content);

        $address = $json->{'content'}->{'address'};//按层级关系提取address数据
        $data['address'] = $address;
        $return['province'] = mb_substr($data['address'],0,3,'utf-8');
        $return['city'] = mb_substr($data['address'],3,3,'utf-8');
        return $return;
    }
}
