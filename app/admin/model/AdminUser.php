<?php


namespace app\admin\model;


use think\Model;

class AdminUser extends Model
{
    protected $table = 'mall_admin_user';

    public static function getAdminUserByUsername($username)
    {
        if(empty($username)){
            return false;
        }

        return self::where('username',$username)->find();
    }

    /**
     * 根据Id保存用户信息
     */
    public static function updateById($id, $data)
    {
        if(empty($id) || empty($data) || !is_array($data)){
            return false;
        }

        return self::where('id',$id)->save($data);
    }
}