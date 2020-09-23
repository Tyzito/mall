<?php


namespace app\common\model\mysql;


use think\Model;

class User extends Model
{
    protected $table = 'mall_user';

    protected $autoWriteTimestamp = true;

    public static function getUserByPhone($phone)
    {
        if(empty($phone)){
            return false;
        }

        return self::where('phone_number',$phone)->find();
    }

    /**
     * @param $id
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getUserById($id)
    {
        $id = intval($id);

        if(!$id){
            return false;
        }

        return self::find($id);
    }

    public static function getUserByUsername($username)
    {
        if(!$username){
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