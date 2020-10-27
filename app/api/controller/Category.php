<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/10/11
 * Time: 14:57
 */


namespace app\api\controller;

use app\common\business\Category as CategoryBus;
use app\common\lib\Arr;
use think\facade\Cache;
use app\common\lib\Snowflake;

class Category extends ApiBase
{
    // 获取所有分类的内容
    public function index()
    {

        $workId = rand(1, 1023);
        $orderId = Snowflake::getInstance()->setWorkId($workId)->nextId();
        dd($orderId);


        $res = [
            'title' => 'zhangsan',
            'num' => 1,
            'image' => 'xxx'
        ];
        $userId = 20;

        $get = Cache::hget('mall_cart_'.$userId, 110);
        if($get){
            $get = json_decode($get,true);
            $res['num'] = $res['num'] + $get['num'];
        }

        Cache::hset('mall_cart_'.$userId, 116, json_encode($res));

        Cache::hDel('mall_cart_'.$userId, 100);

        $getAll = Cache::hgetAll('mall_cart_'.$userId);

        $count = Cache::hLen('mall_cart_'.$userId);

        dump($count);
        dd($getAll);

        $categoryObj = (new CategoryBus())->getNormalCategorys();
        $result = Arr::getTree($categoryObj);

        return show(config('status.success'),'ok',$result);
    }
}