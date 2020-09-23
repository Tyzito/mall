<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/9/22
 * Time: 22:55
 */


namespace app\api\controller;


use app\BaseController;
use think\exception\HttpResponseException;

/**
 * 不需要登录的控制器继承 ApiBase
 * Class ApiBase
 * @package app\api\controller
 */
class ApiBase extends BaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function show(...$args)
    {
        throw new HttpResponseException(show(...$args));
    }
}