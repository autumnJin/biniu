<?php

namespace Home\Controller;

use Think\Page;
use app\Home\Controller\Base;

class PropertyController extends BaseController
{
    public function index()
    {
        $id = $this->user_info['id'];
        $data = M('user')->where('id = ' . $id)->find();

        $data1 = M('reward_config')->where('id=1')->find();
        //dump($data1);
        $this->assign('data', $data);
        $this->assign('data1', $data1);
        $this->display();

    }

    public function price()
    {
        if (IS_POST) {
            $data = I('post.type');
            $this->ajaxReturn($this->price_api($data));
        }
    }

    public function price2()
    {
        $data = [];
        $data['btc'] = $this->https_request1("http://api.coindog.com/api/v1/tick/Binance:btcUSDT?unit=cny");
        $data['eth'] = $this->https_request1("http://api.coindog.com/api/v1/tick/Binance:ethUSDT?unit=cny");
        $data['ltc'] = $this->https_request1("http://api.coindog.com/api/v1/tick/Binance:ltcUSDT?unit=cny");
//        $data['wfx']=$this->https_request1("https://api.mytokenapi.com/ticker/search?category=currency&keyword=Webflix&timestamp=1558063765845&code=15e926eac6ff75e8664ad3ca93a94a7a&platform=web_pc&v=1.0.0&language=zh_CN&legal_currency=CNY");
//        $data['wfx']=$this->https_request1("https://api.mytokenapi.com/ticker/search?category=currency&keyword=iote&timestamp=1558063765845&code=15e926eac6ff75e8664ad3ca93a94a7a&platform=web_pc&v=1.0.0&language=zh_CN&legal_currency=CNY");
        $data['wfx'] = $this->https_request1("https://b1.run/api/xn/v1/markets");

//        $data['btc']=$this->https_request1("http://api.coindog.com/api/v1/tick/Binance:btcUSDT?unit=cny");
        $res['btc'] = json_decode($data['btc'], true);
        $res['eth'] = json_decode($data['eth'], true);
        $res['ltc'] = json_decode($data['ltc'], true);
        $res['wfx'] = json_decode($data['wfx'], true);
//        dump($res['wfx']['data']);die;
        $wfx = $res['wfx']['data'][0]['asset_pairs'];

        foreach ($wfx as $key => $v) {
            if ('IOTE-USDT' == $v['name']) {
                $res['wfx'] = array(
                    'close' => $v['ticker']['close'],
                    'daily_change_perc' => $v['ticker']['daily_change_perc'],
                );
            }

        }
//        dump($res['wfx']);die;
//        $key = array_search('IOTE-USDT', array_column($wfx, 'name'));

        echo json_encode($res);
    }

    public function wfxrecord()
    {
        $wfx = M('user')->where(array('id' => $this->user_info['id']))->find();
        $config = M('reward_config')->where('id=1')->find();
        $this->assign('wfx', $wfx);
        $where['user_id'] = $this->user_info['id'];
        $where['type'] = 5;
        $wfxrecord = M('money_detail')->where($where)->select();
        $this->assign('wfxrecord', $wfxrecord);
//        $this->assign('cny',round($wfx['z5']*$config['hapy'],2));
        $this->display();
    }

    public function btcrecord()
    {
        $btc = M('user')->where(array('id' => $this->user_info['id']))->find();
        $record = M('fmoney')->where(array('user_id' => $this->user_info['id']))->select();
        $this->assign('btc', $btc);
        $this->display();
    }

    public function ltcrecord()
    {
        $ltc = M('user')->where(array('id' => $this->user_info['id']))->find();
        $record = M('fmoney')->where(array('user_id' => $this->user_info['id']))->select();
        $this->assign('ltc', $ltc);
        $this->display();
    }

    public function ethrecord()
    {
        $eth = M('user')->where(array('id' => $this->user_info['id']))->find();
        $record = M('fmoney')->where(array('user_id' => $this->user_info['id']))->select();
        $this->assign('eth', $eth);
        $this->display();
    }

    public function usdtrecord()
    {
        $usdt = M('user')->where(array('id' => $this->user_info['id']))->find();
        $record = M('fmoney')->where(array('user_id' => $this->user_info['id']))->select();
        $this->assign('usdt', $usdt);
        $this->display();
    }

    //钱包首页
    public function qianbao()
    {

        //获取充提币记录
        $userid = $this->user_info['id'];

        $coinListData = M('coinlist')->where(['userid' => $userid])->order('id desc')->select();

        $this->assign('coinListData', $coinListData);

        $this->getBTC();
        $this->getEth();
        $this->getUSDT();
        $this->getWFX();
//        $this->getOmniUsdt();
        $this->display();
    }

    //充币页面
    public function zhuanshou()
    {

        //判断是否生成钱包地址
        $userid = $this->user_info['id'];
        $userData = M('user')->where(['id' => $userid])->find();

        $this->assign('isAddress', $userData['is_address']);

//        $this->assign('coinAddress',$userData['btc_address']);
        $this->assign('coinAddress', $userData['eth_address']);

        $this->display();
    }

    //生成BTC地址

    public function btcAddress()
    {

        //判断BTC地址是否存在
        $userid = $this->user_info['id'];
        $userData = M('user')->where(['id' => $userid])->find();

        if (!empty($userData['btc_address'])) {
            ajax_return(1, '请勿重复申请');
        }

        $CoinClient = CoinClient('bitcoinrpc', 'bitcoinrpc', '127.0.0.1', '8332', 5, array(), 1);

        $json = $CoinClient->getwalletinfo();

        if (!isset($json['walletversion']) || !$json['walletversion']) {
            ajax_return(1, '钱包连接失败');
        }

        //生成新的钱包地址
        $wallet_ad = $CoinClient->getnewaddress($userData['phone']);

        if (!$wallet_ad) {
            ajax_return(1, '生成新钱包地址失败');
        }

        $coininfo=C('OMNI');
        $CoinClient_omni = CoinClient($coininfo['user'], $coininfo['pass'], $coininfo['ip'], $coininfo['port'], 5, array(), 1);
        //生成新的USDT钱包地址
        $wallet_adomni = $CoinClient_omni->getnewaddress($userData['phone']);

        if (!$wallet_adomni) {
            ajax_return(1, '生成新钱包地址失败');
        }
        $info['btc_address'] = $wallet_ad;
        $info['usdt_omni_address'] = $wallet_adomni;
        $info['is_address'] = 2;


        $res = M('user')->where(['id' => $userid])->save($info);


    }

    //生成ETH地址

    public function ethAddress()
    {
        $data = I('post.');

        //判断BTC地址是否存在
        $userid = $this->user_info['id'];

        $userData = M('user')->where(['id' => $userid])->find();

        if (!empty($userData['eth_address'])) {
            ajax_return(1, '请勿重复申请');
        }
//        $coinArr=$this->auto_coin();//随机平台钱包地址
//        $info['usdt_address'] = $coinArr['from'];
        $info['eth_address'] = $data['address'];
        $info['eth_key'] = $data['key'];
        $info['coin_time'] = time();
        $info['is_address'] = 2;


        $res = M('user')->where(['id' => $userid])->save($info);

        if ($res) {
            ajax_return(0, '申请成功');
        } else {
            ajax_return(1, '申请失败');
        }


        //ajax_return(0,'申请成功');
        //ajax_return(1,'申请失败');

    }

    //获取币种名称
    public function coinName()
    {
        $data = I('post.');

        $userid = $this->user_info['id'];
        $userData = M('user')->where(['id' => $userid])->find();

        if ($data['coinname'] == 1) {
            ajax_return(0, 'BTC', $userData['btc_address']);

        } elseif ($data['coinname'] == 2) {

            ajax_return(0, 'ETH', $userData['eth_address']);

        } elseif ($data['coinname'] == 3) {

            ajax_return(0, 'USDT', $userData['eth_address']);
//            ajax_return(0,'USDT',$userData['usdt_address']);


        } elseif ($data['coinname'] == 4) {

//            ajax_return(0,'WFX',$userData['eth_address']);
            ajax_return(0, 'IOTE', $userData['eth_address']);

        }elseif($data['coinname'] == 6){
            ajax_return(0, 'USDT_OMNI', $userData['usdt_omni_address']);
        }

        if ($data['coinname'] == 1) {
            $qrcode == 1;
        } else {
            $qrcode == 2;
        }

        $this->assign('qrcode', $qrcode);

        $this->assign('coinAddress', $coinAddress);

    }


    //BTC查询
    public function getBtc()
    {
        // header('Content-type: application/json');
        $userid = $this->user_info['id'];
        $userData = M('user')->where(['id' => $userid])->find();

        $map['coinname'] = 'btc';
        $map['type'] = 1;
        $map['userid'] = $userid;

        $data = M('coinlist')->where($map)->find();

        //如果数据库不存在则去查询区块数据
        if (!$data) {

            $CoinClient = CoinClient('bitcoinrpc', 'bitcoinrpc', '127.0.0.1', '8332', 5, array(), 1);

            $json = $CoinClient->getwalletinfo();

            if (!isset($json['walletversion']) || !$json['walletversion']) {
                ajax_return(1, '钱包连接失败');
            }

            $resData = $CoinClient->listtransactions();

            //再判断区块中是否有数据
            if ($resData) {
                //如果存在数据入库
                foreach ($resData as $k => $v) {
                    if ($v['category'] == 'receive' && $v['label'] == $userData['phone']) {
                        //交易数据入库
                        $info['userid'] = $userid;
                        $info['phone'] = $userData['phone'];
                        $info['coinname'] = 'btc';
                        $info['address'] = $v['address'];
                        $info['hash'] = $v['txid'];
                        $info['amount'] = $v['amount'];
                        $info['fee'] = 0;
                        $info['type'] = 1; //1 充币 2提币
                        $info['addtime'] = $v['time'];
                        $info['endtime'] = time();
                        $info['status'] = 1; // 1 已完成 2审核中

                        //充值记录入库
                        M('coinlist')->add($info);

                        //账户中增加余额
                        M('user')->where(['id' => $userid])->setInc('z7', $v['amount']);
                    }
                }
            }

        } else {//如果数据库里不为空，再去区块里查询

            $CoinClient = CoinClient('bitcoinrpc', 'bitcoinrpc', '127.0.0.1', '8332', 5, array(), 1);

            $json = $CoinClient->getwalletinfo();

            if (!isset($json['walletversion']) || !$json['walletversion']) {
                ajax_return(1, '钱包连接失败');
            }

            $resData = $CoinClient->listtransactions();

            //再判断区块中是否有数据
            if ($resData) {
                //如果存在数据入库
                foreach ($resData as $k => $v) {
                    if ($v['category'] == 'receive' && $v['label'] == $userData['phone']) {
                        //再判断数据是否已经插入到数据库中
                        $isempty = M('coinlist')->where(['hash' => $v['txid']])->find();

                        if (!$isempty) {
                            //交易数据入库
                            $info['userid'] = $userid;
                            $info['phone'] = $userData['phone'];
                            $info['coinname'] = 'btc';
                            $info['address'] = $v['address'];
                            $info['hash'] = $v['txid'];
                            $info['amount'] = $v['amount'];
                            $info['fee'] = 0;
                            $info['type'] = 1; //1 充币 2提币
                            $info['addtime'] = $v['time'];
                            $info['endtime'] = time();
                            $info['status'] = 1; // 1 已完成 2审核中

                            //充值记录入库
                            M('coinlist')->add($info);

                            //账户中增加余额
                            M('user')->where(['id' => $userid])->setInc('z7', $v['amount']);
                        }
                    }
                }
            }

        }

    }

    //ETH查询
    public function getETH()
    {

        $userid = $this->user_info['id'];
        $userData = M('user')->where(['id' => $userid])->find();

        $map['coinname'] = 'eth';
        $map['type'] = 1;
        $map['userid'] = $userid;

        $data = M('coinlist')->where($map)->find();

        //判断数据库里没有充值记录，则去区块中查询
        if (!$data) {

            //$userData['eth_address'] = '0xE3c78b49cfAfe43Bc62Ca149F3B7f144C59ED9E7';

            $url = "http://api.etherscan.io/api?module=account&action=txlist&address=" . $userData['eth_address'] . "&startblock=0&endblock=99999999&sort=asc&apikey=H4R65KDWH86I2T8CD8R4ZU5TCXBAX8M7PR";

            $resUrl = requestGet($url);

            $res = json_decode($resUrl, true);

            if ($res['status'] == 1 && !empty($res['result'])) {

                foreach ($res['result'] as $k => $v) {

                    if ($v['value'] / 1000000000000000000 > 0 && $v['to'] == strtolower($userData['eth_address'])) {

                        //交易数据入库
                        $info['userid'] = $userid;
                        $info['phone'] = $userData['phone'];
                        $info['coinname'] = 'eth';
                        $info['address'] = $v['to'];
                        $info['hash'] = $v['hash'];
                        $info['amount'] = $v['value'] / 1000000000000000000;
                        $info['fee'] = 0;
                        $info['type'] = 1;
                        $info['addtime'] = $v['timeStamp'];
                        $info['endtime'] = time();
                        $info['status'] = 1;

                        //充值记录入库
                        M('coinlist')->add($info);

                        //账户中增加余额
                        M('user')->where(['id' => $userid])->setInc('z9', $v['value'] / 1000000000000000000);

                    }
                }
            }

        } else {
            //数据库中已经有充值记录，则查询区块并判断

            //$userData['eth_address'] = '0xE3c78b49cfAfe43Bc62Ca149F3B7f144C59ED9E7';

            $url = "http://api.etherscan.io/api?module=account&action=txlist&address=" . $userData['eth_address'] . "&startblock=0&endblock=99999999&sort=asc&apikey=H4R65KDWH86I2T8CD8R4ZU5TCXBAX8M7PR";

            $resUrl = requestGet($url);

            $res = json_decode($resUrl, true);

            if ($res['status'] == 1 && !empty($res['result'])) {

                foreach ($res['result'] as $k => $v) {

                    if ($v['value'] / 1000000000000000000 > 0 && $v['to'] == strtolower($userData['eth_address'])) {
                        //再判断数据是否已经插入到数据库中
                        $isempty = M('coinlist')->where(['hash' => $v['hash']])->find();

                        if (!$isempty) {
                            //交易数据入库
                            $info['userid'] = $userid;
                            $info['phone'] = $userData['phone'];
                            $info['coinname'] = 'eth';
                            $info['address'] = $v['to'];
                            $info['hash'] = $v['hash'];
                            $info['amount'] = $v['value'] / 1000000000000000000;
                            $info['fee'] = 0;
                            $info['type'] = 1;
                            $info['addtime'] = $v['timeStamp'];
                            $info['endtime'] = time();
                            $info['status'] = 1;

                            //充值记录入库
                            M('coinlist')->add($info);

                            //账户中增加余额
                            M('user')->where(['id' => $userid])->setInc('z9', $v['value'] / 1000000000000000000);
                        }
                    }
                }
            }

        }
    }

    //USDT查询
    public function getUSDT()
    {
        $userid = $this->user_info['id'];
        $userData = M('user')->where(['id' => $userid])->find();

        $map['coinname'] = 'usdt';
        $map['type'] = 1;
        $map['userid'] = $userid;

        $data = M('coinlist')->where($map)->find();

        //判断数据库里没有充值记录，则去区块中查询
        if (!$data) {

            //$userData['eth_address'] = '0xE3c78b49cfAfe43Bc62Ca149F3B7f144C59ED9E7';

            $url = "http://api.etherscan.io/api?module=account&action=tokentx&address=" . $userData['eth_address'] . "&startblock=0&endblock=999999999&sort=asc&apikey=H4R65KDWH86I2T8CD8R4ZU5TCXBAX8M7PR";
//            $url = "http://api.etherscan.io/api?module=account&action=tokentx&address=".$userData['usdt_address']."&startblock=0&endblock=999999999&sort=asc&apikey=H4R65KDWH86I2T8CD8R4ZU5TCXBAX8M7PR";

            $resUrl = requestGet($url);

            $res = json_decode($resUrl, true);

            if ($res['status'] == 1 && !empty($res['result'])) {

                foreach ($res['result'] as $k => $v) {
                    if ($v['value'] / 1000000 > 0 && $v['tokenSymbol'] == 'USDT' && $v['to'] == strtolower($userData['eth_address']) && $v['contractAddress'] == '0xdac17f958d2ee523a2206206994597c13d831ec7') //                    if($v['value'] / 1000000 > 0 && $v['tokenSymbol'] == 'USDT' && $v['to'] == strtolower($userData['usdt_address']) && $v['contractAddress'] == '0xdac17f958d2ee523a2206206994597c13d831ec7')
                    {

                        //交易数据入库
                        $info['userid'] = $userid;
                        $info['phone'] = $userData['phone'];
                        $info['coinname'] = 'usdt';
                        $info['address'] = $v['to'];
                        $info['hash'] = $v['hash'];
                        $info['amount'] = $v['value'] / 1000000;
                        $info['fee'] = 0;
                        $info['type'] = 1;
                        $info['addtime'] = $v['timeStamp'];
                        $info['endtime'] = time();
                        $info['status'] = 1;

                        //充值记录入库
                        M('coinlist')->add($info);

                        //账户中增加余额
                        M('user')->where(['id' => $userid])->setInc('z8', $v['value'] / 1000000);

                    }
                }
            }

        } else {

            //判断数据库里没有充值记录，则去区块中查询

            //$userData['eth_address'] = '0xE3c78b49cfAfe43Bc62Ca149F3B7f144C59ED9E7';

            $url = "http://api.etherscan.io/api?module=account&action=tokentx&address=" . $userData['eth_address'] . "&startblock=0&endblock=999999999&sort=asc&apikey=H4R65KDWH86I2T8CD8R4ZU5TCXBAX8M7PR";

            $resUrl = requestGet($url);

            $res = json_decode($resUrl, true);

            if ($res['status'] == 1 && !empty($res['result'])) {

                foreach ($res['result'] as $k => $v) {

                    if ($v['value'] / 1000000 > 0 && $v['tokenSymbol'] == 'USDT' && $v['to'] == strtolower($userData['eth_address']) && $v['contractAddress'] == '0xdac17f958d2ee523a2206206994597c13d831ec7') {

                        //再判断数据是否已经插入到数据库中
                        $isempty = M('coinlist')->where(['hash' => $v['hash']])->find();

                        if (!$isempty) {

                            //交易数据入库
                            $info['userid'] = $userid;
                            $info['phone'] = $userData['phone'];
                            $info['coinname'] = 'usdt';
                            $info['address'] = $v['to'];
                            $info['hash'] = $v['hash'];
                            $info['amount'] = $v['value'] / 1000000;
                            $info['fee'] = 0;
                            $info['type'] = 1;
                            $info['addtime'] = $v['timeStamp'];
                            $info['endtime'] = time();
                            $info['status'] = 1;

                            //充值记录入库
                            M('coinlist')->add($info);

                            //账户中增加余额
                            M('user')->where(['id' => $userid])->setInc('z8', $v['value'] / 1000000);

                        }
                    }
                }
            }

        }


    }

    //OMNI_USDT查询
    public function getOmniUsdt()
    {
        // header('Content-type: application/json');
        $coin = 'usdt_omni';
        $coininfo=C('OMNI');
        $CoinClient = CoinClient($coininfo['user'], $coininfo['pass'], $coininfo['ip'], $coininfo['port'], 5, array(), 1);
        $json = $CoinClient->getinfo();
        if ($json['version'] == '{' || !$json['version'] || $json['version'] == '') {
            die ('钱包同步中！' . date('Y-m-d H:i:s') . "\n");
        }
//        echo 'USDT start,connect ' . (empty($CoinClient) ? 'fail' : 'ok') . ' :' . "\n";
        $omnilist = $CoinClient->omni_listtransactions('*', 100, 0);
        if (empty($omnilist)) {
            echo date('Y-m-d H:i:s') . '无交易记录.' . "\n";
        }
        $userid = $this->user_info['id'];
        $userData = M('user')->where(['id' => $userid])->find();
        foreach ($omnilist as $v) {

//            if (M('user_charge')->where(array('trade_no' => $v['txid'], 'charge_state' => 2, 'addr' => $v['referenceaddress']))->find()) {
//                echo 'TXID:' . $v['txid'] . '转入成功的记录存在.' . "\n";
//                continue;
//            }
//
//            if (!($userid = M('addr')->where(array('addr' => $v['referenceaddress']))->find())) {
//                echo '系统未找到对应账户' . "\n";
//                continue;
//            }
            //判断是否转币成功
            if ($v['confirmations'] >= 3 && $v['valid'] && $v['referenceaddress'] == $userData['usdt_address']) {
                //再判断数据是否已经插入到数据库中
                $res = M('coinlist')->where(array('hash' => $v['txid'], 'address' => $v['referenceaddress']))->find();
//                     M('coinlist')->save(array('id' => $res['id'], 'addtime' => date('Y-m-d H:i:s'), 'endtime' => intval($v['confirmations'] - 1)));
                if (!$res) {
                    //交易数据入库
                    $info['userid'] = $userid;
                    $info['phone'] = $userData['phone'];
                    $info['coinname'] = $coin;
                    $info['address'] = $v['referenceaddress'];
                    $info['hash'] = $v['txid'];
                    $info['amount'] = $v['amount'];
                    $info['fee'] = 0;
                    $info['type'] = 1; //1 充币 2提币
                    $info['addtime'] = time();
                    $info['endtime'] = time();
                    $info['status'] = 1; // 1 已完成 2审核中
                    //充值记录入库
                    M('coinlist')->add($info);
                    //账户中增加余额
                    M('user')->where(['id' => $userid])->setInc('z7', $v['amount']);

                }
                continue;
            }
        }

    }

    //ETH
    //WFX查询
    public function getWFX()
    {

        $userid = $this->user_info['id'];
        $userData = M('user')->where(['id' => $userid])->find();

        $map['coinname'] = 'wfx';
        $map['type'] = 1;
        $map['userid'] = $userid;

        $data = M('coinlist')->where($map)->find();

        //判断数据库里没有充值记录，则去区块中查询
        if (!$data) {

            //$userData['eth_address'] = '0x61cb9627e11689d491be1b883c33280c736f38e1';

            $url = "http://api.etherscan.io/api?module=account&action=tokentx&address=" . $userData['eth_address'] . "&startblock=0&endblock=999999999&sort=asc&apikey=H4R65KDWH86I2T8CD8R4ZU5TCXBAX8M7PR";

            $resUrl = requestGet($url);

            $res = json_decode($resUrl, true);

            if ($res['status'] == 1 && !empty($res['result'])) {

                foreach ($res['result'] as $k => $v) {

                    if ($v['value'] / 1000000000000000000 > 0 && $v['to'] == strtolower($userData['eth_address']) && $v['contractAddress'] == '0xba1ed22c69ad00739ee2b4abd70e270be9e87ee2') {

                        //交易数据入库
                        $info['userid'] = $userid;
                        $info['phone'] = $userData['phone'];
                        $info['coinname'] = 'wfx';
                        $info['address'] = $v['to'];
                        $info['hash'] = $v['hash'];
                        $info['amount'] = $v['value'] / 1000000000000000000;
                        $info['fee'] = 0;
                        $info['type'] = 1;
                        $info['addtime'] = $v['timeStamp'];
                        $info['endtime'] = time();
                        $info['status'] = 1;

                        //充值记录入库
                        M('coinlist')->add($info);

                        //账户中增加余额
                        M('user')->where(['id' => $userid])->setInc('z5', $v['value'] / 1000000000000000000);
                    }
                }
            }
        } else {

            //判断数据库里没有充值记录，则去区块中查询

            //$userData['eth_address'] = '0x61cb9627e11689d491be1b883c33280c736f38e1';

            $url = "http://api.etherscan.io/api?module=account&action=tokentx&address=" . $userData['eth_address'] . "&startblock=0&endblock=999999999&sort=asc&apikey=H4R65KDWH86I2T8CD8R4ZU5TCXBAX8M7PR";

            $resUrl = requestGet($url);

            $res = json_decode($resUrl, true);

            if ($res['status'] == 1 && !empty($res['result'])) {

                foreach ($res['result'] as $k => $v) {

                    if ($v['value'] / 1000000000000000000 > 0 && $v['to'] == strtolower($userData['eth_address']) && $v['contractAddress'] == '0xba1ed22c69ad00739ee2b4abd70e270be9e87ee2') {

                        //再判断数据是否已经插入到数据库中
                        $isempty = M('coinlist')->where(['hash' => $v['hash']])->find();

                        if (!$isempty) {

                            //交易数据入库
                            $info['userid'] = $userid;
                            $info['phone'] = $userData['phone'];
                            $info['coinname'] = 'wfx';
                            $info['address'] = $v['to'];
                            $info['hash'] = $v['hash'];
                            $info['amount'] = $v['value'] / 1000000000000000000;
                            $info['fee'] = 0;
                            $info['type'] = 1;
                            $info['addtime'] = $v['timeStamp'];
                            $info['endtime'] = time();
                            $info['status'] = 1;

                            //充值记录入库
                            M('coinlist')->add($info);

                            //账户中增加余额
                            M('user')->where(['id' => $userid])->setInc('z5', $v['value'] / 1000000000000000000);
                        }
                    }
                }
            }
        }

    }

    //获取账户余额
    public function getBalance()
    {
        $data = I('post.');

        //dump($data);

        $userid = $this->user_info['id'];
        $userData = M('user')->where(['id' => $userid])->find();

        if ($data['coinname'] == 1) {
            ajax_return(0, 'BTC', $userData['z7']);

        } elseif ($data['coinname'] == 2) {

            ajax_return(0, 'ETH', $userData['z9']);

        } elseif ($data['coinname'] == 3) {

            ajax_return(0, 'USDT', $userData['z8']);

        } elseif ($data['coinname'] == 4) {

            ajax_return(0, 'IOTE', $userData['z5']);
        } elseif ($data['coinname'] == 5) {
            ajax_return(0, 'IOTE奖金', $userData['z10']);
        } elseif ($data['coinname'] == 6) {
            ajax_return(0, 'USDT_OMNI', $userData['z8']);
        }
    }

    //提币页面
    public function zhuanzhang()
    {

        $userid = $this->user_info['id'];
        $userData = M('user')->where(['id' => $userid])->find();
        $config = M('reward_config')->find();
        if (IS_POST) {
            $data = I('post.');

            //验证信息是否完整
//            if($data['coinname'] == '' || $data['address'] == '' || $data['amount'] == '' || $data['password'] == '')
            if ($data['coinname'] == '' || $data['address'] == '' || $data['amount'] == '' || $data['password'] == '' || $data['phone'] == '' || $data['getCode'] == '') {
                //ajax_return(0,'申请成功');
                ajax_return(1, '提币信息不完整');
            }
            //短信
            $code['mobile'] = $data['phone'];
            $code['code'] = $data['getCode'];
            if (!M('msg_list')->where($code)->order('id desc')->find()) {
                ajax_return(1, '验证码不正确');
            }

            //验证支付密码
            if (md5($data['password']) != $userData['password2']) {
                ajax_return(1, '支付密码错误');
            }

            //数量不能小于等于0
            if ($data['amount'] <= 0) {
                ajax_return(1, '提币数量不能小于等于0');
            }

//            if($data['coinname'] == 5){
            if ($data['coinname'] == 5 && $config['ptr94'] == 0 && $config['ptr95'] == 0) {

                //手续费扣除
                $charge = $data['amount'] * $config['ptr96'];
                $amount = $data['amount'] + $charge;
//                $amount = $data['amount']*(1+$config['ptr76']);
                if ($amount > $userData['z10']) {
                    ajax_return(1, '账户余额不足');
                }

            } else {
//            $day_money=$userData['day_money']-$data['amount'];
//            if($day_money<0){
//                ajax_return(1,'超过每日限额');
//            }
//            $day_count=$userData['day_count']-1;
                if ($data['coinname'] == 5) {
                   
                    if ($config['ptr97'] <=$userData['day_count1']) {
                        ajax_return(1, '超过每日提币次数');
                    }
                 //  ajax_return(1, $userData['day_count1']);
                } else {
                    if ($config['ptr68'] < $userData['day_count']) {
                        ajax_return(1, '超过每日提币次数');
                    }
                }


                $amount = 0;//总共扣除币默认为0
                $charge = 0;//手续费默认为0

                if ($data['coinname'] == 1) {
                    //BTC2019052117
                    if ($config['ptr77'] > $data['amount']) {
                        ajax_return(1, '超过最低限额' . $config['ptr77']);
                    }
                    //手续费扣除
                    $charge = $data['amount'] * $config['ptr73'];
                    $amount = $data['amount'] + $charge;
//                $amount = $data['amount']*(1+$config['ptr73']);
//                if($data['amount'] > $userData['z7'])
                    if ($amount > $userData['z7']) {
                        ajax_return(1, '账户余额不足');
                    }
                    //BTC
                    if ($config['ptr69'] < ($userData['day_money1'] + $data['amount'])) {
                        ajax_return(1, '超过每日限额');
                    }


                } elseif ($data['coinname'] == 2) {
                    //ETH2019052117
                    if ($config['ptr78'] > $data['amount']) {
                        ajax_return(1, '超过最低限额' . $config['ptr78']);
                    }
                    //手续费扣除
                    $charge = $data['amount'] * $config['ptr74'];
                    $amount = $data['amount'] + $charge;
//                $amount = $data['amount']*(1+$config['ptr74']);
                    if ($amount > $userData['z9']) {
                        ajax_return(1, '账户余额不足');
                    }
                    //ETH
                    if ($config['ptr70'] < ($userData['day_money2'] + $data['amount'])) {
                        ajax_return(1, '超过每日限额');
                    }

                } elseif ($data['coinname'] == 3||$data['coinname'] == 6) {//添加usdt_omin20190711
                    //USDT2019052117
                    if ($config['ptr79'] > $data['amount']) {
                        ajax_return(1, '超过最低限额' . $config['ptr79']);
                    }
                    //手续费扣除
                    $charge = $data['amount'] * $config['ptr75'];
                    $amount = $data['amount'] + $charge;
//                $amount= $data['amount']*(1+$config['ptr75']);
                    if ($amount > $userData['z8']) {
                        ajax_return(1, '账户余额不足');
                    }

                    //USDT
                    if ($config['ptr71'] < ($userData['day_money3'] + $data['amount'])) {
                        ajax_return(1, '超过每日限额');
                    }

                } elseif ($data['coinname'] == 4) {
                    //WFX2019052117
                    if ($config['ptr80'] > $data['amount']) {
                        ajax_return(1, '超过最低限额' . $config['ptr80']);
                    }
                    //手续费扣除
                    $charge = $data['amount'] * $config['ptr76'];
                    $amount = $data['amount'] + $charge;
//                $amount = $data['amount']*(1+$config['ptr76']);
                    if ($amount > $userData['z5']) {
                        ajax_return(1, '账户余额不足');
                    }

                    //WFX
                    if ($config['ptr72'] < ($userData['day_money4'] + $data['amount'])) {
                        ajax_return(1, '超过每日限额1');
                    }
                } elseif ($data['coinname'] == 5) {
                    //WFX2019052117
                    if ($config['ptr94'] > $data['amount']) {
                        ajax_return(1, '超过最低限额' . $config['ptr94']);
                    }
                    //手续费扣除
                    $charge = $data['amount'] * $config['ptr96'];
                    $amount = $data['amount'] + $charge;
//                $amount = $data['amount']*(1+$config['ptr76']);
                    if ($amount > $userData['z10']) {
                        ajax_return(1, '账户余额不足');
                    }
                    //IOTE奖金
                    if ($config['ptr95'] < ($userData['day_money5'] + $data['amount'])) {
                        ajax_return(1, '超过每日限额');
                    }
                }
            }

            //数据入库
            $info['userid'] = $userid;
            $info['phone'] = $userData['phone'];
            if ($data['coinname'] == 1) {
                $info['coinname'] = 'btc';


            } elseif ($data['coinname'] == 2) {

                $info['coinname'] = 'eth';

            } elseif ($data['coinname'] == 3) {

                $info['coinname'] = 'usdt';

            } elseif ($data['coinname'] == 4) {

//                $info['coinname'] = 'wfx';
                $info['coinname'] = 'iote';
            } elseif ($data['coinname'] == 5) {

//                $info['coinname'] = 'wfx';
                $info['coinname'] = 'iote奖金';
            } elseif ($data['coinname'] == 6) {

                $info['coinname'] = 'usdt_omni';

            }
//            $info['address'] = $data['address'];

//            //手续费扣除
//            $info['amount'] = $data['amount']*(1-$config['ptr76']);
            $info['amount'] = $data['amount'];
            $info['address'] = $data['address'];
            $info['fee'] = $charge;
            $info['type'] = 2;
            $info['status'] = 2;
            $info['addtime'] = time();

            $res1 = M('coinlist')->add($info);

            if ($data['coinname'] == 1) {
                //统计每日限额
                $res4 = M('user')->where(['id' => $userid])->setInc('day_money1', $amount);
                $res2 = M('user')->where(['id' => $userid])->setDec('z7', $amount);

            } elseif ($data['coinname'] == 2) {
                //统计每日限额
                $res4 = M('user')->where(['id' => $userid])->setInc('day_money2', $amount);
                $res2 = M('user')->where(['id' => $userid])->setDec('z9', $amount);

            } elseif ($data['coinname'] == 3||$data['coinname'] == 6) {
                //统计每日限额
                $res4 = M('user')->where(['id' => $userid])->setInc('day_money3', $amount);
                $res2 = M('user')->where(['id' => $userid])->setDec('z8', $amount);

            } elseif ($data['coinname'] == 4) {
                //统计每日限额
                $res4 = M('user')->where(['id' => $userid])->setInc('day_money4', $amount);
                $res2 = M('user')->where(['id' => $userid])->setDec('z5', $amount);
            } elseif ($data['coinname'] == 5) {
                //统计每日限额
                $res4 = M('user')->where(['id' => $userid])->setInc('day_money5', $amount);
                $res2 = M('user')->where(['id' => $userid])->setDec('z10', $amount);
              
               $res3 = M('user')->where(['id' => $userid])->setInc('day_count1');
            }
            //统计提币次数
//            $res3 = M('user')->where(['id'=>$userid])->save(['day_money'=>$day_money,'day_count'=>$day_count]);
                if($data['coinname'] != 5){
            $res3 = M('user')->where(['id' => $userid])->setInc('day_count');
               }
            if ($res1 && $res2 && $res3) {
                ajax_return(0, '申请成功');
            } else {
                ajax_return(1, '申请失败');
            }


        } else {
            //判断是否生成钱包地址

            $this->assign('accountBalance', $userData['z7']);

            $this->assign('config', $config);
            $this->assign('userData', $userData);
            $this->display();
        }

    }


}