<?php


namespace app\common\business;

use app\common\lib\Str;
use app\common\lib\Time;
use app\common\model\mysql\User as UserModel;
use think\Exception;

class User
{
    public $userObj = null;
    public function __construct()
    {
        $this->userObj = new UserModel();
    }

    public function login($data)
    {
        $redisCode = cache(config('redis.code_pre').$data['phone']);
        if(empty($redisCode) || $redisCode != $data['code']){
            throw new Exception('不存在该验证码');
        }

        // 查询手机号是否存在数据库中
        $user = UserModel::getUserByPhone($data['phone']);
        if(!$user){
            $username = 'mall_'.$data['phone'];
            $data = [
                'username' => $username,
                'phone_number' => $data['phone'],
                'type' => $data['type'],
                'status' => config('status.mysql.table_normal')
            ];

            try{
                $this->userObj->save($data);
                $userId = $this->userObj->id;
            }catch (Exception $e){
                throw new Exception('数据库内部异常');
            }
        }else{
            $userId = $user->id;
            $username = $user->username;
        }

        $token = Str::getLoginToken($data['phone']);
        $redisData = [
            'id' => $userId,
            'username' => $username
        ];

        $res = cache(config('redis.token_pre').$token, $redisData ,Time::getTokenExpireTime($data['type']));

        return $res ? ['token' => $token, 'username' => $username] : false;
    }

    /**
     * 获取用户信息
     * @param $id
     * @return array|bool|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalUserById($id)
    {
        return UserModel::getUserById($id);
    }

    public function getNormalUserByUsername($username)
    {
        return UserModel::getUserByUsername($username);
    }

    public function update($id, $data)
    {
        // 检查用户是否存在
        $user = $this->getNormalUserById($id);
        if(!$user){
            throw new Exception('不存在该用户');
        }

        // 检查用户名是否存在
        $userResult = $this->getNormalUserByUsername($data['username']);
        if($userResult && $userResult['id'] != $id){
            throw new Exception('该用户已经存在，请重新设置');
        }

        return UserModel::updateById($id, $data);
    }
}