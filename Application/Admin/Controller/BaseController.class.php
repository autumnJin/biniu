<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6 0006
 * Time: 15:44
 */

namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller
{
    protected $admin;
    protected $permission;
    protected $menus;
    public function __construct()
    {


        parent::__construct();


        $this->admin = session('Admin_yctr');
        if($this->admin['group_id'] == 1){
            define('ROOT',1);
        }
        if(!$this->admin){
            $this->redirect('Public/login');
        }
        $this->permission = session('Admin_permissions');
        $this->menus =  session('Admin_menus');
    //        dump($this->menus);die;
        $url =  CONTROLLER_NAME.'/'.ACTION_NAME;
        $this->checkAuth($url);
        $this->assign('admin_menu',$this->menus);

        //获取配置参数
        $config=M('reward_config')->find();
        $this->assign('config',$config);
    }

    private function checkAuth($url)
    {
        if(ROOT == 1){
            return true;
        }
            $url  = strtolower($url);

            if($url == 'index/index'){ //默认首页都可以看到
                return true;
            }
            $menu_id = M('menu')->where(array('url'=>$url))->getField('id');
            if(!in_array($menu_id,$this->permission)){
                $this->error('禁止访问');
            }

    }



    protected function  add_fmoney($user_id,$from_id,$amount,$type,$reward_type,$tips,$flag='+')
    {
        $map['user_id'] =$user_id;
        $map['from_id'] = $from_id;
        $map['amount'] = $amount;
        $map['type'] = $type;
        $map['reward_type'] = $reward_type;
        $map['tips'] = $tips;
        $map['create_time'] = time();
        $map['flag'] = $flag;

        return M('fmoney')->add($map);
    }


    private function getmenus()
    {

    }


    public function _empty()
    {
            $this->redirect('Public/404');
    }

    private function getCalendar()
    {

    }



}