<?php
namespace Home\Controller;

use Think\Page;
use app\Home\Controller\Base;
class OtcController extends BaseController
{
    public function index()
    {
        $id = $this->user_info['id'];
         $data = M('user')->where('id = '.$id )->find();

        $data1 = M('reward_config')->where('id=1')->find();
        //dump($data1);
//        dump($this->price_api());die;
         $this->assign('data',$data);
         $this->assign('data1',$data1);
        $this->display();

    }

    public function price(){
        if(IS_POST){
            $data=I('post.type');
            $this->ajaxReturn($this->price_api($data));
        }
    }
    public function wfxrecord()
    {
        $wfx=M('user')->where(array('id'=>$this->user_info['id']))->find();
        $config=M('reward_config')->where('id=1')->find();
        $this->assign('wfx',$wfx);
        $this->assign('cny',round($wfx['z5']*$config['hapy'],2));
        $this->display();
    }
    public function btcrecord()
    {
        $btc=M('user')->where(array('id'=>$this->user_info['id']))->find();
        $record=M('fmoney')->where(array('user_id'=>$this->user_info['id']))->select();
        $this->assign('btc',$btc);
        $this->display();
    }
    public function ltcrecord()
    {
        $ltc=M('user')->where(array('id'=>$this->user_info['id']))->find();
        $record=M('fmoney')->where(array('user_id'=>$this->user_info['id']))->select();
        $this->assign('ltc',$ltc);
        $this->display();
    }
    public function ethrecord()
    {
        $eth=M('user')->where(array('id'=>$this->user_info['id']))->find();
        $record=M('fmoney')->where(array('user_id'=>$this->user_info['id']))->select();
        $this->assign('eth',$eth);
        $this->display();
    }
    public function usdtrecord()
    {
        $usdt=M('user')->where(array('id'=>$this->user_info['id']))->find();
        $record=M('fmoney')->where(array('user_id'=>$this->user_info['id']))->select();
        $this->assign('usdt',$usdt);
        $this->display();
    }

    /**
     * 卖出
     */
    public function sell()
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
            //挂卖
            $this->add_coin_sell($this->user_info['id'], $param['amount'], $param['low_num'],$param['amount']);

            $userSave['z5'] = $user_info['z5'] - $param['amount']; //更新账户wfx
            if($userSave['z5']<0){
                $this->ajaxreturn(array('code' => 0, 'message' => 'WFX不够'));
            }
            //事务 :
            M()->startTrans();
            $result =  M('user')->where(array('id'=>$this->user_info['id']))->save($userSave);
            $this->add_fmoney($user_info['id'], $user_info['id'], -$param['amount'], 5, 502, '卖出数量');
            if (!empty($result)) {
                M()->commit();
                $this->ajaxreturn(array('code' => 1, 'message' => '卖出成功'));
            } else {
                M()->rollback();
                $this->ajaxreturn(array('code' => '0', 'message' => '卖出失败！'));
            }
        }
        $where['user_id'] = $this->user_info['id'];
//        $user= M('user')->where(array('id'=>$this->user_info['id']))->find();
        //个人卖出记录
        $data = M('coin_sell')->alias('cs')
            ->join('ms_user AS mu ON mu.id=cs.user_id')
            ->where($where)
            ->field('cs.*,mu.username')
            ->select();
        $this->assign('data', $data);

        $this->assign('user', $user_info);
        $this->display();
    }

    /**
     * 买入
     */
    public function buy(){

        $sell_id=I('get.sell_id');

        if($sell_id){
            $sell=M('coin_sell')->where(['id'=>$sell_id])->find();

            $this->assign('sell', $sell);
        }
        //用户信息
        $user_info = $this->user->getUserinfoById($this->user_info['id']);
        if (IS_POST) {
            $config=M('reward_config')->find();
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

            $sell_info=M('coin_sell')->where(['id'=>$param['sell_id']])->find();
            if($sell_info){
                if ($sell_info['lave']<$param['amount']){
                    $this->ajaxreturn(array('code' => 0, 'message' => '超过剩余数量'));
                }


                if ($sell_info['low_num']>$param['amount']){
                    $this->ajaxreturn(array('code' => 0, 'message' => '不能低于最低买入数量'));
                }


                //事务 :
                M()->startTrans();
                $result =  M('user')->where(array('id'=>$this->user_info['id']))->setInc('z5', $param['amount']);
                $buy_wfx=$param['amount']*$config['ptr83'];//买入得的算力百分比20190603
                M('user')->where(array('id'=>$this->user_info['id']))->setInc('z6', $buy_wfx);
                $this->add_fmoney($user_info['id'], $user_info['id'], $param['amount'], 5, 503, '买入数量');

                $this->add_fmoney($user_info['id'], $user_info['id'], $buy_wfx, 6, 513, '交易挖矿买入wfx得的算力');
//                M('coin_sell')->where(array('id'=>$this->user_info['id']))->setDec('lave', $param['amount']);
                $num=$sell_info['lave']-$param['amount'];
                if($num<=0){
                    $data['status']=1;//售空
                }
                $data['lave']=$num;
//                M('coin_sell')->where(array('id'=>$this->user_info['id']))->save($data);
                M('coin_sell')->where(array('id'=>$param['sell_id']))->save($data);
                $sell_wfx=$param['amount']*$config['ptr84'];//卖出得的算力百分比20190603
                $this->add_fmoney($param['sell_id'], $user_info['id'], $sell_wfx, 6, 514, '交易挖矿卖出wfx得的算力');

//                $this->add_fmoney($user_info['id'], $user_info['id'], -$param['amount'], 5, 504, '买入数量');

                //买入
                $this->add_coin_buy($this->user_info['id'],$sell_info['user_id'], $sell_info['id'], $param['amount'],2);
                if (!empty($result)) {
                    M()->commit();
                    $this->ajaxreturn(array('code' => 1, 'message' => '买入成功'));
                } else {
                    M()->rollback();
                    $this->ajaxreturn(array('code' => '0', 'message' => '买入失败！'));
                }


            }else{
                $this->ajaxreturn(array('code' => 0, 'message' => '不能购买'));
            }
//            //挂卖
//            $this->add_coin_sell($this->user_info['id'], $param['amount'], $param['low_num']);
//            $this->ajaxreturn(array('code' => 1, 'message' => '买入成功'));

        }
        $data=M('coin_buy')->where(['user_id'=>$this->user_info['id']])->select();
        $this->assign('data',$data);
        $this->display();
    }
    /**
     * 交易
     */
    public function exchange()
    {

//        $where['user_id'] = $this->user_info['id'];
        $where['cs.status'] = 0;
        $where['cs.is_show'] = 1;
        $where['cs.lave'] = ['gt',0];
        //个人卖出记录
        $data = M('coin_sell')->alias('cs')
            ->join('ms_user AS mu ON mu.id=cs.user_id')
            ->where($where)
            ->field('cs.*,mu.username')
            ->select();
        $this->assign('data', $data);
        $user= M('user')->where(array('id'=>$this->user_info['id']))->find();
        $this->assign('user', $user);
        $this->display();
    }
}