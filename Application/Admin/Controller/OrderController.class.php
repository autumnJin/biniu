<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6 0006
 * Time: 16:27
 */

namespace Admin\Controller;



use Admin\Model\OrderModel;
use Think\Page;

class OrderController extends BaseController
{

    protected $order;
    public function __construct()
    {
        parent::__construct();
        $this->order =  new OrderModel();
    }
    //


    public function iii()
    {
        $map1['level'] = 1;
        $data = M('user')->where($map1)->select();
        $arr = [];
        foreach ($data as $k => $v){
            $map['admin_id'] = $v['id'];
            if((M('tj')->where($map)->find()) || (M('tj')->where($map)->count() == 1)){
                $arr[] = $v['id'].'___'.$v['username'].'___'.$v['higher_id'];
            }

        }

        dump($arr);
    }

    public function orderlist()
    {
        $username = I('get.username');
        $status = I('get.status');
        $param = I('get.');
        if ($param['start_time'] && !$param['end_time']) {
            $map['o.time_end'] = array('gt', strtotime($param['start_time']));
            $this->assign('start_time',$param['start_time']);
        }
        if ($param['end_time'] && !$param['start_time']) {
            $map['o.time_end'] = array('lt', strtotime($param['end_time']));
            $this->assign('end_time',$param['end_time']);
        }

        if ($param['start_time'] && $param['end_time']) {
            $map['o.time_end'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
            $this->assign('start_time',$param['start_time']);
            $this->assign('end_time',$param['end_time']);
        }
        if($username){
            $where['username'] = $username;
            $user = M('user')->where($where)->find();
            $map['user_id'] = $user['id'];
            $this->assign('username',$param['username']);
        }

        if($status){
            $map['o.status'] = $status;
            $this->assign('status',$param['status']);
        }


        if($param['shopname']){
            $s= D('user')->getUsersByname($param['shopname']);
            $map['o.shop_id'] = $s['id'];
            $this->assign('shopname',$param['shopname']);
        }


        if($param['wuliu_status']){
            $map['o.wuliu_status'] = $param['wuliu_status'];
            $this->assign('wuliu_status',$param['wuliu_status']);
        }

        if($param['phone']){
            $map['o.phone'] =$param['phone'];
            $this->assign('phone',$param['phone']);
        }

        if($param['order_id']){
            $map['o.order_id'] = $param['order_id'];
            $this->assign('order_id',$param['order_id']);
        }

        //$map['order_type'] = 1;
        $join = 'left join '.C('DB_PREFIX').'user as u on u.id = o.user_id';
        $count = $this->order->alias('o')->join($join)->where($map)->count();
        $page = new Page($count,20,$map);
        $show = $page->show();
        $list = $this->order->alias('o')->join($join)->where($map)->order('o.create_time desc')->limit($page->firstRow.','.$page->listRows)->field('o.*,u.username,u.service_id')->select();
        $u =M('user');
        foreach ($list as $k => $v)
        {
            $s  = $u->find($v['shop_id']);
            $list[$k]['shop_id'] = $s['username'];
        }
        $this->assign('count',$count);
        $this->assign('page',$show);
        $this->assign('data',$list);
        $this->display();
    }


    public function edit_order()
    {
        if(IS_POST){
            if(I('post.is_sign'))
            {
                $map['is_sign'] = I('post.is_sign');
            } else {
                $map['wuliu_status'] = 5;
                $map['wuliu'] = I('post.wuliu');
                $map['wuliu_company'] = I('post.wuliu_company');
            }
            $where['id'] = I('post.id');

            if($this->order->where($where)->save($map) === false){
                ajax_return(1,'订单状态异常');
            }

            //确认发货后计算业绩
//            $order_info = $this->order->where(array('id'=>$where['id']))->find();
//            $db = M();
//            $a = $order_info['user_id'];
//            $e = $order_info['amount'];
            // $db->execute("call kt001($a,$e)"); //以订单金额为业绩

            ajax_return(0,'保存成功',U('orderlist'));

        }else{
            $this->assign('title','订单处理');
            $order_info = $this->order->where('id = '.I('get.id'))->find();

            if($order_info){
                if($order_info['goods_id']){
                    $goods_info = M('goods')->find($order_info['goods_id']);
                    $goods_info['num'] = $order_info['num'];

                    $t[] = $goods_info;

                    $goods_info = $t;
                }
                else{
                    $map['order_id'] = $order_info['id'];
                    $d = M('suborder')->where($map)->field('goods_id,num')->select();

                    foreach ($d as $k => $v)
                    {
                        $goods_info[$k] = M('goods')->find($v['goods_id']);
                        $goods_info[$k]['num'] = $v['num'];
                    }
                }

                $this->assign('goods_info',$goods_info);
                $user_info = M('user')->where('id = '.$order_info['user_id'])->find();
                $this->assign('user_info',$user_info);

            }
            $this->assign('order_info',$order_info);

            $this->display();
        }
    }


    public function exportOrder()
    {



        $param = I('get.');

        if ($param['start_time'] && !$param['end_time']) {
            $map1['o.create_time'] = array('gt', strtotime($param['start_time']));
            $this->assign('start_time',$param['start_time']);
        }
        if ($param['end_time'] && !$param['start_time']) {
            $map1['o.create_time'] = array('lt', strtotime($param['end_time']));
            $this->assign('end_time',$param['end_time']);

        }

        if ($param['start_time'] && $param['end_time']) {
            $map1['o.create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
            $this->assign('start_time',$param['start_time']);
            $this->assign('end_time',$param['end_time']);



        }

        $xlsName = 'Order';
        $xlsCell = array(
            array('order_id','订单编号'),
            array('username','会员编号'),
            array('amount','订单金额'),
            ['status','订单付款状态'],

            array('create_time','时间'),
            ['goodslist','商品信息'],
            ['receiver','收货人'],
            ['phone','联系方式'],
            ['address','收货地址'],
            ['num','数量'],

        );


        if($param['status']){
            $map1['o.status']= $param['status'];
            $this->assign('status',$param['status']);

        }
        if($param['username']){
            $map1['u.username']= $param['username'];
            $this->assign('username',$param['username']);
        }

        if($param['wuliu_status']){
            $map['o.wuliu_status'] = $param['wuliu_status'];
            $this->assign('wuliu_status',$param['wuliu_status']);
        }

        $join = 'left join '.C('DB_PREFIX').'user as u on u.id = o.user_id';
        $data = M('order')->alias('o')->join($join)->where($map1)->field('order_id,username,amount,o.create_time,o.receiver,o.phone,o.address,o.shop_id,o.num,o.id,o.goods_id,o.status')->order('create_time desc')->select();
        $user = M('user');
        $goods = M('goods');
        $suborder = M('suborder');
        $format = C('FORMAT');
        // dump($data);die;
        foreach ($data as $k =>$v){
            $data[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            $shop = $user->find($v['shop_id']);
            $data[$k]['shop'] = "\t".$shop['username']."\t";
            $data[$k]['order_id'] = "\t".$v['order_id']."\t";
            $data[$k]['phone'] = "\t".$v['phone']."\t";
            $data[$k]['status'] = $v['status'] == 1?'待付款':'已付款';
            $str ='';
            if($v['goods_id']){
                $god1 = $goods->find($v['goods_id']);
                $str='商品名称:'.$god1['name'].'数量:X'.$v['num'].'规格:'.$format[$god1['format']].'----';

            }else{
                $map['order_id'] = $v['id'];
                $suborderinfo  = $suborder->where($map)->select();
                foreach ($suborderinfo as $k1 => $v1)
                {
                    $god2 = $goods->find($v1['goods_id']);
                    $str='商品名称:'.$god2['name'].'数量:X'.$v1['num'].'规格:'.$format[$god2['format']].'----';
                }
            }

            $data[$k]['goodslist'] =$str;
        }

        // dump($data);die;

        if($data){
            exportExcel('order',$xlsCell,$data);
        }else{

        }
    }


    public function deleteOrder()
    {
        if(IS_POST){

            $orderinfo = M('order')->find(I('post.id'));

            if(!M('order')->delete(I('post.id'))){
                ajax_return(1,'删除失败');
            }

//            M('user')->where(array('id'=>$orderinfo['user_id']))->setInc('z4',$orderinfo['amount']);
//            $this->add_log($orderinfo['user_id'],$orderinfo['amount'],4,'订单退款',4,'+');


            ajax_return(0,'删除成功');
        }
    }


    public function cancelOrder()
    {
        if(IS_POST){
            $OrderInfo = M('order')->find(I('post.id'));
            $UserInfo = M('user')->where(['id'=>$OrderInfo['user_id']])->find();
            if($OrderInfo['pay_type'] == 5){
                $UserSave['z5'] = $UserInfo['z5'] + $OrderInfo['pay_amount'];
            }

            if($OrderInfo['pay_type'] == 6){
                $UserSave['z10'] = $UserInfo['z10'] + $OrderInfo['pay_amount'];
            }

            if(!M('order')->where(['id'=>$OrderInfo['id']])->save(['status'=>1])){
                ajax_return(1,'取消失败');
            }

            M('user')->where(array('id'=>$UserInfo['id']))->save($UserSave);
//            $this->add_log($orderinfo['user_id'],$orderinfo['amount'],4,'订单退款',4,'+');

            ajax_return(0,'订单已取消');
        }
    }

    public function test()
    {
        include 'smsapi.fun.php';
        $uid = 'tianrui';
        $pwd = 'b167d0f2f913b8843a491ce9d02bfaf5';
        $mobile  = I('mobile');
        $mobile  = 13004488228;
        //  $code = randNumber();
        $code = 4444;
//       $data['tel'] = $mobile;
//        $data['code'] = $code;
//        M('msg_list')->add($data);
//
        $content = '【尚品惠】您的验证码是'.$code.',请于5分钟之内在注册页面中输入，如非本人，请勿理会，谢谢。';
        $content1=urlencode(mb_convert_encoding($content ,"gb2312","UTF-8"));
        $res = sendSMS($uid,$pwd,$mobile,$content1);
        ajax_return(1,'xxx',$res);
        $this->ajaxReturn('发送成功,请查看手机'.$res);
    }

}