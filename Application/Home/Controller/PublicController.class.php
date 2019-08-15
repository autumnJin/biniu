<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6 0006
 * Time: 15:47
 */

namespace Home\Controller;

use Admin\Model\UserModel;
use Think\Controller;

class PublicController extends Controller
{

    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new UserModel();
        if (!getSysStatus()) {
            header("Content-type:text/html;charset=utf-8");

            exit('系统维护中....');
        }
    }


    public function login()
    {
        if (session('User_yctr')) {
            $this->redirect('User/index');
        }
        if (IS_POST) {
            $param = I('post.');
            $param['password'] = md5($param['password']);

            if (!($info = M('user')->where($param)->find())) {
                ajax_return(1, '用户名或者密码错误');
            }
//            ajax_return(1,'维护期，晚上6点以后可以登录使用');
//            if($info['status'] == 1){
//                ajax_return(1,'您的账户未激活');
//            }

            if ($info['is_f'] == 2) {
                ajax_return(1, '您的账户已经被冻结');
            }

//            if($info['status'] != 2){
//                ajax_return(1,'请等待管理员开通');
//            }
            session('User_yctr', $info);
            $this->makeAdminLogin();
            ajax_return(0, '登录成功', U('User/index'));
        } else {
            $this->assign('username', I('get.username'));
            $this->display();
        }
    }

    /**
     * 登录接口
     * User: ming
     * Date: 2019/8/13 18:50
     */
    public function loginAPI()
    {
        if (session('User_yctr')) {
            ajax_return(1, '用户名或者密码错误');
//            $this->redirect('User/index');
        }
        if (IS_POST) {
            $param = I('post.');
            $param['password'] = md5($param['password']);

            if (!($info = M('user')->where($param)->find())) {
                ajax_return(1, '用户名或者密码错误');
            }
//            ajax_return(1,'维护期，晚上6点以后可以登录使用');
//            if($info['status'] == 1){
//                ajax_return(1,'您的账户未激活');
//            }

            if ($info['is_f'] == 2) {
                ajax_return(1, '您的账户已经被冻结');
            }

//            if($info['status'] != 2){
//                ajax_return(1,'请等待管理员开通');
//            }
            session('User_yctr', $info);
            $this->makeAdminLogin();
            ajax_return(0, '登录成功', U('User/index'));
        } else {
            $this->assign('username', I('get.username'));
            $this->display();
        }
    }




    //发送短信
//    public function sendCode()
//    {
//        if(IS_POST){
//            include 'smsapi.fun.php';
//            $uid = 'txhtsms0023';
//            $pwd = '833b1e88baac27c3e7641d477aac89a6';
//            $data['mobile'] = I('phone');
//            if(empty($data['mobile'])){
//                $this->ajaxreturn(array(code=>'1',message=>'请输入手机号'));
//            }
//            //           $msg_list = M('msg_list')->where('mobile = "'.$data['mobile'].'"')->order('id desc')->find();
//            //            if(time()-$msg_list['time']<120){
//            //                $this->ajaxreturn(array(code=>'1',message=>'请120秒后重试'));
//            //             ajax_return(1,'请120秒后重试');
//            //         }
//            /*$user = M('user')->where('username = "'.$data['mobile'].'"')->find();
//            if(empty($user)){
//                ajax_return(1,'该手机号未注册');
//            }*/
//            $data['code'] = randNumber(4);
//            $data['time'] = time();
//            M('msg_list')->add($data);
//            $content = '【GHA】尊敬的用户，您的验证码为：'.$data['code'].'，10分钟内有效，若非本人操作请忽略';
//            $content1=urlencode(mb_convert_encoding($content ,"gb2312","UTF-8"));
//            $res = sendSMS($uid,$pwd,$data['mobile'],$content1);
//            $this->ajaxreturn(array(code=>'1',message=>'发送成功'));
////            $this->ajaxreturn(array(code=>'1',message=>$res));
//        }
//    }
    public function sendCode()
    {

        if (IS_POST) {
            echo 333;die;

            include 'smsapi.fun.php';
            $uid = C('SMS.UID');
            $pwd = C('SMS.PWD');
            $data['mobile'] = I('phone');
            if (empty($data['mobile'])) {
                $this->ajaxreturn(array('code' => '1', 'message' => '请输入手机号'));
            }
            //           $msg_list = M('msg_list')->where('mobile = "'.$data['mobile'].'"')->order('id desc')->find();
            //            if(time()-$msg_list['time']<120){
            //                $this->ajaxreturn(array(code=>'1',message=>'请120秒后重试'));
            //             ajax_return(1,'请120秒后重试');
            //         }
            /*$user = M('user')->where('username = "'.$data['mobile'].'"')->find();
            if(empty($user)){
                ajax_return(1,'该手机号未注册');
            }*/
            $data['code'] = randNumber(4);
            $data['time'] = time();
            M('msg_list')->add($data);
//            $content = '【WFX】尊敬的用户，您的验证码为：'.$data['code'].'，若非本人操作请忽略';
            $content = '【Hpay】尊敬的用户，您的验证码为：' . $data['code'] . '，若非本人操作请忽略';
            $content1 = urlencode(mb_convert_encoding($content, "gb2312", "UTF-8"));
            $res = sendSMS($uid, $pwd, $data['mobile'], $content1);
            $this->ajaxreturn(array('code' => '1', 'message' => '发送成功'));
//            $this->ajaxreturn(array(code=>'1',message=>$res));
        }
    }

    /**
     * 短信接口
     * User: ming
     * Date: 2019/8/13 17:54
     */
    public function sendCodeAPI()
    {

        if (IS_POST) {

            include 'smsapi.fun.php';
            $uid = C('SMS.UID');
            $pwd = C('SMS.PWD');
            $data['mobile'] = I('phone');
            if (empty($data['mobile'])) {
                $this->ajaxreturn(array('code' => '1', 'message' => '请输入手机号'));
            }
                       $msg_list = M('msg_list')->where('mobile = "'.$data['mobile'].'"')->order('id desc')->find();
                        if(time()-$msg_list['time']<120){
                            $this->ajaxreturn(array('code'=>'-1','message'=>'请120秒后重试'));
//                         ajax_return(1,'请120秒后重试');
                     }
            /*$user = M('user')->where('username = "'.$data['mobile'].'"')->find();
            if(empty($user)){
                ajax_return(1,'该手机号未注册');
            }*/
            $data['code'] = randNumber(4);
            $data['time'] = time();
            M('msg_list')->add($data);
//            $content = '【WFX】尊敬的用户，您的验证码为：'.$data['code'].'，若非本人操作请忽略';
            $content = '【Hpay】尊敬的用户，您的验证码为：' . $data['code'] . '，若非本人操作请忽略';
            $content1 = urlencode(mb_convert_encoding($content, "gb2312", "UTF-8"));
            $res = sendSMS($uid, $pwd, $data['mobile'], $content1);
            $this->ajaxreturn(array('code' => '1', 'message' => '发送成功'));
//            $this->ajaxreturn(array(code=>'1',message=>$res));
        }
    }

    public function find_password()
    {
        if (IS_POST) {
            $param = I('post.');
            //dump($param);

            $param['password'] = md5($param['password']);
            $param['password2'] = md5($param['password2']);
            // if(!$param['username'] || ! $param['password'] || ! $param['code']){
            //     ajax_return(1,'填写信息不完整');
            // }
            if (!$info = $this->user->where(array('phone' => $param['phone']))->find()) {
                ajax_return(1, '该手机号未注册');
            }

            //$map['phone'] = $param['username'];
            $msg_list = M('msg_list')->where('mobile = "' . $param['phone'] . '"')->order('id desc')->find();

            if (!$msg_list) {
                ajax_return(1, '请获取验证码');
            }

            // if(time() - $dd['create_time'] > 120){
            //     ajax_return(1,'验证码已失效');
            // }

            if ($param['code'] != $msg_list['code']) {
                ajax_return(1, '验证码错误');
            }


            $save['id'] = $info['id'];
            $save['password'] = $param['password'];
            $save['password2'] = $param['password2'];

            if ($this->user->save($save) === false) {
                ajax_return(1, '密码找回失败');
            }

            ajax_return(0, '提交成功', U('login'));


        } else {
            $this->display();
        }
    }

    private function test($phone)
    {

        include 'smsapi.fun.php';
        $uid = 'tianrui';
        $pwd = 'b167d0f2f913b8843a491ce9d02bfaf5';
        $data['code'] = randNumber(4);
        $data['time'] = time();
        $content = '【cocoin】本次找回密码验证码为' . $data['code'] . '，请及时操作。';
        $content1 = urlencode(mb_convert_encoding($content, "gb2312", "UTF-8"));
        $res = sendSMS($uid, $pwd, $phone, $content1);
        $this->ajaxReturn('发送成功,请查看手机');


        require_once 'Ucpaas.class.php';
        $options['accountsid'] = 'bd8f02677ed3820aea2d5e0ddb942a0a';
        $options['token'] = '33901adfe0ee77c83b9ae8d90399912c';
        $appId = 'd7ba246e408648889edaeddd56367a93';
        $to = $phone;
        $templateId = 253918;

//初始化 $options必填

        $ucpass = new \Ucpaas($options);

//开发者账号信息查询默认为json或xml
        $code = randNumber(4);
        $map['code'] = $code;
        $map['phone'] = $phone;
        $map['create_time'] = time();

        M('phone_code')->add($map);

//        echo $ucpass->getDevinfo('xml');
        if ($ucpass->templateSMS($appId, $to, $templateId, $code)) {
            dump(11);
            die;
        }


    }


    public function getOut()
    {
        session('User_yctr', null);
        // session_destroy();
        $this->redirect('Index/index');
    }


    //微信H5支付回调
    public function weixin_h5_notify()
    {
        die;
        include_once 'wechatH5Pay.php';
        $notify = new \wechatAppPay();
        $xmlObj = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA']); //解析回调数据
        $out_trade_no = $xmlObj->out_trade_no;//订单号
        $total_fee = $xmlObj->total_fee;//钱
        $return_code = $xmlObj->return_code;
        // $rejg = $notify->orderQuery($out_trade_no);
        file_put_contents("out_trade_no.txt", $return_code);
        $order = M('recharge')->where('id = "' . $out_trade_no . '"')->find();

        if ($return_code == 'SUCCESS' and $order['status'] == 1) {

            $o = M('recharge');

            $save['id'] = $order['id'];
            $save['status'] = 2;
            $o->save($save);
            //  file_put_contents('log.txt',"【sql】:\n".M()->getLastSql()."\n");

            $this->user->where(array('id' => $order['user_id']))->setInc('z' . $order['account'], $order['amount']);
            file_put_contents('log.txt', "【sql】:\n" . M()->getLastSql() . "\n");

            $map['user_id'] = $order['user_id'];
            $map['amount'] = $order['amount'];
            $map['type'] = $order['account'];
            $map['account'] = $order['account'];
            $map['create_time'] = time();
            $map['tips'] = '账户充值';
            $map['flag'] = '+';

            M('money_detail')->add($map);

        }
    }


    // 推广奖与推荐代理奖

    private function rewardByUser($user_id)
    {
        $userinfo = $this->user->find($user_id);
        if ($userinfo) {

        }
        return true;
    }

    public function notifydfc()
    {
        Vendor('WxPayv3.JSAPI');
        $xmlObj = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA']); //解析回调数据
        $out_trade_no = $xmlObj->out_trade_no;//订单号
        $total_fee = $xmlObj->total_fee;//支付价格
        $openid = $xmlObj->openid;//
        $queryorder = new \MicroPay();
        $rejg = $queryorder->query($out_trade_no);

        if ($rejg) {
            //$data = M('reward_config')->find(1);
            //   $temp = explode('_',$out_trade_no);
            //  $out_trade_no = $temp[1];
            $map['order_id'] = $out_trade_no;
            $order = M('order')->where($map)->find();

            if ($order['status'] == 1) {

//                if($order['status']>1){
//                    exit();
//                }

                $save1['id'] = $order['id'];
                $save1['status'] = 2;
                $save1['time_end'] = strtotime($xmlObj->time_end);

                M('order')->save($save1);
                $db = M();
                if ($order['order_type'] == 1) {
                    $level = 1;
                    if ($order['goods_id']) {
                        $ttt = M('goods')->find($order['goods_id']);


                        $level = $ttt['price'] == 88 ? 2 : 3;


                    }


                    $u = $this->user->getUserinfoById($order['user_id']);


                    if ($level > $u['level']) {
                        $save['level'] = $level;
                        $save['id'] = $order['user_id'];
                        $this->user->save($save);

                    }

                    if (!M('tj')->where(['admin_id' => $order['user_id']])->find()) {
                        $userinfo = $this->user->find($order['user_id']);
                        $higher_info = $this->user->find($userinfo['higher_id']);

                        if ($higher_info) {
                            $id = $order['user_id'];
                            $higher_id = $higher_info['id'];
                            $db->execute("call net_add_tj($id,$higher_id)");
                        }

                    }

                    if ($level == 2) {

                        for ($i = 0; $i < $order['num']; $i++) {
                            $this->tuijian_reward2($order['user_id']);

                        }

                    }

                    if ($level == 3) {
                        $this->daili_reward($order['user_id']);
                    } else {
                        for ($i = 0; $i < $order['num']; $i++) {
                            $this->jiandian($order['user_id']);
                        }
                    }
                    //$this->baodan($order['user_id'],$order['amount']);
                    if ($level == 2) {
                        //  $this->yeji_reward($order['user_id'],$order['amount']);
                        //   $this->yeji_reward2($order['user_id'],$order['amount']);
                        $this->yeji_reward4($order['user_id'], $order['amount']);
                    }
                } else {

                }
                $a = $order['user_id'];
                $e = $order['amount'];
                $db->execute("call kt001($a,$e)");
                $this->add_min_sale($order);
            }
        }
    }


    public function yyy()
    {
        $user = M('user')->where(['level', ['gt', 1]])->select();
        foreach ($user as $k => $v) {
            $map['admin_id'] = $k['id'];
        }
    }


    public function notify_url()
    {

        //使用通用通知接口
        vendor('WxPayPubHelper.WxPayPubHelper');
        $notify = new \Notify_pub();

        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);

        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if ($notify->checkSign() == FALSE) {
            $notify->setReturnParameter("return_code", "FAIL");//返回状态码
            $notify->setReturnParameter("return_msg", "签名失败");//返回信息
        } else {
            $notify->setReturnParameter("return_code", "SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;

        //==商户根据实际情况设置相应的处理流程，此处仅作举例=======

        //以log文件形式记录回调信息


        // file_put_contents('log.txt',"【接收到的notify通知】:\n".$notify->checkSign()."\n");

        if ($notify->checkSign() == TRUE) {
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                file_put_contents('log.txt', "【通信出错】:\n" . $xml . "\n");
            } elseif ($notify->data["result_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                file_put_contents('log.txt', "【业务出错】:\n" . $xml . "\n");
            } else {
                //此处应该更新一下订单状态，商户自行增删操作
                $out_trade_no = $notify->data["out_trade_no"];

                $order = M('order')->where('order_id = "' . $out_trade_no . '"')->find();
                //  file_put_contents('log.txt',"【sql】:\n".M()->getLastSql()."\n");

                if ($order['status'] == 2) {
                    $this->success('订单已经支付', U('index/index'));
                    exit();
                }

                $o = M('order');

                $save['id'] = $order['id'];
                $save['status'] = 2;
                $o->save($save);
                file_put_contents('log.txt', "【sql】:\n" . M()->getLastSql() . "\n");

                if ($order['is_recharge'] == 2) { //充值订单处理
                    $recharge = M('recharge');
                    $save1['id'] = $order['recharge_id'];
                    $save1['status'] = 2;
                    $recharge->save($save1);


                    $this->rechargeWard($order['user_id'], $order['amount']);
                    $this->zhitui($order['id'], $order['amount']);


                } else if ($order['is_recharge'] == 1) {//普通订单处理
                    $save2['id'] = $order['user_id'];
                    $u = M('user')->find($order['user_id']);
                    $save2['z2'] = $u['z2'] + $order['amount'];

                    M('user')->save($save2);

                    $this->checklevel($order['user_id']);
                    $this->zhitui($order['id'], $order['amount']);


                    $this->add_log($u['id'], $order['amount'], 2, '品牌补贴', '+');
                    $this->add_fmoney($u['id'], $u['id'], $order['amount'], 2, 4, '品牌补贴');
                } else {

                }


            }
        }
    }


    protected function add_log($user_id, $amount = 0, $type, $tips, $flag = '+')
    {
        $map['user_id'] = $user_id;
        $map['amount'] = $amount;
        $map['type'] = $type;
        $map['create_time'] = time();

        // $map['account'] = $account;
        $map['flag'] = $flag;

        $map['tips'] = $tips;
        return M('money_detail')->add($map);
    }


    /**
     * 添加奖金纪录明细
     * @param $user_id
     * @param $from_id
     * @param $amount
     * @param $type
     * @param $reward_type
     * @param $tips
     * @return mixed
     */
    protected function add_fmoney($user_id, $from_id, $amount, $type, $reward_type, $tips)
    {
        $map['user_id'] = $user_id;
        $map['from_id'] = $from_id;
        $map['amount'] = $amount;
        $map['type'] = $type;
        $map['reward_type'] = $reward_type;
        $map['tips'] = $tips;
        $map['create_time'] = time();
        return M('fmoney')->add($map);
    }

    //随机生成钱包地址

    public function randomkeys($length)
    {
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz 
                         ABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $key .= $pattern{mt_rand(0, 35)};    //生成php随机数
        }
        return $key;
    }

    /**
     * 会员注册
     */
    public function register()
    {
        if (IS_POST) {
            $param = I('post.');
            if (empty($param['username'])) {
                ajax_return(1, '请输入用户名');
            }

            if (empty($param['password'])) {
                ajax_return(1, '请输入密码');
            }

            if (empty($param['password2'])) {
                ajax_return(1, '请输入支付密码');
            }

            $param['password'] = md5($param['password']);
            $param['password2'] = md5($param['password2']);
            $param['payaddress'] = $this->randomkeys(32);
//            if(!$param['province'] || !$param['city'] || !$param['area']){
//                ajax_return(1,'请完善区域信息');
//            }
//

//            if(!preg_phone($param['phone'])){
//                ajax_return(1,'手机号');
//            }

            //短信
//            $code['mobile'] = $param['phone'];
//            $code['code'] = $param['code'];
//
//            if(!M('msg_list')->where($code)->find())
//            {
//                ajax_return(1,'验证码不正确');
//            }

//            if (!preg_match('/^[_0-9a-z]{3,16}$/i',$param['username'])){
//            }

            //手机号已经注册账号个数
            $registerNum = M('user')->where(['phone' => $param['phone']])->count();
            if ($registerNum >= 1) {
                ajax_return(1, '每个手机号只能注册一个账号，请更换手机号注册');
            }

            //用户名是否存在
            if ($this->user->where(array('username' => $param['username']))->find()) {
                ajax_return(1, '该用户名已经注册');
            }

            //推荐人
            if (!$info = $this->user->getUserByname($param['higher'])) {
                ajax_return(1, '推荐人不存在');
            } else {
                //   if($info['status'] == 1){
                //      ajax_return(1,'推荐人未激活');
                //   }
                $param['higher_id'] = $info['id'];
            }
            $config = M('reward_config')->find();

            #注册时间
            $param['create_time'] = time();
            $param['status'] = 1;
            $time = time();
            $number = rand(111111, 999999);
            $string = $time . $number;

            $param['payaddress'] = md5($string);
            if (!$id = $this->user->add($param)) {
                ajax_return(1, '注册失败');
            }

            //注册成功,上级获得10wfx币
            //上级
//            $higher_data  = M('user')->where('id',$param['higher_id'])->find();
            $higher_data = M('user')->where(['id' => $param['higher_id']])->find();

            //推荐关系
            $higher_member_id = $param['higher_id'];
            $db = M();
            $aa = $db->execute("call net_add_tj($id,$higher_member_id)");

            //接点关系
            $bb = $db->execute("call net_add_jd_auto($id,$higher_member_id)");

            //登录信息
            #$userinfo = $this->user->find($id);
            #session('User_yctr',$userinfo);
            #$this->makeAdminLogin();

//            ajax_return(0,'注册成功',U('login',array('username'=>$param['username'])));
            ajax_return(0, '注册成功', U('login'));
        } else {

            if ($username = I('get.username')) {
                $this->assign('h', $username);
            }
            $province = M('province')->select();
            $this->assign('p', $province);

            $id = I('get.username');
            $user = M('user')->where(array('id' => $id))->find();
            //	dump($name);die;
            //   $this->assign('username',I('get.username'));
            $this->assign('username', $user['username']);
            // $this->assign('rand_user','AM'.randNumber());
            $this->display();
        }
    }

    /**
     * 注册接口
     * User: ming
     * Date: 2019/8/13 18:13
     */
    public function registerAPI()
    {
        if (IS_POST) {
            $param = I('post.');
            if (empty($param['phone'])) {
                ajax_return(1, '请输入手机号');
            }
            if (empty($param['password'])) {
                ajax_return(1, '请输入密码');
            }
            if (empty($param['password2'])) {
                ajax_return(1, '请输入支付密码');
            }
            $param['password'] = md5($param['password']);
            $param['password2'] = md5($param['password2']);

            $param['username'] = $param['phone'];//用户名=手机号
//            $param['payaddress'] = $this->randomkeys(32);
//            if(!preg_phone($param['phone'])){
//                ajax_return(1,'手机号');
//            }
            //短信
//            $code['mobile'] = $param['phone'];
            $code['code'] = $param['code'];
//
            if(!M('msg_list')->where($code)->find())
            {
                ajax_return(1,'验证码不正确');
            }
//            if (!preg_match('/^[_0-9a-z]{3,16}$/i',$param['username'])){
//            }
            //手机号已经注册账号个数
            $registerNum = M('user')->where(['phone' => $param['phone']])->count();
            if ($registerNum >= 1) {
                ajax_return(1, '每个手机号只能注册一个账号，请更换手机号注册');
            }
            //用户名是否存在
//            if ($this->user->where(array('username' => $param['username']))->find()) {
//                ajax_return(1, '该用户名已经注册');
//            }
            //推荐人
            if (!$info = $this->user->getUserByname($param['higher'])) {
                ajax_return(1, '推荐人不存在');
            } else {
                //   if($info['status'] == 1){
                //      ajax_return(1,'推荐人未激活');
                //   }
                $param['higher_id'] = $info['id'];
            }
//            $config = M('reward_config')->find();

            #注册时间
            $param['create_time'] = time();
            $param['status'] = 1;
            if (!$id = $this->user->add($param)) {
                ajax_return(1, '注册失败');
            }
            //推荐关系
            $higher_member_id = $param['higher_id'];
            $db = M();
            $aa = $db->execute("call net_add_tj($id,$higher_member_id)");
            //接点关系
//            $bb = $db->execute("call net_add_jd_auto($id,$higher_member_id)");
            //登录信息
            #$userinfo = $this->user->find($id);
            #session('User_yctr',$userinfo);
            #$this->makeAdminLogin();

//            ajax_return(0,'注册成功',U('login',array('username'=>$param['username'])));
            ajax_return(0, '注册成功', U('login'));
        } else {

            if ($username = I('get.username')) {
                ajax_return(0, '注册',$username);
            }else{
                ajax_return(1, '注册');
            }


        }
    }

    //登录记录
    private function makeAdminLogin()
    {
        $map['create_time'] = time();
        $map['ip'] = get_client_ip();
        $map['username'] = session('User_yctr.username');

        return M('user_login')->add($map);
    }

    public function area_choose()
    {
        if (IS_POST) {
            $province_id = I('post.pro_id');
            $region = M('city')->where('father = "' . $province_id . '"')->select();
            $opt = '<option>选择市</option>';
            foreach ($region as $key => $val) {
                $opt .= "<option value='{$val['cityid']}'>{$val['city']}</option>";
            }
            echo json_encode($opt);
        } else {
        }
    }

    public function city_choose()
    {
        if (IS_POST) {
            $city_id = I('post.city_id');
            $region = M('area')->where('father = "' . $city_id . '"')->select();
            $optt = '<option>选择区</option>';
            foreach ($region as $key => $val) {
                $optt .= "<option value='{$val['areaid']}'>{$val['area']}</option>";
            }
            echo json_encode($optt);
        } else {
        }
    }

    public function province_choose()
    {
        if (IS_POST) {
            $pianqu_id = I('post.pianqu_id');
            $region = M('province')->where('father = "' . $pianqu_id . '"')->select();

            $optt = '<option>--请选择省区--</option>';
            foreach ($region as $key => $val) {
                $optt .= "<option value='{$val['provinceid']}'>{$val['province']}</option>";
            }
            echo json_encode($optt);
        } else {
        }
    }


    public function explode_address($p, $c, $a)
    {

        $provinceid = M('province')->where('provinceid = "' . $p . '"')->find();
        $city = M('city')->where('cityid = "' . $c . '"')->find();
        $area = M('area')->where('areaid = "' . $a . '"')->find();
        return $provinceid['province'] . $city['city'] . $area['area'];

    }

    //三级分销奖


    public function zfb_return()
    {
        Vendor('Alipay.pagepay.service.AlipayTradeService');
        $arr = $_GET;

        $config = C("alipay");
        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($arr);

        echo "<script>window.location.href='/index.php/Index/index.html';</script>";
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if (json_encode($arr)) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号

            // $out_trade_no = htmlspecialchars($_GET['out_trade_no']);

            // //支付宝交易号

            // $trade_no = htmlspecialchars($_GET['trade_no']);
            echo "<script>window.location.href='/index.php/Index/index.html';</script>";
            // echo "验证成功<br />外部订单号：".$out_trade_no;

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            echo "验证失败";
        }
    }


    public function zfb_notify()
    {

        Vendor('Alipay.pagepay.service.AlipayTradeService');
        $config = C("alipay");
        $arr = $_POST;

        $alipaySevice = new \AlipayTradeService($config);

        $alipaySevice->writeLog(var_export($_POST, true));
        $result = $alipaySevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */

        if (json_encode($arr)) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号

            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];


            //   if($_POST['trade_status'] == 'TRADE_FINISHED') {

            // //判断该笔订单是否在商户网站中已经做过处理
            // 	//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            // 	//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
            // 	//如果有做过处理，不执行商户的业务程序

            // //注意：
            // //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            //   }
            if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                $where['order_id'] = $out_trade_no;
                $order = M('order')->where($where)->find();
                $userCenterLevel = M('user')->where(['id' => $order['user_id']])->getField('center_level');
                if ($order['status'] > 1) {
                    echo "success";
                    exit();
                }
                $save1['id'] = $order['id'];
                $save1['status'] = 2;
                $save1['time_end'] = time();
                M('order')->save($save1);

                //执行存储过程
                $db = M();
                $aa = $db->execute("call zhixing_ri()");

                //会员购买发报单奖给各个等级中心
                //当前用户中心等级
                if ($userCenterLevel == 0) {
                    $userCenterLevel = 1;
                }
                $wh['user_id'] = $order['user_id'];
                $wh['is_default'] = 2;
                //获取用户默认地址
                $address = M('address')->where($wh)->field('prince,city,area')->find();

                $whereAd['b.center_level'] = array('gt', $userCenterLevel);
                $whereAd['a.prince'] = $address['prince'];
                $whereAd['a.city'] = $address['city'];
                $whereAd['a.area'] = $address['area'];
                $whereAd['a.is_default'] = 2; //选择默认地址
                $list = M('address')->alias('a')//中心所有用户
                ->join('__USER__ b ON a.user_id=b.id')
                    ->where($whereAd)
                    ->field('b.id,b.username,b.center_level,a.longitude,a.latitude,a.street')
                    ->select();
                if ($list) {
                    for ($a = 0; $a < count($list); $a++) {
                        if ($list[$a]['center_level'] == 2) {
                            $cf = M('reward_config')->where(['id' => 1])->getField('ptr59');
                        }
                        if ($list[$a]['center_level'] == 3) {
                            $cf = M('reward_config')->where(['id' => 1])->getField('ptr60');
                        }
                        if ($list[$a]['center_level'] == 4) {
                            $cf = M('reward_config')->where(['id' => 1])->getField('ptr61');
                        }
                        $getMoney = $order['amount'] * $cf / 100;
                        //进入重销比例
                        $rate = M('reward_config')->where(['id' => 1])->getField('ptr39');
                        $srate = M('reward_config')->where(['id' => 1])->getField('ptr45');
                        if ($getMoney > 0) {
                            M('user')->where(['id' => $list[$a]['id']])->setInc('z3', $getMoney * (100 - $rate) / 100 * (100 - $srate) / 100);
                            M('user')->where(['id' => $list[$a]['id']])->setInc('z2', $getMoney * $rate / 100 * (100 - $srate) / 100);

                            //添加记录,报单奖-购物积分
                            $fmoney['user_id'] = $list[$a]['id'];
                            $fmoney['from_id'] = $order['user_id'];
                            $fmoney['amount'] = $getMoney * (100 - $rate) / 100 * (100 - $srate) / 100;
                            $fmoney['type'] = 0; //物流积分
                            $fmoney['reward_type'] = 1;
                            $fmoney['create_time'] = time();
                            $fmoney['tips'] = '区域奖-购物积分';
                            M('fmoney')->add($fmoney);

                            //添加记录,报单奖-重销积分
                            $fmoney['amount'] = $getMoney * $rate / 100 * (100 - $srate) / 100;
                            $fmoney['create_time'] = time();
                            $fmoney['tips'] = '区域奖-重销积分';
                            M('fmoney')->add($fmoney);
                        }
                    }
                }
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            echo "success";        //请不要修改或删除

        } else {
            //验证失败
            echo "fail";    //请不要修改或删除

        }
    }

    public function ttt()
    {

    }

    public function add_min_sale($orderinfo)
    {
        //商品销量,库存
        if ($orderinfo['goods_id']) {
            $goodsinfo = M('goods')->find($orderinfo['goods_id']);

            $save['id'] = $goodsinfo['id'];
            $save['sale'] = $goodsinfo['sale'] + $orderinfo['num'];
            $save['repertory'] = $goodsinfo['repertory'] - $goodsinfo['num'];
            M('goods')->save($save);

        } else {//有子订单
            $where['order_id'] = $orderinfo['id'];
            $suborderinfo = M('suborder')->where($where)->select();
            foreach ($suborderinfo as $k => $v) {
                $goodsinfo = M('goods')->find($v['goods_id']);

                $save['id'] = $goodsinfo['id'];
                $save['sale'] = $goodsinfo['sale'] + $v['num'];
                $save['repertory'] = $goodsinfo['repertory'] - $v['num'];
                M('goods')->save($save);

            }
        }


    }

    /**
     * 提币汇总
     * User: ming
     * Date: 2019/7/11 15:33
     */
    public function autoUsdtOmniAll()
    {
        set_time_limit(0);
        ignore_user_abort();
        $coininfo=C('OMNI');
//        $coininfo['user'] = 'usdtomni';
//        $coininfo['pass'] = 'usdtomni';
//        $coininfo['ip'] = '47.245.58.232';
//        $coininfo['port'] = '60001';
//        $mainadd = '396emUCuHYwCMzjapvq2YLrTMS2doVsJAM';//汇总地址
        $mainadd = $coininfo['address'];//汇总地址
        $CoinClient = CoinClient($coininfo['user'], $coininfo['pass'], $coininfo['ip'], $coininfo['port'], 5, array(), 1);
        $where['userid'] = array('neq', '');
        $where['address'] = array('neq', $mainadd);
        $where['status'] = 3;//已完成
        $where['type'] = 2;//提币
        $accounts = M('coinlist')->where($where)->field('address')->select();
        $json = $CoinClient->getwalletinfo();
        if (!isset($json['walletversion']) || !$json['walletversion']) {
            echo 'Wallet connect fail' . "<br>\n";
            exit;
        }
        foreach ($accounts as $k => $v) {
            $getinfo = $CoinClient->omni_getbalance($v['address'], 31);
            if ($getinfo['balance'] >= 10) {
                $trance = $CoinClient->omni_funded_send($v['address'], $mainadd, 31, $getinfo['balance'], $mainadd);
                if (strlen($trance) != 64) {
                    echo '汇总失败:' . $trance;
                } else {
                    echo '成功:' . $trance;
                }
            } else {
                echo '账户:' . $v['usdtb'] . '余额为:' . $getinfo['balance'] . ',不汇总.';
            }
        }
    }


}