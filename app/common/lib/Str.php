<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/9/20
 * Time: 22:29
 */


namespace app\common\lib;


class Str
{
    // 生成 Token
    public static function getLoginToken($string)
    {
        $str = md5(uniqid(md5(microtime(true)),true));
        $token = sha1($str.$string); // 加密

        return $token;
    }
}