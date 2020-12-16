<?php


namespace App\Models;

class TestModel extends BaseModel
{

    public function getUser($id)
    {
        $result = $this
//            ->setTable('articles')
            ->mtb->where('id', $id)->limit(1)->get()->toArray();
        $result = reset($result);
        return $result;
    }

    public function test1()
    {
        $result = $this->db->select("select * from user limit 1");
        $result = reset($result);
    }

    public function test2()
    {
        $newId = $this->iInsert([
            'name' => 123,
        ]);
    }

    public function test3()
    {
        $affected = $this->mtb->where('id', 1)->update([
            'name' => '哈哈',
        ]);
    }
}