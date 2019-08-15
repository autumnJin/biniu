<?php
namespace Home\Controller;

use Think\Page;
use app\Home\Controller\Base;
class HangqingController extends BaseController
{
    public function index()
    {

        $RewardConfig = M('reward_config')->where(['id'=>1])->field('')->find();
    
        $this->assign('RewardConfig',$RewardConfig);
//       $btc= $this->testApi('BTC');
//       $eth= $this->testApi('ETH');
//       $ltc= $this->testApi('LTC');

        $this->display();
    }

    public function api(){
        //       $wfx= $this->testApi('WFX');

       // $data['btc']= $this->testApi('BTC');
       // $data['eth']= $this->testApi('ETH');
       // $data['ltc']= $this->testApi('LTC');
      
     // $data['eos']=$this->testApi('EOS');
      // $data['bnb']=$this->testApi('BNB');
      // $data['xlm']=$this->testApi('XLM');
      // $data['ada']=$this->testApi('ADA');
    //  $data['neo']=$this->testApi('NEO');
      
     //   $data['OMG']= $this->testApi('OMG');
      //  $data['USDT']= $this->testApi('USDT');
     //   $data['PPT']= $this->testApi('PPT');
      //  $data['TRIP']= $this->testApi('TRIP');
     //   $data['CT']= $this->testApi('CT');
//        dump($data);die;
      $data=$this->testApi();
         echo json_encode($data);

    }

    /**
     * curl()   curl模拟请求---一个参数是get请求，两个参数是post请求
     *
     * 上传文件$post=array('logo'=>'@D:\wamp\wamp\www\czbk\php&mysql\1.png');
     * logo是$_FILES的name，后面的是图片路径，加@表示这是一个文件而不是字符串
     *
     * @param string $url 模拟请求的url
     * @param array $post post请求时要提交的数据
     * @param boolean $header 是否要将响应头输出
     * @return string $str   返回响应结果
     */
    public function api_curl($url, $post = array(), $header = false)
    {
        if (!$url) return;

        //设置资源句柄
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        //如果传$post，则说明是post请求
        if ($post && is_array($post) && count($post) > 0) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
        }

        //请求执行时，不将响应数据直接输出，而是以返回值的形式输出响应数据
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //决定要不要将响应头输出
        curl_setopt($curl, CURLOPT_HEADER, $header);
        $str = curl_exec($curl);

        //IGNORE 忽略转换时的错误，如果没有ignore参数，所有该字符后面的字符串都无法被保存。
//        $str = iconv("UTF-8", "GBK//IGNORE", $str);
        curl_close($curl);

        return $str;
    }
    /**
     * curl()   curl模拟请求---一个参数是get请求，两个参数是post请求
     *
     * 上传文件$post=array('logo'=>'@D:\wamp\wamp\www\czbk\php&mysql\1.png');
     * logo是$_FILES的name，后面的是图片路径，加@表示这是一个文件而不是字符串
     *
     * @param string $url 模拟请求的url
     * @param array $post post请求时要提交的数据
     * @param boolean $header 是否要将响应头输出
     * @return string $str   返回响应结果
     */
    function curl($url, $post = array(), $header = false)
    {
        if (!$url) return;

        //设置资源句柄
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        //如果传$post，则说明是post请求
        if ($post && is_array($post) && count($post) > 0) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
        }

        //请求执行时，不将响应数据直接输出，而是以返回值的形式输出响应数据
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //决定要不要将响应头输出
        curl_setopt($curl, CURLOPT_HEADER, $header);
        $str = curl_exec($curl);

        //IGNORE 忽略转换时的错误，如果没有ignore参数，所有该字符后面的字符串都无法被保存。
//        $str = iconv("UTF-8", "GBK//IGNORE", $str);
        curl_close($curl);

        return $str;
    }

    public function apireg()
    {
        $url = "https://api.omniexplorer.info/v1/address/addr/";
        $data = array('addr' => "1EXoDusjGwvnjZUyKkxZ4UHEf77z6A5S4P");
        $res = $this->curl($url, $data);
        dump($res);die;
        echo $res;
    }

    public function testApi($type='BTC')
    {
        //獲取BTC價格寫入數據庫
   //    $url = "http://www.coinyee.pro/app/v1/ThirdpartyController/markets?coin=".$type."&unit=cny&tdsourcetag=s_pcqq_aiomsg";
      // $url = " https://api.shenjian.io/?appid=ef09ed7301060858d32af37380bc8095&coin=bitcoin&currency=BTC";
       // $url = "http://api.coindog.com/api/v1/tick/Binance:".$type."USDT?unit=cny";
       $url = "https://api.jinse.com/v3/coin/detail?slugs=tether&_source=m";
        $btcData = $this->https_request($url);
        $btcData = json_decode($btcData, true);
   		return $btcData;
        //return $btcData['data']['obj'];die;
//        dump($btcData);die;
//       echo $btcData['data']['obj'];die;
//        dump($btcData);die;
//        $btcPrice = $btcData['close'];
//        $info['canshu60'] = $btcPrice;
//        M('config')->where(['id'=>1])->save($info);
//        $uid = $this->create_guid();
//        echo $uid;

    }
    public function test($type='BTC')
    {
        //獲取BTC價格寫入數據庫
      //  $url = "http://www.coinyee.pro/app/v1/ThirdpartyController/markets?coin=".$type."&unit=cny&tdsourcetag=s_pcqq_aiomsg";
        $url = "http://api.coindog.com/api/v1/tick/Binance:".$type."USDT?unit=cny";
   		
        $btcData = $this->https_request($url);
        $btcData = json_decode($btcData, true);
       dump($btcData);die;


    }
    function https_request($url,$data = null){
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


}