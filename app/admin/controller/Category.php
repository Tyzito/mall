<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/9/24
 * Time: 22:50
 */
namespace app\admin\controller;

use think\Exception;
use think\facade\View;
use app\common\business\Category as CategoryBus;
use app\common\lib\Status as StatusLib;

class Category extends AdminBase
{
    public function index()
    {
        $pid = input('param.pid', 0, 'intval');

        $data = [
            'pid' => $pid
        ];

        try{
            $categorys = (new CategoryBus())->getList($data, 3);
        }catch (\Exception $e){
            $categorys = [];
        }

        return View::fetch('',[
            'categorys' => $categorys,
            'pid' => $pid
        ]);
    }

    public function add()
    {
        $categorys = (new CategoryBus())->getNormalCategorys();

        return View::fetch('',[
            'categorys' => json_encode($categorys)
        ]);
    }

    public function save()
    {

        $pid = input('param.pid','','intval');
        $name = input('param.name','','trim');

        $data = [
            'pid' => $pid,
            'name' => $name
        ];

        $validate = new \app\admin\validate\Category();
        if(!$validate->check($data)){
            return show(config('status.error'),$validate->getError());
        }

        try{
            $result = (new CategoryBus())->addCategory($data);
        }catch (Exception $e){
            return show(config('status.error'),$e->getMessage());
        }

        if(!$result){
            return show(config('status.error'),'添加失败');
        }

        return show(config('status.success'),'添加成功');

    }

    public function listorder()
    {
        $id = input('param.id', 0 ,'intval');
        $listorder = input('param.listorder', 0, 'intval');

        if(!$id){
            return show(config('status.error'),'参数错误');
        }

        try {
            $res = (new CategoryBus())->listorder($id, $listorder);
        }catch (\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }

        if(!$res){
            return show(config('status.error'), '排序失败');
        }

        return show(config('status.success'), '排序成功');
    }

    public function status()
    {
        $id = input('param.id', 0 ,'intval');
        $status = input('param.status', 0, 'intval');

        if(!$id){
            return show(config('status.error'),'参数错误');
        }

        if(!in_array($status, StatusLib::getTableStatus())){
            return show(config('status.error'),'状态不合法');
        }

        try {
            $res = (new CategoryBus())->status($id, $status);
        }catch (\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }

        if(!$res){
            return show(config('status.error'), '更改状态失败');
        }

        return show(config('status.success'), '更改状态成功');
    }
}