<?php


namespace app\demo\controller;


use app\BaseController;
use think\exception\HttpException;

class index extends BaseController
{
    public function test()
    {
        return 123;
    }
}