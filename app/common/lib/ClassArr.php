<?php


namespace app\common\lib;


class ClassArr
{
    public static function smsClassStat()
    {
        return [
            'ali' => 'app\common\lib\sms\AliSms',
            'baidu' => 'app\common\lib\sms\BaiduSms',
            'jd' => 'app\common\lib\sms\JdSms',
        ];
    }

    public static function initClass($type, $class, $params = [], $needInstance = false)
    {
        // 如果我们工厂模式调用方法是静态的，那么我们这个地方返回类库 AliSms
        // 如果不是静态的，那么就需要返回 对象
        if(!array_key_exists($type, $class)){
            return false;
        }

        $className = $class[$type];

        return $needInstance == true ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
    }
}