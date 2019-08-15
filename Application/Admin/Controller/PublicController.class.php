<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6 0006
 * Time: 15:47
 */

namespace Admin\Controller;

use Admin\Model\MenuModel;
use Think\Controller;

class PublicController extends Controller
{
    //提币管理test
    public function withdrawCoinTest()
    {

        $this->display();
    }


    //自动处理
    public function autoWithdrawETH()
    {
        $info['type'] = 2;//提币
        $info['status'] = 2;//审核中
        $info['flag01'] = 0;//状态0审核中
        $user = M('coinlist')->where($info)->order('addtime')->find();//获取asc的订单
        if ($user) {
            //        M('coinlist')->where(['id'=>$user['id']])->save(['flag01'=>1]);//审核后改状态
            M('coinlist')->where(['id' => $user['id']])->save(['flag01' => 1]);//审核后改状态

            $where['type'] = 2;
            $where['status'] = 1;//已完成
//            $higher = M('coinlist')->where($where)->order('addtime desc')->find();//获取asc的订单

            //轮询6个钱包地址
            $id = $user['id'] % 6;
            //判断是否属于同一个值
//            if (($higher % 6) === $id) {
//                $id = $id + 1;
//            }
            $data = $this->auto_coin($id);
            $user = array_merge($user, $data);
            ajax_return(0, $user);
        } else {
            ajax_return(1, '暂时还没有未审核订单');
        }

    }

    /**
     * 查找钱包地址的hash
     */
    public function auto_address()
    {
//        $address = '0xacac7dc006c8e7b1877e527e76e88952fc5e13a5';
        $map['flag01'] = 1;
        $map['type'] = 2;//2提币
//        $map['id'] = 303;//2提币
//        $map['address'] = '0xc2c76c32989503527e88cddbdbc056884be65393';//2提币
//        $map['address'] = '0xe8aaa8b9f038fd1956332524aad8303ef0c63369';//2提币

        $info = M('coinlist')->where($map)->group('address')->select();
//        $info = M('coinlist')->where($map)->select();
        foreach ($info as $val) {
            if ($val['address']) {
                //        $url = "https://api.etherscan.io/api?module=account&action=txlist&address=".$address."&startblock=0&endblock=99999999&sort=asc&apikey=B4GMTESFZK1XVUHQ3ZBT482T9AVSCEN6GC";
                $url = "http://api.etherscan.io/api?module=account&action=tokentx&address=" . $val['address'] . "&startblock=0&endblock=999999999&sort=asc&apikey=B4GMTESFZK1XVUHQ3ZBT482T9AVSCEN6GC";
                $btcData = $this->https_request($url);
                $btcData = json_decode($btcData, true);

//          $where['flag01']=1;
//          $where['type']=2;//2提币
                $where['address'] = $val['address'];
                $where['flag01'] = 1;
                $where['type'] = 2;
                //获取此钱包地址所有的hash
                $list = M('coinlist')->where($where)->select();
                foreach ($list as $key => $v) {
                    $result = 0;
                    //判断是否已经生成
                    foreach ($btcData['result'] as $val) {
                        if (in_array($v['hash'], $val)) {
                            $result = 1;
                        }
                    }
                    if ($result == 1) {
                        M('coinlist')->where(['id' => $v['id']])->save(['flag01' => 3]);//验证成功
                    } else {
                        $second = time() - $v['endtime'];
                        $minute = $second / 60;         //60秒1分钟


                        if($v['hash']==''){
//                            $map['status']=2;//再去执行一遍
                            $data['flag01']=0;//再去执行一遍

                        }else{

                            $data['remark']='提交hash未交易成功';
                        }
                        //超过8分钟的订单才执行未成功
                        if ($minute > 8 || $v['endtime']==0) {
                            $data['status']=2;//改为待审核
                            M('coinlist')->where(['id' => $v['id']])->save($data);
                        }
                        //超过10分钟的订单才执行未成功
//                        if ($minute > 10 && ($v['hash'] != '')) {
//                            M('coinlist')->where(['id' => $v['id']])->save(['status' => 2, 'remark' => '提交hash未交易成功']);
//                        }

//               M('coinlist')->where(['id'=>$v['id']])->save(['status'=>2,'flag01'=>0,'remark'=>'提交hash未交易成功']);
                    }
//                    if (!in_array($v['hash'], $btcData['result'])) {
//                        M('coinlist')->where(['id' => $v['id']])->save(['status' => 2, 'remark' => '提交hash未交易成功']);
//                    } else {
//                        M('coinlist')->where(['id' => $v['id']])->save(['flag01' => 3]);//验证成功
//                    }
                }
                sleep(1);//1s请求
            }
        }

//        dump($btcData);die;
    }

    /**
     * 自动选择钱包地址
     * @param $id
     * @return array
     */
    public function auto_coin($id = 0)
    {
//        $id = $id % 10;
//        $id = $id % 6;
        $user = [];
        switch ($id) {
//            case 5:
//                $user['from'] = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//                $user['key'] = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//                break;
            case 0:
                $user['from'] = '0x9e63f8300C502E037BA66752eDC8e1234C445Ec3';//平台钱包地址
                $user['key'] = '0xbfe876f130f4405e85395594306cf1107281c940a9e75665eb93f52f8d65c8d9';//平台密钥
                break;
            case 1:
                $user['from'] = '0x35a9FD0Cf8ADc77452E946AFED3518184C2D15D1';//平台钱包地址
                $user['key'] = '0x232213f769a117eaab5f357f657b272ce2b9398ce1ef0f5955a5c5a4ddcd2a16';//平台密钥
                break;
            case 2:
                $user['from'] = '0x19A5219F54c436C426a50461Ebc4a68a3B00beD8';//平台钱包地址
                $user['key'] = '0xcb9ec034a2598105a1a17893205455b63d250d4fbfcd3a33227b8cfb027a8cef';//平台密钥
                break;
            case 3:
                $user['from'] = '0x48211ebc204DaFa0f5FB7AD7b26667F9F7764319';//平台钱包地址
                $user['key'] = '0x521e70874d05f91698e9e2de2b712a9fb913f649941eb2d29614109f75bad5e9';//平台密钥
                break;
            case 4:
                $user['from'] = '0x28A0D357770AA0fa4C7e9F9e7F6227aBD64EB312';//平台钱包地址
                $user['key'] = '0x7a5427367f8679b4e80abd3fd766d903c204c654bfd54268f3fc04546dca2737';//平台密钥
                break;
            case 5:
                $user['from'] = '0xA55e379c75E2698a7e542c50D36807e2407dce72';//平台钱包地址
                $user['key'] = '0xad02d972b7b4cd87a7efc4d4e582b0fd16fe97788bba5b210dd20775d298d578';//平台密钥
                break;

//            case 7:
//                $user['from'] = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//                $user['key'] = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//                break;
//            case 8:
//                $user['from'] = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//                $user['key'] = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//                break;
//            case 9:
//                $user['from'] = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';//平台钱包地址
//                $user['key'] = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';//平台密钥
//                break;
        }
        return $user;
    }

    public function login()
    {
        if (session('Admin_yctr')) {
            $this->redirect('Index/index');
        }

        if (IS_POST) {
            $data = I('post.');
            $data['password'] = md5($data['password']);
            $data['status'] = 1;
            $where['username'] = I('username');
            if (!$admin = M('admin')->where($data)->find()) {
                ajax_return(1, '用户名或者密码错误');
            }

            session('Admin_yctr', $admin);//管理员信息

            $p_info = M('admin_group')->find($admin['group_id']);
//            echo M()->getLastSql();die;
//            dump($p_info);die;
            $menu = new MenuModel();
            session('Admin_menus', $menu->getMenusByPms(explode(',', $p_info['permission'])));//菜单信息
            session('Admin_permissions', explode(',', $p_info['permission']));//权限信息

            $this->makeAdminLogin();
            ajax_return(0, '登录成功', U('Index/index'));

        } else {
            $this->display();
        }
    }


    //管理员登录记录
    private function makeAdminLogin()
    {
        $map['create_time'] = time();
        $map['ip'] = get_client_ip();
        $map['username'] = session('Admin_yctr.username');
        $map['truename'] = session('Admin_yctr.truename');

        return M('login')->add($map);
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


    public function getOut()
    {
        session('Admin_yctr', null);
        $this->redirect('login');
    }


    public function zhen_choose()
    {
        if (IS_POST) {
            $province_id = I('post.area_id');
            $region = M('zhen')->where('father = "' . $province_id . '"')->select();
            $opt = '<option>--请选择镇区--</option>';
            foreach ($region as $key => $val) {
                $opt .= "<option value='{$val['id']}'>{$val['zhen']}</option>";
            }
            echo json_encode($opt);
        } else {
        }
    }


    public function area_choose()
    {
        if (IS_POST) {
            $province_id = I('post.pro_id');
            $region = M('city')->where('father = "' . $province_id . '"')->select();
            $opt = '<option value="">--请选择市区--</option>';
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
            $optt = '<option value="">--请选择地区--</option>';
            foreach ($region as $key => $val) {
                $optt .= "<option value='{$val['areaid']}'>{$val['area']}</option>";
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

    function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}