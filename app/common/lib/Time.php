<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/9/20
 * Time: 22:57
 */


namespace app\common\lib;


class Time
{
    public static function getTokenExpireTime($type = 2)
    {
        $type = !in_array($type, [1, 2]) ? 2 : $type;

        // 1-7天，2-30天
        if($type == 1){
            $day = $type * 7;
        }elseif($type == 2){
            $day = $type * 30;
        }

        return $day * 24 * 3600;
    }
}