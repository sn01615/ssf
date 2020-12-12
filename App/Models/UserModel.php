<?php


namespace App\Models;


class UserModel extends BaseModel
{

    public function getUser($id)
    {
        $result = $this->mtb->where('id', $id)->limit(1)->get()->toArray();
        return reset($result);
    }
}