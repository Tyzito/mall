<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/9/24
 * Time: 23:24
 */


namespace app\common\business;

use app\common\model\mysql\Category as CategoryModel;
use think\Exception;

class Category
{
    public $model = null;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function addCategory($data)
    {
        $data['status'] = config('status.mysql.table_normal');

        $isName = $this->model->where('name',$data['name'])->select()->toArray();
        if(!empty($isName)){
            throw new Exception('分类名称已经存在');
        }

        try{
            $this->model->save($data);
        }catch (\Exception $e){
            throw new Exception('服务内部异常');
        }

        return $this->model->id;
    }

    public function getNormalCategorys()
    {
        $field = 'id, pid, name';
        $result = $this->model->getNormalCategorys($field);

        if(!$result){
            return [];
        }

        return $result->toArray();
    }

    public function getList($data, $num)
    {
        $list = $this->model->getLists($data, $num);
        if(!$list){
            return [];
        }

        $result = $list->toArray();
        $result['render'] = $list->render();

        $pids = array_column($result['data'],'id');

        if($pids){
            // 获取子分类的个数
            $idCountResult = $this->model->getChildCountInPids(['pid' => $pids]);

            $idCounts = [];
            foreach ($idCountResult as $countResult){
                $idCounts[$countResult['pid']] = $countResult['count'];
            }
        }

        if($result['data']){
            foreach($result['data'] as $k => $v){
                $result['data'][$k]['childCount'] = $idCounts[$v['id']] ?? 0;
            }
        }

        return $result;
    }

    public function getById($id)
    {
        $res = $this->model->where('id', $id)->find();
        if(!$res){
            return false;
        }

        return true;
    }

    public function listorder($id, $listorder)
    {
        $res = $this->getById($id);

        if(!$res){
            throw new Exception('不存在该记录');
        }

        try{
            $res = $this->model->updateById($id, $listorder);
        }catch (\Exception $e){
            return false;
        }

        return $res;
    }

    public function status($id, $status)
    {
        $res = $this->getById($id);

        if(!$res){
            throw new Exception('不存在该记录');
        }

        try{
            $res = $this->model->updateByStatus($id, $status);
        }catch (\Exception $e){
            return false;
        }

        return $res;
    }
}