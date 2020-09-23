<?php


namespace app\api\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'phone' => 'require',
        'username' => 'require',
        'code' => 'require|number|min:4',
        'type' => 'require|in:1,2',
        'sex' => 'require|in:0,1,2'
    ];

    protected $message = [
        'phone.require' => '手机号不能为空',
        'username.require' => '用户名不能为空',
        'code.require' => '验证码不能为空',
        'code.number' => '验证码必须为数字',
        'code.min' => '验证码长度不得低于4',
        'type.require' => '类型必须',
        'type.in' => '类型数值错误',
        'sex.require' => '性别必须',
        'sex.in' => '性别数值有误',
    ];

    protected $scene = [
        'sendCode' => ['phone'],
        'login' => ['phone', 'code', 'type'],
        'update_user' => ['username','sex'],
    ];
}