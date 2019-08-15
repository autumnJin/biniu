<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/16 0016
 * Time: 9:30
 * 报单中心类
 */


namespace Admin\Controller;

class ServiceController extends  BaseController
{
    public function serviceList()
    {
//        $where['u.id'] = array('gt',1);
//        $where['u.status'] = 2;
//        $join ='left join '.C('DB_PREFIX').'user as u on u.id = s.user_id';
//        $data = M('Service')->alias('s')->join($join)->where($where)->field('u.*,s.status')->select();
//        $this->assign('data',$data);


        $map['is_service'] = 2;
        $map['id'] = array('gt',1);
        $data = M('user')->where($map)->select();
        $this->assign('title','已开通报单中心');
        $this->assign('data',$data);
        $this->display();
    }

    public function getTrueName()
    {
        if(IS_POST)
        {
            if($username = I('post.username')){
                $map['username'] = $username;
                $data = M('user')->where($map)->getField('truename');
                ajax_return(0,'',$data);
            }else{
                //  ajax_return(1,'获取失败',M()->getLastSql());
            }
        }
    }


    public function unServiceList()
    {
        $where['u.id'] = array('gt',1);
        $where['s.status'] = 1;
        $join ='left join '.C('DB_PREFIX').'user as u on u.id = s.user_id';
        $data = M('Service')->alias('s')->join($join)->where($where)->field('u.*,s.status')->select();
        $this->assign('title','未开通报单中心');
        $this->assign('data',$data);
        $this->display('serviceList');
    }
    //添加报单中心
    public function addService()
    {
        $this->assign('title','报单中心添加');
        $this->display();
    }



    //修改报单中心

    public function editService()
    {
//        $province = M('province')->select();
//        $this->assign('p',$province);
        $this->assign('title','商家设置');
        $this->assign('data',M('User')->find(I('get.id')));
        $this->display('addService');
    }


    //添加修改


    public function add_edit_service()
    {
        $param = I('post.');
        $service = M('service');
        if($param['id']){
//            $map['user_id'] = $param['id'];
//            if($service->where($map)->find()){
//                $map1['status'] = $param['is_service'];
//                if($service->where($map)->save($map1) === false){
//                    ajax_return(1,'修改失败001');
//                }
//            }


//            if($param['daili_level']){
//                if(!$param['province'] || !$param['city'] || !$param['area']){
//                    ajax_return(1,'请选择代理区域');
//                }
//            }
            if(!$id = M('shop')->add($param)){
                ajax_return(1,'注册失败');
            }

            $param['level'] = 4;


            if(M('user')->save($param) === false){
                ajax_return(1,'修改失败');
            }
        }

        ajax_return(0,'保存成功',U('User/userList'));
    }



    public function add_daili()
    {
        if(IS_POST){
            $param = I('post.');
            $user = M('user');
            $map['username'] = $param['username'];
            if(!$info = $user->where($map)->find()){
                ajax_return(1,'该用户不存在');
            }

            if($param['daili_level'] != 9){
                if(!$param['province'] || !$param['city'] || !$param['area']){
                    ajax_return(1,'请选择代理区域');
                }
            }


            $param['truename'] = $info['truename'];
            $param['phone'] = $info['phone'];
            $param['user_id'] =  $info['id'];
            $address = $this->explode_address($param['province'],$param['city'],$param['area']);
            $param['p_name'] = $address[0];
            $param['c_name'] = $address[1];
            $param['a_name'] = $address[2];
            $param['create_time'] = time();

            if(!M('daili')->add($param)){
                ajax_return(1,'新增失败');
            }

            $amount = 0;
            switch ($param['daili_level']){
                case 5:
                    $amount =  30000;
                    break;
                case 6:
                    $amount = 100000;
                    break;
                case 7:
                    $amount = 500000;
                    break;
                case 8:
                    $amount = 1000000;
                    break;

            }


            $save['level'] = $param['daili_level'];
            $save['id'] = $info['id'];
            $save['z2'] = $info['z2'] + $amount;
            $user->save($save);
                $this->add_log($info['id'],$amount,2,'升级合伙人奖励','+');
//            if($param['is_service'] == 2){
//                $save['is_service'] = 2;
//                $save['id'] = $info['id'];
//                $user->save($save);
//            }

            ajax_return(0,'新增成功',U('daililist'));






        }else{

            $info = M('user')->find(I('get.id'));
            $this->assign('info',$info);
            $province = M('province')->select();
            $this->assign('p',$province);
            $this->assign('title','新增合伙人');
            $this->display();
        }
    }


    protected function add_log($user_id,$amount=0,$type,$tips,$flag='+')
    {
        $map['user_id'] = $user_id;
        $map['amount'] = $amount;
        $map['type'] = $type;
        $map['create_time'] = time();

        // $map['account'] = $account;
        $map['flag'] = $flag;

        $dd = M('user')->find($map['user_id']);
        $type = 'z'.$type;
        $map['tips'] = $tips;
        return M('money_detail')->add($map);
    }

    public function explode_address($p,$c,$a){

        $provinceid = M('province')->where('provinceid = "'.$p.'"')->find();
        $city = M('city')->where('cityid = "'.$c.'"')->find();
        $area = M('area')->where('areaid = "'.$a.'"')->find();
        $arr[] = $provinceid['province'];
        $arr[] = $city['city'];
        $arr[] = $area['area'];
        return $arr;

    }

    public function daililist()
    {
        $param  = I('get.');
        $map=[];
        if($param['daili_level']){
            $map['daili_level'] = $param['daili_level'];
        }


        if($param['c']){
            $map['city'] = $param['c'];
        }
        if($param['a']){
            $map['area'] = $param['a'];
        }

        $map['level'] = array('gt',2);

        $data = M('user')->where($map)->order('create_time desc')->select();
        $this->assign('data',$data);
        $this->assign('title','代理统计');
        $province = M('province')->select();
        $this->assign('p',$province);
        $this->display();
    }

    public function dongjie()
    {
        if(IS_POST){
            $param=I('post.');
            $data = M('daili')->find($param['id']);

            $save['id'] =$data['id'];
            $save['status']=  $data['status'] == 1? 2:1;
            if(M('daili')->save($save) === false){
                ajax_return(1,'操作失败');
            }

            ajax_return(0,'操作成功',U('daililist'));
        }
    }

}
