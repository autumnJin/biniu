<?php
namespace Home\Controller;

use Think\Controller;

class WxController extends Controller {

    private $appid;
    private $appsecret;
    private $token ;
    public function __construct()
    {
        $this->appid     =    C('APP_ID');
        $this->appsecret = C('APPSECRET');
        $this->token = C('TOKEN');
        parent::__construct();
    }


    public function index()
    {





        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $echoStr = $_GET["echostr"];
        $token = $this->token;


        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            echo $echoStr;exit();
        }else{
            $this->responseMsg();
        }
    }


    public function userindex()
    {

        $type = $_GET['type'];

        if($type == 1){
            $url = 'index/index';
        }else{
            $url = '/user/index';
        }

        Vendor('WxPayv3.JSAPI');  

        $tools =new \JsApiPay();
        $openid = $tools->GetOpenid();
        session('open_id',$openid);
        $map['openid'] = $openid;
        if(($info = M('user')->where($map)->find())) {




                session('User_yctr', $info);
                 $this->redirect($url);

        }

    }


    public function responseMsg(){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){
            ob_clean();
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $eventKey = $postObj->EventKey;
            $ticket = $postObj->Ticket;
            $keyword = trim($postObj->Content);

            $time = time();
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";


            $ev = $postObj->Event;
            if ($ev == "subscribe"){ // 关注
                $msgType = "text";
                $openid = $fromUsername;
                $jsoninfo = $this->getWxuserinfo($openid);


              //  $add['openid'] = $jsoninfo['openid'];
               // $add['sex'] = $jsoninfo['sex'];
               // $add['nickname'] = $jsoninfo['nickname'];

               // $add['headimgurl'] = $jsoninfo['headimgurl'];
               // $add['subscribe_time'] = $jsoninfo['subscribe_time'];



               // $add['create_time'] = time();
//                $add = [];
//                $add['username'] = 4234;
//                $add['password'] = 24234;
//
//                $add['higher_id'] = 1;
//
//                $id = M('user')->add($add);


                $c = "您好，欢迎您关注324！";
                $contentStr = $jsoninfo['nickname'].$c;
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;




                $map['openid'] = $openid;
                $userinfo  =  M('user')->where($map)->find();
                if($userinfo){ //已经关注过
                    $c = "您好，欢迎您关注！";
                    $contentStr =$jsoninfo['nickname'].$c;
                }else{ //未关注
                    if(empty($ticket)){//直接关注
                        $add['openid'] = $jsoninfo['openid'];
                        $add['sex'] = $jsoninfo['sex'];
                        $add['nickname'] = $jsoninfo['nickname'];

                        $add['headimgurl'] = $jsoninfo['headimgurl'];
                        $add['subscribe_time'] = $jsoninfo['subscribe_time'];

                        $add['create_time'] = time();
                        $add['username'] = '188'.randNumber();

                        $add['higher_id'] = 1;

                        $where['openid'] = $jsoninfo['openid'];

                        if(M('user')->where($where)->find()){
                            die('请不要重复注册');
                        }

                        if(!$id = M('user')->add($add)){
                            $c = '内部错误001';
                        }

                       $qrcodeurl = $this->getEwm($id);
                        $save['id'] = $id;
                        $save['qrcode'] = $qrcodeurl;
                        if(M('user')->save($save) === false){
                            $c = '内部错误002';
                        }
                        $db = M();
                        $db->execute("call net_add_tj($id,1)");
                        $c = "您好，欢迎您关注！";
                        $contentStr = $jsoninfo['nickname'].$c;
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }else {//扫码关注 （推荐关注）
                        $add['openid'] = $jsoninfo['openid'];
                        $add['sex'] = $jsoninfo['sex'];
                        $add['nickname'] = $jsoninfo['nickname'];
                        $add['headimgurl'] = $jsoninfo['headimgurl'];
                        $add['subscribe_time'] = $jsoninfo['subscribe_time'];
                        $add['username'] = '188' . randNumber();


                        $where['openid'] = $jsoninfo['openid'];

                        if (M('user')->where($where)->find()) {
                            die('请不要重复注册');
                        }

                        $add['higher_id'] = substr($eventKey, 8);
                        $add['create_time'] = time();

                        if (!$id = M('user')->add($add)) {
                            $c = '内部错误003';
                        }
                        $qrcodeurl = $this->getEwm($id);
                        $save['id'] = $id;
                        $save['qrcode'] = $qrcodeurl;
                        if (M('user')->save($save) === false) {
                            $c = '内部错误002';
                        }


                        $db = M();
                        $db->execute("call net_add_tj($id,1)");


                        $c = "您好，欢迎您关注！";
                        $contentStr = $jsoninfo['nickname'] . $c;

                    }
                }
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
            if($ev == "SCAN"){
                $msgType = "text";
                $contentStr = '扫码操作';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
            if($keyword == "1" || $keyword == "1")
            {

                $msgType = "text";


                $jsoninfo = $this->getWxuserinfo($fromUsername);
                $contentStr = json_encode($jsoninfo);



                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
            if($keyword == "3" || $keyword == "3")
            {
                $msgType = "text";
                $contentStr = $keyword;
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
            elseif($keyword == "2" || $keyword == "2")
            {
                $msgType = "text";
                $con = mysql_connect("127.0.0.1","root","qazwsx123456");
                mysql_select_db("tr_wx0430", $con);
                mysql_query("set names 'utf8'");
                $openid = $fromUsername;
                $sq2=mysql_query("select id from ms_user where openid='$openid'");
                $re2=mysql_fetch_array($sq2);
                $admin_id = $re2['id'];
                $qrcodeurl = $this->getEwm($admin_id);
                $openid = $fromUsername;
                $sqlll=mysql_query("update ms_user set qrcode = '$qrcodeurl' where id= '$admin_id'");
                //  $ret=mysql_fetch_array($sqlll);
                $contentStr = '二维码生成成功！';

                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
            else{
                $msgType = "text";
                $contentStr = '无效指令';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
        }else{
            echo " ";
            exit;
        }
    }



    public function getEwm($fqid){
        $ACCESS_TOKEN = $this->get_access_token();
        $url = $this->getQrcodeurl($ACCESS_TOKEN,$fqid,1);
        return $url;
        // return $this->DownLoadQr2($url,time());
    }


    Public function getWxuserinfo($openid){
        $access_token = $this->get_access_token();

        $urls = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $results = $this->https_request($urls);
        $jsoninfo1 = json_decode($results, true);

        return $jsoninfo1;
    }



    // 单文本回复

    private function singleText($fromUsername,$toUsername,$contentStr)
    {
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";

        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), 'text', $contentStr);
        return $resultStr;
    }


    //单，多图文消息回复


    //模板回复

    private function sendTemplateMsg()
    {
        //获取access_token
        //$url 模板接口
        //参数  {
        //  touser:openid,
            //template_id:"",
        //url 跳转url
        //date:{
        //}
        //}


        //https_request
    }


    //群发消息接口，公众号后台也可以发送



    //网页授权

    public function getBaseinfo()
    {

        $u_id = session('User_yctr.id');

        $data = M('user')->find($u_id);



        if($data['openid']){
            header("Content-type:text/html;charset=utf-8");
           exit('您已经成功绑定');
        }


        $REDIRECT_URI = urlencode("http://zj0619.tianruisoft.com/index.php/Wx/getUserinfo3");

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appid&redirect_uri=$REDIRECT_URI&response_type=code&scope=snsapi_userinfo&state=$u_id#wechat_redirect";
        header('location:'.$url);
    }



    public function getUserinfo3()
    {


        $code= $_GET['code'];

        $uid= $_GET['state'];

        $url ="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsecret&code=$code&grant_type=authorization_code ";
      //  echo $url;die;
        $res = $this->https_request($url);
       // dump($res);die;
        $res = json_decode($res,true);
        $access_token = $res['access_token'];
        $openid = $res['openid'];
        $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN ";


     //   dump($url2);die;
        $res2 = $this->https_request($url2);
        $res2 = json_decode($res2,true);

        $save['id'] = $uid;
        $save['openid'] = $res2['openid'];
        $save['nickname'] = $res2['nickname'];
        $save['headimgurl'] = $res2['headimgurl'];

       M('user')->save($save);

        header('location:'.U('User/index'));

    }


    public function getUserinfo2()
    {
        $data = M('web_accesstoken')->find(1);

        if(!$data){  //code  从未被使用
            $code = $_GET['code'];
            $url ="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsecret&code=$code&grant_type=authorization_code ";
            $res = $this->https_request($url);

            $add1['access_token'] = $res['access_token'];
            $add1['dateline'] = time();
            $add2['access_token'] = $res['refresh_token'];
            M('web_accesstoken')->add($add1);
            M('web_accesstoken')->add($add2);
            $accesstoken = $res['access_token'];
        }else{
            $t = time() - $data['dateline'];
                if($t>7200){
                    $data2 =  M('web_accesstoken')->find(2);
                    $url2 = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$this->appid&grant_type=&refresh_token=".$data2['access_token']."";
                    $res2 = $this->https_request($url2);
                    $accesstoken = $res2['access_token'];
                    $save['id'] = 1;
                    $save['access_token'] = $accesstoken;
                    $save['dateline'] = time();
                    M('web_accesstoken')->save($save);

                }else{
                    $accesstoken = $data['accesstoken'];
                }

        }


    }


    public function getUserinfo1()
    {
            $code= $_GET['code'];

            $uid= $_GET['state'];

            $data = M('web_accesstoken')->find(1);

            if(!$data){
                $url ="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsecret&code=$code&grant_type=authorization_code ";
                $res = $this->https_request($url);
            }

        $t = time() - $data['dateline'];
            if($data['access_token'] && $t>7200){
                $data2 =  M('web_accesstoken')->find(2);
                $url2 = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$this->appid&grant_type=&refresh_token=".$data2['access_token']."";
                $res2 = $this->https_request($url2);


            }


            $access_token = $res['access_token'];



            $openid = $res['openid'];
            $url3 = "https://api.weixin.qq.com/sns/auth?access_token=$access_token&openid=$openid";
                $res3 = $this->https_request($url3);
                dump($res3);die;
               if($res3['errcode']){
                   $url4 = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$this->appid&grant_type=&refresh_token=".$res['refresh_token']."";
                   $res4 = $this->https_request($url4);

               }
            $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN ";

            $res2 = $this->https_request($url2);
            dump($res2);
    }



    public function get_access_token() {
        $wx = M('accesstoken');
        $ret  = $wx->find();
        $dateline = $ret['dateline'];
        $acctoken = $ret['acctoken'];
        $time = time();
        if (($time - $dateline) > 7200) {



            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret."";
            $ret_json = $this->https_request($url);
            $ret = json_decode($ret_json);

            if ($ret -> access_token) {

                $map['id'] = 1;
                $map['acctoken'] = $ret->access_token;
                $map['dateline'] = $time;
                $wx->save($map);
                return $ret->access_token;
            }
        }


        return $acctoken;
    }



    function access_token() {
        $con = mysql_connect("127.0.0.1","root","qazwsx123456");
        mysql_select_db("tr_wx0430", $con);
        mysql_query("set names 'UTF-8'");
        $sql=mysql_query("select dateline,acctoken from ms_accesstoken where id=1");
        $ret=mysql_fetch_array($sql);
        $dateline = $ret['dateline'];
        $acctoken = $ret['acctoken'];


        $time = time();
        if (($time - $dateline) > '7200') {
            $appid = APPID;
            $appsecret = APPSECRET;
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret."";
            $ret_json = $this->https_request($url);
            $ret = json_decode($ret_json);
            if ($ret -> access_token) {
                $dateline = $time;
                $acctoken = $ret -> access_token;
                $sq = "UPDATE ms_accesstoken SET acctoken = '$acctoken',dateline = '$dateline' WHERE id = '1'";
                $re=mysql_query($sq);
                return $acctoken;
            }
        }
        return $acctoken;
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





}

?>