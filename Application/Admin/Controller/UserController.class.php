<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6 0006
 * Time: 16:09
 */

namespace Admin\Controller;

use Admin\Model\UserModel;
use Think\Page;

class UserController extends BaseController
{
    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new UserModel();
    }


    public function userList()
    {
        $param = I('get.');
        $param['start_time'] = trim($param['start_time']);
        $param['end_time'] = trim($param['end_time']);
        if ($param['start_time'] && !$param['end_time']) {
            $map['create_time'] = array('gt', strtotime($param['start_time']));
            $this->assign('start_time', $param['start_time']);

        }
        if ($param['end_time'] && !$param['start_time']) {
            $map['create_time'] = array('lt', strtotime($param['end_time']));
            $this->assign('end_time', $param['end_time']);

        }

        if ($param['start_time'] && $param['end_time']) {
            $map['create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
            $this->assign('start_time', $param['start_time']);
            $this->assign('end_time', $param['end_time']);
        }

        if ($param['level']) {
            $map['level'] = $param['level'];
            $this->assign('level', $param['level']);
        }

//        if ($param['status']) {
//            $map['status'] = $param['status'];
//            $this->assign('status',$param['status']);
//
//        }

        if ($param['username']) {
//            $map['username'] = $param['username'];
            $map['username|phone'] = array('like', '%' . $param['username'] . '%');
            $this->assign('username', $param['username']);

        }

        if ($param['truename']) {
            $map['truename'] = $param['truename'];
            $this->assign('truename', $param['truename']);

        }

        if ($param['province']) {
            $map['province'] = $param['province'];
            $this->assign('province', $param['province']);
        }
        if ($param['city']) {
            $map['city'] = $param['city'];
            $this->assign('city', $param['city']);
        }


        $map['id'] = array('gt', 1);
        $count = $this->user->where($map)->count();
        $this->assign('count', $count);
        $page = new Page($count, 20);
        $this->assign('show', $page->show());
        $data = $this->user->where($map)->order('create_time desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($data as $k => $v) {
            $info1 = $this->user->getUserinfoById($v['higher_id']);
            $info2 = $this->user->getUserinfoById($v['node_id']);
            $info3 = $this->user->getUserinfoById($v['service_id']);
            $data[$k]['node_name'] = $info2['username'];
            $data[$k]['higher_name'] = $info1['username'];
//            $data[$k]['service_name'] =$info3['username'];
            $data[$k]['all'] = $v['zuo_zong'] + $v['you_zong'];
            $data[$k]['tj_count'] = M('user')->where(['higher_id' => $data[$k]['id']])->count();
        }

        if ($param['order_all']) {
            $this->assign('order_all', $param['order_all']);
        }
        if ($param['order_all'] == 1) {
            $data = list_arr($data, 'all');
        } else if ($param['order_all'] == 2) {
            $data = list_arr($data, 'all', 'asc');
        } else {

        }
        $this->assign('data', $data);
        $province = M('province')->select();
        $this->assign('p', $province);
        $this->display();
    }

    //会员退本操作
    public function backPT()
    {
        if (IS_POST) {
            $id = I('post.id');
            $UserInfo = $this->user->find($id);

            //最后一条矿机购买记录
            $Info = M('fmoney')->where(['user_id' => $UserInfo['id'], 'reward_type' => '51'])->order('create_time desc')->find();
            $Day = (time() - $Info['create_time']) / (24 * 60 * 60);  //矿机已购买天数

            //系统参数
            $Config = M('reward_config')->where(['id' => 1])->find();

            if ($Day < 30) { //状态为1时 配套够买未达30天 需要扣除所产生的奖金和10%手续费
                $map['from_id'] = $UserInfo['id'];
                $map['reward_type'] = array('in', '52,53,54');
                $map['flag3'] = 0;
                $sum = M('fmoney')->where($map)->sum('amount');
                $Free = $UserInfo['z6'] * 0.1;  //手续费
                $Back = $UserInfo['z6'] - $Free - $sum;    //冻结积分转换成USDT
            } else {  //配套够买达30天 直接返还本金
                $Back = $UserInfo['z6']; //冻结积分转换成USDT
            }

            $UserSave['z10'] = $UserInfo['z10'] + $Back;
            $UserSave['z6'] = 0;
            $UserSave['pt_level'] = 0;
            $UserSave['pt_flag'] = 0;
            $UserSave['is_open'] = 0;
            $UserSave['team_level'] = 0;

            if (M('user')->where(['id' => $UserInfo['id']])->save($UserSave)) {
                M('fmoney')->where(['from_id' => $UserInfo['id']])->save(['flag3' => 1]);
                $this->add_fmoney($UserInfo['id'], $UserInfo['id'], $Back, '10', '56', '配套退本');
                ajax_return(0, '退本成功', U('userList'));
            } else {
                ajax_return(1, '系统错误，请重试');
            }
        }
    }

    /**
     * 矿机激活
     */
    public function MachineOpen(){
        if(IS_POST){
            //会员信息
            $userId = I('post.id');
            $UserInfo = M('user')->where(['id'=>$userId])->find();
            if($UserInfo['is_open'] == 1){
                ajax_return(1,'矿机已激活，请勿重复操作');
            }

            if(M('user')->where(['id'=>$userId])->save(['is_open'=>1])){
                $db = M();
                $aa = $db->execute("call jiangjin_13()");   //直推奖
                ajax_return(0,'激活成功',U('userList'));
            }else{
                ajax_return(1,'激活失败，请重试');
            }
        }
    }

    /**
     * 矿机取消激活
     */
    public function MachineBack(){
        if(IS_POST){
            //会员信息
            $userId = I('post.id');
            $UserInfo = M('user')->where(['id'=>$userId])->find();

            $UserSave['pt_level'] = $UserInfo['old_pt_level'];
            $UserSave['z6'] = $UserInfo['old_z6'];
            $UserSave['is_open'] = 1;
            if(M('user')->where(['id'=>$userId])->save(['is_open'=>1])){
                ajax_return(0,'取消激活成功',U('userList'));
            }else{
                ajax_return(1,'取消激活失败，请重试');
            }
        }
    }



    //连锁店管理
    public function chainStoreManger()
    {
        $param = I('get.');
        $map['a.center_level'] = array('gt', 0);
        if ($param['prince']) {
            $map['c.province'] = $param['prince'];
            $this->assign('province', $param['prince']);
        }
        if ($param['city']) {
            $map['c.city'] = $param['city'];
            $map['a.center_level'] = array(array('gt', 0), array('lt', 4));
            $city = M('area')->where(['areaID' => $param['city']])->find();
            $this->assign('city', $city);
        }
        if ($param['area']) {
            $map['c.area'] = $param['area'];
            $map['a.center_level'] = array(array('gt', 0), array('lt', 3));
            $area = M('area')->where(['areaID' => $param['area']])->find();
            $this->assign('area', $area);
        }

        $map['a.id'] = array('gt', 1);
        $count = $this->user
            ->alias('a')
            ->join('__CENTER_ADDRESS__ c ON a.id=c.user_id')
            ->where($map)
            ->field('a.*')
            ->count();
        $this->assign('count', $count);
        $page = new Page($count, 20);
        $this->assign('show', $page->show());
        $data = $this->user
            ->alias('a')
            ->join('__CENTER_ADDRESS__ c ON a.id=c.user_id')
            ->where($map)
            ->field('a.*')
            ->order('create_time desc')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        foreach ($data as $k => $v) {
            $info1 = $this->user->getUserinfoById($v['higher_id']);
            $info2 = $this->user->getUserinfoById($v['node_id']);
            $info3 = $this->user->getUserinfoById($v['service_id']);
            $data[$k]['node_name'] = $info2['username'];
            $data[$k]['higher_name'] = $info1['username'];
//            $data[$k]['service_name'] =$info3['username'];
            $data[$k]['all'] = $v['zuo_zong'] + $v['you_zong'];
            $data[$k]['tj_count'] = M('user')->where(['higher_id' => $data[$k]['id']])->count();
        }
        if ($param['order_all']) {
            $this->assign('order_all', $param['order_all']);
        }
        if ($param['order_all'] == 1) {
            $data = list_arr($data, 'all');
        } else if ($param['order_all'] == 2) {
            $data = list_arr($data, 'all', 'asc');
        } else {

        }
        $this->assign('data', $data);
        $province = M('province')->select();
        $this->assign('p', $province);
        $this->display();
    }

    public function exportuser()
    {

        $param = I('get.');


        if ($param['start_time'] && !$param['end_time']) {
            $map['create_time'] = array('gt', strtotime($param['start_time']));
            $this->assign('start_time', $param['start_time']);

        }
        if ($param['end_time'] && !$param['start_time']) {
            $map['create_time'] = array('lt', strtotime($param['end_time']));
            $this->assign('end_time', $param['end_time']);

        }

        if ($param['start_time'] && $param['end_time']) {
            $map['create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
            $this->assign('start_time', $param['start_time']);
            $this->assign('end_time', $param['end_time']);


        }

        if ($param['province']) {
            $map['province'] = $param['province'];
            $this->assign('province', $param['province']);
        }
        if ($param['city']) {
            $map['city'] = $param['city'];
            $this->assign('city', $param['city']);
        }

        if ($param['status']) {
            $map['status'] = $param['status'];
            $this->assign('status', $param['status']);
        }

        if ($param['username']) {
            $map['username'] = $param['username'];
            $this->assign('username', $param['username']);

        }


        if ($param['truename']) {
            $map['truename'] = $param['truename'];

        }

        $map['id'] = array('gt', 1);
        $reg_level = C('level');
        $td_level = C('td_level');

        $data = $this->user->where($map)->order('create_time desc')->select();
        foreach ($data as $k => $v) {
//            $info1 = $this->user->getUserinfoById($v['higher_id']);
//            $data[$k]['higher_name'] = $info1['username'];
            $data[$k]['phone'] = $data[$k]['phone'].' ';
            $data[$k]['level'] = $reg_level[$v['level']];
            $data[$k]['td_level'] = $td_level[$v['td_level']];

            if($data[$k]['pt_level'] == 1){
                $data[$k]['pt_name'] = "100USDT";
            }elseif($data[$k]['pt_level'] == 2){
                $data[$k]['pt_name'] = "1000USDT";
            }elseif($data[$k]['pt_level'] == 3){
                $data[$k]['pt_name'] = "5000USDT";
            }elseif($data[$k]['pt_level'] == 4){
                $data[$k]['pt_name'] = "10000USDT";
            }else{
                $data[$k]['pt_name'] = "暂无配套";
            }

            $data[$k]['create_time'] = date('Y-m-d H:i:s',$data[$k]['create_time']);

        }


        $xlsName = '会员列表';
        $xlsCell = array(
            ['username', '用户账号'],
            ['phone', '手机号'],
            ['level', '会员级别'],
            ['td_level', '代理级别'],
            ['pt_name', '配套等级'],
            ['z6', 'IOTE算力'],
            ['z5', 'IOTE'],
            ['z7', 'BTC'],
            ['z8', 'USDT'],
            ['z9', 'ETH'],
            ['z10', 'IOTE奖金'],
            ['tj_count', '推荐人数'],
            ['zuo_zong', '总业绩'],
            ['eth_key', '会员私钥'],
            ['create_time', '注册时间'],


        );


        if ($data) {
            exportExcel($xlsName, $xlsCell, $data);
        } else {
            $this->error('找不到数据');
        }


    }

    /**
     * 导出提币数据
     * User: ming
     * Date: 2019/7/9 16:33
     */
    public function exportCoin()
    {

        $param = I('get.');


//        if ($param['start_time'] && !$param['end_time']) {
//            $map['create_time'] = array('gt', strtotime($param['start_time']));
//            $this->assign('start_time',$param['start_time']);
//
//        }
//        if ($param['end_time'] && !$param['start_time']) {
//            $map['create_time'] = array('lt', strtotime($param['end_time']));
//            $this->assign('end_time',$param['end_time']);
//
//        }
//
//        if ($param['start_time'] && $param['end_time']) {
//            $map['create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
//            $this->assign('start_time',$param['start_time']);
//            $this->assign('end_time',$param['end_time']);
//
//
//
//        }
//
//        if($param['province']){
//            $map['province'] = $param['province'];
//            $this->assign('province',$param['province']);
//        }
//        if($param['city']){
//            $map['city'] = $param['city'];
//            $this->assign('city',$param['city']);
//        }

        if ($param['status']) {
            $map['status'] = $param['status'];
            $this->assign('status', $param['status']);
        }

        if ($param['phone']) {
            $map['phone'] = $param['phone'];
            $this->assign('phone', $param['phone']);

        }

//
//        if($param['truename']){
//            $map['truename'] = $param['truename'];
//
//        }
        $map['type'] = 2;//提币数据
        $data = M('coinlist')->where($map)->order('id desc')->select();
        foreach ($data as $key => $v) {
            $data[$key]['username'] = M('user')->where(array('id' => $v['userid']))->getField('username');
            $data[$key]['phone'] = ' ' . $v['phone'];
            $data[$key]['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
            $data[$key]['endtime'] = date('Y-m-d H:i:s', $v['endtime']);
            $data[$key]['status'] = $v['status'] == 1 ? "已完成" : $v['status'] == 2 ? "审核中" : "已驳回";
        }
        $xlsName = '提币列表';
        $xlsCell = array(
            ['username', '会员编号'],
            ['phone', '手机号'],
            ['coinname', '币种名称'],
            ['address', '交易地址'],
            ['amount', '币种数量'],
            ['hash', '交易hash'],
            ['fee', '交易手续费'],
            ['status', '状态'],
            ['addtime', '添加时间'],
            ['endtime', '确认时间'],
        );


        if ($data) {
            exportExcel($xlsName, $xlsCell, $data);
        } else {
            $this->error('找不到数据');
        }


    }

    //会员新增

    public function userAdd()
    {
        header("Content-type:text/html;charset=utf-8");

        $data['username'] = randNumber(8);
        $this->assign('data', $data);
        $level = getLevel_();
        $this->assign('level', $level);
        $this->assign('title', '会员新增');
        $province = M('province')->select();
        $this->assign('p', $province);
        $this->display();
    }

    //会员修改
    public function userEdit()
    {
        header("Content-type:text/html;charset=utf-8");
        $this->assign('title', '修改会员等级');
        $info = $this->user->find(I('get.id'));
        $city = M('city')->select();
        $area = M('area')->select();

        $province = M('province')->select();
        $this->assign('p', $province);
        $this->assign('c', $city);
        $this->assign('a', $area);
        $this->assign('data', $info);
        $this->display('userAdd');
    }


    //充值
    public function rechargeByType()
    {
        if (IS_POST) {
            $param = I('post.');
            if (!is_numeric(trim($param['amount']))) {
                ajax_return(1, '金额格式不正确');
            }


            $user_info = $this->user->getUserinfoById($param['id']);
            $save['id'] = $param['id'];
            $param['amount'] = trim($param['amount']);
            switch ($param['accountType']) {
                case 1:
                    $save['z1'] = $user_info['z1'] + $param['amount'];
                    $type = 1;
                    break;
                case 2:
                    $save['z2'] = $user_info['z2'] + $param['amount'];
                    $type = 2;
                    break;
                case 3:
                    $save['z3'] = $user_info['z3'] + $param['amount'];
                    $type = 3;
                    break;
                case 4:
                    $save['z4'] = $user_info['z4'] + $param['amount'];

                    $type = 4;
                    break;
                case 5:
                    $save['z5'] = $user_info['z5'] + $param['amount'];

                    $type = 5;
                    break;
                case 7:
                    $save['z7'] = $user_info['z7'] + $param['amount'];

                    $type = 7;
                    break;
                case 8:
                    $save['z8'] = $user_info['z8'] + $param['amount'];

                    $type = 8;
                    break;
                case 9:
                    $save['z9'] = $user_info['z9'] + $param['amount'];

                    $type = 9;
                    break;

            }


//            if($param['accountType'] == 4){
//                $save['z2'] = $user_info['z2'] + $param['amount'];
//                $add1['amount'] = abs($param['amount']);
//                $add1['user_id'] = $param['id'];
//                $add1['create_time'] = time();
//                $add1['type'] =2 ;//充值
//
//                $add1['tips'] = '充值返里程积分';
//
//                $param['amount'] = $param['amount']/12*100;
//
//                if(!M('money_detail')->add($add1)){
//                    ajax_return(1,'写入记录失败');
//                }
//            }

            if ($this->user->save($save) === false) {
                ajax_return(1, '充值失败');
            }


            if ($param['flag']) {//如果充值充值积分账户成功，修改充值申请列表记录
                $map['status'] = 2;
                $map['id'] = $param['flag'];
                M('recharge')->save($map);
            }


            $da = $this->user->find($param['id']);
            $add['amount'] = abs($param['amount']);
            $add['user_id'] = $param['id'];
            $add['create_time'] = time();
            $add['type'] = $type;//充值
            $z = 'z' . $type;
            $add['tips'] = $param['shuoming'];

            if ($param['amount'] < 0) {
                $add['flag'] = '-';
            }


            if (!M('money_detail')->add($add)) {
                ajax_return(1, '写入记录失败');
            }

            ajax_return(0, '操作成功', U('userList'));


        } else {
            $data = $this->user->getUserinfoById(I('get.id'));
            $this->assign('data', $data);
            $this->assign('type', I('get.type'));
            if ($flag = I('get.flag')) {
                $this->assign('flag', I('get.flag'));
            }

            if ($money = I('get.money')) {
                $this->assign('money', $money);
            }

            $this->display();
        }
    }


    //充值申请拒绝

    public function refuseRecharge()
    {
        if (IS_POST) {
            $param = I('post.');
            $param['status'] = 3;
            if (M('recharge')->save($param) === false) {
                ajax_return(1, '操作失败');
            }

            ajax_return(0, '操作成功', U('rechargeList'));
        }
    }

    //修改、新增操作

    public function add_edit_user()
    {
        $map1['status'] = 1;
        $m = getLevel();
        if (IS_POST) {
            $param = I('post.');
//            $userSave['level'] = $param['level'];
            $userSave['td_level'] = $param['td_level'];
//            $userSave['province'] = $param['prince'];
//            $userSave['city'] = $param['city'];
//            $userSave['area'] = $param['area'];

//            if($userSave['level'] == 4){
//                if(empty($userSave['province']) || empty($userSave['city']) || empty($userSave['area'])){
//                    ajax_return(1,'升级全球合伙人请选择详细区域信息！');
//                }
//            }

            if (M('user')->where(['id' => $param['id']])->save($userSave)) {
                ajax_return(0, '修改成功', U('userList'));
            } else {
                ajax_return(1, '修改失败，请重试！');
            }
        } else {

            $this->assign('level', $m);
            $this->assign('rand_user', randNumber(8));
            // $province = M('province')->select();
            //  $this->assign('p',$province);
            //  $this->assign('bank_info',M('bank')->select());
            $this->assign('title', '会员注册');
            $this->display();
        }
    }

    //连锁店审核
    public function checkUpdate()
    {
        if (IS_POST) {
            $param = I('post.');
            if ($param['checkStauts'] == 3) {
                if (M('center_address')->where(['user_id' => $param['userId']])->delete()) {
                    ajax_return(1, '删除操作成功！');
                }
                ajax_return(-1, '删除操作失败！');
            }
            $res1 = M('center_address')->where(['user_id' => $param['userId']])->save(['status' => $param['checkStauts']]);
            if ($param['checkStauts'] == 1) {
                $res = M('user')->where(['id' => $param['userId']])->save(['center_level' => $param['level']]);
            }
            if ($res1) {
                ajax_return(1, '审核操作成功！');
            }
            ajax_return(-1, '审核操作失败！');
        }
        //审核中的数据
        $count = M('center_address')->count();
        $page = new Page($count, 15);
        $list = M('center_address')
            ->order('status desc,create_time desc')
            ->limit($page->firstRow . ',' . $page->listRows)->select();

        for ($a = 0; $a < count($list); $a++) {
            $list[$a]['username'] = M('user')->where(['id' => $list[$a]['user_id']])->getField('username');
            $list[$a]['provincename'] = M('province')->where(['provinceID' => $list[$a]['province']])->getField('province');
            $list[$a]['cityname'] = M('city')->where(['cityID' => $list[$a]['city']])->getField('city');
            $list[$a]['areaname'] = M('area')->where(['areaID' => $list[$a]['area']])->getField('area');
        }

        $this->assign([
            'list' => $list,
            'page' => $page,
            'count' => $count
        ]);
        $this->display();
    }

    //重置用户密码
    public function changePassword()
    {
        if (IS_POST) {
            $param = I('post.');
            $password = md5('123456');
            if (M('user')->where(['id' => $param['userId']])->save(['password' => $password])) ;
            {
                ajax_return(1, '密码重置成功!');
            }
            ajax_return(0, '密码重置失败!');
        }
    }

    //重置用户支付密码
    public function changePassword2()
    {
        if (IS_POST) {
            $param = I('post.');
            $password = md5('123456');
            if (M('user')->where(['id' => $param['userId']])->save(['password2' => $password])) ;
            {
                ajax_return(1, '密码重置成功!');
            }
            ajax_return(0, '密码重置失败!');
        }
    }

    public function explode_address($p, $c, $a)
    {

        $provinceid = M('province')->where('provinceid = "' . $p . '"')->find();
        $city = M('city')->where('cityid = "' . $c . '"')->find();
        $area = M('area')->where('areaid = "' . $a . '"')->find();
        return $provinceid['province'] . $city['city'] . $area['area'];

    }

    public function add_edit_user1()
    {
        $param = I('post.'); //user
        $level_info = explode('@', $param['level']);
        if ($param['id']) {
            $param['level'] = $level_info[0];
            $map['status'] = 2;
            $map['node_id'] = $param['node_id'];
            $map['left_right'] = $param['left_right'];

            unset($param['username']);
            if (!trim($param['password'])) {
                unset($param['password']);
            } else {
                $param['password'] = md5($param['password']);
            }
            if (!trim($param['password2'])) {
                unset($param['password2']);
            } else {
                $param['password2'] = md5($param['password2']);
            }
            if (M('user')->where(array('username' => $param['username']))->find()) {
                ajax_return(1, ' 该用户名已经被注册');
            }

            if (M('user')->where($map)->find()) {
                ajax_return(1, '该位置已经有会员注册，请重新选择');
            }
            if ($this->user->save($param) === false) {
                ajax_return(1, '修改失败');
            }
        } else {

            if (!trim($param['password']) || !trim($param['password2'])) {
                ajax_return(1, '密码不得为空');
            }
            $param['password'] = md5($param['password']);
            $param['password2'] = md5($param['password2']);
            if (!$param['username']) {
                ajax_return(1, '用户名不得为空');
            }
            if ($this->user->getUserByname($param['username'])) {
                ajax_return(1, '该用户已经存在');
            }
            //$users = $this->user->getUsersByname(array($param['higher_name'], $param['node_name']));
            $users_node = $this->user->getUserByname($param['node_name']);
            $users_high = $this->user->getUserByname($param['higher_name']);

            $param['higher_id'] = $users_high['id'];
            if (!$param['higher_id']) {
                ajax_return(1, '推荐人不存在');
            }

            if ($users_high['status'] != 2) {
                ajax_return(1, '推荐人还未开通');
            }
            $param['node_id'] = $users_node['id'];
            if (!$param['node_id']) {
                ajax_return(1, '接点人不存在');
            }


            $map['node_id'] = $param['node_id'];

            if ($users_node['level'] < 1) {
                ajax_return(1, '免费会员不得作为接点人');
            }
            if (!M('user')->where(array('id' => $param['node_id'], 'status' => 2))->find()) {
                ajax_return(1, '该接点人还未开通');
            }
            $map['left_right'] = $param['left_right'];
            if (M('user')->where($map)->find()) {
                ajax_return(1, '该位置已经有会员注册,重新选择');
            }

            $service_info = $this->user->getServiceByName($param['service_name']);


            if (!$service_info) {
                ajax_return(1, '服务中心不存在或还未开通');
            }

            $param['service_id'] = $service_info['id'];
            $param['create_time'] = time();
            $param['level'] = $level_info[0];
            if (!$id = $this->user->add($param)) {
                ajax_return(1, '添加失败');
            }
            //添加订单信息

            if (!$level_info[1] || !($reg_goods_info = M('goods')->find($level_info[1]))) {
                ajax_return(1, '未找到注册商品');
            }
            $order['user_id'] = $id;
            $order['order_id'] = getOrderNum();
            $order['goods_id'] = $reg_goods_info['id'];
            $order['pv_amount'] = $reg_goods_info['price'] * 0.8;
            $order['amount'] = $reg_goods_info['price'];
            $order['status'] = 1;
            $order['order_type'] = 1;
            //$suborder = M('suborder');

//            dump($param['goods']);die;
//            foreach ($param['goods'] as $k => $v) {
//                $order['pv_amount'] += $v['price'] * $v['num'];
//                $order['amount'] += $v['pv'] * $v['num'];
//                $order['goods_id'] = $v['id'];
//            }


//            $order['num'] = implode(',',$num);
//            $order['goods_id'] = implode(',',$goods_ids);

            $order['create_time'] = time();

            if (!$order_id = M('order')->add($order)) {
                ajax_return(1, '保存订单失败');  //总订单
            }
//            foreach ($param['goods'] as $k => $v) {//子订单
//                $param1['order_id'] = $order_id;
//                $param1['goods_id'] = $v['id'];
//                $param1['num'] = $v['num'];
//                $suborder->add($param1);
//            }

        }

        ajax_return(0, '保存成功', U('userList'));

    }


    public function checkEdit()
    {

        if (IS_POST) {
            $data = M('check')->find(I('post.id'));
            if (I('post.status') == 1) {
                $save['id'] = $data['id'];
                $save['status'] = 1;
                M('check')->save($save);

                $save2['id'] = $data['user_id'];
                $save2['role'] = 1;

                M('user')->save($save2);

                ajax_return(0, '操作成功', U('checklist'));
            } else {
                if (!M('check')->delete($data['id'])) {
                    ajax_return(1, '操作失败');
                }
            }

        }
        $this->assign('data', M('check')->find(I('get.id')));
        $this->display();
    }

    public function checklist()
    {
        $param = I('get.');
        if ($param['status']) {
            $map['status'] = $param['status'];
        }

        if ($param['username']) {
            $map['username'] = $param['username'];
        }
        $count = M('check')->where($map)->count();
        $page = new Page($count, 20);
        $list = M('check')->order('create_time desc')->where($map)->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('show', $page->show());
        $this->display();
    }


    public function docheck()
    {
        if (IS_POST) {
            $param = I('post.');

        }
    }

    //前台登录
    public function dongjie()
    {
        if (IS_POST) {
            $param = I('post.');
            $data = $this->user->getUserinfoById($param['id']);
            $save['id'] = $data['id'];
            $save['is_f'] = $data['is_f'] == 1 ? 2 : 1;
            if ($this->user->save($save) === false) {
                ajax_return(1, '操作失败');
            }
            ajax_return(0, '操作成功', U('userList'));
        }
    }


    public function userFront()
    {


        $s = $_SERVER['SCRIPT_NAME'];

        $s = substr($s, 0, -9);
        //   dump($s);die;

        $info = $this->user->getUserinfoById(I('get.id'));
        session('User_yctr', $info);
        // $this->redirect('Home/Index/index');
        header("Location:http://" . $_SERVER['SERVER_NAME'] . $s . "index.php/Index/index");
    }

    /**
     * 后台激活会员
     */
    public function activeUser()
    {
        if (IS_POST) {
            $param = I('post.');
            $userinfo = $this->user->getUserinfoById($param['user_id']);
            if ($userinfo['status'] == 2) {
                ajax_return(1, '请不要重复开通');
            }
            $where['id'] = $param['user_id'];
            $where['status'] = 2; //改为已开通状态
            $where['pass_time'] = time();
            $config = M('reward_config')->where(['id' => 1])->find();    //激活会员返购物币\
            $where['z3'] = $userinfo['z3'] + $config['ptr1'];
            // $where['tj_count'] = $userinfo['tj_count'] +1 ;
            if (M('user')->save($where) === false) {
                ajax_return(1, '会员状态操作失败');
            }

            $save['id'] = $userinfo['higher_id'];
            $hihgerinfo = $this->user->getUserinfoById($save['id']);
            $save['tj_count'] = $hihgerinfo['tj_count'] + 1;

            if ($this->user->save($save) === false) {
                ajax_return(1, '推荐人异常');
            }
            ajax_return(0, '开通成功', U('User/userList'));
        }
    }

    public function withdraw()
    {
        if (IS_POST) {

        } else {

            header("Content-Type:text/html;charset=utf-8");
            $status = I('get.status', 0);
            $username = I('get.username');
            $param = I('get.');

            if ($param['start_time'] && !$param['end_time']) {
                $map['w.create_time'] = array('gt', strtotime($param['start_time']));
                $this->assign('start_time', $param['start_time']);

            }
            if ($param['end_time'] && !$param['start_time']) {
                $map['w.create_time'] = array('lt', strtotime($param['end_time']));
                $this->assign('end_time', $param['end_time']);

            }

            if ($param['start_time'] && $param['end_time']) {
                $map['w.create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
                $this->assign('start_time', $param['start_time']);
                $this->assign('end_time', $param['end_time']);


            }
            if ($status) {
                $map['w.status'] = $status;
                $this->assign('status', $param['status']);

            }


            if ($username) {
                $map['username'] = $username;
                $this->assign('username', $param['username']);

            }
            $join = 'left join ' . C('DB_PREFIX') . 'user as u on u.id = w.user_id';

            $count = M('withdraw')->alias('w')->join($join)->where($map)->count();
            $this->assign('count', $count);
            $page = new Page($count, 10);
            $list = M('withdraw')->alias('w')->join($join)->where($map)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->field('w.*,u.username')->select();

            foreach ($list as $k => $v) {
                $bank = M('bank')->find($v['bank_name']);
                $list[$k]['bank_name'] = $bank['name'];
            }

            $this->assign('page', $page->show());
            $this->assign('data', $list);
            $config = M('reward_config')->find();
            $sxf = $config['cf'];
            $this->assign('sxf', $sxf);

            $this->assign('bank_info', M('bank')->getField('id,name'));
            $this->display();
        }
    }

    /**
     * 矿机购买列表
     * User: ming
     * Date: 2019/6/29 8:32
     */
    public function discover()
    {
        if (IS_POST) {

        } else {

            header("Content-Type:text/html;charset=utf-8");
            $status = I('get.status', 0);
            $username = I('get.username');
            $param = I('get.');

            if ($param['start_time'] && !$param['end_time']) {
                $map['w.create_time'] = array('gt', strtotime($param['start_time']));
                $this->assign('start_time', $param['start_time']);

            }
            if ($param['end_time'] && !$param['start_time']) {
                $map['w.create_time'] = array('lt', strtotime($param['end_time']));
                $this->assign('end_time', $param['end_time']);

            }

            if ($param['start_time'] && $param['end_time']) {
                $map['w.create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
                $this->assign('start_time', $param['start_time']);
                $this->assign('end_time', $param['end_time']);


            }
            if ($status) {
                $map['w.status'] = $status;
                $this->assign('status', $param['status']);

            }


            if ($username) {
                $map['username'] = $username;
                $this->assign('username', $param['username']);

            }
            $map['w.type'] = 8;
            $map['w.reward_type'] = 51;

            $join = 'left join ' . C('DB_PREFIX') . 'user as u on u.id = w.user_id';

            $count = M('fmoney')->alias('w')->join($join)->where($map)->count();
            $this->assign('count', $count);
            $page = new Page($count, 10);
//            $list = M('withdraw')->alias('w')->join($join)->where($map)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->field('w.*,u.username')->select();
            $list = M('fmoney')->alias('w')->join($join)->where($map)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->field('w.*,u.username,u.phone')->select();

//            foreach ($list as $k => $v)
//            {
//                $bank = M('bank')->find($v['bank_name']);
//                $list[$k]['bank_name']= $bank['name'];
//            }
            $this->assign('page', $page->show());
            $this->assign('data', $list);
            $config = M('reward_config')->find();
            $sxf = $config['cf'];
            $this->assign('sxf', $sxf);

            $this->assign('bank_info', M('bank')->getField('id,name'));
            $this->display();
        }
    }

    /**
     * 闪兑审核
     */
    public function exchange()
    {
        if (IS_POST) {

        } else {

            header("Content-Type:text/html;charset=utf-8");
            $status = I('get.status', 0);
            $username = I('get.username');
            $param = I('get.');

            if ($param['start_time'] && !$param['end_time']) {
                $map['w.create_time'] = array('gt', strtotime($param['start_time']));
                $this->assign('start_time', $param['start_time']);

            }
            if ($param['end_time'] && !$param['start_time']) {
                $map['w.create_time'] = array('lt', strtotime($param['end_time']));
                $this->assign('end_time', $param['end_time']);

            }

            if ($param['start_time'] && $param['end_time']) {
                $map['w.create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
                $this->assign('start_time', $param['start_time']);
                $this->assign('end_time', $param['end_time']);


            }
            if ($status) {
                $map['w.status'] = $status;
                $this->assign('status', $param['status']);

            }


            if ($username) {
                $map['username'] = $username;
                $this->assign('username', $param['username']);

            }
            $join = 'left join ' . C('DB_PREFIX') . 'user as u on u.id = w.user_id';

            $count = M('exchange')->alias('w')->join($join)->where($map)->count();
            $this->assign('count', $count);
            $page = new Page($count, 10);
            $list = M('exchange')->alias('w')->join($join)->where($map)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->field('w.*,u.username')->select();

            foreach ($list as $k => $v) {
                if ($v['sure_time'] == '') {
                    $list[$k]['sure_time'] = '';
                }
//                $bank = M('bank')->find($v['bank_name']);
//                $list[$k]['bank_name']= $bank['name'];

            }

            $this->assign('page', $page->show());
            $this->assign('data', $list);
            $config = M('reward_config')->find();
            $sxf = $config['cf'];
            $this->assign('sxf', $sxf);

            $this->assign('bank_info', M('bank')->getField('id,name'));
            $this->display();
        }
    }

    public function doexchange()
    {
        $param = I('get.');
        $w = M('exchange');

        $info = $w->find($param['id']);
        $config = M('reward_config')->find();
        $sxf = $config['cf'];
        // $sxf =0.1;
        $param['true_amount'] = $info['amount'] * (1 - $sxf);
//        if($w->save($param) === false){
//            $this->error('审核失败');
//        }

        if ($param['status'] == 2) {
            $arr1['status'] = 2;
            $arr1['sure_time'] = time();
            $res = M('exchange')->where(array('id' => $param['id']))->save($arr1);
            $this->add_log($info['user_id'], $info['from_coin_num'], 1, '闪兑通过', '-');
            if ($res) {
                $this->success('操作成功', U('exchange'));
            } else {
                $this->error('操作失败');
            }
//           $map['user_id'] =$info['user_id'];
//           $map['tips'] = '提现通过,手续费比例'.$sxf;
//           $map['amount'] = $param['true_amount'];
//           $map['account'] = $info['account'];
//
//
//
//           if(!M('money_detail')->add($map)){
//               $this->error('流水记录记录失败');
//           }
        } elseif ($param['status'] == 3) {//驳回返还
            $map['id'] = $info['user_id'];
            $u = $this->user->getUserinfoById($map['id']);
            $fromcoin = 'z' . $info['from_coin'];
            $tocoin = 'z' . $info['to_coin'];
            $map[$fromcoin] = $u[$fromcoin] + $info['from_coin_num'];
            if ($u[$tocoin] < $info['to_exchange_num']) {
                $map[$tocoin] = 0;
            } else {
                $map[$tocoin] = $u[$tocoin] - $info['to_exchange_num'];
            }


            $res4 = $this->user->save($map);
            $arr['status'] = 3;
            $arr['sure_time'] = time();
            $res3 = M('exchange')->where(array('id' => $param['id']))->save($arr);


            $map1['user_id'] = $info['user_id'];
            $map1['tips'] = '闪兑申请被拒绝';
            $map1['amount'] = $info['from_coin_num'];
            //$map1['account'] = '奖金积分账户';
            $map1['create_time'] = time();
            $map1['type'] = 2;
            $map1['flag'] = '+';
            $res5 = M('money_detail')->add($map1);
            if ($res3 && $res4 && $res5) {
                $this->success('操作成功', U('exchange'));
            } else {
                $this->error('流水记录记录失败');
            }
        }


    }

    public function exportexchange()
    {
        $xlsName = '闪兑';
        $xlsCell = array(
            ['username', '会员编号'],
            ['from_coin', '闪兑币类型'],
            ['from_coin_num', '闪兑币数量'],
            ['to_coin', '兑换币类型'],
            ['to_exchange_coin', '兑换币数量'],

            ['price', '价格'],
            ['create_time', '闪兑时间'],
            ['sure_time', '审核时间'],
            ['status', '状态'],

        );
        $map['w.status'] = 0;
        $join = 'left join ' . C('DB_PREFIX') . 'user as u on u.id = w.user_id';
        $data = M('exchange')->alias('w')->join($join)->where($map)->field('w.*,u.username')->select();
        $type = C('leixing');
        foreach ($data as $k => $v) {
            $data[$k]['from_coin'] = $type[$v['from_coin']];
            $data[$k]['to_coin'] = $type[$v['to_coin']];
            $data[$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
            if ($v['sure_time'] != '') {
                $data[$k]['sure_time'] = date('Y-m-d H:i:s', $v['sure_time']);
            } else {
                $data[$k]['sure_time'] = '';
            }

            $data[$k]['status'] = '待审核';
        }
        exportExcel($xlsName, $xlsCell, $data);

    }

    public function exportexchange1()
    {
        $xlsName = '闪兑';
        $xlsCell = array(
            ['username', '会员编号'],
            ['from_coin', '闪兑币类型'],
            ['from_coin_num', '闪兑币数量'],
            ['to_coin', '兑换币类型'],
            ['to_exchange_coin', '兑换币数量'],

            ['price', '价格'],
            ['create_time', '闪兑时间'],
            ['sure_time', '审核时间'],
            ['status', '状态'],

        );
        $map['w.status'] = array('in', '2,3');
        $join = 'left join ' . C('DB_PREFIX') . 'user as u on u.id = w.user_id';
        $data = M('exchange')->alias('w')->join($join)->where($map)->field('w.*,u.username')->select();
        $type = C('leixing');
        foreach ($data as $k => $v) {
            $data[$k]['from_coin'] = $type[$v['from_coin']];
            $data[$k]['to_coin'] = $type[$v['to_coin']];
            $data[$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
            if ($v['sure_time'] != '') {
                $data[$k]['sure_time'] = date('Y-m-d H:i:s', $v['sure_time']);
            } else {
                $data[$k]['sure_time'] = '';
            }
            if ($v['status'] == 2) {
                $data[$k]['status'] = '已通过';
            } else {
                $data[$k]['status'] = '已退回';
            }

        }
        exportExcel($xlsName, $xlsCell, $data);
    }

    public function exportOrder1()
    {
        $xlsName = '提现';
        $xlsCell = array(
            ['username', '会员编号'],
            ['truename', '会员姓名'],
            ['level', '会员等级'],
            ['amount', '提现金额'],
            ['dz', '到账金额'],

            ['bank_num', '银行卡号'],
            ['bank_name', '开户行'],
            ['bank_tree', '开户支行'],
            ['bank_user', '开户人'],
            ['phone', '手机号'],
            ['create_time', '提款时间'],

        );
        $map['w.status'] = 2;
        $join = 'left join ' . C('DB_PREFIX') . 'user as u on u.id = w.user_id';
        $data = M('withdraw')->alias('w')->join($join)->where($map)->field('username,truename,level,amount,w.bank_user,w.bank_num,w.phone,w.bank_tree,w.bank_name,w.create_time,w.sxf')->select();
        $level = M('bank')->getField('id,name');
        $reg = C('reg_level');
        foreach ($data as $k => $v) {
            $data[$k]['bank_name'] = $level[$v['bank_name']];
            $data[$k]['dz'] = $v['amount'] - $v['sxf'];
            $data[$k]['level'] = $reg[$v['level']];
            $data[$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
            $data[$k]['bank_num'] = "\t" . $v['bank_num'] . "\t";
            $data[$k]['phone'] = "\t" . $v['phone'] . "\t";
        }


        if ($data) {
            exportExcel('提现已处理工单', $xlsCell, $data);
        } else {

        }
    }

    public function exportOrder()
    {
        $xlsName = '提现';
        $xlsCell = array(
            ['username', '会员编号'],
            ['truename', '会员姓名'],
            ['level', '会员等级'],
            ['amount', '提现金额'],
            ['dz', '到账金额'],

            ['bank_num', '银行卡号'],
            ['bank_name', '开户行'],
            ['bank_user', '开户人'],
            ['bank_tree', '开户支行'],
            ['phone', '手机号'],
            ['create_time', '提款时间'],

        );
        $map['w.status'] = 1;
        $join = 'left join ' . C('DB_PREFIX') . 'user as u on u.id = w.user_id';
        $data = M('withdraw')->alias('w')->join($join)->where($map)->field('username,truename,level,amount,w.bank_num,w.bank_user,w.phone,w.bank_tree,w.bank_name,w.create_time,w.sxf')->select();
        $level = M('bank')->getField('id,name');

        $reg = C('reg_level');
        foreach ($data as $k => $v) {
            $data[$k]['bank_name'] = $level[$v['bank_name']];
            $data[$k]['dz'] = $v['amount'] - $v['sxf'];
            $data[$k]['level'] = $reg[$v['level']];
            $data[$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
            $data[$k]['bank_num'] = "\t" . $v['bank_num'] . "\t";
            $data[$k]['phone'] = "\t" . $v['phone'] . "\t";
        }


        if ($data) {
            exportExcel('提现未处理工单', $xlsCell, $data);
        } else {

        }
    }

    /**
     * 矿机导出列表
     * User: ming
     * Date: 2019/6/29 10:06
     */
    public function exportDiscover()
    {
        $xlsName = '购买矿机列表';
        $xlsCell = array(
            ['id', '会员编号'],
            ['username', '会员姓名'],
            ['phone', '手机号'],
            ['amount', '金额'],
            ['tips', '记录'],
            ['create_time', '时间'],

        );
        $map['w.type'] = 8;
        $map['w.reward_type'] = 51;
        $join = 'left join ' . C('DB_PREFIX') . 'user as u on u.id = w.user_id';
        $data = M('fmoney')->alias('w')->join($join)->where($map)->field('u.id,u.username,u.phone,w.amount,w.tips,w.create_time')->select();

        foreach ($data as $k => $v) {
            $data[$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
            $data[$k]['phone'] = "\t" . $v['phone'] . "\t";
        }

        if ($data) {
            exportExcel('矿机列表', $xlsCell, $data);
        } else {

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

    public function doWithdraw()
    {
        $param = I('get.');
        $w = M('withdraw');

        $info = $w->find($param['id']);
        $config = M('reward_config')->find();
        $sxf = $config['cf'];
        // $sxf =0.1;
        $param['true_amount'] = $info['amount'] * (1 - $sxf);
        if ($w->save($param) === false) {
            $this->error('审核失败');
        }

        if ($param['status'] == 2) {
//           $map['user_id'] =$info['user_id'];
//           $map['tips'] = '提现通过,手续费比例'.$sxf;
//           $map['amount'] = $param['true_amount'];
//           $map['account'] = $info['account'];
//
//
//
//           if(!M('money_detail')->add($map)){
//               $this->error('流水记录记录失败');
//           }
        } elseif ($param['status'] == 3) {//驳回返还
            $map['id'] = $info['user_id'];
            $u = $this->user->getUserinfoById($map['id']);
            $map['z2'] = $u['z2'] + $info['amount'];

            $this->user->save($map);


            $map1['user_id'] = $info['user_id'];
            $map1['tips'] = '提现申请被拒绝';
            $map1['amount'] = $info['amount'];
            //$map1['account'] = '奖金积分账户';
            $map1['create_time'] = time();
            $map1['type'] = 1;
            if (!M('money_detail')->add($map1)) {
                $this->error('流水记录记录失败');
            }
        }

        $this->success('操作成功', U('withdraw'));
    }


    //充值申请列表

    public function rechargeList()
    {
        $param = I('get.');
        if ($param['start_time'] && !$param['end_time']) {
            $map['r.create_time'] = array('gt', strtotime($param['start_time']));
            $this->assign('start_time', $param['start_time']);
        }
        if ($param['end_time'] && !$param['start_time']) {
            $map['r.create_time'] = array('lt', strtotime($param['end_time']));
            $this->assign('end_time', $param['end_time']);

        }

        if ($param['start_time'] && $param['end_time']) {
            $map['r.create_time'] = array(array('gt', strtotime($param['start_time'])), array('elt', strtotime($param['end_time'])));
            $this->assign('start_time', $param['start_time']);
            $this->assign('end_time', $param['end_time']);

        }

        if ($param['status']) {
            $map['r.status'] = $param['status'];
            $this->assign('status', $param['status']);

        }

        if ($param['username']) {
            $map['u.username'] = array('like', $param['username']);
            $this->assign('username', $param['username']);
        }

        if ($param['bank_user']) {
            $map['bank_user'] = $param['bank_user'];
            $this->assign('bank_user', $param['bank_user']);
        }
        $join = 'left join ' . C('DB_PREFIX') . 'user as u on u.id = r.user_id';
        $count = M('recharge')->alias('r')->join($join)->where($map)->count();
        $this->assign('count', $count);
        $page = new Page($count, 20);
        $this->assign('page', $page->show());
        $list = M('recharge')->alias('r')->join($join)->order('r.create_time desc')->where($map)->field('r.*,u.username')->limit($page->firstRow . ',' . $page->listRows)->select();

        $this->assign('data', $list);
        $this->assign('bank_info', M('bank')->getField('id,name'));
        $this->display();
    }

    /**
     * 充值申请操作
     */
    public function check_recharge()
    {
        //系统参数
        $config = M('reward_config')->where(['id' => 1])->find();

        $param = I('post.');

        $rechargeInfo = M('recharge')->where(['id' => $param['id']])->find();
        $userInfo = M('user')->where(['id' => $rechargeInfo['user_id']])->find();
        //2表示通过审核
        if ($param['s'] == 2) {
            if ($rechargeInfo['type'] == 1) {
                $userSave['z1'] = $userInfo['z1'] + $rechargeInfo['amount'];
                $userSave['zong_jf'] = $userInfo['zong_jf'] + $config['ptr4'] * $rechargeInfo['amount'];
                $userSave['own_zong'] = $userInfo['own_zong'] + $rechargeInfo['amount'];
                //wfx加1000
                $userSave['z5'] = $userInfo['z5'] + $rechargeInfo['amount'];

                if ($userInfo['level'] == 0 && $userSave['own_zong'] >= $config['ptr8']) {
                    $userSave['level'] = 1;
                }
                $rechargeSave['zong_jf'] = $rechargeInfo['amount'] * $config['ptr4'];
            }
            if ($rechargeInfo['type'] == 2) {
                $userSave['z2'] = $userInfo['z2'] + $rechargeInfo['amount'];
            }
            if ($rechargeInfo['type'] == 3) {
                $userSave['z3'] = $userInfo['z3'] + $rechargeInfo['amount'];
            }
            if ($rechargeInfo['type'] == 4) {
                $userSave['z4'] = $userInfo['z4'] + $rechargeInfo['amount'];
            }

            //20190606
            if ($rechargeInfo['amount'] >= 1000) {
                //正式成为会员
                $userSave['status'] = 2;
                $userSave['count'] = $config['ptr86'];//正式会员挖矿算力提高到5%
                //上级推荐正式会员个数加1
                $higher_id = $userInfo['higher_id'];
                //取出上一级推荐会员个数+1,给推荐正式员工WFX币
                $member_higher = M('user')->where(array('id' => $higher_id))->find();
                $member_data['member_count'] = $member_higher['member_count'] + 1;
                //推荐正式会员，第1-10个奖励10枚，20枚，30枚，40枚，50枚，60枚，70枚，80枚，90枚，100枚。第11个奖励10枚。
                $num = $member_data['member_count'] % 10;
                if ($num == 0) {
                    $reward_wfx = 100;
                } else {
                    $reward_wfx = $num * 10;
                }
                $member_data['z5'] = $member_higher['z5'] + $reward_wfx;
//                M('user')->where(['id'=>$higher_id])->save($member_data);
                M('user')->where(['id' => $higher_id])->save($member_data);
                //推荐人 记录  wfx币操作记录
//             add_fmoney($user_id,$from_id,$amount,$type,$reward_type,$tips)
                $this->add_fmoney($higher_id, $userInfo['id'], $reward_wfx, 5, 511, '推荐第' . $member_data['member_count'] . '个会员奖励' . $reward_wfx . 'WFX币', '+');


            }
            M('user')->where(['id' => $rechargeInfo['user_id']])->save($userSave);
            $this->add_log($rechargeInfo['user_id'], $rechargeInfo['amount'], 5, '成为会员', '+');
            $rechargeSave['status'] = 2;
            $rechargeSave['chuli_time'] = time();
        } elseif ($param['s'] == 3) {
            $rechargeSave['status'] = 3;
            $rechargeSave['chuli_time'] = time();
        }
        if (M('recharge')->where(['id' => $rechargeInfo['id']])->save($rechargeSave)) {
            ajax_return(0, '操作成功', U('rechargeList'));
        } else {
            ajax_return(1, '操作失败');
        }
    }

    //查看会员网络关系

    public function netMap()
    {
        $param = I('get.');
        if ($param['username']) { //根据用户名搜索
            $p_id = $this->user->where(array('username' => $param['username']))->getField('id');
        } else {
            $p_id = $param['id'] ? $param['id'] : 1;
        }

        $p_info = $this->user->find($p_id); //顶层结点
        $level_second_l = $this->find_left_right($p_info['id'], 1);//次层左结点
        $level_second_r = $this->find_left_right($p_info['id'], 2);//次层右结点


        $level_third_l1 = $this->find_left_right($level_second_l['id'], 1);
        $level_third_r1 = $this->find_left_right($level_second_l['id'], 2);


        $level_third_l2 = $this->find_left_right($level_second_r['id'], 1);
        $level_third_r2 = $this->find_left_right($level_second_r['id'], 2);


        $this->assign('p_info', $p_info);
        $this->assign('level_second_l', $level_second_l);
        $this->assign('level_second_r', $level_second_r);
        $this->assign('level_third_l1', $level_third_l1);
        $this->assign('level_third_r1', $level_third_r1);
        $this->assign('level_third_l2', $level_third_l2);
        $this->assign('level_third_r2', $level_third_r2);
        $this->display();
    }

    private function find_left_right($node_id, $left_right)
    {
        $where['node_member'] = $node_id;
        $where['zuoyou'] = $left_right;
        return $this->user->where($where)->find();
    }

    //查看会员推荐关系

    public function userMap()
    {
        if ($username = I('post.username')) {
            $this->assign('username', $username);
            $where['username'] = $username;
        }
        if (IS_POST) {
            if ($where['username']) {
                $data = $this->user->where($where)->field('id')->find();
                $id = $data['id'];
            } else {
                $id = 0;
            }

            echo json_encode($this->selectChild($id));
        } else {
            $this->display();

        }

    }

    public function deleteUser()
    {
        if (IS_POST) {
            $id = I('post.id');
            $userinfo = $this->user->find($id);
            if ($userinfo['level'] > 1) {
                ajax_return(1, '非游客会员禁止删除');
            }
            if (!M('user')->delete($id)) {
                ajax_return(1, '删除失败');
            }

//            $where['user_id'] = $id;
//            M('order')->where($where)->delete();
            ajax_return(0, '删除成功', U('userList'));
        }
    }

    private function selectChild($pid)
    {
        $data = array();
        $where['higher_id'] = $pid;
        $r = C('reg_level');
        if ($info = $this->user->where($where)->select()) {
            foreach ($info as $k => $v) {

                $status = $v['status'] == 1 ? '未开通' : '已开通';
                //  $c_info = $this->user->getUserinfoById($v['id']);


                $arr[$k]['name'] = $v['username'] . '|' . $v['truename'] . '|' . $status . '|' . $r[$v['level']] . '|' . $v['pt_level'];
                $arr[$k]['create_time'] = $v['create_time'] . '|';
                // $arr[$k]['status'] = $status;
                $arr[$k]['children'] = $this->selectChild($v['id']);
                array_push($data, $arr[$k]);
            }
        }
        return $data;
    }

    //充币管理
    public function chargeCoin()
    {
        if (IS_POST) {

        } else {

            header("Content-Type:text/html;charset=utf-8");
            $status = I('get.status', 0);
            $username = I('get.username');
            $param = I('get.');

            if ($param['start_time'] && !$param['end_time']) {
                $map['w.create_time'] = array('gt', strtotime($param['start_time']));
                $this->assign('start_time', $param['start_time']);

            }
            if ($param['end_time'] && !$param['start_time']) {
                $map['w.create_time'] = array('lt', strtotime($param['end_time']));
                $this->assign('end_time', $param['end_time']);

            }

            if ($param['start_time'] && $param['end_time']) {
                $map['w.create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
                $this->assign('start_time', $param['start_time']);
                $this->assign('end_time', $param['end_time']);


            }

            if ($status) {
                $map['w.status'] = $status;
                $this->assign('status', $param['status']);

            }

            if ($username) {
                $map['username'] = $username;
                $this->assign('username', $param['username']);

            }

            $map['type'] = 1;
            $count = M('coinlist')->where($map)->count();
            $this->assign('count', $count);
            $page = new Page($count, 10);
            $list = M('coinlist')->where($map)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
            foreach ($list as $key => $v) {
                $list[$key]['username'] = M('user')->where(array('id' => $v['userid']))->getField('username');
            }

            $this->assign('page', $page->show());
            $this->assign('data', $list);

            $this->display();
        }
    }

    //提币管理
    public function withdrawCoin()
    {
        if (IS_POST) {

        } else {

            header("Content-Type:text/html;charset=utf-8");
            $status = I('get.status');
            $username = I('get.username');
            $param = I('get.');

//            if ($param['start_time'] && !$param['end_time']) {
//                $map['create_time'] = array('gt', strtotime($param['start_time']));
//                $this->assign('start_time',$param['start_time']);
//
//            }
//            if ($param['end_time'] && !$param['start_time']) {
//                $map['create_time'] = array('lt', strtotime($param['end_time']));
//                $this->assign('end_time',$param['end_time']);
//
//            }
//
//            if ($param['start_time'] && $param['end_time']) {
//                $map['create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
//                $this->assign('start_time',$param['start_time']);
//                $this->assign('end_time',$param['end_time']);
//
//            }

            if ($status) {
                $map['status'] = $status;
                $this->assign('status', $param['status']);

            }

            if ($param['phone']) {
                $map['phone'] = array('like', '%' . $param['phone'] . '%');
                $this->assign('phone', $param['phone']);
            }

            if ($username) {
                $map['username'] = $username;
                $this->assign('username', $param['username']);

            }

            $map['type'] = 2;
            $count = M('coinlist')->where($map)->count();
            $this->assign('count', $count);
            $page = new Page($count, 10);
            $list = M('coinlist')->where($map)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
            foreach ($list as $key => $v) {
                $list[$key]['username'] = M('user')->where(array('id' => $v['userid']))->getField('username');
            }

            $this->assign('page', $page->show());
            $this->assign('data', $list);

            //获取BTC余额
            $CoinClient = CoinClient('bitcoinrpc', 'bitcoinrpc', '127.0.0.1', '8332', 5, array(), 1);

            $json = $CoinClient->getwalletinfo();

            $this->assign('balance', isset($json['balance']) ? $json['balance'] : 0);

            $this->display();
        }
    }

    //提币管理test
    public function withdrawCoinTest()
    {
        if (IS_POST) {

        } else {

            header("Content-Type:text/html;charset=utf-8");
            $status = I('get.status');
            $username = I('get.username');
            $param = I('get.');

//            if ($param['start_time'] && !$param['end_time']) {
//                $map['create_time'] = array('gt', strtotime($param['start_time']));
//                $this->assign('start_time',$param['start_time']);
//
//            }
//            if ($param['end_time'] && !$param['start_time']) {
//                $map['create_time'] = array('lt', strtotime($param['end_time']));
//                $this->assign('end_time',$param['end_time']);
//
//            }
//
//            if ($param['start_time'] && $param['end_time']) {
//                $map['create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
//                $this->assign('start_time',$param['start_time']);
//                $this->assign('end_time',$param['end_time']);
//
//            }

            if ($status) {
                $map['status'] = $status;
                $this->assign('status', $param['status']);

            }

            if ($param['phone']) {
                $map['phone'] = array('like', '%' . $param['phone'] . '%');
                $this->assign('phone', $param['phone']);
            }

            if ($username) {
                $map['username'] = $username;
                $this->assign('username', $param['username']);

            }

            $map['type'] = 2;
            $count = M('coinlist')->where($map)->count();
            $this->assign('count', $count);
            $page = new Page($count, 10);
            $list = M('coinlist')->where($map)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->select();


            $this->assign('page', $page->show());
            $this->assign('data', $list);

            //获取BTC余额
            $CoinClient = CoinClient('bitcoinrpc', 'bitcoinrpc', '127.0.0.1', '8332', 5, array(), 1);

            $json = $CoinClient->getwalletinfo();

            $this->assign('balance', $json['balance']);

            $this->display();
        }
    }


    public function yijian_sure()
    {
        $arr = I('post.arr');
//        dump($arr);die;
        if ($arr) {
//            $this->ajaxReturn(array('code'=>1,'message'=>'一键确认完成'));
            $where['id'] = array('in', $arr);
//            $save['status']=1;
//            $save['end_time']=time();
//            $res=M('coinlist')->where($where)->save($save);
//            if($res){
//                $this->ajaxReturn(array('code'=>1,'message'=>'一键确认完成'));
//            }else{
//                $this->ajaxReturn(array('code'=>-1,'message'=>'操作失败'));
//            }
        }
    }


    //处理驳回
    public function doReject()
    {
        $param = I('get.');
        //dump($param);die;

        //处理提币状态
        $info['status'] = 3;
        $info['endtime'] = time();

        $res1 = M('coinlist')->where(['id' => $param['id']])->save($info);
        $config = M('reward_config')->find();
        //处理账户余额
        if ($param['coinname'] == 'btc') {
            //手续费返回20190521
            $param['amount'] = $param['amount'] * (1 + $config['ptr73']);
            $res2 = M('user')->where(['id' => $param['userid']])->setInc('z7', $param['amount']);

        } elseif ($param['coinname'] == 'eth') {
            //手续费返回
            $param['amount'] = $param['amount'] * (1 + $config['ptr74']);
            $res2 = M('user')->where(['id' => $param['userid']])->setInc('z9', $param['amount']);

        } elseif ($param['coinname'] == 'usdt') {
            //手续费返回
            $param['amount'] = $param['amount'] * (1 + $config['ptr75']);
            $res2 = M('user')->where(['id' => $param['userid']])->setInc('z8', $param['amount']);

        } elseif ($param['coinname'] == 'wfx') {
            //手续费返回
            $param['amount'] = $param['amount'] * (1 + $config['ptr76']);
            $res2 = M('user')->where(['id' => $param['userid']])->setInc('z5', $param['amount']);
        }

        if ($res1 && $res2) {
            $this->success('操作成功', U('withdrawCoin'));
        } else {
            $this->error('操作失败', U('withdrawCoin'));
        }

        //$this->success('操作成功',U('withdraw'));
    }

    //处理BTC提币
    public function doWithdrawBTC()
    {
        $param = I('post.');
        //dump($param);die;

        //获取提币信息
        $withdrawData = M('coinlist')->where(['id' => $param['id']])->find();

        //只要提交过就默认已经审核过20190523
        M('coinlist')->where(['id' => $param['id']])->save(['flag01' => 3]);//审核后改状态成功完成

        $CoinClient = CoinClient('bitcoinrpc', 'bitcoinrpc', '127.0.0.1', '8332', 5, array(), 1);

        $json = $CoinClient->getwalletinfo();

        if (!isset($json['walletversion']) || !$json['walletversion']) {
            ajax_return(1, '钱包连接失败');
        }

        //判断当前钱包余额

        if ($json['balance'] <= $withdrawData['amount']) {
            ajax_return(1, '平台钱包余额不足');
        }

        //提币
        $withdrawBtc = $CoinClient->sendtoaddress($withdrawData['address'], (double)$withdrawData['amount']);

        if ($withdrawBtc) {
            $info['hash'] = $withdrawBtc;
            $info['status'] = 1;
            $info['endtime'] = time();
            $res = M('coinlist')->where(['id' => $withdrawData['id']])->save($info);
            if ($res) {
                ajax_return(2, '提币成功');
            }
        } else {
            ajax_return(0, '提币失败');
        }

    }

    /**
     * 处理USDT_OMNI提币
     * User: ming
     * Date: 2019/7/11 14:15
     */
    public function doWithdrawUSDT()
    {
        $param = I('post.');
        //dump($param);die;

        //获取提币信息
        $withdrawData = M('coinlist')->where(['id' => $param['id']])->find();


        set_time_limit(0);
        ignore_user_abort();
        $coininfo=C('OMNI');
        $mainadd = $coininfo['address'];//手续费地址
        $centerAdd =  $coininfo['center_address'];//平台钱包地址
        $CoinClient = CoinClient($coininfo['user'], $coininfo['pass'], $coininfo['ip'], $coininfo['port'], 5, array(), 1);
//        $omnilist = $CoinClient->omni_listtransactions('*', 100, 0);
//        dump($omnilist);

        $json = $CoinClient->getwalletinfo();
//        dump($json);die;
        if (!isset($json['walletversion']) || !$json['walletversion']) {
            ajax_return(1, '钱包连接失败');
        }

        $getInfo = $CoinClient->omni_getbalance($centerAdd, 31);
//        dump($getInfo);die;
        if ($getInfo['balance'] > 0) {
            //提币
            $withdrawBtc = $CoinClient->omni_funded_send($centerAdd, $withdrawData['address'], 31, (double)$withdrawData['amount'], $mainadd);
            if ($withdrawBtc) {
                $info['hash'] = $withdrawBtc;
                $info['status'] = 1;
                $info['endtime'] = time();
                $res = M('coinlist')->where(['id' => $withdrawData['id']])->save($info);
                if ($res) {
                    //只要提交过就默认已经审核过20190523
                    M('coinlist')->where(['id' => $param['id']])->save(['flag01' => 3]);//审核后改状态成功完成

                    ajax_return(2, '提币成功');
                }
            } else {
                ajax_return(0, '提币失败');
            }
        } else {
            ajax_return(1, '平台钱包余额不足');
        }

    }

    //处理ETH系统提币
    public function doWithdrawETH()
    {
        $data = I('post.');
        $info['hash'] = $data['txhash'];
        $info['status'] = 1;
        $info['endtime'] = time();
        $res = M('coinlist')->where(['id' => $data['id']])->save($info);
        $user = M('coinlist')->where(array('id' => $data['id']))->find();
        if ($user['coinname'] == 'wfx') {
            ajax_return(0, 'wfx不能提币');
        }
      
      //iote不能提币20190812
        if ($user['coinname'] == 'iote') {
            M('coinlist')->where(['id' => $data['id']])->save(['flag01' => 3]);
            ajax_return(0, 'iote不能提币');
         
        }
      //  if ($user['coinname'] == 'iote' || $user['coinname'] == 'iote奖金') {
            if ($user['coinname'] == 'iote奖金') {
            $type = 5;
        } elseif ($user['coinname'] == 'btc') {
            $type = 7;
        } elseif ($user['coinname'] == 'eth') {
            $type = 9;
        } elseif ($user['coinname'] == 'usdt') {
            $type = 8;
        }
        if ($res) {
            M('coinlist')->where(['id' => $data['id']])->save(['flag01' => 1]);//审核后改状态20190704
            $this->add_log($user['userid'], $user['amount'], $type, '提币通过', '-');
          ajax_return(1, '序号:' . $data['id'] . ',提币成功');
          //  ajax_return(1, '用户ID:' . $user['userid'] . ',提币成功');
        } else {
          //  ajax_return(0, '用户ID:' . $user['userid'] . ',提币失败');
          ajax_return(1, '序号:' .$data['id'] . ',提币失败');
        }
    }

    //自动处理
//    public function autoWithdrawETH(){
//        $info['type'] = 2;//提币
//        $info['status'] = 2;//审核中
//        $info['flag01'] = 0;//待审核状态
//        $user=M('coinlist')->where($info)->order('addtime')->find();//获取asc的订单
////        M('coinlist')->where(['id'=>$user['id']])->save(['flag01'=>1]);//审核后改状态
//        $data=$this->auto_coin($user['id']);
//        $user=array_merge($user,$data);
//        ajax_return(0,$user);
//    }

    /**
     * 自动选择钱包地址
     * @param $id
     * @return array
     */
//    public  function auto_coin($id=0){
//        $id=$id%10;
//        $user=[];
//       switch ($id){
//           case 0:
//               $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//               $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//           break;
//           case 1:
//               $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//               $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//               break;
//           case 2:
//               $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//               $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//               break;
//           case 3:
//               $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//               $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//               break;
//           case 4:
//               $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//               $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//               break;
//           case 5:
//               $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//               $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//               break;
//           case 6:
//               $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//               $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//               break;
//           case 7:
//               $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//               $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//               break;
//           case 8:
//               $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//               $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//               break;
//           case 9:
//               $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//               $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//               break;
//       }
//       return $user;
//    }
//    //处理ETH系统提币
//    public function doWithdrawETHTest()
//    {
//        $info['type'] = 2;//提币
//        $info['status'] = 2;//审核中
////        $info['id'] = 2;//审核中
////        $info['endtime'] = time();
//        $user=M('coinlist')->where($info)->order('addtime')->find();//获取asc的订单
//        $user['form']='0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//        $user['key']='0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//        ajax_return(0,$user);
//
//        $data = I('post.');
//        $info['hash'] = $data['txhash'];
//        $info['status'] = 1;
//        $info['endtime'] = time();
//        $res = M('coinlist')->where(['id'=> $data['id']])->save($info);
//        $user=M('coinlist')->where(array('id'=>$data['id']))->find();
//        if($user['coinname']=='wfx'){
//            $type=5;
//        }elseif ($user['coinname']=='btc'){
//            $type=7;
//        }elseif ($user['coinname']=='eth'){
//            $type=9;
//        }elseif ($user['coinname']=='usdt'){
//            $type=8;
//        }
//        if($res)
//        {
//            $this->add_log($user['userid'],$user['amount'],$type,'提币通过','-');
//            ajax_return(1,'提币成功');
//        }else
//        {
//            ajax_return(0,'提币失败');
//        }
//    }

}