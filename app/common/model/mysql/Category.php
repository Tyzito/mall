<?php
/**
 * Created by PhpStorm.
 * User: Taidmin
 * Date: 2020/9/26
 * Time: 16:22
 */


namespace app\common\model\mysql;


use think\Model;

class Category extends Model
{
    protected $table = 'mall_category';

    protected $autoWriteTimestamp = true;

    public function getNormalCategorys($field)
    {
        $where = [
            'status' => config('status.mysql.table_normal')
        ];

        $result = $this->field($field)->where($where)->select();

        return $result;
    }

    public function getLists($data, $num)
    {
        $order = [
            "listorder" => "desc",
            'id' => "desc"
        ];

        $result = $this->where('status','<>',config('status.mysql.table_delete'))
            ->where($data)
            ->order($order)
            ->paginate($num);

        return $result;
    }

    public function updateById($id, $listorder)
    {
        $data = [
            'listorder' => $listorder,
            'update_time' => time()
        ];

        return $this->where('id',$id)->save($data);
    }

    public function updateByStatus($id, $status)
    {
        $data = [
            'status' => $status,
            'update_time' => time()
        ];

        return $this->where('id',$id)->save($data);
    }

    public function getChildCountInPids($where)
    {
        $data = $this->field('pid,count(*) as count')
            ->where($where)
            ->where('status','<>',config('status.mysql.table_delete'))
            ->group('pid')
            ->select()
            ->toArray();

        return $data;
    }

}