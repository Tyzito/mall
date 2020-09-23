<?php


namespace app\admin\business;


use think\Exception;
use app\admin\model\AdminUser as AdminUserModel;

class AdminUser
{
    public static function getAdminUserByUsername($data)
    {
        // 验证用户名
        $adminUser = AdminUserModel::getAdminUserByUsername($data['username']);

        if(empty($adminUser) && $adminUser['status'] != config('status.mysql.table_normal')){
            throw new Exception('用户名不存在');
            //return show(config('status.error'),'用户名不存在');
        }

        $adminUser = $adminUser->toArray();

        // 验证密码
        if($adminUser['password'] != md5($data['password'].'_mall')){
            throw new Exception('密码不正确');
            //return show(config('status.error'),'密码不正确');
        }

        // 保存用户信息
        $resultData = [
            'update_time' => time(),
            'last_login_time' => time(),
            'last_login_ip' => request()->ip(),
        ];

        $res = AdminUserModel::updateById($adminUser['id'], $resultData);
        if(empty($res)){
            throw new Exception('登录失败');
            //return show(config('status.error'),'登录失败');
        }

        // session
        session(config('admin.session_admin'), $adminUser);

        return true;
    }
}