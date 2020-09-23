<?php
declare(strict_types = 1);

namespace app\api\controller;


use app\api\validate\User;
use app\BaseController;
use think\exception\ValidateException;
use app\common\business\Sms as SmsBus;

class Sms extends BaseController
{
    public static function code():object
    {
        $phoneNumber = request()->param('phone','','trim');

        try{
            validate(User::class)->scene('sendCode')->check(['phone' => $phoneNumber]);
        }catch (ValidateException $e){
            return show(config('status.error'),$e->getError());
        }

        if(SmsBus::sendCode($phoneNumber, 6, 'ali')){
            return show(config('status.success'),'验证码发送成功');
        }

        return show(config('status.error'),'验证码发送失败');
    }
}