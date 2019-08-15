<?php
namespace Admin\Controller;

class IndexController extends BaseController {

    public function index(){

      //  $this->assign('all',$this->getAllOrder());

        $this->assign('newer',$this->getNewUser());
        $this->assign('zhichu',$this->getBobi());
        $this->assign('shouru',$this->getshouru());
        $this->assign('shouru1',$this->getshouruday());
        $this->assign('l',$this->getlevelcounts());
        $this->assign('c',$this->c());
        $this->assign('d',$this->d());
        $this->assign('f',$this->f());

        $this->display();

    }







    public function f()
    {
        $map['create_time'] = array('lt',time());
        $map['create_time'] = array('gt',strtotime(date('Y-m-d')));
        $map['status'] = 1;
        $r = M('recharge')->where($map)->count();
        return $r;
    }

    public function bo1 ()
    {
        $map['status'] = 2;
        return M('order')->where($map)->count();
    }

    //今日新增会员


    public function getNewUser()
    {
        $map['create_time'] = array('lt',time());
        $map['create_time'] = array('gt',strtotime(date('Y-m-d')));
        return M('user')->where($map)->count();
    }

    //今日提现
    public function c()
    {
        $map['create_time'] = array('lt',time());
        $map['create_time'] = array('gt',strtotime(date('Y-m-d')));
        $map['status'] = 2;
        $r = M('withdraw')->where($map)->sum('amount');
        return $r;
    }

    //累计提现


    public function d()
    {
        $map['status'] = 2;
        $r = M('withdraw')->where($map)->sum('amount');
        return $r;
    }




    private function getlevelcounts()
    {
//        $map['status'] = 2;
        $map['id'] =array('gt',1);

        $data = M('user')->where($map)->group('level')->field('level,count(*) as c')->select();
        return $data;
    }
    public function getAllUser()
    {

//        $map['status'] = 2;
        $map['id'] =array('gt',1);
        return M('user')->where($map)->count();
    }




    //今日提现充值总额


    public function getWithdrawRec()
    {
        $map['create_time'] = array('lt',time());
        $map['create_time'] = array('gt',strtotime(date('Y-m-d')));
        $map['status'] = 1;
        $arr=array();
        $w = M('withdraw')->where($map)->sum('amount');
        $r = M('recharge')->where($map)->sum('amount');
        $arr['w'] = $w;
        $arr['r'] = $r;
        return $arr;
    }

    public function  getUnactive()
    {
        $map['status'] = 1;
        return M('user')->where($map)->count();
    }
    //总业绩(注册单)
    private function getAllOrder()
    {
        $map['order_type'] = 1;
        $map['status'] = 2;
        $data =  M('order')->where($map)->sum('amount');
        return $data;
    }
    //总拨比 fmoney amount>0

    private function getBobi()
    {
        $map['amount'] = array('gt',0);
        $map['admin_id'] = array('neq',1);
        $data = M('fmoney')->where($map)->sum('amount');
        return $data;
    }

    private function getNews()
    {
        return M('news')->order('create_time desc')->limit(10)->select();
    }


    private function getshouru()
    {
       // $map['order_type'] = 1;
        $map['status'] = 2;
        $data1 =  M('order')->where($map)->sum('amount');
        /*$map['level'] = 4;
        $map['id'] = array('neq',1);
        $level4 = M('user')->where($map)->count();
        $map['level'] = 5;

        $level5 = M('user')->where($map)->count();*/
     //   $map['status'] = 2;
      //  $data2 = M('recharge')->where($map)->sum('amount');

        return $data1;

    }

    private function getshouruday()
    {
        // $map['order_type'] = 1;
        $map['status'] = 2;
        $map['create_time'] = array('between',array(strtotime(date('Y-m-d')),time()));
        $data1 =  M('order')->where($map)->sum('amount');
        return $data1;

    }
}