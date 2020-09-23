<?php
declare(strict_types = 1);

namespace app\common\lib;


class Num
{
    public static function getCode(int $len)
    {
        $code = mt_rand(1000, 9999);

        if($len == 6){
            $code = mt_rand(100000, 999999);
        }

        return $code;
    }
}