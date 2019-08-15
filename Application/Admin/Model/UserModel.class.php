<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6 0006
 * Time: 16:29
 */

namespace Admin\Model;

use Think\Model;

class UserModel extends Model
{
    public function getUserByname($username)
    {
        $map['username'] = $username;
        //$map['level'] = array('gt',1);
        return $this->where($map)->find();
    }

    public function getUsersByname($user_ids)
    {
        $map['username'] = array('in',$user_ids);
        return $this->where($map)->select();
    }

    public function getServiceByName($username){
        $map['username'] = $username;
        $map['is_service'] = 2;
        $map['status'] = 2;
        return $this->where($map)->find();
    }

    public function getUserinfoById($id)
    {
        return $this->find($id);
    }
}