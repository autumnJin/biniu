<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6 0006
 * Time: 16:29
 */

namespace Admin\Model;

use Think\Model;

class MenuModel extends Model
{
    public function menu_auth_list()
    {
        $p_menus =  $this->getParentMenu();
        foreach ($p_menus as $k => $v)
        {
//            $c_menus = $this->where(array('parent_id'=>$v['id'],'is_show'=>1))->select();
            $c_menus = $this->where(array('parent_id'=>$v['id'],'is_show'=>['in',[1,3]]))->select();
            $p_menus[$k]['children_menu'] =$c_menus;
        }
        return $p_menus;
    }

    public function getMenulist()
    {
        return $this->select();
    }

    public function getParentMenu()
    {
        return $this->where(array('parent_id'=>0,'is_show'=>1))->select();
    }


    public function getMenusByPms($permission)
    {
        $where['parent_id'] = 0;
        $where['id'] = array('in',$permission);
        $where['is_show'] = 1;
        $p_menus = $this->order('sort desc')->where($where)->select();
        foreach ($p_menus as $k=> $v)
        {
            $c_menus = $this->where(array('parent_id'=>$v['id'],'is_show'=>1,'id'=>array('in',$permission)))->select();
            if(empty($c_menus)){
                        unset($p_menus[$k]);
            }else{
                $p_menus[$k]['children_menu'] =$c_menus;
            }
        }

        return $p_menus;
//        foreach ($p_menus as $k => $v)
//        {
//            if(in_array($v['id'],$permission) && isset($v['children_menu']) && !empty($v['children_menu'])){
//                    $data[]=$v;
//            }
//        }
//        return $data;

    }
}