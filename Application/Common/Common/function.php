<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6 0006
 * Time: 16:01
 */

function getAddress($u_id,$num=2)
{
    $map['user_id'] = $u_id;
    return M('address')->where($map)->order('is_default desc')->limit($num)->select();
}

function explode_address($p,$c,$a){

    $provinceid = M('province')->where('provinceid = "'.$p.'"')->find();
    $city = M('city')->where('cityid = "'.$c.'"')->find();
    $area = M('area')->where('areaid = "'.$a.'"')->find();
    return $provinceid['province'].$city['city'].$area['area'];

}




function getip() {

    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {

        $ip = getenv('HTTP_CLIENT_IP');

    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {

        $ip = getenv('HTTP_X_FORWARDED_FOR');

    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {

        $ip = getenv('REMOTE_ADDR');

    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {

        $ip = $_SERVER['REMOTE_ADDR'];

    }

    return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';

}


//
//手机号正则
function preg_phone($phone)
{
    if($phone){
        $preg_phone='/^1[34578]\d{9}$/ims';
        if(preg_match($preg_phone,$phone)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }


}

function getLevel()
{
    $data = M('reward_config')->find(1);
    $arr = array();
    $arr[1] = $data['g1'];
    $arr[2] = $data['g2'];
    $arr[3] = $data['g3'];
    $arr[4] = $data['g4'];
    return $arr;
}

function getLevel_()
{
    return M('level')->getField('id,name');
}

function ajax_return($code=0,$msg,$data='')
{
    $arr = [];
    $arr['code'] =  $code;
    $arr['msg']  =  $msg;
    $arr['data'] = $data;
    exit(json_encode($arr));
}


function imgUpload($maxSize)
{
    $upload = new \Think\Upload();
    $upload->maxSize = $maxSize;
//设置上传文件类型
    $upload->allowExts = explode(',', 'jpg,png,jpeg');
//设置附件上传目录
    $upload->savePath = C('UPLOAD_PATH');

    $upload->saveRule = 'uniqid';

    if($info =  $upload->upload()){

    }
    return $upload->upload();
}


//模拟get请求

function requestGet($url = '') 
{
    $postUrl = $url;
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    $data = curl_exec($ch);//运行curl
    curl_close($ch);
    return $data;
}
  


function username($id = NULL, $type = 'id')
{
    if ($id && $type) {
        $username = (APP_DEBUG ? NULL : S('username' . $id . $type));

        if (!$username) {
            $username = M('User')->where(array($type => $id))->getField('username');
            S('username' . $id . $type, $username);
        }
    }
    else {
        $username = session('userName');
    }

    return $username ? $username : NULL;
}


function debug($value, $type = 'DEBUG', $verbose = false, $encoding = 'UTF-8')
{
    if (M_DEBUG || 1) {
        if (!IS_CLI) {
            Common\Ext\FirePHP::getInstance(true)->log($value, $type);
        }
    }
}

function CoinClient($username, $password, $ip, $port, $timeout = 3, $headers = array(), $suppress_errors = false)
{
    return new \Common\Ext\CoinClient($username, $password, $ip, $port, $timeout, $headers, $suppress_errors);
}


function exportExcel($expTitle,$expCellName,$expTableData){
    $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
    $fileName = $expTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
    $cellNum = count($expCellName);
    $dataNum = count($expTableData);
    vendor("PHPExcel.PHPExcel");
    $objPHPExcel = new PHPExcel();
    $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

    $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
    for($i=0;$i<$cellNum;$i++){
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
    }
    // Miscellaneous glyphs, UTF-8
    for($i=0;$i<$dataNum;$i++){
        for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
        }
    }


    ob_clean(); flush();
    header('pragma:public');
    header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
    header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}

/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}



function createLinkstring($para) {
    $arg  = "";
    while (list ($key, $val) = each ($para)) {
        $arg.=$key."=".$val."&";
    }
    //去掉最后一个&字符
    $arg = substr($arg,0,count($arg)-2);

    //如果存在转义字符，那么去掉转义
    if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

    return $arg;
}


//生成唯一订单号

function getOrderNum()
{
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8).mt_rand(1,99);

}



function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}

function check_arr($rs)
{
    foreach ($rs as $v) {
        if (!$v || $v == 0) {
            return false;
        }
    }

    return true;
}

function is_weixin()
{
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }
    return false;
}


//获取文件修改时间
function getfiletime($file, $DataDir) {
    $a = filemtime($DataDir . $file);
    $time = date("Y-m-d H:i:s", $a);
    return $time;
}

//获取文件的大小
function getfilesize($file, $DataDir) {
    $perms = stat($DataDir . $file);
    $size = $perms['size'];
    // 单位自动转换函数
    $kb = 1024;         // Kilobyte
    $mb = 1024 * $kb;   // Megabyte
    $gb = 1024 * $mb;   // Gigabyte
    $tb = 1024 * $gb;   // Terabyte

    if ($size < $kb) {
        return $size . " B";
    } else if ($size < $mb) {
        return round($size / $kb, 2) . " KB";
    } else if ($size < $gb) {
        return round($size / $mb, 2) . " MB";
    } else if ($size < $tb) {
        return round($size / $gb, 2) . " GB";
    } else {
        return round($size / $tb, 2) . " TB";
    }
}


function  getSysStatus()
{
    $s = M('sysconfig')->find(1);
    return $s['is_open'] == 1 ? true:false;
}




function list_arr($arr,$field='',$sort='desc')
{

 $arrSort = array();
 foreach($arr AS $uniqid => $row){
        foreach($row AS $key=>$value){
                 $arrSort[$key][$uniqid] = $value;
     }
 }
if($sort['direction']){
         array_multisort($arrSort[$field], constant($sort), $arr);
 }


return $arr;

}




