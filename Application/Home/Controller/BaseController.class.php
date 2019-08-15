<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/16 0016
 * Time: 10:03
 */

namespace Home\Controller;

use Admin\Model\UserModel;
use Think\Controller;

class BaseController extends Controller
{
    protected $user_info;
    protected $user;
    public function  __construct()
    {
        parent::__construct();
        $this->user = new UserModel();
        if(!getSysStatus()){
            header("Content-type:text/html;charset=utf-8");
            exit('系统维护中....');
        }

        $this->user_info =  session('User_yctr');

        if(!$this->user_info){
            $this->redirect('Public/login');
        }

    }

    /**
     * 实时价格API
     * @param string $type
     * @return mixed
     */
    protected function price_api($url)
    {

        //    $url = "http://www.coinyee.pro/app/v1/ThirdpartyController/markets?coin=".$type."&unit=cny&tdsourcetag=s_pcqq_aiomsg";
        // $url = " https://api.shenjian.io/?appid=ef09ed7301060858d32af37380bc8095&coin=bitcoin&currency=BTC";
//        $url = "http://api.coindog.com/api/v1/tick/Binance:".$type."USDT?unit=cny";
//       $url = "https://api.jinse.com/v3/coin/detail?slugs=tether&_source=m";
        $btcData = $this->https_request1($url);
        $btcData = json_decode($btcData, true);
//        $btcData['wfx']=$this->https_request1("https://api.mytokenapi.com/ticker/search?category=currency&keyword=Webflix&timestamp=1558063765845&code=15e926eac6ff75e8664ad3ca93a94a7a&platform=web_pc&v=1.0.0&language=zh_CN&legal_currency=CNY");
//        $btcData['USDT']=$this->https_request1("https://api.jinse.com/v3/coin/detail?slugs=tether&_source=m");

        return $btcData;
    }
    function https_request1($url,$data = null){
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


    protected function add_log($user_id,$amount=0,$type,$tips,$flag='+')
    {
        $map['user_id'] = $user_id;
        $map['amount'] = $amount;
        $map['type'] = $type;
        $map['create_time'] = time();

        //$map['account'] = $account;
        $map['flag'] = $flag;

        $dd = M('user')->find($map['user_id']);
        $type = 'z'.$type;
        $map['tips'] = $tips;
        return M('money_detail')->add($map);
    }

    protected function  add_fmoney($user_id,$from_id,$amount,$type,$reward_type,$tips)
    {
        $map['user_id'] =$user_id;
        $map['from_id'] = $from_id;
        $map['amount'] = $amount;
        $map['type'] = $type;
        $map['reward_type'] = $reward_type;
        $map['tips'] = $tips;
        $map['create_time'] = time();
        return M('fmoney')->add($map);
    }
    /**
     * 挂卖
     * @param $user_id
     * @param $sell_num |挂卖数量
     * @param $low_num |最低买入数量
     * @param int $lave |剩余数量
     * @param $sell |已卖出的数量
     * @param int $status
     * @param int $is_show
     * @return mixed
     */
    protected  function add_coin_sell($user_id,$sell_num,$low_num=0,$lave=0,$sell=0,$status=0,$is_show=1){
        $map['user_id'] =$user_id;
        $map['sell_num'] = $sell_num;
        $map['low_num'] = $low_num;
        $map['sell'] = $sell;
        $map['lave'] = $lave;
        $map['status'] = $status;
        $map['is_show'] = $is_show;
        $map['add_time'] = time();
        return M('coin_sell')->add($map);
    }

    /**
     * @param $user_id
     * @param $from_id
     * @param $sell_id
     * @param int $buy_num
     * @param int $status
     * @return mixed
     */
    protected  function add_coin_buy($user_id,$from_id,$sell_id,$buy_num=0,$status=0){
        $map['user_id'] =$user_id;
        $map['from_id'] = $from_id;
        $map['sell_id'] = $sell_id;
        $map['buy_num'] = $buy_num;
        $map['status'] = $status;
        $map['buy_time'] = time();
        return M('coin_buy')->add($map);
    }

    /**
     * 自动选择钱包地址20190627
     * @return array
     */
    public function auto_coin()
    {
       $id = rand(0,6);
        $user = [];
        switch ($id) {
            case 0:
                $user['from'] = '0x9e63f8300C502E037BA66752eDC8e1234C445Ec3';//平台钱包地址
                break;
            case 1:
                $user['from'] = '0x35a9FD0Cf8ADc77452E946AFED3518184C2D15D1';//平台钱包地址
                break;
            case 2:
                $user['from'] = '0x19A5219F54c436C426a50461Ebc4a68a3B00beD8';//平台钱包地址
                break;
            case 3:
                $user['from'] = '0x48211ebc204DaFa0f5FB7AD7b26667F9F7764319';//平台钱包地址
                break;
            case 4:
                $user['from'] = '0x28A0D357770AA0fa4C7e9F9e7F6227aBD64EB312';//平台钱包地址
                break;
            case 5:
                $user['from'] = '0xA55e379c75E2698a7e542c50D36807e2407dce72';//平台钱包地址
                break;
            case 6:
                $user['from'] = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
                break;
        }
        return $user;
    }
}
