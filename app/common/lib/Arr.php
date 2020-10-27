<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/10/11
 * Time: 15:01
 */


namespace app\common\lib;


class Arr
{
    /**
     * 获取无限极分类
     * @param $data
     */
    public static function getTree($data)
    {
        $items = [];
        foreach($data as $v){
            $v['category_id'] = $v['id'];
            $items[$v['category_id']] = $v;
            unset($v['category_id']);
        }

        $tree = [];
        foreach ($items as $key => $item){
            //关键是看这个判断,是顶级分类就给$tree,不是的话继续拼凑子分类（结合上述&用法）
            if(isset($items[$item['pid']])){
                $items[$item['pid']]['list'][] = &$items[$key];
            }else{
                $tree[] = &$items[$key];
            }
        }

        return $tree;
    }
}