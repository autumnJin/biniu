<?php
namespace Home\Controller;

use Think\Page;
use app\Home\Controller\Base;
class DuihuanController extends BaseController
{
    public function index()
    {
        if (IS_POST){
            //系统参数
            $Config = M('reward_config')->where(['id'=>1])->find();

            //会员信息
            $UserInfo = M('user')->where(['id'=>$this->user_info['id']])->find();
            $this->assign('UserInfo',$UserInfo);

            //判断字段信息收购完整
            $param = I('post.');
            //取出用户WFX币 与传递过来的WFX 比较
            $wfx_num = $param['num1'];
            if($wfx_num ==0){
                $this->ajaxreturn(array('code' => 0, 'message' => '输入的WFX币不能为 0 哦'));
            }


            if($wfx_num > $UserInfo['z5']){
                $this->ajaxreturn(array('code' => 0, 'message' => 'WFX币不足'));
            }


            //取出WFX币实时价格
            $wfx_price = $Config['hapy'];
            if(!$wfx_price){
                $this->ajaxreturn(array('code' => 0, 'message' => 'WFX币实时价格不存在'));
            }


            //取出需要兑换的币
            if(!$param['coin2']){
                $this->ajaxreturn(array('code' => 0, 'message' => '需要兑换的币不存在'));
            }

            //取出兑换的币的价格
            if(!$param['num2']){
                $this->ajaxreturn(array('code' => 0, 'message' => 'WFX币兑换的币实时价格不存在'));
            }

            //兑换价格 wfx价格/兑换币价格
            $data['price']       = number_format($wfx_price/$param['num2'],12);
            $data['user_id']     = $UserInfo['id'];
            $data['from_coin']   = $param['coin1'];
            $data['from_coin_num']   = $wfx_num;
            $data['to_exchange_num'] =number_format($wfx_num * $wfx_price/$param['num2'],12); //兑换币的数量 wfx数量 * wfx价格/兑换币价格
            $data['to_coin']     = $param['coin2'];
            $data['create_time'] = time();
            $data['status']      = 0;//待审核

            $from='z'.$param['coin1'];
            $to='z'.$param['coin2'];
            $arr[$from]=$UserInfo[$from]-$wfx_num;
            $arr[$to]=$UserInfo[$to]+number_format($wfx_num * $wfx_price/$param['num2'],12);
            $res=M('user')->where(array('id'=>$this->user_info['id']))->save($arr);

            $result = M('exchange')->add($data);
            if($res&&$result){
                $this->add_log($UserInfo['id'],$wfx_num,$param['coin1'],'申请闪兑','-');
                $this->ajaxreturn(array('code' => 1, 'message' => '兑换成功,等待审核'));
            }else{
                $this->ajaxreturn(array('code' => 0, 'message' => '兑换失败'));
            }
//            if($param['type'] == ""){
//                $this->ajaxreturn(array('code' => 0, 'message' => '请选择转换类型'));
//            }
//            if($param['num'] == "" || $param['num'] < 0){
//                $this->ajaxreturn(array('code' => 0, 'message' => '请输入正确的转换数量'));
//            }
//
//            if($param['type'] == 2){
//                //验证余额是否足够
//                if($param['num'] > $UserInfo['z2']){
//                    $this->ajaxreturn(array('code' => 0, 'message' => '流通积分不足，当前剩余'.$UserInfo['z2']));
//                }else{
//                    $UserSave['z2'] = $UserInfo['z2'] - $param['num'];
//                    //根据系统参数转换WFX数量
//                    $SendNum = $param['num'] * $Config['ptr27'];
//                    $UserSave['z5'] = $UserInfo['z5'] + $SendNum;
//                }
//                $tips1 = '转换WFX扣除';
//                $tips2 = '流通转换获得';
//            }
//
//            if($param['type'] == 4){
//                //验证余额是否足够
//                if($param['num'] > $UserInfo['z4']){
//                    $this->ajaxreturn(array('code' => 0, 'message' => '兑换积分不足，当前剩余'.$UserInfo['z4']));
//                }else{
//                    $UserSave['z4'] = $UserInfo['z4'] - $param['num'];
//                    //根据系统参数转换WFX数量
//                    $SendNum = $param['num'] * $Config['ptr27'];
//                    $UserSave['z5'] = $UserInfo['z5'] + $SendNum;
//                }
//                $tips1 = '转换WFX扣除';
//                $tips2 = '兑换转换获得';
//            }
//
//            if(M('user')->where(['id'=>$UserInfo['id']])->save($UserSave)){
//                $this->add_fmoney($UserInfo['id'],$UserInfo['id'],$param['num'],$param['type'],9,$tips1);
//                $this->add_fmoney($UserInfo['id'],$UserInfo['id'],$SendNum,5,10,$tips2);
//                $this->ajaxreturn(array('code' => 1, 'message' => '转换成功'));
//            }else{
//                $this->ajaxreturn(array('code' => 0, 'message' => '转换失败，请重试'));
//            }
        }
        $config=M('reward_config')->find();
        $this->assign('config',$config);
        //会员信息
        $UserInfo = M('user')->where(['id'=>$this->user_info['id']])->find();
        $this->assign('UserInfo',$UserInfo);

        //去交易表中查询数据
        $exchange_list = M('exchange')->where(['user_id'=>$UserInfo['id']])->select();
        $this->assign('exchange_list',$exchange_list);

//        $url = "https://api.mytokenapi.com/ticker/search?category=currency&keyword=Webflix&timestamp=1558063765845&code=15e926eac6ff75e8664ad3ca93a94a7a&platform=web_pc&v=1.0.0&language=zh_CN&legal_currency=CNY";
        $urlWfx = "https://api.mytokenapi.com/ticker/search?category=currency&keyword=IOTE&timestamp=1558063765845&code=15e926eac6ff75e8664ad3ca93a94a7a&platform=web_pc&v=1.0.0&language=zh_CN&legal_currency=CNY";
        $paramWfx = $this->price_api($urlWfx);

        $url = "https://b1.run/api/xn/v1/markets";
        $param = $this->price_api($url);
        $wfx = $param['data'][0]['asset_pairs'];
        foreach ($wfx as $key => $v) {
            if ('IOTE-USDT' == $v['name']) {
                $wfx = array(
                    'close' => $v['ticker']['close'],
//                    'daily_change_perc' => $v['ticker']['daily_change_perc'],
                );
            }

        }
        $param['close'] = $wfx['close'] ? $wfx['close'] : $paramWfx['data'][0]['price'];
        M('reward_config')->where(array('id'=>1))->save(['hapy'=>$param['close']]);

        $this->display();
    }
    public function coin(){


        if (IS_POST){
            $type= I('post.type');
            $coin= C('COIN_TYPE');
            //获取实时价格
            $type=$coin[$type];
            if($type=="USDT"){
                $url = "https://api.jinse.com/v3/coin/detail?slugs=tether&_source=m";
                $param= $this->price_api($url);
                $param['close']=$param['rate'];
            }elseif ($type=="IOTE"){
//                $url = "https://api.mytokenapi.com/ticker/search?category=currency&keyword=IOTE&timestamp=1558063765845&code=15e926eac6ff75e8664ad3ca93a94a7a&platform=web_pc&v=1.0.0&language=zh_CN&legal_currency=CNY";
//                $param= $this->price_api($url);
//                $param['close']=$param['data'][0]['price'];

                //20190614更换IOTE接口
                $urlWfx = "https://api.mytokenapi.com/ticker/search?category=currency&keyword=IOTE&timestamp=1558063765845&code=15e926eac6ff75e8664ad3ca93a94a7a&platform=web_pc&v=1.0.0&language=zh_CN&legal_currency=CNY";
                $paramWfx = $this->price_api($urlWfx);

                $url = "https://b1.run/api/xn/v1/markets";
                $param = $this->price_api($url);
                $wfx = $param['data'][0]['asset_pairs'];
                foreach ($wfx as $key => $v) {
                    if ('IOTE-USDT' == $v['name']) {
                        $wfx = array(
                            'close' => $v['ticker']['close'],
//                    'daily_change_perc' => $v['ticker']['daily_change_perc'],
                        );
                    }

                }
                $param['close'] = $wfx['close'] ? $wfx['close'] : $paramWfx['data'][0]['price'];

            }
            else{
                $url = "http://api.coindog.com/api/v1/tick/Binance:".$type."USDT?unit=cny";
                $param= $this->price_api($url);
            }

//            $param= $this->price_api($url,$coin[$type]);


            $this->ajaxreturn(array('code' => 1, 'message' =>$param['close']));
        }
    }
}
