<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/9/22
 * Time: 23:01
 */


namespace app\api\controller;

use app\common\business\User as UserBus;
use app\api\validate\User as UserValidate;


class User extends AuthBase
{
    public function index()
    {
        $user = (new UserBus())->getNormalUserById($this->userId);

        $result = [
            'id' => $this->userId,
            'username' => $user->username,
            'sex' => $user->sex,
        ];

        return show(config('status.success'),'OK',$result);
    }

    public function update()
    {
        $username = input('param.username','','trim');
        $sex = input('param.sex','','intval');

        $data = [
            'username' => $username,
            'sex' => $sex,
        ];

        $validate = new UserValidate();
        if(!$validate->scene('update_user')->check($data)){
            return show(config('status.error'),$validate->getError());
        }


        $user = (new UserBus())->update($this->userId, $data);

        if(!$user){
            return show(config('status.error'),'更新失败');
        }

        return show(config('status.success'),'更新成功');
    }
}