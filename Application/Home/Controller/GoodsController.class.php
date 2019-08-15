<?php
namespace Home\Controller;
use Think\Page;

class GoodsController extends BaseController {

    /**
     * 产品列表
     */
    public function GoodsLists()
    {
        $Where['status'] = 1;
        $GoodsLists = M('goods')->where($Where)->order('sort desc')->select();
        foreach ($GoodsLists as $k=>$v){
            $LogoInfo =  M('goods_img')->where(['goods_id'=>$GoodsLists[$k]['id'],'type'=>1])->find();
            $GoodsLists[$k]['logo'] = $LogoInfo['path'];
        }
        $this->assign('GoodsLists',$GoodsLists);

        $this->display();
    }


    /**
     * 产品详情
     */
    public function GoodsDetail()
    {
        //产品编号
        $GoodsID = I('get.id');

        //产品信息
        $GoodsInfo = M('goods')->where(['id'=>$GoodsID])->find();
        $this->assign('GoodsInfo',$GoodsInfo);

        //产品相册
        $Photo_1 = M('goods_img')->where(['goods_id'=>$GoodsInfo['id'],'type'=>2])->find();
        $Photo_2 = M('goods_img')->where(['goods_id'=>$GoodsInfo['id'],'type'=>3])->find();
        $Photo_3 = M('goods_img')->where(['goods_id'=>$GoodsInfo['id'],'type'=>4])->find();
        $Str =  $Photo_1['path'].','. $Photo_2['path'].','.$Photo_3['path'];
        $Photo = explode(',',$Str);
        $this->assign('Photo',$Photo);

        $this->display();
    }


    /**
     * 创建订单
     */
    public  function MakeOrder(){
        //Post请求
        if(IS_POST){
            $Data = I('post.');

            //产品信息
            $GoodsInfo = M('goods')->where(['id'=>$Data['goods_id']])->find();
            if(empty($GoodsInfo)){
                $this->ajaxreturn(array('code' => 0, 'message' => '商品不存在！'));
            }

            //地址信息
            $Address = M('address')->where(['id'=>$Data['address_id']])->find();
            if(empty($Address)){
                $this->ajaxreturn(array('code' => 0, 'message' => '请完善地址信息！'));
            }

            if($Address['wallet_address'] == ""){
                $this->ajaxreturn(array('code' => 0, 'message' => '请完善钱包地址！！'));
            }

            $Order_id = getOrderNum();
            $OrderAdd['order_id'] = $Order_id;
            $OrderAdd['goods_id'] = $GoodsInfo['id'];
            $OrderAdd['user_id'] = $this->user_info['id'];
            $OrderAdd['amount'] = $GoodsInfo['price'] * $Data['num'];
            $OrderAdd['pay_amount'] = $OrderAdd['amount'];
            $OrderAdd['num'] = $Data['num'];
            $OrderAdd['create_time'] = time();
            $OrderAdd['address'] = $Address['address'];
            $OrderAdd['area_id'] = $Address['area'];
            $OrderAdd['receiver'] = $Address['receiver'];
            $OrderAdd['phone'] = $Address['phone'];
            $OrderAdd['tips'] = $Data['tips'];
            $OrderAdd['is_recomd'] = 1;
            $OrderAdd['is_td'] = 1;
            $OrderAdd['is_js'] = 1;
            $OrderAdd['is_up'] = 1;
            $OrderAdd['wallet_address'] = $Address['wallet_address'];

            if(M('order')->add($OrderAdd)){
                $this->ajaxreturn(array('code' => 1, 'message' => '订单创建成功！','order_id'=>$Order_id));
            }else{
                $this->ajaxreturn(array('code' => 0, 'message' => '系统错误，请重试！'));
            }
        }

        //产品信息
        $GoodsID = I('get.goods_id');
        $GoodsInfo = M('goods')->where(['id'=>$GoodsID])->find();
        $GoodsLogo = M('goods_img')->where(['goods_id'=>$GoodsInfo['id'],'type'=>1])->find();
        $GoodsInfo['goods_logo'] = $GoodsLogo['path'];
        $this->assign('GoodsInfo',$GoodsInfo);

        //地址信息
        $Address = M('address')->where(['user_id'=>$this->user_info['id']])->order('is_default desc')->order('id asc')->find();
        $this->assign('Address',$Address);

        $this->display();
    }

    /**
     * 支付
     */
    public function Pay(){
        if(IS_POST){
            $Data = I('post.');
            //订单信息
            $OrderInfo = M('order')->where(['order_id'=>$Data['order_id']])->find();
            if(!$OrderInfo) {
                $this->ajaxreturn(array('code'=>'-1','message'=>'该订单不存在！'));
            }
            if($OrderInfo['status'] == 2) {
                $this->ajaxreturn(array('code'=>'-1','message'=>'该订单已付款！'));
            }
            if(time() - $OrderInfo['create_time'] >= 1800){
                $this->ajaxreturn(array('code'=>'-1','message'=>'该订单已创建30分钟以上，不能确认支付！'));
            }

//            //会员信息
//            $UserInfo = M('user')->where(['id'=>$OrderInfo['user_id']])->find();
//
//            //密码验证
//            if($UserInfo['password2'] != md5($Data['password'])) {
//                $this->ajaxreturn(array('code'=>'-1','message'=>'支付密码不正确！'));
//            }
//
//            //IOTE支付
//            if($Data['module'] == 1){
//                if($UserInfo['z5'] < $OrderInfo['pay_amount'])
//                {
//                    $this->ajaxreturn(array('code'=>'-1','message'=>'您的IOTE不足！'));
//                }else{
//                    $UserSave['z5'] = $UserInfo['z5'] - $OrderInfo['pay_amount'];
//                }
//                $OrderSave['pay_type'] = 5;
//            }
//
//            //IOTE奖金支付
//            if($Data['module'] == 2){
//                if($UserInfo['z10'] < $OrderInfo['pay_amount'])
//                {
//                    $this->ajaxreturn(array('code'=>'-1','message'=>'您的IOTE奖金不足！'));
//                }else{
//                    $UserSave['z10'] = $UserInfo['z10'] - $OrderInfo['pay_amount'];
//                }
//
//                $OrderSave['pay_type'] = 6;
//            }

            $OrderSave['status'] = 2;
            if(M('order')->where(['id'=>$OrderInfo['id']])->save($OrderSave)) {
//                M('user')->where(['id' => $UserInfo['id']])->save($UserSave);
                $this->ajaxreturn(array('code'=>'1','message'=>'确认支付成功！'));
            }else{
                $this->ajaxreturn(array('code'=>'-1','message'=>'确认支付失败，请重试'));
            }
        }

        //订单信息
        $OrderID = I('get.order_id');
        $OrderInfo = M('order')->where(['order_id'=>$OrderID])->find();
        $this->assign('OrderInfo',$OrderInfo);

        //会员信息
        $UserInfo = M('user')->where(['id'=>$OrderInfo['user_id']])->find();
        $this->assign('UserInfo',$UserInfo);

        //系统参数
        $RewardConfig = M('reward_config')->find(1);
        $this->assign('RewardConfig',$RewardConfig);

        $this->display();
    }
}