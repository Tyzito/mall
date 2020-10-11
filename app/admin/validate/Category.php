<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/9/24
 * Time: 23:20
 */


namespace app\admin\validate;


use think\Validate;

class Category extends Validate
{
    protected $rule = [
        'pid' => 'require',
        'name' => 'require',
    ];

    protected $message = [
        'pid.require' => '分类不能为空',
        'name.require' => '分类名称不能为空'
    ];
}