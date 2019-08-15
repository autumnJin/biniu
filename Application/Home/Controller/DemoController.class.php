<?php
namespace Home\Controller;
use app\Home\Controller\Lib;
use Think\Page;
use app\Home\Controller\Base;
class DemoController extends BaseController
{
  	public function index()
    {
      define('ACCOUNT_ID', '97654126'); // your account ID 
      define('ACCESS_KEY','47bafbe5-1qdmpe4rty-b8a90c09-157a1'); // your ACCESS_KEY
      define('SECRET_KEY', '0ece64cc-238f7e3d-a8417299-599ab'); // your SECRET_KEY

      //实例化类库
      $req = new LibController();
      // 获取account-id, 用来替换ACCOUNT_ID
     $data = [];
      $data['btc']= $req->get_detail_merged('btcusdt')->tick;
        $data['eth']= $req->get_detail_merged('ethusdt')->tick;
        $data['ltc']= $req->get_detail_merged('ltcusdt')->tick;
        $data['omg']= $req->get_detail_merged('omgusdt')->tick;
        $data['eos']= $req->get_detail_merged('eosusdt')->tick;
      	 $data['xrp']= $req->get_detail_merged('xrpusdt')->tick;
      	 $data['bch']= $req->get_detail_merged('bchusdt')->tick;
      	 $data['eos']= $req->get_detail_merged('eosusdt')->tick;
      	 $data['etc']= $req->get_detail_merged('etcusdt')->tick;
      echo json_encode($data);
      // 获取账户余额示例
      //var_dump($req->get_balance());
          }
      

}