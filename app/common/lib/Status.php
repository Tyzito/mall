<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/9/26
 * Time: 23:19
 */


namespace app\common\lib;


class Status
{
    public static function getTableStatus()
    {
        $status = config('status.mysql');

        return array_values($status);
    }
}