<?php
declare(strict_types = 1);

namespace app\common\business;

use app\common\lib\ClassArr;
use app\common\lib\sms\AliSms;
use app\common\lib\Num;

class Sms
{
    public static function sendCode(string $phoneNumber, int $len = 4, string $type = 'ali'):bool
    {
        $code = Num::getCode($len);

        /*$class = 'app\\common\\lib\sms\\'.ucfirst($type).'Sms';
        $sms = $class::sendCode($phoneNumber, $code);*/

        $classStats = ClassArr::smsClassStat();
        $classObj = ClassArr::initClass($type, $classStats);
        $sms = $classObj::sendCode($phoneNumber, $code);

        if($sms){
            // 如果成功，把短信验证码存入redis,并且给失效时间
            cache(config('redis.code_pre').$phoneNumber, $code, config('redis.code_expire'));
        }

        return $sms;
    }
}