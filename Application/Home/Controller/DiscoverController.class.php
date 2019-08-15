<?php
namespace Home\Controller;

use Think\Page;
use app\Home\Controller\Base;
use Think\Session\Driver\Db;

class DiscoverController extends BaseController
{
    public function index()
    {
        $this->display();
    }

    /**
     * 云矿池
     */
    public function machine(){

        //购买/升级记录
        $userId = session('User_yctr.id');
        $map['user_id'] =  $userId;
        $map['reward_type'] = array('in','51,56');
        $Data = M('fmoney')->where($map)->order('create_time desc')->select();
        $this->assign('Data',$Data);
        //获取配置参数
        $config=M('reward_config')->find();
        $this->assign('config',$config);
        //会员信息
        $UserInfo = $this->user->find($userId);
        $this->assign('UserInfo',$UserInfo);
        $this->display();

    }

    /**
     * 矿机购买/升级
     */
    public function buyMachine(){
        if(IS_POST){

            //选购的配套等级
            $pt_level = I('pt_level');  //当前会员选购等级

            //系统参数
            $Config = M('reward_config')->where(['id'=>1])->find();

            //会员信息
            $userId = session('User_yctr.id');
            $UserInfo = M('user')->where(['id'=>$userId])->find();

            //判断选购等级是否高于当前自身配套等级（只可升级）
            if($pt_level <= $UserInfo['pt_level']){
                ajax_return(1,'选购配套需高于当前自身配套');
            }

            //判断选购等级与自身现有等级差价
            if($pt_level == 1 && $UserInfo['pt_level'] == 0){
                $Pay = 4700;
              	$Integral = 100/100 * $Config['ptr87'];
                $Content = '购买100USDT配套';
            }elseif($pt_level == 2 && $UserInfo['pt_level'] == 0){
                $Pay = 47000;
                $Integral = 1000/100 * $Config['ptr87'];
                $Content = '购买1000USDT配套';
            }elseif($pt_level == 2 && $UserInfo['pt_level'] == 1) {
                $Pay = 42300;
                $Integral = 1000/100 * $Config['ptr87'];
                $Content = '100USDT奖金配套升级1000USDT奖金配套';
            }
          //elseif($pt_level == 3 && $UserInfo['pt_level'] == 0){
            //    $Pay = 5000;
            //    $Integral = 5000/100 * $Config['ptr87'];
            //    $Content = '购买5000IOTE奖金配套';
            //}elseif($pt_level == 3 && $UserInfo['pt_level'] == 1){
            //    $Pay = 4900;
            //    $Integral = 5000/100 * $Config['ptr87'];
            //    $Content = '100IOTE奖金配套升级5000IOTE奖金配套';
            //}elseif($pt_level == 3 && $UserInfo['pt_level'] == 2){
            //    $Pay = 4000;
            //    $Integral = 5000/100 * $Config['ptr87'];
            //    $Content = '1000IOTE奖金配套升级5000IOTE奖金配套';
            //}elseif($pt_level == 4 && $UserInfo['pt_level'] == 0){
            //    $Pay = 10000;
            //    $Integral = 10000/100 * $Config['ptr87'];
            //    $Content = '购买10000IOTE奖金配套';
            //}elseif($pt_level == 4 && $UserInfo['pt_level'] == 1){
            //    $Pay = 9900;
            //    $Integral = 10000/100 * $Config['ptr87'];
            //    $Content = '100IOTE奖金配套升级10000IOTE奖金配套';
            //}elseif($pt_level == 4 && $UserInfo['pt_level'] == 2){
            //    $Pay = 9000;
            //    $Integral = 10000/100 * $Config['ptr87'];
            //    $Content = '1000IOTE奖金配套升级10000IOTE奖金配套';
            //}elseif($pt_level == 4 && $UserInfo['pt_level'] == 3){
            //    $Pay = 5000;
            //    $Integral = 10000/100 * $Config['ptr87'];
            //    $Content = '5000IOTE奖金配套升级10000IOTE奖金配套';
            //}

            //判断余额是否足够
            //if($Pay > $UserInfo['z10']){
              //  ajax_return(1,'IOTE奖金余额不足，需'.$Pay.'IOTE奖金,当前剩余'.$UserInfo['z10'].'IOTE奖金');
            //}

            //$UserSave['z10'] = $UserInfo['z10'] - $Pay;   //扣除余额
            $UserSave['pt_level'] = $pt_level;
            $UserSave['z6'] = $Integral;
          	$UserSave['is_open'] = 0;
          	$UserSave['old_pt_level'] = $UserInfo['pt_level'];
          	$UserSave['old_z6'] = $UserInfo['z6'];
            if (M('user')->where(['id'=>$UserInfo['id']])->save($UserSave)){
                $this->add_fmoney($UserInfo['id'],$UserInfo['id'],$Pay,10,'51',$Content);
//                if($UserInfo['pt_flag'] < 1){
//                    $db = M();
//                    $aa = $db->execute("call jiangjin_13()");   //直推奖
//                }
                if($UserInfo['pt_level'] > 0){
                    ajax_return(0,'升级成功');
                }else{
                    ajax_return(0,'购买成功');
                }
            }else{
                ajax_return(1,'系统错误，请重试');
            }

        }
    }

    /**
     * 我的矿机信息及收益
     */
    public function myMachine(){
        //会员信息
        $userId = session('User_yctr.id');
        $UserInfo = M('user')->where(['id'=>$userId])->find();
        $this->assign('UserInfo',$UserInfo);

        //最后一条矿机购买记录
        $Info = M('fmoney')->where(['user_id'=>$userId,'reward_type'=>'51'])->order('create_time desc')->find();
        $Day = (time() - $Info['create_time']) / (24 * 60 * 60);  //矿机已购买天数
        $this->assign('Day',$Day);

        if(IS_POST){
            //收益记录
            $Page = I('post.page');

            $Begin = $Page * 10 + 1;
            $End = $Page * 20;
            $map['user_id'] =  $userId;
            $map['reward_type'] =  array('in','52,53,54,55');
            $Data = M('fmoney')->where($map)->order('create_time desc')->limit($Begin. ',' . $End)->select();
            foreach ($Data as $k=>$v){
                $Data[$k]['create_time'] = date('Y-m-d H:i:s',$Data[$k]['create_time']);
            }
            ajax_return(0,'升级成功',$Data);
        }

        $map['user_id'] =  $userId;
        $map['reward_type'] =  array('in','52,53,54,55');
        $Data = M('fmoney')->where($map)->order('create_time desc')->limit(20)->select();

        $this->assign('Data',$Data);

        $this->display();
    }



    /**
     * 矿机激活
     */
    public function MachineOpen(){
        if(IS_POST){
            //会员信息
            $userId = session('User_yctr.id');
            $UserInfo = M('user')->where(['id'=>$userId])->find();
            if($UserInfo['is_open'] == 1){
                ajax_return(1,'矿机已激活，请勿重复操作');
            }

            if(M('user')->where(['id'=>$userId])->save(['is_open'=>1])){
                $db = M();
                $aa = $db->execute("call jiangjin_13()");   //直推奖
                ajax_return(0,'激活成功');
            }else{
                ajax_return(1,'激活失败，请重试');
            }
        }
    }

    /**
     * 退本操作
     */
    public function backMachine(){
        if(IS_POST){
            $ptLevel = I('pt_level');   //配套等级
            $status = I('status');  //状态

            //会员信息
            $userId = session('User_yctr.id');
            $UserInfo = M('user')->where(['id'=>$userId])->find();

            //系统参数
            $Config = M('reward_config')->where(['id'=>1])->find();


            if($status == 1){   //状态为1时 配套够买未达30天 需要扣除所产生的奖金和10%手续费
                $map['from_id'] = $userId;
                $map['reward_type'] = array('in','52,53,54');
                $map['flag3'] = 0;
                $sum = M('fmoney')->where($map)->sum('amount');
                $Free = $UserInfo['z6'] * 0.1;
                $USDT = ($UserInfo['z6']- $Free - $sum) / $Config['ptr87'];    //冻结积分转换成USDT
            }elseif($status == 2){ //状态为2时 配套够买达30天 直接返还本金
                $USDT = $UserInfo['z6'] / $Config['ptr87']; //冻结积分转换成USDT
            }
            $UserSave['z8'] = $UserInfo['z8'] + $USDT;
            $UserSave['z6'] = 0;
            $UserSave['pt_level'] = 0;
            $UserSave['pt_flag'] = 0;
            $UserSave['team_level'] = 0;

            if(M('user')->where(['id'=>$userId])->save($UserSave)){
                M('fmoney')->where(['user_id'=>$userId])->save(['flag3'=>1]);
                $this->add_fmoney($userId,$userId,$USDT,'8','56','配套退本');
                ajax_return(0,'退本成功');
            }else{
                ajax_return(1,'系统错误，请重试');
            }
        }
    }
}