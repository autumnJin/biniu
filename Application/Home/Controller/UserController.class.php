<?php
namespace Home\Controller;

use Think\Page;

class UserController extends BaseController {


    public function tttt()
    {
        ///  $map1['level'] = 1;
        $map1['level'] = array('gt',1);
        $data = M('user')->where($map1)->select();

        $arr = [];
        $tj = M('tj');
        foreach ($data as $k => $v)
        {
            $map['admin_id'] = $v['id'];
            if(!$tj->where($map)->find()){
                $arr[] = $v['id'].'---'.$v['username'].'---'.$v['level'];
            }
        }

        dump($arr);
    }

//    /**
//     * 通知公告
//     */
//    public function notice()
//    {
//
//        $data = M('news2')->select();
////        dump($data);die;
//        $this->assign('data',$data);
//        $this->display();
//    }

    /**
     * 通知公告
     */
    public function news2()
    {

        $data=M('news2')->where(array('status'=>1))->select();
        $this->assign('data',$data);
        $this->display();
    }

    public function newsdetail()
    {
        $id = I('get.id',0);
        if($id){
            $data=M('news2')->find($id);
//            dump($id);die;
            $this->assign('data',$data);
//            $this->assign('data',M('news2')->find($id));
        }
        $this->display();
    }

    public function notice()
    {
        $id = I('get.id',0);
        if($id){
            $data=M('news')->find($id);
//            dump($id);die;
            $this->assign('data',$data);
//            $this->assign('data',M('news2')->find($id));
        }
        $this->display();
    }

//    /**
//     * 通知公告
//     */
//    public function guanyu()
//    {
//        $where['title']="关于我们";
//        $data= M('news2')->where($where)->find();
//       // dump($data);die;
//        $this->assign('data',$data);
//        $this->display();
//    }
//
//    public function callus()
//    {
//        $where['title']="联系我们";
//        $data= M('news2')->where($where)->find();
//        $this->assign('data',$data);
//        $this->display();
//    }
//    public function news()
//    {
//        $where['title']="公司新闻";
//        $data= M('news2')->where($where)->find();
//        $this->assign('data',$data);
//        $this->display();
//    }
    /**
     * 我的收益
     */
    public function earnings()
    {
        $map['user_id'] = $this->user_info['id'];
        $map['reward_type'] = array('in','52,53,54,55');//算力挖矿统计
        $data = M('fmoney')->where($map)->select();
        foreach ($data as $key=>$v){
            $data[$key]['username']=M('user')->where(['id'=>$this->user_info['id']])->getField('username');
        }
        $this->assign('data',$data);
        $this->display();
    }
    /**
     * 转账收付款
     */
    public function zhuanshou()
    {
        $this->display();
    }

    public function index()
    {
        $data = $this->user->getUserinfoById($this->user_info['id']);

        $this->assign('data',$data);
        $this->assign('h',$this->user->getUserinfoById($data['higher_id']));
        $map1['user_id'] = $map['user_id'] = $this->user_info['id'];
        $leiji_jj = M('fmoney')->where($map)->sum('amount');
        $this->assign('leiji',$leiji_jj);

        $map2['user_id'] = $this->user_info['id'];
        $map2['create_time'] = array('between',array(strtotime(date('Y-m-d'))-86400,strtotime(date('Y-m-d'))));
        $this->assign('lastday',M('fmoney')->where($map2)->sum('amount'));

        $config = M('reward_config')->find(1);
        $this->assign('qq',$config['qq']);
        $this->assign('hapy',$config['hapy']);
        $this->assign('config',$config);
        $today=strtotime(date('Y-m-d'));

        if($data['sign_time']>$today){
            //签到成功1
            $this->assign('sign',1);
        }else{
            $this->assign('sign',0);
        }
        $this->assign('news',$this->getNews());
        $this->display();
    }
    //商城公告模块
    public function getNews()
    {

        $map['status'] = 1;
        return M('news')->where($map)->order('create_time desc')->limit(7)->field('id,title')->select();
    }

    /**
     * 签到
     */
    public function sign()
    {
        if (IS_POST) {
            $data = $this->user->find($this->user_info['id']);
            if (!$data) {
                ajax_return(1, '该用户不存在');
            }
            $today = strtotime(date('Y-m-d'));
            if ($data['sign_time'] < $today) {
                $config = M('reward_config')->find();
                $z5 = $data['z5'] + $config['ptr62'];
//                $this->user->save(['sign_time'=>time(),'z5'=>$z5],['id'=>$this->user_info['id']]);//更新签到时间
                M('user')->where(['id' => $this->user_info['id']])->save(['sign_time' => time(), 'z5' => $z5]);//更新签到时间
                $this->add_fmoney($this->user_info['id'], $this->user_info['id'], $config['ptr62'], 5, 551, '+');
//                ajax_return(0,'签到成功',U('index'));
                ajax_return(0, '签到成功');
            } else {
                ajax_return(1, '今天已经签过到');
            }
        }
    }

    /**
     * wfx转算力钱包20190520
     */
    public function exchange()
    {
        //系统参数
//        $rewardConfig = M('reward_config')->where(['id'=>1])->find();
        //用户信息
        $user_info = $this->user->getUserinfoById($this->user_info['id']);
        if (IS_POST) {
            $param = I('post.');
            if (!is_numeric(trim($param['amount']))) {
                $this->ajaxreturn(array('code' => 0, 'message' => '金额格式不正确'));
            }
//            if($param['amount'] < 100){
//                $this->ajaxreturn(array('code' => 0, 'message' => '转账金额最少100'));
//            }
//
//            if ($param['amount'] %100 != 0) {
//                $this->ajaxreturn(array('code' => 0, 'message' => '金额只能是100的整数倍'));
//            }
            $param['amount'] = trim($param['amount']);
            if (md5($param['password']) != $user_info['password2']) {
                $this->ajaxreturn(array('code' => 0, 'message' => '支付密码错误'));
            }
//            //挂卖
//            $this->add_coin_sell($this->user_info['id'], $param['amount'], $param['low_num'],$param['amount']);

            $userSave['z5'] = $user_info['z5'] - $param['amount']; //更新账户wfx

            if($userSave['z5']<0){
                $this->ajaxreturn(array('code' => 0, 'message' => 'WFX不够'));
            }
            $userSave['z6'] = $user_info['z6'] + $param['amount']; //更新算力钱包
            //事务 :
            M()->startTrans();
            $result =  M('user')->where(array('id'=>$this->user_info['id']))->save($userSave);
            $this->add_fmoney($user_info['id'], $user_info['id'], -$param['amount'], 5, 504, 'WFX转换');
            $this->add_fmoney($user_info['id'], $user_info['id'], $param['amount'], 6, 601, 'WFX转换为算力钱包');
            if (!empty($result)) {
                M()->commit();
                $this->ajaxreturn(array('code' => 1, 'message' => '转换成功'));
            } else {
                M()->rollback();
                $this->ajaxreturn(array('code' => '0', 'message' => '转换失败！'));
            }
        }
        $where['user_id'] = $this->user_info['id'];
//        $user= M('user')->where(array('id'=>$this->user_info['id']))->find();
//        //个人卖出记录
//        $data = M('coin_sell')->alias('cs')
//            ->join('ms_user AS mu ON mu.id=cs.user_id')
//            ->where($where)
//            ->field('cs.*,mu.username')
//            ->select();
//        $this->assign('data', $data);

        $this->assign('user', $user_info);
        $this->display();
    }

    /**
     * 完成支付充值
     */
    public function shengou2()
    {
        $id = session('index_user_id');
        $config = M('reward_config')->find();
//        if (!isset($id)) {
//            $this->redirect('User/shengou');
//        }
        if (IS_POST) {
            $data = I('post.');
            if ($config['canshu11'] == '-1') {
                $this->ajaxreturn(array('code' => '-1', 'message' => $config['canshu12']));
            }
            if (empty($data['money'])) {
                $this->ajaxreturn(array('code' => '-1', 'message' => '请输入充值金额'));
                //                echo "<script>alert('金额不能为空!');window.location.href='javascript:history.go(-1)';</script>";
                //                exit();
            }
//            if ($data['money'] < 100) {
//                $this->ajaxreturn(array('code' => '-1', 'message' => '最低充值100'));
//            }
//            if (($data['money'] % 100) != 0) {
//                $this->ajaxreturn(array('code' => '-1', 'message' => '请输入100的整数倍'));
//            }

            $data['status'] = -2;//状态为1表示已完成充值
            $data["user_id"]=$id;
            $data['time']=time();
            if (M('shengou')->add($data)) {
                $this->ajaxreturn(array('code' => 1, 'message' => '操作成功!,等待管理员审核!'));
            } else {
                $this->ajaxreturn(array('code' => '-1', 'message' => '请返回重试'));
            }
        }
        $data = M('shengou')->where(['id' => $id])->find();
        $this->assign('data', $data);

//        $config = M('config')->find();
        $this->assign('bank_info', $config['bank_info']);
        $this->display();
    }
    //购物车
    public function cart(){
        $join1 ='left join '.C('DB_PREFIX').'cart as c on g.id = c.goods_id ';
        $join2 ='left join '.C('DB_PREFIX').'goods_img as gi on
        gi.goods_id = g.id';
        $map['c.user_id'] = $this->user_info['id'];
        $map['gi.type'] = 1;
        $data = M('goods')->alias('g')->join($join1)->join($join2)->order('c.create_time desc')->where($map)->field('g.*,c.id as c_id,c.num as c_num,gi.path')->select();
        $this->assign('data',$data);
        $this->display();
    }

    public function deleteCart()
    {

        if(IS_POST){
            $ids = I('post.id');

            for($a=0;$a<count($ids);$a++)
            {
                if(!M('cart')->delete($ids[$a])){
                    ajax_return(1,'删除失败');
                }
            }

            ajax_return(0,'删除成功',U('cart'));
        }
    }


    public function sendCode()
    {
        if(IS_POST){
            $this->test(I('post.phone'));
            ajax_return(0,'');
        }




    }
    private function test($phone)
    {
        require_once 'Ucpaas.class.php';
        $options['accountsid']='bd8f02677ed3820aea2d5e0ddb942a0a';
        $options['token']='33901adfe0ee77c83b9ae8d90399912c';
        $appId = '4f75b0201b684067bff9782ae6f69baf';
        $to = $phone;
        $templateId = 116150;

//初始化 $options必填

        $ucpass = new \Ucpaas($options);

//开发者账号信息查询默认为json或xml
        $code = randNumber(4);
        $map['code'] = $code;
        $map['phone'] = $phone;
        $map['create_time'] = time();

        M('phone_code')->add($map);

//        echo $ucpass->getDevinfo('xml');
        $ucpass->templateSMS($appId,$to,$templateId,$code);

    }


    public function active()
    {
        $m = getLevel();
        if(IS_POST){

            $param = I('post.');
            $data = $this->user->find($this->user_info['id']);
            if(!($info = $this->user->where(array('username'=>$param['username']))->find())){
                ajax_return(1,'该用户不存在');
            }

            if(md5($param['password_'])!=$data['password2']){
                ajax_return(1,'支付密码错误');
            }

            if($info['status'] == 2){
                ajax_return(1,'该用户已开通');

            }

            $amount = $m[$param['level']];

            if($amount>$data['z2']){
                ajax_return(1,'余额不足');
            }

            $save['id'] =$data['id'];
            $save['z2'] = $data['z2'] - $amount;
            $save['tj_count'] = $data['tj_count']+1;
            if($this->user->save($save) === false){
                ajax_return(1,'账户异常');
            }


            $save5['status'] = 2;

            $map['user_id'] = $info['id'];
            $map['order_type'] = 1;
            //订单状态修改
            M('order')->where($map)->save($save5);



            $save1['id'] =$info['id'];
            $save1['status'] =2;

            if($this->user->save($save1) === false){
                ajax_return(1,'账户异常1');
            }

            $this->add_log($data['id'],$amount,5,'开通会员'.$param['username'],'-');


            $a =$info['id']; $b = $data['id'];$l = $param['level'];
            $db = M();
            $aa = $db->execute("call net_add_tj($a,$b,$l)");
            $m = getLevel();
            $fmoney =$m[1];
            $bb = $db->execute("call kt001($a,$fmoney)");//正常

            ajax_return(0,'开通成功');

        }else{

            $this->assign('data',$this->user->find($this->user_info['id']));
            $this->assign('data1',$this->user->find(I('get.id')));

            $this->assign('level',$m);
            $this->display();
        }
    }


    //余额支付
    public function balancePay(){
        if(IS_POST) {
            $data = I('post.');

            $config = M('reward_config')->where(['id'=>1])->find();    //系统参数

            $orderInfo = M('order')->where(['order_id'=>$data['order_id']])->find();
            if(!$orderInfo) {
                $this->ajaxreturn(array('code'=>'-1','message'=>'该订单不存在！'));
            }
            if($orderInfo['status'] == 2) {
                $this->ajaxreturn(array('code'=>'-1','message'=>'该订单已付款！'));
            }

            $userId = session('User_yctr.id');
            $userInfo = M('user')->where(['id'=>$userId])->find();

            //密码验证
            if($userInfo['password2'] != md5($data['password']))
            {
                $this->ajaxreturn(array('code'=>'-1','message'=>'支付密码不正确！'));
            }

            //充值积分支付
            if($data['module'] == 1)
            {
                if($userInfo['z1'] < $orderInfo['pay_amount'])
                {
                    $this->ajaxreturn(array('code'=>'-1','message'=>'您的充值积分不足！'));
                }else{
                    $userSave['z1'] = $userInfo['z1'] - $orderInfo['pay_amount'];
                }
            }

            //流通积分支付 需5%的手续费
            if($data['module'] == 2) {
                $sxf = $orderInfo['pay_amount'] * $config['j17'];
                $allAmount = $orderInfo['pay_amount'] + $sxf;
                if ($userInfo['z2'] < $allAmount) {
                    $this->ajaxreturn(array('code' => '-1', 'message' => '您的流通积分不足！需'.$allAmount.'（手续费'.$sxf.'）'));
                }else{
                    $userSave['z2'] = $userInfo['z2'] - $allAmount;
                }
            }

            //购物积分支付
            if($data['module'] == 3) {
                if ($userInfo['z3'] < $orderInfo['pay_amount']) {
                    $this->ajaxreturn(array('code' => '-1', 'message' => '您的购物积分不足！'));
                }else{
                    $userSave['z3'] = $userInfo['z3'] - $orderInfo['pay_amount'];
                }
            }

            //兑换积分支付
            if($data['module'] == 4) {
                if ($userInfo['z4'] < $orderInfo['pay_amount']) {
                    $this->ajaxreturn(array('code' => '-1', 'message' => '您的兑换积分不足！'));
                }else{
                    $userSave['z4'] = $userInfo['z4'] - $orderInfo['pay_amount'];
                }
            }

            $orderSave['status'] = 2;
//            $config = M('reward_config')->where(['id'=>1])->find();
//            $orderSave['zong_jf'] = $orderInfo['pay_amount'] * $config['ptr4']; //总返

            if(M('order')->where(['id'=>$orderInfo['id']])->save($orderSave)){
                M('user')->where(['id'=>$orderInfo['user_id']])->save($userSave);
//                $db = M();
//                $id = $userInfo['id'];
//                $money = $orderInfo['pay_amount'];
//                $newSave['zong_jf'] = $userInfo['zong_jf'] + $orderSave['zong_jf'];
//                $newSave['own_zong'] = $userInfo['own_zong'] + $orderInfo['pay_amount'];
//                M('user')->where(['id'=>$id])->save($newSave);
//                $nowInfo = M('user')->where(['id'=>$id])->find();
//                if($nowInfo['level'] == 0 && $nowInfo['own_zong'] >= $config['ptr8']){
//                    M('user')->where(['id'=>$id])->save(['level'=>1]);
//                }
//                $aa = $db->execute("call kt001($id,$money)"); //增加团队业绩
                $this->ajaxreturn(array('code'=>'1','message'=>'支付成功！'));
            }else{
                $this->ajaxreturn(array('code'=>'-1','message'=>'支付失败！'));
            }
        }
    }

    //申请运营中心
    public function updateCenter()
    {
        if(IS_POST) {
            $param = I('post.');
            //判断
            if($param['center_level'] == '' || $param['province'] == '' || $param['city'] == '' || $param['area'] == '' || $param['address'] == '')
            {
                $this->ajaxreturn(array('code'=>'-1','message'=>'请填写参数完整！'));
            }

            //是否有人已经申请或者在申请中
            if($param['center_level'] > 1)
            {
                $check['center_level'] = $param['center_level'];
                $check['province'] = $param['province'];
                $check['city'] = $param['city'];
                $check['area'] = $param['area'];
                $check['center_level'] = $param['center_level'];
                if(M('center_address')->where($check)->find())
                {
                    $this->ajaxreturn(array('code'=>'-1','message'=>'当前位置已有申请,请重新选择地区！'));
                }
            }

            //判断是否有申请中
            if(M('center_address')->where(['user_id'=>session('User_yctr.id'),'status'=>0])->find())
            {
                $this->ajaxreturn(array('code'=>'-1','message'=>'您已有申请，请勿重新申请！'));
            }

            //新增
            $param['create_time'] = time();
            $param['update_time'] = time();
            $param['user_id'] = session('User_yctr.id');
            if(M('center_address')->add($param))
            {
                $this->ajaxreturn(array('code'=>'1','message'=>'申请添加成功！'));
            }
            $this->ajaxreturn(array('code'=>'-1','message'=>'申请添加失败！'));
        }

        $centers = C('center_level');
        unset($centers[0]); //第一个无等级去除

        //所有省
        $provinces = M('province')->select();

        $this->assign([
            'centers' => $centers,
            'provinces' => $provinces
        ]);

        $this->display();
    }

    public function selectpay2()
    {
        $map['order_id'] = I('get.id');
        $data = M('order')->where($map)->find();
        if(!$data){
            $this->error('订单不存在');
        }

        $goods = M('goods')->find($data['goods_id']);

        //移动端手机端判断
        $isMobile = 0;
        if(!isMobile())
        {
            $isMobile = 1;
        }
        $this->assign('MoneyLst',M('user')->where(['id'=>session('User_yctr.id')])->find());
        $this->assign('data',$data);
        $this->assign('goods',$goods);
        $this->assign('isMobile',$isMobile);
        $this->display();

    }

    //扫码支付
    public function scanPay()
    {
        if(IS_POST){
            // 配置参数
            $res = array();
            $res['out_trade_no'] = $_POST['order_id'];        // 商户订单号
            $res['subject']      = $_POST['subject'];          // 商品名称
            $res['total_amount'] = $_POST['total_amount'];          // 商品总价
            //$res['total_amount'] = 0.01;
            $res['body']         = $_POST['subject'];    // 商品描述
            // 引入支付核心文件
            Vendor('Alipay.AopSdk');
            Vendor("Alipay.pagepay.service.AlipayTradeService");
            Vendor("Alipay.pagepay.buildermodel.AlipayTradePagePayContentBuilder");
            // 获取支付宝配置参数
            $config = C("alipay");
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $res["out_trade_no"];
            //订单名称，必填
            $subject = trim($res["subject"]);
            //付款金额，必填
            $total_amount = $res["total_amount"];
            //商品描述，可空
            $body = trim($res["body"]);
            //构造参数
            $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setOutTradeNo($out_trade_no);
            $aop = new \AlipayTradeService($config);
            /**
             * pagePay 电脑网站支付请求
             * @param $builder 业务参数，使用buildmodel中的对象生成。
             * @param $return_url 同步跳转地址，公网可以访问
             * @param $notify_url 异步通知地址，公网可以访问
             * @return $response 支付宝返回的信息
             */
            $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
            //输出支付二维码
            var_dump($response);
        }
    }

    //移动端支付
    public function webPay()
    {
        if(IS_POST){
            // 配置参数
            $res = array();
            $res['out_trade_no'] = $_POST['order_id'];        // 商户订单号
            $res['subject']      = $_POST['subject'];          // 商品名称
            $res['total_amount'] = $_POST['total_amount'];          // 商品总价
            //$res['total_amount'] = 0.01;          // 商品总价
            $res['body']         = $_POST['subject'];    // 商品描述
            // 引入支付核心文件
            Vendor('Alipay.pagepay.service.AlipayTradeService');
            Vendor('Alipay.pagepay.buildermodel.AlipayTradeWapPayContentBuilder');
            // 获取支付宝配置参数
            $config = C("alipay");
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $res["out_trade_no"];
            //订单名称，必填
            $subject = trim($res["subject"]);
            //付款金额，必填
            $total_amount = $res["total_amount"];
            //商品描述，可空
            $body = trim($res["body"]);

            //超时时间
            $timeout_express="1m";

            $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setOutTradeNo($out_trade_no);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setTimeExpress($timeout_express);

            $payResponse = new \AlipayTradeService($config);
            $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
            return ;

        }
    }

    public function selectpay()
    {

        $this->display();


    }

    public function selectpay1(){
        header('Content-Type: text/html; charset=UTF-8');
        $order_num = I('id');
        $order = M('order')->where('id = "'.$order_num.'"')->field('order_id,amount')->find();
        vendor('WxPayPubHelper.WxPayPubHelper');
        $unifiedOrder = new \UnifiedOrder_pub();

        $unifiedOrder->setParameter("body","支付金额");//商品描述

        $timeStamp = $order['order_id'];
        $out_trade_no = $timeStamp;
        $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号
        $unifiedOrder->setParameter("total_fee",$order['amount']*100);//总金额
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/index.php/Home/Public/notify_url';
        $unifiedOrder->setParameter("notify_url",  'http://'.$_SERVER['SERVER_NAME'].'/index.php/Public/notify_url');//
        // 通知地址
        $unifiedOrder->setParameter("trade_type","NATIVE");//交易类型

        //dump($unifiedOrder);exit();
        //获取统一支付接口结果
        $unifiedOrderResult = $unifiedOrder->getResult();
        //商户根据实际情况设置相应的处理流程
        if ($unifiedOrderResult["return_code"] == "FAIL")
        {
            //商户自行增加处理流程
            echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
        }
        elseif($unifiedOrderResult["result_code"] == "FAIL")
        {
            //商户自行增加处理流程
            echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
            echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
        }
        elseif($unifiedOrderResult["code_url"] != NULL)
        {
            //从统一支付接口获取到code_url
            $code_url = $unifiedOrderResult["code_url"];
            //商户自行增加处理流程
            //......
        }


        $this->assign('out_trade_no',$out_trade_no);
        $this->assign('code_url',$code_url);
        $this->assign('unifiedOrderResult',$unifiedOrderResult);
        $this->assign('order',$order);
        $this->display();


    }


    public function jsapipay()
    {

        if(!$id = I('get.id')){
            $this->error('非法参数');
        }

        $data = M('order')->where(['order_id'=>$id])->find();
        if(!$data){
            $this->error('参数错误');
        }

        Vendor('WxPayv3.JSAPI');
        $tools = new \JsApiPay();
        $openid = $tools->GetOpenid();
        $total_money =$data['amount'];
        $input = new \WxPayUnifiedOrder();
        $input->SetBody('商城消费');//商品或支付单简要描述
        $input->SetAttach($data['id']); //附加数据
        $input->SetOut_trade_no($data['order_id']);//传的值
        $input->SetTotal_fee($total_money*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("商城消费");
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/index.php/Public/notifydfc';
        $input->SetNotify_url($url);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openid);

        $or = \WxPayApi::unifiedOrder($input);

        $jsApiParameters = $tools->GetJsApiParameters($or);

        $this->assign('jsApiParameters',$jsApiParameters);
        $this->assign("total_money",$total_money);

        $this->assign('data',$data);
        // $this->assign('info',$info);

        $this->display('selectpay');
    }

    public function send_to_server($param=array())
    {
        $data=[];
        $data['service_type'] = 'WECHAT_SCANNED';
        $data['mch_id'] =C('m_id');
        $data['out_trade_no'] = $param['order_id'] = 2234;
        $data['body'] = $param['body'] = 324;
        $data['detail'] = $param['detail'] = 34;
        $data['fee_type'] = 'CNY';
        $data['total_fee'] = $param['total_fee'] = 23;
        $data['notify_url'] = C('notify_url');
        $data['time_start'] = $param['time'] = 23254235234;
        $data['time_expire'] = 600;
        $data['spbill_create_ip'] = get_client_ip();
        $data['nonce_str'] = getOrderNum();

        ksort($data);


        $url = createLinkstring($data);

        $p = $url.C('secrete');
        $data['sign'] = strtoupper(md5($p));

        dump($this->https_request(C('testgateway'),$data));

    }

    private function https_request($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }


//    public function qrcode()
//    {
//
//        $s =$_SERVER['SCRIPT_NAME'];
//
//        $s = substr($s,0,-9);
//
//        $map['user_id'] = $this->user_info['id'];
//        $map['order_type'] =1;
//        $map['amount'] = 88;
//        $map['status'] = 2;

//        if(M('order')->where($map)->find()){
//            $this->assign('u',1);
//        }
//
//
//
//        $d =  $this->user->getUserinfoById($this->user_info['id']);
//        if($d['level'] == 2){
//            $this->assign('u',1);
//
//        }
//
//        if($d['is_qrcode'] == 1){
//            $this->assign('u',1);
//
//        }
//        $this->assign('data',$d);
//        $url  = "http://".$_SERVER['SERVER_NAME'].$s."index.php/Public/login/username/".$d['username'];
//        $this->assign('url',$url);
//        $this->display();
//    }

    public function tuijianlist()
    {

        $level = I('get.level',1);

        $this->assign('active',$level);

        if($level == 1){
            $map['higher_id'] = $this->user_info['id'];


            $data = $this->user->where($map)->order('create_time desc')->select();
        }else{
            $map['t.level'] = $level;
            $map['t.higher_id'] = $this->user_info['id'];
            $join = 'left join '.C('DB_PREFIX').'user as u on u.id = t.admin_id';
            $data = M('tj')->alias('t')->join($join)->where($map)->field('u.*')->select();
        }
        $this->assign([
            'data'=>$data,
            'userInfo'=>$this->user_info
        ]);

        $this->display();

    }

    //推荐人
    public function recommend()
    {
        $topInfo = M('user')->where(['id'=>$this->user_info['higher_id']])->field('truename,id,all_achievement')->find();
        $recomSum = M('user')->where(['higher_id'=>$this->user_info['higher_id']])->count();
        $this->assign([
           'topInfo' => $topInfo,
            'recomSum' => $recomSum
        ]);
        $this->display();
    }

    public function addCart()
    {
        if(IS_POST){
            $param = I('post.');
            $map['user_id'] = $this->user_info['id'];
            $map['goods_id'] = $param['goods_id'];
            $map['shop_id']   = $param['shop_id'];

            $sell = M('order')->where('goods_id = "'.$map['goods_id'].'"')->count('id'); #已售
            $goods = M('goods')->where('id = "'.$map['goods_id'].'"')->find(); #已售\
            if($goods['repertory']<=$sell){
                ajax_return(1,'该商品暂无库存,请稍后再试');
            }

            if($goods['buy_type'] == 2){
                ajax_return(1,'该产品仅限流通积分支付,不能加入购物车，请单独购买');
            }
            #总


            $c = M('cart');
            if($info = $c->where($map)->find()){
                $info['num'] = $info['num'] + $param['num'];
                if($info['num']>1){
                    $info['num'] = 1;
                }
                $info['create_time'] = time();
                if($c->save($info) ===false){
                    ajax_return(1,'添加购物车失败');
                }
            }else{
                $map['num'] = $param['num'];
                $map['create_time'] = time();
                if(!$c->add($map)){
                    ajax_return(1,'添加购物车失败');
                }
            }

            ajax_return(1,'添加购物车成功');
        }
    }




    //添加地址并设为默认
    public function add_address()
    {
        if(IS_POST){
            $param = I('post.');
            $where['user_id'] = $param['user_id'] = $this->user_info['id'];
            $save['is_default'] = 1;
            M('address')->where($where)->save($save);
            $param['is_default'] = 2;
            $param['address'] =explode_address($param['prince'],$param['city'],$param['area']).$param['street'];
            if(!M('address')->add($param)){
                ajax_return(1,'地址添加失败');
            }
            ajax_return(0,'添加成功');


        }
    }
    public function confirm_order()
    {
        if(IS_POST){

//            if($this->user_info['status'] == 2){
//                ajax_return(1,'您已经是本站会员');
//            }

            $param = I('post.');
            $sell = M('order')->where('goods_id = "'.$param['id'].'"')->count('num'); #已售
            $goods = M('goods')->where('id = "'.$param['id'].'"')->field('repertory')->find(); #已售\
            /*if($goods['repertory']<=$sell){
               ajax_return(1,'该商品暂无库存,请稍后再试');
            }*/

            if($param['id']&&$param['num']){//单品购买
                $p=implode('-',$param);
                ajax_return(0,'',U('before_pay',array('p'=>$p)));
            }else if($param['order_id']){//待付款购买
                ajax_return(0,'',U('before_pay',array('o'=>$param['order_id'])));

            }else if($param['c_id']){//购物车购买
                $goods = M('goods');
                $cart = M('cart');

                //购物车第一个产品
                $cart_info = $cart->find($param['c_id'][0]);
                $goods_info = $goods->find($cart_info['goods_id']);

//                $module = $goods_info['module'];
                $is_up= $goods_info['is_up'];
//                foreach ($param['c_id'] as $k => $v)
//                {
//                    $cart_info = $cart->find($v);
//                    $goods_info = $goods->find($cart_info['goods_id']);
//
////                    if($module != $goods_info['module'])
//                    if($is_up != $goods_info['is_up'])
//                    {
////                        ajax_return(1,'会员商品和重销商品不可一起购买!');
//                        ajax_return(1,'升级产品和复购产品不能一起购买!');
//                    }
//                }

//                foreach ($param['c_id'] as $k => $v)
//                {
//                    $cart_info = $cart->find($v);
//                    $goods_info = $goods->find($cart_info['goods_id']);
//
//                    if($goods_info['pro_type'] == 1 && count($param['c_id'])>1){
//                        ajax_return(1,'阿胶产品请单独购买');
//                    }
//                }

                $c = implode('-',$param['c_id']);

                ajax_return(0,'',U('before_pay',array('cid'=>$c)));

            }else{
                ajax_return(1,'非法参数');
            }


        }
    }

    public function before_pay()
    {
        $goods=array();
        $map['gi.type'] = 1;
        $join = 'left join '.C('DB_PREFIX').'goods_img as gi on gi.goods_id = g.id';
        $g = M('goods');
        if($p = I('get.p')){////单品购买

            $p = explode('-',$p);
            $map['g.id'] = $p[0];
            $m = $g->alias('g')->join($join)->where($map)->field('g.name,g.price,g.price1,g.format,g.pro_type,g.id as g_id,gi.path,g.pv,g.shopid')->find();
            $m['num'] = $p[1];
            $goods[] =$m;

        }

        if($c = I('get.cid')){
            $c = explode('-',$c);
            $map['c.id'] = array('in',$c);
            $map['gi.type'] = 1;
            $join1 = 'right join '.C('DB_PREFIX').'cart as c on c.goods_id = g.id';
            $join2 = 'left join '.C('DB_PREFIX').'goods_img as gi on gi.goods_id = g.id';
            $goods = $g->alias('g')->join($join1)->join($join2)->where($map)->field('c.*,g.price1,g.name,g.price,g.pv,gi.path,g.format,g.pro_type,g.id as g_id,g.shopid')->select();

        }

        if(!$goods){
            $this->error('非法参数');
        }

        $all = 0;
        foreach ($goods as $k=>$v){
            $all += $goods[$k]['num']*$goods[$k]['price'];
        }
        foreach ($goods as $k=>$v){
            if($this->user_info['level'] == 4){
                $price = $goods[$k]['price1'];
                $goods[$k]['price'] = $goods[$k]['price1'];
            }else{
                $price = $goods[$v]['price'];
            }
            $all += $goods[$v]['num']*$price;
        }

        $this->assign('all',$all);

        $this->assign('goods',$goods);

        $config = M('reward_config')->find(1);
        // $this->assign('commission',$config['duipeng_2']);
        //  $province = M('province')->select();
        $this->assign('address',getAddress($this->user_info['id']));
        //  $this->assign('p',$province);
        $this->display();
    }


    public function shengji()
    {
        $config = M('reward_config')->find(1);
        $data = $this->user->getUserinfoById($this->user_info['id']);

        if(IS_POST){
            $param = I('post.');

            if(md5($param['password']) != $data['password2']){
                ajax_return(1,'密码错误');
            }
            $amount = $config['h'.($param['level']-1)];
            if($data['z1']<$amount){
                ajax_return(1,'余额不足,请先充值');
            }

            $save['id'] = $data['id'];
            $save['level'] = $param['level'];
            $save['z1'] = $data['z1'] - $amount;

            $save['z2'] = $data['z2'] + $amount;

            $this->user->save($save);

            $this->add_log($data['id'],$amount,1,'升级会员','-');
            $this->add_log($data['id'],$amount,2,'升级会员','+');

            // 至尊会员(也可能是商家level)推荐奖

            $higher = $this->user->getUserinfoById($this->user_info['higher_id']);

            if($higher['level'] >= 3){
                $save1['id'] = $higher['id'];
                $save1['z1'] = $higher['z1'] + $amount*0.4;
                $this->user->save($save1);
                $this->add_log($higher['id'],$amount*0.4,1,'来自会员'.$data['username'].'推荐奖','+');


            }

            ajax_return(0,'升级成功',U('user/index'));

        }else{
            $this->assign('config',$config);
            $this->assign('data',$data);
            $this->display('futou');
        }

    }

    public function buying()
    {
        if(IS_POST){
            $param = I('post.');
            $arr = $this->array_group_by($param['p'],'shop_id');
            $sub_o = M('suborder');
            $o = M('order');

            $address = M('address')->find($param['address']);
            if(!$address){
                ajax_return(1,'请添加收货信息');
            }
            $order['address'] = $address['address'];
            $order['area_id'] = $address['area'];
            $order['receiver'] = $address['receiver'];
            $order['phone'] = $address['phone'];
            $order['tips'] = $param['tips'];
            $order['logistics_style'] = $param['logistics_style'];

            //判断是否是连锁店购买
            $centerLevel = M('user')->where(['id'=>$this->user_info['id']])->getField('center_level');
            if($centerLevel > 0)
            {
                $order['is_from_sign'] = 1;
            }

            foreach ($arr as $k=>$v)
            {
                $order['order_id'] = getOrderNum();
                $return_order[] = $order['order_id'];
                $order['user_id'] = $this->user_info['id'];
                $order['amount'] = 0;
                $order['create_time'] = time();
                $order['shop_id'] = $k;
                foreach ($v as $k1=>$v1){
                    $order['amount'] += $v1['goods_num']*$v1['price'];
                    $order['pv_amount'] += $v1['goods_num']*$v1['pv'];
                    $order['pay_amount'] += $v1['goods_num']*$v1['price'];

                }
                $goodsinfo = M('goods')->find($v[0]['goods_id']);
                $order['module'] = $goodsinfo['module'];
                $order['buy_type'] = $goodsinfo['buy_type'];

                if(count($v)<2){
                    $order['num'] = $v[0]['goods_num'];
                    $order['goods_id'] = $v[0]['goods_id'];

                    if($goodsinfo['pro_type'] == 1){
                        $order['order_type'] = 1;
                    }
                }else{
                    $order['is_sub'] = 2;
                    $order['order_type'] = 2;
                }

                //总订单
                //连锁店优惠比例
//                if($centerLevel > 0)
//                {
//                    $rate = 0;
//                    switch ($centerLevel)
//                    {
//                        case 1:
//                            $rate = M('reward_config')->where(['id'=>1])->getField('ptr50');
//                            break;
//                        case 2:
//                            $rate = M('reward_config')->where(['id'=>1])->getField('ptr51');
//                            break;
//                        case 3:
//                            $rate = M('reward_config')->where(['id'=>1])->getField('ptr52');
//                            break;
//                        case 4:
//                            $rate = M('reward_config')->where(['id'=>1])->getField('ptr53');
//                            break;
//                        default:
//                            $rate = 0;
//                    }
//
//                    if($rate > 0)
//                    {
//                        $order['amount'] = $order['amount']*$rate/100;
//                    }
//                }

                $id = $o->add($order);

                //子订单
                if($order['is_sub'] == 2){
                    $sub_order['order_id'] = $id;
                    foreach ($v as $k1=>$v1){
                        $sub_order['goods_id'] = $v1['goods_id'];
                        $sub_order['num'] = $v1['goods_num'];
                        $sub_o->add($sub_order);
                    }

                }
            }
            ajax_return(0,'',U('pay',array('order_id'=>$return_order[0])));
        }
    }





    private function array_group_by($arr, $key)
    {
        $grouped = [];
        foreach ($arr as $value) {
            $grouped[$value[$key]][] = $value;
        }

        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $parms);
            }
        }
        return $grouped;
    }


    public function pay()
    {
        $id = I('get.order_id');
        $map['order_id'] = $id;
        $o = M('order');
        $amount = $o->where($map)->sum('amount');
        $pay_amount = $o->where($map)->sum('pay_amount');
        //订单产品所属模块
        $module = $o->where(['order_id'=>$id])->getField('module');

        //用户id
        $userId = session('User_yctr.id');
        $addressInfo = M('address')->where(['user_id'=>$userId])->field('prince,city,area,longitude,latitude')->find();

        //连表查询同一个区域的所有连锁店
        $whereAd['a.prince'] = $addressInfo['prince'];
        $whereAd['a.city'] = $addressInfo['city'];
        $whereAd['a.area'] = $addressInfo['area'];
        $whereAd['a.is_default'] = 2; //选择默认地址
        $whereAd['a.user_id'] = array('neq',$userId);
        $whereAd['b.center_level'] = array('eq',1);
        $list = M('address')->alias('a')
            ->join('__USER__ b ON a.user_id=b.id')
            ->where($whereAd)
            ->field('b.id,b.username,b.center_level,a.longitude,a.latitude,a.street')
            ->select();

        for ($a=0;$a<count($list);$a++)
        {
            //测算距离
            $distance = $this->getDistance($addressInfo['latitude'],$addressInfo['longitude'],$list[$a]['latitude'],$list[$a]['longitude']);
            $list[$a]['distance'] = $distance;
        }
        //二维数组排序
        $newList = $this->arraySort($list,'distance');

        //用户中心等级
        $userCenterLevel = M('user')->where(['id'=>session('User_yctr.id')])->getField('center_level');

        $this->assign([
            'newList' => $newList,
            'id' => $id,
            'user_center_level' => $userCenterLevel,
            'amount' => $amount,
            'pay_amount' => $pay_amount,
            'module' => $module,
        ]);
        // $url = $this->wxh5Request($id,$amount);
        // $this->assign('url',$url);
        if(IS_POST){
            $param = I('post.');
            $where['order_id'] = $param['id'];
            $save['pay_type'] = is_weixin()?1:2;
//            $save['is_update'] = $param['isupdate'];
            $save['send_shop_id'] = $param['shopid'];
            M('order')->where($where)->save($save);
            $order = M('order')->where($where)->find();

            if(is_weixin()){
                //ajax_return(0,'提交成功',U('user/jsapipay',array('id'=>$param['id'])));
                ajax_return(0,'提交成功',U('user/selectpay2',array('id'=>$param['id'])));
            }else{
                ajax_return(0,'提交成功',U('user/selectpay2',array('id'=>$param['id'])));
            }
            if($param['paytype'] == 3){ // 测试
                if($order['order_type'] == 1){
                    $u = $this->user->getUserinfoById($this->user_info['id']);
                    $level  = $order['amount'] == 88 ? 2:3;
                    if($level>$u['level']){
                        $save['level'] = $level;
                        $save['id'] = $order['user_id'];
                        $this->user->save($save);
                    }
                    $save1['id'] = $order['id'];
                    $save1['status'] = 2;
                    M('order')->save($save1);
                    $db = M();
                    $a = $order['user_id'];
                    $e = $order['amount'];
                    $db->execute("call kt001($a,$e)");
                    if($order['amount'] == 88){
                        $this->tuijian_reward2($order['user_id']);
                    }
                    if($level == 3){
                        $this->daili_reward($order['user_id']);
                    }else{
                        $this->jiandian($order['user_id']);
                    }
                    // $this->baodan($order['user_id'],$order['amount']);
                    if($order['amount'] == 88){
                        //$this->yeji_reward($order['user_id'],$order['amount']);
                        // $this->yeji_reward2($order['user_id'],$order['amount']);
                        $this->yeji_reward4($order['user_id'],$order['amount']);
                    }
                }else{

                }
                ajax_return(0,'支付成功',U('Index/index'));
            }else if($param['paytype'] == 1){ //微信支付
                ajax_return(0,'提交成功',U('user/wxh5_pay',array('id'=>$param['id'])));

            }else if($param['paytype'] == 2){//支付宝支付
                ajax_return(0,'提交成功',U('user/selectpay2',array('id'=>$param['id'])));

            }

        }else{
//            if(!$o_info||$o_info['user_id']!= $this->user_info['id']){
//                $this->error('非法订单');
//            }
            //  $this->assign('data',$o_info);
            $this->display();
        }
    }

    /**
     * @desc arraySort php二维数组排序 按照指定的key 对数组进行自然排序
     * @param array $arr 将要排序的数组
     * @param string $keys 指定排序的key
     * @param string $type 排序类型 asc | desc
     * @return array
     */
    function arraySort($arr, $keys, $type = 'asc') {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v){
            $keysvalue[$k] = $v[$keys];
        }
        // dump($keysvalue);

        $type == 'asc'?asort($keysvalue):arsort($keysvalue);
        // dump($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        // dump($new_array);
        return $new_array;
    }

    /**
     * @desc 根据两点间的经纬度计算距离
     * @param float $lat 纬度值
     * @param float $lng 经度值
     */
    function getDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6367000; //approximate radius of earth in meters
        $lat1 = ($lat1 * pi() ) / 180;
        $lng1 = ($lng1 * pi() ) / 180;
        $lat2 = ($lat2 * pi() ) / 180;
        $lng2 = ($lng2 * pi() ) / 180;
        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;
        return round($calculatedDistance);
    }

    //推广奖(普通会员 无紧缩) j11 j12 j13
    private function tuijian_reward($user_id)
    {
        $config = M('reward_config')->find(1);

        $map['admin_id'] = $user_id;
        $map['t.level'] = array('gt',0);

        $join = 'left join '.C('DB_PREFIX').'user as u on u.id = t.higher_id';
        $data4 = M('tj')->alias('t')->join($join)->where($map)->order('t.level asc')->field('u.*')->limit(3)->select();


        foreach ($data4 as $k => $v){
            if($v && $v['level'] == 2){
                $this->add_fmoney($v['id'],$user_id,8,1,1,'推广奖');
                $save['id'] = $v['id'];
                $save['z1'] = $v['z1'] +8;
                M('user')->save($save);

                $this->add_log($v['id'],8,1,'推广奖','+');
            }
        }

    }

    //推广奖(代理 有紧缩) j11 j12 j13
    private function tuijian_reward2($user_id)
    {
        $map1['u.level'] = array('gt',1);
        $map1['admin_id'] = $user_id;
        $map1['t.higher_id'] = array('neq',1);
        $map1['t.level'] = array('gt',0);

        $join = 'right join '.C('DB_PREFIX').'user as u on u.id = t.higher_id';
        $data4 = M('tj')->alias('t')->join($join)->where($map1)->order('t.level asc')->field('u.*')->limit(3)->select();
        $count = count($data4);
        $config = M('reward_config2');
        if($count == 1){
            $map['r1'] = $data4[0]['level'];
            $rc = $config->where($map)->find();


        }else if($count == 2){
            $map['r1'] = $data4[0]['level'];
            $map['r2'] = $data4[1]['level'];
            $rc = $config->where($map)->find();
        }else if($count == 3){
            $map['r1'] = $data4[0]['level'];
            $map['r2'] = $data4[1]['level'];
            $map['r3'] = $data4[2]['level'];
            $rc = $config->where($map)->find();
        }else{
            return true;
        }


        if($count){
            foreach ($data4 as $k => $v){
                $this->add_fmoney($v['id'],$user_id,$rc['amount'.($k+1)],1,1,'推广奖');
                $save['id'] = $v['id'];
                $save['z1'] = $v['z1'] + $rc['amount'.($k+1)];
                M('user')->save($save);

                $this->add_log($v['id'],$rc['amount'.($k+1)],1,'推广奖发放','+');
            }
        }


    }

    //推荐代理奖 $userid 是代理的id，level>=3 d1,d2,d3   d4 7500 d5 20000
    private function daili_reward1($user_id)
    {
        $userinfo = M('user')->find($user_id);
        $higherinfo = M('user')->find($userinfo['higher_id']);
        $map['u.level'] = array('gt',2);//高级会员以上
        $map['u.level'] = array('gt',2);//高级会员以上
        $map['admin_id'] = $user_id;
        $map['t.level'] = array('gt',0);
        $join = 'right join '.C('DB_PREFIX').'user as u on u.id = t.higher_id';
        $data4 = M('tj')->alias('t')->join($join)->where($map)->order('t.level asc')->field('u.*')->limit(3)->select();
        $config = M('reward_config')->find(1);
        if($userinfo['level'] == 3){
            foreach ($data4 as $k => $v)
            {
                if($v){
                    $this->add_fmoney($v['id'],$user_id,$config['d'.($k+1)],1,2,'推荐代理奖');
                    $save['id'] = $v['id'];
                    $save['z1'] = $v['z1'] + $config['d'.($k+1)];
                    M('user')->save($save);

                    $this->add_log($v['id'],$config['d'.($k+1)],1,'推荐代理奖发放','+');
                }
            }
        }



        if($userinfo['level'] == 4 && $higherinfo['level'] == 4){
            $this->add_fmoney($higherinfo['id'],$userinfo['id'],$config['d4'],1,2,'推荐代理奖');
            $save['id'] = $higherinfo['id'];
            $save['z1'] = $higherinfo['z1'] + $config['d4'];
            M('user')->save($save);

            $this->add_log($higherinfo['id'],$config['d4'],1,'推荐代理奖发放','+');
        }
        if($userinfo['level'] == 4 && $higherinfo['level'] == 5){
            $this->add_fmoney($higherinfo['id'],$userinfo['id'],$config['d4'],1,2,'推荐代理奖');
            $save['id'] = $higherinfo['id'];
            $save['z1'] = $higherinfo['z1'] + $config['d4'];
            M('user')->save($save);

            $this->add_log($higherinfo['id'],$config['d4'],1,'推荐代理奖发放','+');
        }

        if($userinfo['level'] == 5 && $higherinfo['level'] == 5){
            $this->add_fmoney($higherinfo['id'],$userinfo['id'],$config['d5'],1,2,'推荐代理奖');
            $save['id'] = $higherinfo['id'];
            $save['z1'] = $higherinfo['z1'] + $config['d5'];
            M('user')->save($save);

            $this->add_log($higherinfo['id'],$config['d5'],1,'推荐代理奖发放','+');
        }

        if($userinfo['level'] == 5 && $higherinfo['level'] == 4){
            $this->add_fmoney($higherinfo['id'],$userinfo['id'],$config['d5'],1,2,'推荐代理奖');
            $save['id'] = $higherinfo['id'];
            $save['z1'] = $higherinfo['z1'] + $config['d5'];
            M('user')->save($save);

            $this->add_log($higherinfo['id'],$config['d5'],1,'推荐代理奖发放','+');
        }



        return true;


    }
    //推荐代理奖 $userid 是代理的id，level>=3 d1,d2,d3   d4 7500 d5 20000
    private function daili_reward($user_id)
    {
        $userinfo = M('user')->find($user_id);
        $higherinfo = M('user')->find($userinfo['higher_id']);
        $map['u.level'] = array('gt',2);//高级会员以上
        $map['admin_id'] = $user_id;
        $map['t.higher_id'] = array('neq',1);

        $map['t.level'] = array('gt',0);
        $join = 'right join '.C('DB_PREFIX').'user as u on u.id = t.higher_id';
        $data4 = M('tj')->alias('t')->join($join)->where($map)->order('t.level asc')->field('u.*')->limit(3)->select();
        $config = M('reward_config')->find(1);
        if($userinfo['level'] == 3){
            foreach ($data4 as $k => $v)
            {
                if($v){
                    $this->add_fmoney($v['id'],$user_id,$config['d'.($k+1)],1,2,'推荐代理奖');
                    $save['id'] = $v['id'];
                    $save['z1'] = $v['z1'] + $config['d'.($k+1)];
                    M('user')->save($save);

                    $this->add_log($v['id'],$config['d'.($k+1)],1,'推荐代理奖发放','+');
                }
            }
        }



        if($userinfo['level'] == 4 || $userinfo['level'] == 5){
            $map1['u.level'] = array('gt',3);//高级会员以上
            $map1['admin_id'] = $user_id;
            $map1['t.level'] = array('gt',0);
            $map1['t.higher_id'] = array('neq',1);
            $join = 'right join '.C('DB_PREFIX').'user as u on u.id = t.higher_id';
            $data5 = M('tj')->alias('t')->join($join)->where($map)->order('t.level asc')->field('u.*')->limit(3)->select();

            if($userinfo['level'] == 4){
                foreach ($data5 as $k => $v)
                {
                    if($v['level']>3){
                        $this->add_fmoney($v['id'],$user_id,$config['d'.($k+4)],1,2,'推荐代理奖');
                        $save['id'] = $v['id'];
                        $save['z1'] = $v['z1'] + $config['d'.($k+4)];
                        M('user')->save($save);

                        $this->add_log($v['id'],$config['d'.($k+4)],1,'推荐代理奖发放','+');
                    }
                }
            }else{
                foreach ($data5 as $k => $v)
                {
                    if($v['level']>3){
                        $this->add_fmoney($v['id'],$user_id,$config['d'.($k+7)],1,2,'推荐代理奖');
                        $save['id'] = $v['id'];
                        $save['z1'] = $v['z1'] + $config['d'.($k+7)];
                        M('user')->save($save);

                        $this->add_log($v['id'],$config['d'.($k+7)],1,'推荐代理奖发放','+');
                    }
                }
            }
        }





        return true;


    }


    //见点奖 jiandian $user_id 必须是普通会员

    private function jiandian($user_id)
    {
        $config = M('reward_config')->find(1);
        $map['u.level'] = array('gt',3);//初级合伙人以上
        $map['admin_id'] = $user_id;
        $map['t.level'] = array('gt',0);
        $join = 'right join '.C('DB_PREFIX').'user as u on u.id = t.higher_id';
        $data4 = M('tj')->alias('t')->join($join)->order('t.level asc')->where($map)->field('u.*')->find();

        if($data4){

            $this->add_fmoney($data4['id'],$user_id,$config['jiandian'],1,4,'见点奖');

            $save['id'] = $data4['id'];
            $save['z1'] = $data4['z1']  + $config['jiandian'];
            M('user')->save($save);

            $this->add_log($data4['id'],$config['jiandian'],1,'见点奖金到账','+');
        }



//        $map['u.level'] = 5;//战略合伙人
//        $map['admin_id'] = $user_id;
//        $map['t.level'] = array('gt',0);
//        $join = 'right join '.C('DB_PREFIX').'user as u on u.id = t.higher_id';
//        $data4 = M('tj')->alias('t')->join($join)->order('t.level  asc')->where($map)->field('u.*')->find();
//
//        if($data4){
//
//            $this->add_fmoney($data4['id'],$user_id,$config['jiandian'],1,4,'见点奖');
//
//            $save['id'] = $data4['id'];
//            $save['z1'] = $data4['z1']  + $config['jiandian'];
//            M('user')->save($save);
//
//            $this->add_log($data4['id'],$config['jiandian'],1,'见点奖金到账','+');
//        }

    }


    public function test123()
    {
        $this->baodan(884,88);
    }

    //战略合伙人报单奖 user_id  普通会员  amount 报单金额
    private function baodan($user_id,$amount)
    {
        $config = M('reward_config')->find(1);


        $map['u.level'] = 5;//战略合伙人
        $map['admin_id'] = $user_id;
        $map['t.higher_id'] = array('neq',1);
        $map['t.level'] = array('gt',0);
        $join = 'right join '.C('DB_PREFIX').'user as u on u.id = t.higher_id';
        $data4 = M('tj')->alias('t')->join($join)->where($map)->order('t.level asc')->field('u.*')->find();
        if($data4){

            $this->add_fmoney($data4['id'],$user_id,$config['baodan']*$amount,1,6,'报单奖');

            $save['id'] = $data4['id'];
            $save['z1'] = $data4['z1']  + $config['baodan']*$amount;
            M('user')->save($save);

            $this->add_log($data4['id'],$config['baodan']*$amount,1,'报单奖金到账','+');
        }

        return true;

    }



    private function yeji_reward3($user_id,$amount)
    {

    }



    public function uuu()
    {
        $this->yeji_reward(902,88);
    }

    private function yeji_reward4($user_id,$amount)
    {
        $config = M('reward_config')->find(1);
        $tj = M('tj');
        $user = M('user');
        $map['admin_id'] = $user_id;
        $map['t.level'] = array('gt', 0);
        $map['u.level'] = array('gt', 3);;
        $map['t.higher_id'] = array('neq',1);
        $join = 'right join ' . C('DB_PREFIX') . 'user as u on u.id = t.higher_id';
        $highers = M('tj')->alias('t')->join($join)->where($map)->order('t.level asc')->field('u.*')->limit(1)->select(); //新增会员上面的所有初级合伙人,遍历他们的直推人（也是初级合伙人）
        if($highers){
            foreach ($highers as $k => $v){

                $userinfo = M('user')->find($v['id']);

                $map1['admin_id'] = $userinfo['id'];
                $map1['t.level'] = array('gt', 0);
                $map1['u.level'] = array('gt', 3);;
                $map1['t.higher_id'] = array('neq',1);
                $join1 = 'right join ' . C('DB_PREFIX') . 'user as u on u.id = t.higher_id';
                $higherss = M('tj')->alias('t')->join($join1)->where($map1)->order('t.level asc')->field('u.*')->limit(3)->select(); //新增会员上面的所有初级合伙人,遍历他们的直推人（也是初级合伙人）

                //  dump($higherss);die;\

                if($higherss){
                    foreach ($higherss as $k1 => $v1) {
                        $higherinfo = M('user')->find($v1['id']);
                        if($higherinfo['level'] >3){

                            $this->add_fmoney($higherinfo['id'],$user_id,$config['yeji_tc']*$amount,1,3,'业绩提成');

                            $save['id'] = $higherinfo['id'];
                            $save['z1'] = $higherinfo['z1']  + $config['yeji_tc']*$amount;
                            M('user')->save($save);

                            $this->add_log($higherinfo['id'],$config['yeji_tc']*$amount,1,'业绩提成奖金到账','+');
                        }
                    }
                }


            }
        }


        return true;


    }
    //初级合伙人业绩提成奖 2%


    private function yeji_reward($user_id,$amount)
    {
        $config = M('reward_config')->find(1);
        $tj = M('tj');
        $user = M('user');
        $map['admin_id'] = $user_id;
        $map['t.level'] = array('gt', 0);
        $map['u.level'] = 4;
        $map['t.higher_id'] = array('neq',1);
        $join = 'right join ' . C('DB_PREFIX') . 'user as u on u.id = t.higher_id';
        $highers = M('tj')->alias('t')->join($join)->where($map)->order('t.level asc')->field('u.*')->limit(1)->select(); //新增会员上面的所有初级合伙人,遍历他们的直推人（也是初级合伙人）
        if($highers){
            foreach ($highers as $k => $v){

                $userinfo = M('user')->find($v['id']);

                $map1['admin_id'] = $userinfo['id'];
                $map1['t.level'] = array('gt', 0);
                $map1['u.level'] = 4;
                $map1['t.higher_id'] = array('neq',1);
                $join1 = 'right join ' . C('DB_PREFIX') . 'user as u on u.id = t.higher_id';
                $higherss = M('tj')->alias('t')->join($join1)->where($map1)->order('t.level asc')->field('u.*')->limit(3)->select(); //新增会员上面的所有初级合伙人,遍历他们的直推人（也是初级合伙人）

                //  dump($higherss);die;\

                if($higherss){
                    foreach ($higherss as $k1 => $v1) {
                        $higherinfo = M('user')->find($v1['id']);
                        if($higherinfo['level'] ==4){

                            $this->add_fmoney($higherinfo['id'],$user_id,$config['yeji_tc']*$amount,1,3,'业绩提成');

                            $save['id'] = $higherinfo['id'];
                            $save['z1'] = $higherinfo['z1']  + $config['yeji_tc']*$amount;
                            M('user')->save($save);

                            $this->add_log($higherinfo['id'],$config['yeji_tc']*$amount,1,'业绩提成奖金到账','+');
                        }
                    }
                }


            }
        }


        return true;


    }



    //战略合伙人业绩提成奖 2%

    private function yeji_reward2($user_id,$amount)
    {

        $config = M('reward_config')->find(1);
        $tj = M('tj');
        $user = M('user');
        $map['admin_id'] = $user_id;
        $map['t.level'] = array('gt', 0);
        $map['u.level'] = 5;
        $map['t.higher_id'] = array('neq',1);
        $join = 'right join ' . C('DB_PREFIX') . 'user as u on u.id = t.higher_id';
        $highers = M('tj')->alias('t')->join($join)->where($map)->order('t.level asc')->field('u.*')->find(); //新增会员上面的所有初级合伙人,遍历他们的直推人（也是初级合伙人）
        if ($highers) {


            $map1['admin_id'] = $highers['id'];
            $map1['t.level'] = array('gt',0);
            $map1['u.level'] = 5;
            $map1['t.higher_id'] = array('neq',1);
            $join1 = 'right join ' . C('DB_PREFIX') . 'user as u on u.id = t.higher_id';
            $higherss = $tj->alias('t')->join($join1)->where($map1)->order('t.level asc')->field('u.*')->limit(3)->select();
            if ($higherss) {
                foreach ($higherss as $k1 => $v1) {


                    if($k1>0){
                        if($v1['level']<5){
                            continue;
                        }else{
                            $this->add_fmoney($v1['id'], $user_id, $config['yeji_tc'] * $amount, 1, 3, '业绩提成');

                            $save['id'] = $v1['id'];
                            $save['z1'] = $v1['z1'] + $config['yeji_tc'] * $amount;
                            $user->save($save);

                            $this->add_log($v1['id'], $config['yeji_tc'] * $amount, 1, '业绩提成奖金到账', '+');
                        }
                    }else{
                        $this->add_fmoney($v1['id'], $user_id, $config['yeji_tc'] * $amount, 1, 3, '业绩提成');

                        $save['id'] = $v1['id'];
                        $save['z1'] = $v1['z1'] + $config['yeji_tc'] * $amount;
                        $user->save($save);

                        $this->add_log($v1['id'], $config['yeji_tc'] * $amount, 1, '业绩提成奖金到账', '+');
                    }



                }
            }



        }


        return true;


    }






    public function checkuser()
    {
        if(IS_POST){


            $where['user_id'] = $this->user_info['id'];



            if(M('check')->where($where)->find()){
                $this->error('请等待审核');
            }

            if($this->user_info['level'] < 3){
                ajax_return(1,'您没有权限');
            }

            $map['user_id'] = $this->user_info['id'];
            $map['username'] = $this->user_info['username'];
            $map['truename'] = $this->user_info['truename'];
            $map['create_time'] = time();



            M('check')->add($map);

            ajax_return(0,'已提交申请',U('index'));


        }else{
            $map['user_id'] = $this->user_info['id'];
            $data = M('check')->where($map)->find();
            $this->assign('data',$data);
            $this->display();

        }
    }

    private function checklevel($user_id)
    {
        $map['status'] = 2;
        $save['id'] = $map['user_id'] = $user_id;
        $config =     M('reward_config')->field('h1,h2')->find();
        $m =  M('order')->where($map)->sum('amount');

        if($m>= $config['h1'] && $m<$config['h2']){
            $save['level'] = 2;
        }

        if($m>= $config['h2']){
            $save['level'] = 3;
        }

        $user = $this->user->find($user_id);
        if($user['level']<$save['level']){
            $this->user->save($save);
        }

        return true;


    }

    //库存
    public function add_min_sale($orderinfo)
    {
        //商品销量,库存
        if($orderinfo['goods_id']){
            $goodsinfo = M('goods')->find($orderinfo['goods_id']);

            $save['id']= $goodsinfo['id'];
            $save['sale'] = $goodsinfo['sale']+ $orderinfo['num'];
            $save['repertory'] = $goodsinfo['repertory'] - $goodsinfo['num'];
            M('goods')->save($save);

        }else{//有子订单
            $where['order_id'] = $orderinfo['id'];
            $suborderinfo = M('suborder')->where($where)->select();
            foreach ($suborderinfo as $k => $v)
            {
                $goodsinfo = M('goods')->find($v['goods_id']);

                $save['id']= $goodsinfo['id'];
                $save['sale'] = $goodsinfo['sale']+ $v['num'];
                $save['repertory'] = $goodsinfo['repertory'] - $v['num'];
                M('goods')->save($save);

            }
        }
    }

    //确认收货
    public function recevice()
    {
        if(IS_POST){
            $id = I('post.id',0);
            if($id){
                $o = M('order');
                $info = $o->find($id);

                $info['wuliu_status'] = 6;
                if($o->save($info) === false){
                    ajax_return(1,'收货失败!');
                }

                //判断是否要发服务奖
                if($info['send_shop_id'] != 0)
                {
                    $config = M('reward_config')->where(['id'=>1])->field('ptr54,ptr39,ptr45')->find();
                    $reward = $info['amount']*$config['ptr54']/100;
                    M('user')->where(['id'=>$info['send_shop_id']])->setInc('z3',$reward*(100-$config['ptr39'])/100*(100-$config['ptr45'])/100);
                    M('user')->where(['id'=>$info['send_shop_id']])->setInc('z2',$reward*$config['ptr39']/100*(100-$config['ptr45'])/100);

                    //添加记录购物积分
                    $fmoney['user_id'] = $info['send_shop_id'];
                    $fmoney['from_id'] = $info['user_id'];
                    $fmoney['amount'] = $reward*(100-$config['ptr39'])/100*(100-$config['ptr45'])/100;
                    $fmoney['type'] = 0; //物流积分
                    $fmoney['reward_type'] = 1;
                    $fmoney['create_time'] = time();
                    $fmoney['tips'] = '服务奖-购物积分';
                    M('fmoney')->add($fmoney);

                    //添加记录重销积分
                    $fmoney['amount'] = $reward*$config['ptr39']/100*(100-$config['ptr45'])/100;
                    $fmoney['create_time'] = time();
                    $fmoney['tips'] = '服务奖-重销积分';
                    M('fmoney')->add($fmoney);
                }

                ajax_return(0,'收货成功',U('orderlist'));
            }else{
                ajax_return(1,'非法参数');
            }
        }
    }

    public function deleteorder()
    {
        if(IS_POST){
            $id = I('post.id',0);
            if($id){
                $o = M('order');
                $info = $o->find($id);

                if(!$o->delete($id)){
                    ajax_return(1,'删除失败');
                }
//                if($info['wuliu_status'] != 5){
//                    ajax_return(1,'禁止删除');
//                }
//
//                $info['status'] = 10;
//                if($o->save($info) === false){
//                    ajax_return(1,'删除失败');
//                }

                ajax_return(0,'删除成功',U('orderlist'));
            }else{
                ajax_return(1,'非法参数');
            }
        }
    }
    //用户中心

    public function wxh5_pay()
    {
        $map['order_id'] = I('get.id');
        $data = M('order')->where($map)->find();


        if(!$data){
            $this->error('订单不存在');
        }

        $goods = M('goods')->find($data['goods_id']);
        $url = $this->wxh5Request($data['order_id'],$data['amount']);
        $this->assign('url',$url);
        $this->assign('data',$data);
        $this->assign('goods',$goods);
        $this->display('selectpay');
    }

    public function user_info()
    {

        if(IS_POST){
            $param = I('post.');
//            $map['phone'] = $param['phone'];
//            $dd = M('phone_code')->where($map)->order('create_time desc')->limit(1)->find();
//            if(!$dd){
//                ajax_return(1,'请获取验证码');
//            }
//
//            if(time() - $dd['create_time'] > 600){
//                ajax_return(1,'验证码已失效');
//            }
//
//            if($param['code'] != $dd['code']){
//                ajax_return(1,'验证码错误');
//            }


            if($this->user->save($param) === false){

                ajax_return(1,'保存失败');
            }

            ajax_return(0,'保存成功',U('index'));
        }else{
            $data = $this->user->find($this->user_info['id']);

            $data2 = $this->user->where(array('id'=>$data['service_id']))->find();//我的代理人
            $zhen = M('zhen')->find($data2['zhen']);
            $area = M('area')->find($zhen['father']);
            $city = M('city')->find($area['father']);

            $province = M('province')->find($city['father']);

            $map1['daili_level'] = 2;
            $map1['area'] = $area['id'];

            $map2['daili_level'] = 3;
            $map2['city'] = $city['id'];

            $map3['daili_level'] = 4;
            $map3['province'] = $province['id'];

            $d_area = $this->user->where($map1)->find();
            $d_city = $this->user->where($map2)->find();
            $d_province = $this->user->where($map3)->find();


            $data['zhen'] = $data2['username'].'('.$data2['truename'].')';
            $data['area'] = $d_area['username'].'('.$d_area['truename'].')';
            $data['city'] = $d_city['username'].'('.$d_city['truename'].')';
            $data['province'] = $d_province['username'].'('.$d_province['truename'].')';
            $this->assign('data',$data);
            $this->assign('bank_info',M('bank')->select());
            $this->display();
        }    }


    private function wxh5Request($out_trade_no,$total_fee){
        include_once  'wechatH5Pay.php';
        $appid = 'wx903fc0f0dd294962';
        $mch_id = '1493282642';//商户号
        $key = 'wx888888888888888888888888888888';//商户key
        $notify_url = "http://sd81114.tianruisoft.com/index.php/public/weixin_h5_notify";//回调地址
        $wechatAppPay = new \wechatAppPay($appid, $mch_id, $notify_url, $key);

        $params['body'] = '消费';                       //商品描述
        $params['spbill_create_ip'] = getip();                       //商品描述
        $params['out_trade_no'] = $out_trade_no;    //自定义的订单号
        $params['total_fee'] = $total_fee*100;                       //订单金额 只能为整数 单位为分
        $params['trade_type'] = 'MWEB';                   //交易类型 JSAPI | NATIVE | APP | WAP
        $params['scene_info'] = '{"h5_info": {"type":"Wap","wap_url": "http://sd81114.tianruisoft.com/index.php","wap_name": "消费"}}';
        $result = $wechatAppPay->unifiedOrder($params);
        $url = $result['mweb_url'].'&redirect_url=http://sd81114.tianruisoft.com/index.php';//redirect_url 是支付完成后返回的页面
        return $url;
    }


    public function safe()
    {
        $this->display();
    }



    public function password()
    {
        $this->display();
    }
    public function password2()
    {
        $this->display();
    }


    public function  address()
    {
        $map['user_id'] = $this->user_info['id'];
        $data = getAddress($map['user_id'],5);
        $return = I('get.returnurl');
        $this->assign('returnurl',urldecode($return));
        $this->assign('data',$data);
        $this->display('address');
    }


    public function add_address_()
    {
        if(IS_POST){
            $param = I('post.');
            $param['address'] =explode_address($param['prince'],$param['city'],$param['area']).$param['street'];
            $param['user_id'] = $this->user_info['id'];
            if($param['id']){
                if(M('address')->where(['id'=>$param['id']])->save($param) === false){
                    ajax_return(1,'地址修改失败');
                }
            }else{
                if(!M('address')->add($param)){
                    ajax_return(1,'地址添加失败');
                }
            }

            $url = U('address');
            if($param['returnurl']){
                $url = $param['returnurl'];
            }
            ajax_return(0,'保存成功',$url);
        }else{
            $province = M('province')->select();
            $return = I('get.returnurl');
            $this->assign('returnurl',urldecode($return));
            $this->assign('p',$province);
            $this->assign('title','新增地址');
            $this->display();
        }
    }


    public function setdeaultaddress()
    {
        if(IS_POST){
            $ad = M('address');
            $id = I('post.id',0);
            if($id){
                $save['is_default'] = 1;
                $where['user_id'] = $this->user_info['id'];
                if($ad->where($where)->save($save)===false){
                    ajax_return(1,'修改失败10001');
                }
                $save1['id'] = $id;
                $save1['is_default'] = 2;
                if($ad->save($save1) === false){
                    ajax_return(1,'修改失败10002');
                }


                ajax_return(0,'修改成功',U('address'));

            }else{
                ajax_return(1,'参数错误');
            }

        }
    }

    public function deleteaddress()
    {
        if(IS_POST){
            if(!M('address')->delete(I('post.id'))){
                ajax_return(1,'删除失败');
            }

            ajax_return(0,'删除成功',U('address'));
        }
    }

    public function edit_address()
    {
        $id = I('get.id',0);
        if($id){
            $data = M('address')->find($id);
            $this->assign('data',$data);

        }
        $city = M('city')->select();
        $area = M('area')->select();
        $this->assign('c',$city);
        $this->assign('a',$area);
        $province = M('province')->select();
        $this->assign('p',$province);
        $this->assign('title','编辑地址');
        $this->display('add_address_');
    }


    public  function  save_password(){
        $this->display();
    }

    public function change_password()
    {
        if(IS_POST){
            $param = I('post.');

            $param['id'] = $this->user_info['id'];
            $userinfo = $this->user->getUserinfoById($this->user_info['id']);

            if(md5($param['password_old'])!=$userinfo['password']){
                ajax_return(1,'旧密码错误');
            }

            if(empty($param['new_password'])){
                ajax_return(1,'请输入新密码');
            }

            if($param['new_password'] != $param['sure_password']){
                ajax_return(1,'两次密码不一致');
            }

            $param['password'] = md5($param['new_password']);

            if($this->user->save($param) === false){
                ajax_return(1,'密码修改失败');
            }else{
                ajax_return(0,'修改成功',U('index'));
            }
        }

    }

    public function change_password2()
    {
        if(IS_POST){
            $param = I('post.');

            $param['id'] = $this->user_info['id'];
            $userinfo = $this->user->getUserinfoById($this->user_info['id']);

            if(md5($param['password_old'])!=$userinfo['password2']){
                ajax_return(1,'旧密码错误');
            }

            if(empty($param['new_password'])){
                ajax_return(1,'请输入新密码');
            }

            if($param['new_password'] != $param['sure_password']){
                ajax_return(1,'两次密码不一致');
            }

            $param['password2'] = md5($param['new_password']);

            if($this->user->save($param) === false){
                ajax_return(1,'密码修改失败');
            }else{
                ajax_return(0,'修改成功',U('index'));
            }
        }

    }
    public function reward_detail()
    {
        $rewardType = I('reward_type');
        $map['reward_type'] = $rewardType;
        $this->assign('reward_type',$rewardType);

        $map['user_id'] = $this->user_info['id'];
        $data = M('fmoney')->where($map)->order('create_time desc')->select();
        foreach($data as $k=>$v){
            $data[$k]['username'] = M('user')->where(['id'=>$data[$k]['user_id']])->getField('username');
        }
        $this->assign('data',$data);
        $this->display();
    }


    public function money_detail()
    {
        $map['user_id'] = $this->user_info['id'];

        $data = M('money_detail')->where($map)->order('create_time desc')->select();
        $this->assign('data',$data);
        $this->display();
    }

    //提现
    public function withdraw()
    {

        $config = M('reward_config')->find(1);
        if(IS_POST){

//            if(!$this->is_check()){
//                ajax_return(1,'请先完成认证');
//            }

            $param = I('post.');

            $param['amount'] = trim($param['amount']);
            $mod = $param['amount']%$config['ptr22'];
            if($mod != 0){
                ajax_return(1,'提现金额须为'.$config['ptr22'].'的整数倍');
            }

            if($param['amount']<0){
                ajax_return(1,'提现金额不正确');

            }

            $data = M('user')->where(['id'=>$this->user_info['id']])->find();

            if(md5($param['password']) !=  $data['password2']){
                 ajax_return(1,'支付密码错误');
            }

//            //判断当天提现总额
            $startTime = strtotime(date("Y-m-d"),time());   //当天0点时间戳
            $endTime = time();  //现在时间戳
//
//
            $sumWhere['create_time'] = array('egt',$startTime);
            $sumWhere['create_time'] = array('elt',$endTime);
            $sumWhere['user_id'] = array('eq',$this->user_info['id']);
            $sumWhere['status'] = array('neq',3);
//
            $sum = M('withdraw')->where($sumWhere)->sum('amount');
            $zong = $sum + $param['amount'];
            if($zong > $config['ptr23']){
                $surplus = $config['ptr23'] - $sum;
                ajax_return(1,'每日申请提现上限提现'.$config['ptr23'].'积分,今日还可提现'.$surplus.'积分');
            }

//
//                if(!$data['truename'] || !$data['phone']){
//                    ajax_return(1,'请先完善个人资料');
//                }
//            //短信验证
//            $code = M('msg_list')->where(['mobile'=>$data['username']])->order('id desc')->find();
//
//            if($code['code'] == '')
//            {
//                //ajax_return(1,'验证码不正确，请重新发送！');
//            } else {
//                if($code['code'] != $param['code'])
//                {
//                    ajax_return(1,'验证码不正确，请重新发送！');
//                }
//            }

            if($data['z2']<$param['amount']){
                ajax_return(1,'流通积分不足');
            }


            $save['id']= $data['id'];
            $save['z2'] = $data['z2'] - $param['amount'];


            if($this->user->save($save) === false){
                ajax_return(1,'账户异常');
            }

            $config = M('reward_config')->find(1);

            $map['user_id'] = $data['id'];
            $map['amount'] = $param['amount'];
            $map['type'] = 1;//提现


            if($param['type'] == 1) //银行
            {
                if(!$data['bank_num'] || !$data['bank_user'] || !$data['bank_tree'] || !$data['bank_name']){
                    ajax_return(1,'请在个人资料中完善银行卡信息');
                }else{
                    $map['account'] = $data['bank_num'];
                    $map['bank_num'] = $data['bank_num'];
                    $map['bank_user'] = $data['bank_user'];
                    $map['bank_tree'] = $data['bank_tree'];
                    $map['bank_name'] = $data['bank_name'];
                }

            }

            if($param['type'] == 2) //微信
            {
                if(!$data['weixin']){
                    ajax_return(1,'请在个人资料中完微信信息');
                }else{
                    $map['weixin'] = $data['weixin'];
                }
            }

            if($param['type'] == 3) //支付宝
            {   if(!$data['weixin']){
                ajax_return(1,'请在个人资料中完支付宝信息');
                }else{
                    $map['zfb'] = $data['zfb'];
                }
            }

            $map['create_time'] = time();
            $map['sxf'] = $param['amount']*$config['j16'];
            if(!M('withdraw')->add($map))
            {
                ajax_return(1,'提现失败');
            }

            $this->add_log($data['id'],$param['amount'],1,'提现','-');
            ajax_return(0,'提交成功',U('index'));
        }else{
            $this->assign('bank_info',M('bank')->select());
            $this->assign('config',$config);
            $this->assign('cf',$config['j16']*100);
            $this->assign('data',$this->user->getUserinfoById($this->user_info['id']));
            $this->display();
        }
    }

    public function withdrawList()
    {

        $map['user_id'] = $this->user_info['id'];
        $data = M('withdraw')->where($map)->order('create_time desc')->select();
        $j16 = M('reward_config')->where(['id'=>1])->getField('j16');
        for($a=0;$a<count($data);$a++)
        {
            $data[$a]['last'] = $data[$a]['amount']*(1-$j16);
        }

        $this->assign('data',$data);
        $this->display();
    }


    public function accountlist()
    {

        $a = C('account_type');

        $id = I('get.id',1);
        $map['type'] = $id;
        $map['user_id'] = $this->user_info['id'];
        $data = M('money_detail')->where($map)->order('create_time desc')->select();
        $this->assign('title',$a[$id]);
        $this->assign('data',$data);
        $this->display();

    }

    public function zhuanzhanglist()
    {

        $this->display();


    }


    public function zhuanzhang()
    {$config = M('reward_config')->find(1);
        if(IS_POST){

//            if(!$this->is_check()){
//                ajax_return(1,'请先完成认证');
//            }

            $config = M('reward_config')->find(1);
            $param = I('post.');
            $param['type'] = $param['type']?$param['type']:1;

            if(!is_numeric(trim($param['amount'])) || $param['amount']<0){
                ajax_return(1,'金额格式不正确');
            }
            switch ($param['type']){
                case 1:
                    $from ='z1';
                    $to = 'z2';
                    $t1 =1;
                    $t2=2;
                    $title='余额转理财钱包';
                    break;
            }

            $data = $this->user->getUserinfoById($this->user_info['id']);
//            if($data['level']  != 4){
//                ajax_return(1,'您没有权限');
//            }


            if(md5($param['password']) !=  $data['password2']){
                ajax_return(1,'支付密码错误');
            }


            if($param['amount']>$data[$from]){
                ajax_return(1,'余额不足');
            }

            $save['id'] =$data['id'];
            $save[$from] = $data[$from] - $param['amount'];
            $save[$to] = $data[$to] + $param['amount'];

            if($this->user->save($save) === false){
                ajax_return(1,'账户异常');
            }

            $this->add_log($data['id'],$param['amount'],$t1,$title,'-');
            $this->add_log($data['id'],$param['amount'],$t2,$title,'+');

            ajax_return(0,'转出成功',U('index'));
        }else{
            $id = I('get.id',1);

            $title='余额转理财钱包';
            $data = $this->user->getUserinfoById($this->user_info['id']);
//            if($data['level']  != 4){
//                $this->error('您没有权限');
//            }
            $this->assign('data',$data);

            $this->assign('title',$title);
            $this->assign('type',$id);
            $this->assign('config',$config);
            $this->display();
        }
    }


    private function is_check()
    {
        return $this->user_info['is_check'];
    }

    public function zhuanzhang_user()
    {
        $data = $this->user->getUserinfoById($this->user_info['id']);
        if(IS_POST){
            $param = I('post.');
            if(!is_numeric(trim($param['amount'])) || $param['amount']<=0){
                ajax_return(1,'金额格式不正确');
            }

            if(!is_int($param['amount']/100)){
                ajax_return(1,'转账金额须为100的整数倍');
            }

            $data1 = $this->user->getUserByname($param['username']);

            if(!$data1){
                ajax_return(1,'会员不存在或未激活');
            }
            if(md5($param['password']) !=  $data['password2']){
                ajax_return(1,'支付密码错误');
            }


            if($param['amount']>$data['z3']){
                ajax_return(1,'余额不足');
            }

            if($param['username'] == $data['username']){
                ajax_return(1,'禁止转给自己');
            }

            $save['id'] =$data['id'];
            $save['z3'] = $data['z3'] - $param['amount'];
            $save2['id'] = $data1['id'];
            $save2['z3'] = $data1['z3'] + $param['amount'];

            $this->user->save($save2);
            $this->user->save($save);

            $this->add_log($save2['id'],$param['amount'],2,$data['username'].'接收');
            $this->add_log($save['id'],$param['amount'],3,$data1['username'].'发送','-');

            ajax_return(0,'转账成功',U('zhuanzhang_user'));
        }else{
            $data1 = $this->user->getUserinfoById($data['higher_id']);
            $this->assign('data',$data);
            $this->assign('title','积分分发');
            $this->display();
        }
    }

    public function zhuanzhang_user1()
    {
        $data = $this->user->getUserinfoById($this->user_info['id']);
        if(IS_POST){
            $param = I('post.');
            if(!is_numeric(trim($param['amount'])) || $param['amount']<=0){
                ajax_return(1,'金额格式不正确');
            }

            /*if(!is_int($param['amount']/100)){
                ajax_return(1,'转账金额须为100的整数倍');
            }*/

            if(md5($param['password']) !=  $data['password2']){
                ajax_return(1,'支付密码错误');
            }

            if($param['amount']>$data['z3']){
                ajax_return(1,'余额不足');
            }

            $save['id'] =$data['id'];
            $save['z1'] = $data['z1'] + $param['amount'];
            $save['z3'] = $data['z3'] - $param['amount'];
            $this->user->save($save);

            $this->add_log($save['id'],$param['amount'],3,$data['username'].'奖励转购物','-');

            ajax_return(0,'转账成功',U('zhuanzhang_user1'));
        }else{
            $data1 = $this->user->getUserinfoById($data['higher_id']);
            $this->assign('data',$data);
            $this->assign('title','积分分发');
            $this->display();
        }
    }

    /**
     * 会员充值
     **/
    public function recharge1()
    {
        $user_info = $this->user->getUserinfoById($this->user_info['id']);
        $this->assign('user_info',$user_info);

        if(IS_POST) {
            $param = I('post.');
            if (!is_numeric(trim($param['amount'])) || $param['amount'] <= 0) {
                $this->ajaxreturn(array('code' => 0, 'message' => '金额格式不正确'));
            }
            $param['amount'] = trim($param['amount']);

            if (md5($param['password']) != $user_info['password2']) {
                $this->ajaxreturn(array('code' => 0, 'message' => '支付密码错误'));
            }

            $countWhere['user_id'] = $this->user_info['id'];
            $countWhere['status'] = 1;
            $count = M('recharge')->where($countWhere)->count();
            if($count > 0){
                $this->ajaxreturn(array('code' => 0, 'message' => '当前有未处理充值记录,暂时不能申请充值，请尽快联系管理员处理'));
            }
            $map['user_id'] = $this->user_info['id'];
            $map['type'] = $param['type'];
            $map['amount'] = $param['amount'];
            $map['create_time'] = time();
            $map['order_id'] = 'CZ' . getOrderNum();

            if (!$id = M('recharge')->add($map)) {
                ajax_return(-1, '提交失败');
                $this->ajaxreturn(array('code' => 0, 'message' => '支付密码错误'));
            } else {
                $this->ajaxreturn(array('code' => 1, 'message' => '提交成功，请等待管理员处理'));
            }
        }
        $this->assign('config',M('reward_config')->find(1));
        $this->display();
    }

    /**
     * 购买wfx币
     */
     public function rechargeWfx(){

         $user_info = $this->user->getUserinfoById($this->user_info['id']);
         $this->assign('user_info',$user_info);
         if(IS_POST) {
             $param = I('post.');


             //金额
             if (!is_numeric(trim($param['amount'])) || $param['amount'] <= 0) {
                 $this->ajaxreturn(array('code' => 0, 'message' => '金额格式不正确'));
             }
             $param['amount'] = trim($param['amount']);
             //汇率
             if (!is_numeric(trim($param['hapy'])) || $param['hapy'] <= 0) {
                 $this->ajaxreturn(array('code' => 0, 'message' => '汇率出现问题'));
             }
             $param['hapy'] = trim($param['hapy']);
             //计算可以购买多少WFX币
             $wfx_num = $param['amount']/$param['hapy'];

             //验证密码是否正确
             if (md5($param['password']) != $user_info['password2']) {
                 $this->ajaxreturn(array('code' => 0, 'message' => '支付密码错误'));
             }


             // 重点 首次购买超过100WFX币,充值1000元,就升级为正式会员,1为临时会员,2为正式会员
             $map['amount'] = array('EGT',1000);
             $recharge_num = M('recharge')->where(array('user_id'=>$user_info['id']))->where($map)->count();

             //事务 :
//             M()->startTrans();
             $wfx_status = $user_info['status'];


             $data['z1']     = $user_info['z1'] - $param['amount'];//余额
             $data['z5']     = $user_info['z5'] + $wfx_num;
             $result =  M('user')->where(array('id'=>$this->user_info['id']))->save($data);
             //购买人记录 余额和wfx币操作记录
//             add_fmoney($user_id,$from_id,$amount,$type,$reward_type,$tips)
             $this->add_fmoney($user_info['id'], '', $param['amount'], 8, '', '购买WFX币', '-');

             $this->add_fmoney($user_info['id'], '', $wfx_num, 9, '', '购买'.$wfx_num.'个WFX币', '+');
             if($result) {
                 if($wfx_status == '1' && $wfx_num >=100 && $recharge_num>=1){
                     //升级为会员
                     $up_leve['status']        = 2;
                     M('user')->where(array('id'=>$this->user_info['id']))->save($up_leve);
                     //上级推荐正式会员个数加1
                     $higher_id  = $user_info['higher_id'];
                     //取出上一级推荐会员个数+1,给推荐正式员工WFX币
                     $member_higher          =  M('user')->where(array('id'=>$higher_id))->find();
                     $member_data['member_count'] =  $member_higher['member_count'] +1;
                     //推荐正式会员，第1-10个奖励10枚，20枚，30枚，40枚，50枚，60枚，70枚，80枚，90枚，100枚。第11个奖励10枚。
                     $num                    = $member_data['member_count']%10;
                     if($num == 0){
                         $reward_wfx         = 100;
                     }else{
                         $reward_wfx   =  $num *10;
                     }
                     $member_data['z5']           =  $member_higher['z5'] + $reward_wfx;
                     M('user')->where(['id'=>$higher_id])->save($member_data);
                     //推荐人 记录  wfx币操作记录
//             add_fmoney($user_id,$from_id,$amount,$type,$reward_type,$tips)
                     $this->add_fmoney($higher_id, $user_info['id'], '', 5, 511, '推荐第'.$member_data['member_count'].'个会员奖励'.$reward_wfx.'WFX币', '+');


                 }
                 $this->ajaxreturn(array('code' => 1, 'message' => '购买WFX币成功'));
             }else{
                 $this->ajaxreturn(array('code' => 0, 'message' => '购买WFX失败'));
             }
//             M()->commit();
//             M()->rollback();
//             $countWhere['user_id'] = $this->user_info['id'];
//             $countWhere['status'] = 1;
//             $count = M('recharge')->where($countWhere)->count();
//             if($count > 0){
//                 $this->ajaxreturn(array('code' => 0, 'message' => '当前有未处理充值记录,暂时不能申请充值，请尽快联系管理员处理'));
//             }
//             $map['user_id'] = $this->user_info['id'];
//             $map['type'] = $param['type'];
//             $map['amount'] = $param['amount'];
//             $map['create_time'] = time();
//             $map['order_id'] = 'CZ' . getOrderNum();
//
//             if (!$id = M('recharge')->add($map)) {
//                 ajax_return(-1, '提交失败');
//                 $this->ajaxreturn(array('code' => 0, 'message' => '支付密码错误'));
//             } else {
//                 $this->ajaxreturn(array('code' => 1, 'message' => '提交成功，请等待管理员处理'));
//             }
         }
         //取出余额,利率
         $this->assign('config',M('reward_config')->find(1));
         $this->display();
     }


    /**
     * 会员复投
     */
    public function futou()
    {
        //系统参数
        $config = M('reward_config')->where(['id'=>1])->find();

        //会员信息
        $user_info = $this->user->getUserinfoById($this->user_info['id']);
        $this->assign('user_info',$user_info);

        //post请求
        if(IS_POST) {
            $param = I('post.');
            if (!is_numeric(trim($param['amount'])) || $param['amount'] <= 0) {
                $this->ajaxreturn(array('code' => 0, 'message' => '金额格式不正确'));
            }
            $param['amount'] = trim($param['amount']);

            if (md5($param['password']) != $user_info['password2']) {
                $this->ajaxreturn(array('code' => 0, 'message' => '支付密码错误'));
            }

            if ($param['amount'] > $user_info['z2']) {
                $this->ajaxreturn(array('code' => 0, 'message' => '流通积分余额不足'));
            }else{
                $userSave['z2'] = $user_info['z2'] - $param['amount']; //更新账户余额
                $userSave['z1'] = $user_info['z1'] + $param['amount']; //更新账户余额
                $userSave['zong_jf'] = $user_info['zong_jf'] + $config['ptr4'] * $param['amount'];
                $userSave['own_zong'] = $user_info['own_zong'] + $param['amount'];
                if($user_info['level'] == 0 && $userSave['own_zong'] >= $config['ptr8']){
                    $userSave['level'] = 1;
                }
            }

            if(M('user')->where(['id'=>$user_info['id']])->save($userSave)){

                $db = M();
                $id = $user_info['id'];
                $money = $param['amount'];
                $aa = $db->execute("call kt001($id,$money)"); //增加团队业绩

                $map['user_id'] = $this->user_info['id'];
                $map['type'] = 1;
                $map['amount'] = $param['amount'];
                $map['create_time'] = time();
                $map['order_id'] = 'CZ' . getOrderNum();
                $map['pay_type'] = 2;   //会员复投
                $map['status'] = 2;   //复投直接通过
                $map['zong_jf'] = $map['amount'] * $config['ptr4']; //返还积分
                if ($id = M('recharge')->add($map)) {
                    $this->ajaxreturn(array('code' => 1, 'message' => '复投成功'));
                } else {
                    $this->ajaxreturn(array('code' => 0, 'message' => '复投失败，请重试'));
                }
            }else{
                $this->ajaxreturn(array('code' => 0, 'message' => '复投失败，请重试'));
            }
        }
        $this->display();
    }

    /**
     * 复投明细
     */
    public function futoulist()
    {
        $where['user_id'] = $this->user_info['id'];
        $where['pay_type'] = 2;
        $futouData = M('recharge')->where($where)->order('create_time desc')->select();
        $this->assign('futouData',$futouData);
        $this->display();
    }


    /**
     * 会员转账
     */
    public function transfer()
    {
        //系统参数
        $rewardConfig = M('reward_config')->where(['id'=>1])->find();

        //用户信息
        $user_info = $this->user->getUserinfoById($this->user_info['id']);
        $this->assign('user_info',$user_info);

        if(IS_POST) {
            $param = I('post.');

            //填写的用户名是否是自己
            if($user_info['username'] == $param['username']){
                $this->ajaxreturn(array('code' => 0, 'message' => '不能给自己转账'));
            }

            //转入的用户信息
            $OtherInfo = M('user')->where(['username'=>$param['username']])->find();
            if(!$OtherInfo){
                $this->ajaxreturn(array('code' => 0, 'message' => '用户不存在'));
            }

            //短信
            $code['mobile'] = $user_info['phone'];
            $Code = M('msg_list')->where($code)->order('id desc')->find();
            if ($param['code'] != $Code['code']) {
                $this->ajaxreturn(array('code' => 0, 'message' => '验证码错误'));
            }

//            //转入用户是否是正式会员
//            if($OtherInfo['level'] < 1){
//                $this->ajaxreturn(array('code' => 0, 'message' => '对方不是正式会员，不能接受转账'));
//            }

//            $res1Where['admin_id'] = $user_info['id'];
//            $res1Where['higher_id'] = $OtherInfo['id'];
//            $res1 = M('tj')->where($res1Where)->find();
//
//            $res2Where['admin_id'] = $OtherInfo['id'];
//            $res2Where['higher_id'] = $user_info['id'];
//            $res2 = M('tj')->where($res2Where)->find();
//            if(!$res1 && !$res2){
//                $this->ajaxreturn(array('code' => 0, 'message' => '不是纵线会员不能互转'));
//            }

            if (!is_numeric(trim($param['amount']))) {
                $this->ajaxreturn(array('code' => 0, 'message' => '金额格式不正确'));
            }

            if($param['amount'] < 100){
                $this->ajaxreturn(array('code' => 0, 'message' => '转账金额最少100'));
            }

            if ($param['amount'] %100 != 0) {
                $this->ajaxreturn(array('code' => 0, 'message' => '金额只能是100的整数倍'));
            }

            $param['amount'] = trim($param['amount']);

            if (md5($param['password']) != $user_info['password2']) {
                $this->ajaxreturn(array('code' => 0, 'message' => '支付密码错误'));
            }


//            $Service = $param['amount'] * $rewardConfig['j17']; //手续费
            $Service = 0;

            $Actual = $param['amount'] - $Service;
            if ($param['amount'] > $user_info['z10']) {
                $this->ajaxreturn(array('code' => 0, 'message' => 'IOTE奖金余额不足'));
            }else{
                $userSave['z10'] = $user_info['z10'] - $param['amount']; //更新账户余额
                $OtherSave['z10'] = $OtherInfo['z10'] + $Actual;  //更新转入账户余额
            }

            if(M('user')->where(['id'=>$user_info['id']])->save($userSave) && M('user')->where(['id'=>$OtherInfo['id']])->save($OtherSave)){
                $userRecord['user_id'] = $user_info['id'];
                $userRecord['from_id'] = $OtherInfo['id'];
                $userRecord['amount'] = $param['amount'];
                $userRecord['type'] = 2;
                $userRecord['reward_type'] = 7;
                $userRecord['create_time'] = time();
                $userRecord['tips'] = '转出给'.$OtherInfo['username'];
                $res1 = M('fmoney')->add($userRecord);

                $otherRecord['user_id'] = $OtherInfo['id'];
                $otherRecord['from_id'] = $user_info['id'];
                $otherRecord['amount'] = $Actual;
                $otherRecord['type'] = 2;
                $otherRecord['reward_type'] = 8;
                $otherRecord['create_time'] = time();
                $otherRecord['tips'] = $user_info['username'].'转进';
                $res2 = M('fmoney')->add($otherRecord);

                if($res1 && $res2){
                    $this->ajaxreturn(array('code' => 1, 'message' => '转账成功'));
                }else{
                    $this->ajaxreturn(array('code' => 0, 'message' => '转账失败，请重试'));
                }
            }else{
                $this->ajaxreturn(array('code' => 0, 'message' => '转账失败，请重试'));
            }
        }
        $this->display();
    }

    /**
     * 转账明细
     */
    public function transferlist()
    {
        $where['user_id'] = $this->user_info['id'];
        $where['reward_type'] = array('in','7,8');
        $transferData = M('fmoney')->where($where)->order('create_time desc')->select();
        $this->assign('transferData',$transferData);
        $this->display();
    }

    /**
     * 余额互转
     */
    public function change(){
        if (IS_POST){
            //系统参数
            $Config = M('reward_config')->where(['id'=>1])->find();

            //会员信息
            $UserInfo = M('user')->where(['id'=>$this->user_info['id']])->find();
            $this->assign('UserInfo',$UserInfo);

            //判断字段信息收购完整
            $param = I('post.');
            if($param['type'] == ""){
                $this->ajaxreturn(array('code' => 0, 'message' => '请选择转换类型'));
            }
            if($param['num'] == "" || $param['num'] < 0){
                $this->ajaxreturn(array('code' => 0, 'message' => '请输入正确的转换数量'));
            }
            if($param['password2'] == ""){
                $this->ajaxreturn(array('code' => 0, 'message' => '请输入支付密码'));
            }

            //验证支付密码
            if(md5($param['password2']) != $UserInfo['password2']){
                $this->ajaxreturn(array('code' => 0, 'message' => '支付密码不正确'));
            }

            if($param['type'] == 2){
                //验证余额是否足够
                if($param['num'] > $UserInfo['z2']){
                    $this->ajaxreturn(array('code' => 0, 'message' => '流通积分不足，当前剩余'.$UserInfo['z2']));
                }else{
                    $UserSave['z2'] = $UserInfo['z2'] - $param['num'];
                    //根据系统参数转换WFX数量
                    $SendNum = $param['num'] * $Config['ptr27'];
                    $UserSave['z5'] = $UserInfo['z5'] + $SendNum;
                }
                $tips1 = '转换WFX扣除';
                $tips2 = '流通转换获得';
            }

            if($param['type'] == 4){
                //验证余额是否足够
                if($param['num'] > $UserInfo['z4']){
                    $this->ajaxreturn(array('code' => 0, 'message' => '兑换积分不足，当前剩余'.$UserInfo['z4']));
                }else{
                    $UserSave['z4'] = $UserInfo['z4'] - $param['num'];
                    //根据系统参数转换WFX数量
                    $SendNum = $param['num'] * $Config['ptr27'];
                    $UserSave['z5'] = $UserInfo['z5'] + $SendNum;
                }
                $tips1 = '转换WFX扣除';
                $tips2 = '兑换转换获得';
            }

            if(M('user')->where(['id'=>$UserInfo['id']])->save($UserSave)){
                $this->add_fmoney($UserInfo['id'],$UserInfo['id'],$param['num'],$param['type'],9,$tips1);
                $this->add_fmoney($UserInfo['id'],$UserInfo['id'],$SendNum,5,10,$tips2);
                $this->ajaxreturn(array('code' => 1, 'message' => '转换成功'));
            }else{
                $this->ajaxreturn(array('code' => 0, 'message' => '转换失败，请重试'));
            }
        }
        //会员信息
        $UserInfo = M('user')->where(['id'=>$this->user_info['id']])->find();
        $this->assign('UserInfo',$UserInfo);
        $this->display();
    }

    /**
     * 转账明细
     */
    public function changelist()
    {
        $where['user_id'] = $this->user_info['id'];
        $where['reward_type'] = array('in','9,10');
        $transferData = M('fmoney')->where($where)->order('create_time desc')->select();
        $this->assign('transferData',$transferData);
        $this->display();
    }


    private function rechargeWard($user_id,$amount=0)
    {
        $user = M('user')->find($user_id);
        $save['id']  = $user_id;
        $save['z2'] = $user['z2']+$amount;
        $save['z4'] = $user['z4']+$amount/12*100;
        M('user')->save($save);

        $this->add_log($user_id,$amount,2,'商家充值');
        $this->add_log($user_id,$amount/12*100,4,'商家充值');

        return true;

    }


    public function rechargeList()
    {
        $map['user_id'] = $this->user_info['id'];
        $data = M('recharge')->where($map)->order('create_time desc')->select();
        $this->assign('data',$data);
        $this->display();
    }

    //网络关系图

    public function netMap()
    {
        if($this->user_info['is_service']  == 2){
            $param = I('get.');
            if($param['username']){ //根据用户名搜索
                $p_id = $this->user->where(array('username'=>$param['username']))->getField('id');
            }else{
                $p_id = $param['id'] ? $param['id'] : $this->user_info['id'];
            }

            $p_info = $this->user->find($p_id); //顶层结点
            $level_second_l = $this->find_left_right($p_info['id'],1);//次层左结点
            $level_second_r = $this->find_left_right($p_info['id'],2);//次层右结点


            $level_third_l1  = $this->find_left_right($level_second_l['id'],1);
            $level_third_r1 = $this->find_left_right($level_second_l['id'],2);



            $level_third_l2  = $this->find_left_right($level_second_r['id'],1);
            $level_third_r2  = $this->find_left_right($level_second_r['id'],2);

            $this->assign('p_info',$p_info);
            $this->assign('level_second_l',$level_second_l);
            $this->assign('level_second_r',$level_second_r);
            $this->assign('level_third_l1',$level_third_l1);
            $this->assign('level_third_r1',$level_third_r1);
            $this->assign('level_third_l2',$level_third_l2);
            $this->assign('level_third_r2',$level_third_r2);
        }
        $s = M('sysconfig')->find(2);
        $this->assign('is_open',$s['is_open']);
        $this->display('service_map');

    }

    private function  find_left_right($node_id,$left_right)
    {
        $where['node_id'] = $node_id;
        $where['left_right'] = $left_right;
        return $this->user->where($where)->find();
    }
    //订单
    public function orderList()
    {
        $param = I('get.status');
        if($param['status']==5){
            $map['o.wuliu_status'] = $param['status'];
            $this->assign('status',5);

        }else if ($param['status'] == 1 || $param['status'] == 2){
            $map['o.status'] = $param['status'];
            $map['o.wuliu_status'] = 4;
            $this->assign('status',$param['status']);
        }else{
            $this->assign('status',0);
        }

//        $map['o.order_type'] = 2;
        $map['o.user_id'] = $this->user_info['id'];
        //  $map['o.status'] = array('neq','10');
        $g = M('goods');
        $gi = M('goods_img');
        $o_sub = M('suborder');

        $join1 = 'right join '.C('DB_PREFIX').'order as o on o.goods_id = g.id';
        $count = $g->alias('g')->join($join1)->where($map)->count();
        $page = new Page($count,10);
        $goods = $g->alias('g')->join($join1)->where($map)->order('o.create_time desc')->limit($page->firstRow.','.$page->listRows)->field('o.order_id,o.create_time,o.id,o.num,o.amount,o.pay_amount,o.status,o.create_time,o.is_sub,o.wuliu,o.wuliu_status,g.price,g.name,g.format,g.id as g_id')->select();

        foreach ($goods as $k => $v)
        {
            $goods[$k]['over_time'] = $goods[$k]['create_time'] + 1800 - time();
            if ($goods[$k]['over_time'] < 0){
                $goods[$k]['over_time'] = 0;
            }
            $map1['type']= 1;
            $map1['goods_id'] =  $v['g_id'];
            $goods[$k]['path'] = $gi->where($map1)->getField('path');
            if($v['is_sub'] == 2){
                $map2['order_id'] = $v['id'];
                $sub_goods = $o_sub->where($map2)->select();
                foreach ($sub_goods as $k1=>$v1){
                    $map3['type']= 1;
                    $map3['goods_id'] =  $v1['goods_id'];
                    $sub_goods[$k1]= $g->find($v1['goods_id']);
                    $sub_goods[$k1]['path'] = $gi->where($map3)->getField('path');
                    $sub_goods[$k1]['num'] = $v1['num'];
                }


                $goods[$k]['children'] = $sub_goods;
            }
        }

        $this->assign('goods',$goods);
        $this->assign('page',$page->show());
        $this->display();
    }

    //订单详情
    public function orderShow()
    {
        $id = I('get.order_id');
        $map['order_id'] = $id;
        $o = M('order');
        $orderInfo = $o->where($map)->find();
        if($orderInfo['goods_id'] == NULL) //多商品
        {
            $orderInfo['suborder'] = M('suborder')->where(['order_id'=>$orderInfo['id']])->select();
            for ($a=0;$a<count($orderInfo['suborder']);$a++)
            {
                $orderInfo['suborder'][$a]['goodInfo'] = M('goods')->where(['id'=>$orderInfo['suborder'][$a]['goods_id']])->find();
                $orderInfo['suborder'][$a]['path'] = M('goods_img')->where(['goods_id'=>$orderInfo['suborder'][$a]['id']])->getField('path');
            }
        } else {
            $orderInfo['suborder'][0] = M('goods')->where(['id'=>$orderInfo['goods_id']])->find();
            $orderInfo['suborder'][0]['goodInfo'] = M('goods')->where(['id'=>$orderInfo['goods_id']])->find();
            $orderInfo['suborder'][0]['path'] = M('goods_img')->where(['goods_id'=>$orderInfo['goods_id']])->getField('path');
        }
        //dump($orderInfo);die;
        $this->assign([
            'id' => $id,
            'orderInfo' => $orderInfo
        ]);

        $this->display();
    }

    //客户订单
    public function memberOrderlist()
    {

        $map['o.send_shop_id'] = $this->user_info['id'];
        $map['o.status'] = 2; //已付款订单
        //  $map['o.status'] = array('neq','10');
        $g = M('goods');
        $gi = M('goods_img');
        $o_sub = M('suborder');

        $join1 = 'right join '.C('DB_PREFIX').'order as o on o.goods_id = g.id';
        $count = $g->alias('g')->join($join1)->where($map)->count();
        $page = new Page($count,10);
        $goods = $g->alias('g')->join($join1)->where($map)->order('o.create_time desc')->limit($page->firstRow.','.$page->listRows)->field('o.order_id,o.id,o.num,o.amount,o.status,o.create_time,o.is_sub,o.wuliu,o.wuliu_status,g.price,g.format,g.id as g_id')->select();

        foreach ($goods as $k => $v)
        {
            $map1['type']= 1;
            $map1['goods_id'] =  $v['g_id'];
            $goods[$k]['path'] = $gi->where($map1)->getField('path');
            if($v['is_sub'] == 2){
                $map2['order_id'] = $v['id'];
                $sub_goods = $o_sub->where($map2)->select();
                foreach ($sub_goods as $k1=>$v1){
                    $map3['type']= 1;
                    $map3['goods_id'] =  $v1['goods_id'];


                    $sub_goods[$k1]= $g->find($v1['goods_id']);
                    $sub_goods[$k1]['path'] = $gi->where($map3)->getField('path');
                    $sub_goods[$k1]['num'] = $v1['num'];
                }


                $goods[$k]['children'] = $sub_goods;
            }
        }

        $this->assign('goods',$goods);
        $this->assign('page',$page->show());
        $this->display();
    }

    //连锁店发货
    public function send_goods()
    {
        if(IS_POST) {
            $orderId = I('post.id');
            if(M('order')->where(['id'=>$orderId])->save(['wuliu_status'=>5]))
            {
                ajax_return(1,'发货成功!');
            }
            ajax_return(-1,'发货失败!');
        }
    }

    /**
     * 会员推荐(二维码)
     */
    public function qrcode(){
        $this->user_info['id'];
        //如果没有则生成
        //会员信息
        $UserInfo = M('user')->where(['id'=>$this->user_info['id']])->find();
//        $url = 'http://'.$_SERVER['HTTP_HOST'] . '/index.php/Public/register.html?&higher='.$UserInfo['username'];
        //$url = 'http://www.ghaglobal.com/index.php/Public/login/username/'.$UserInfo['id'];
        $url = 'http://pay.healthpays.net/index.php/Public/register/username/'.$UserInfo['id'];

        $qrpath = $this->addQrcode($url,$UserInfo['id']);
          $QrCodeUrl = "/Uploads/qrcode/".$qrpath;
        $this->assign('QrCodeUrl',$QrCodeUrl);
        $this->assign('url',$url);
        return $this->display();
    }

    /**
     * 二维码生成
     */
    public function addQrcode($url,$id){
        Vendor('phpqrcode.phpqrcode');
        //生成二维码图片
        $object = new \QRcode();


        $path = $_SERVER['DOCUMENT_ROOT']."/Uploads/qrcode/";
//        $path = "/Uploads/qrcode/";
        $time = time();
        $ad = $path.$time.$id.'.png';
        $errorCorrectionLevel ='L' ;//容错级别1
        $matrixPointSize = 6;//生成图片大小
        $object->png($url,  $ad, $errorCorrectionLevel, $matrixPointSize, 2);
        $src = $time.$id.'.png';
        return $src;
    }


}