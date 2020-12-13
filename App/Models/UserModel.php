<?php


namespace App\Models;


class UserModel extends BaseModel
{

    public function getUser($id)
    {
        return $this->setTable('articles')->mtb->where('id', $id)->limit(1)->get()->toArray();
    }
}