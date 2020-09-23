<?php


namespace app\admin\controller;


use app\BaseController;
use think\exception\HttpResponseException;

class AdminBase extends BaseController
{
    public $adminUser = null;

    public function initialize()
    {
        parent::initialize();

        // 转为中间件处理
        /*if(!$this->isLogin()){
            return $this->redirect(url('login/index'));
        }*/
    }

    public function isLogin()
    {
        $this->adminUser = session(config('admin.session_admin'));
        if(empty($this->adminUser)){
            return false;
        }

        return true;
    }

    // 解决构造方法中无法使用redirect()重定向问题，可以在AdminBase控制器下重写重定向方法
    public function redirect(...$args)
    {
        throw new HttpResponseException(redirect(...$args));
    }
}