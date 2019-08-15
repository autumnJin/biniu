<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/9 0009
 * Time: 17:43
 */
namespace Admin\Controller;

use Admin\Model\MenuModel;
use Think\Page;

class AdminController extends BaseController
{
    //权限列表
    public function authlist()
    {
        $this->assign('group_info',M('admin_group')->find(I('get.group_id')));
        $this->assign('title','修改权限');
        $menu = new MenuModel();
        $this->assign('menulist',$menu->menu_auth_list());
        $this->display();
    }

    //修改权限
    public function doauth()
    {
        if(IS_POST){
            $param = I('post.');
            $admin_group = M('admin_group');
           if(!$info = $admin_group->find($param['id'])){
               ajax_return(1,'用户组不存在');
           }

           $param['permission']  =  implode(',',$param['permission']);
           if($admin_group->save($param) === false){
                    ajax_return(1,'修改失败',$admin_group->getLastSql());
           }
            ajax_return(0,'修改成功',U('admin_group'));
        }
    }
    //角色列表
    public function admin_group()
    {
        $this->assign('data',M('admin_group')->select());
        $this->display();
    }


    public function admin_list()
    {

        $join = 'left join '.C('DB_PREFIX').'admin_group as g on a.group_id = g.id';
        $data = M('admin')->alias('a')->join($join)->field('a.*,g.group_name')->select();
        $this->assign('data',$data);
        $this->display();
    }

    //管理员添加

    public function add_admin()
    {
            $this->assign('title','管理员添加');
            $this->assign('admin_group',$this->getAdminGroup());
            $this->display();
    }

    //管理员编辑

    public function edit_admin()
    {
        $this->assign('title','管理员编辑');
        $this->assign('data',M('admin')->find(I('id')));
        $this->assign('admin_group',$this->getAdminGroup());
        $this->display('add_admin');
    }

    //管理员添加和修改

    public function add_edit_admin()
    {
       if(IS_POST){
           $param = I('post.');
           $admin =  M('admin');
           if($param['id']){
               if(!trim($param['password'])){
                   unset($param['password']);
               }else{
                   $param['password'] = md5($param['password']);
               }
               if($admin->save($param) === false){
                   ajax_return(1,'编辑失败');
               }
           }else{
               if($this->getAdminByUsername($param['username'])){
                   ajax_return(1,'该用户名已经存在');
               }
               $param['password'] =  md5($param['password']);
               if(!$admin->add($param)){
                   ajax_return(1,'添加失败');
               }
           }

           ajax_return(0,'保存成功',U('admin_list'));
       }
    }


    public function loginRecord()
    {
        $param = I('get.');
        if ($param['start_time'] && !$param['end_time']) {
            $map['create_time'] = array('gt', strtotime($param['start_time']));
            $this->assign('start_time',$param['start_time']);

        }
        if ($param['end_time'] && !$param['start_time']) {
            $map['create_time'] = array('lt', strtotime($param['end_time']));
            $this->assign('end_time',$param['end_time']);
        }

        if ($param['start_time'] && $param['end_time']) {
            $map['create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
            $this->assign('start_time',$param['start_time']);
            $this->assign('end_time',$param['end_time']);
        }


        if ($param['username']) {
            $map['username'] = $param['username'];
            $this->assign('username',$param['username']);
        }

        $count = M('login')->where($map)->count();
        $page = new Page($count,20);
        $list = M('login')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('data',$list);
        $this->assign('page',$page->show());
        $this->display();

    }



    public function userloginRecord()
    {
        $param = I('get.');
        if ($param['start_time'] && !$param['end_time']) {
            $map['create_time'] = array('gt', strtotime($param['start_time']));
            $this->assign('start_time',$param['start_time']);

        }
        if ($param['end_time'] && !$param['start_time']) {
            $map['create_time'] = array('lt', strtotime($param['end_time']));
            $this->assign('end_time',$param['end_time']);

        }

        if ($param['start_time'] && $param['end_time']) {
            $map['create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
            $this->assign('start_time',$param['start_time']);
            $this->assign('end_time',$param['end_time']);



        }


        if ($param['username']) {
            $map['username'] = $param['username'];
            $this->assign('username',$param['username']);

        }

        $count = M('user_login')->where($map)->count();
        $page = new Page($count,20);
        $list = M('user_login')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('data',$list);
        $this->assign('page',$page->show());
        $this->display();

    }
    //系统开关
    public function sysswitch()
    {
        if(IS_POST){
            $param = I('post.');
            $param['id'] = 1;
            if(M('sysconfig')->save($param) === false){
                ajax_return(1,'保存失败');
            }

            ajax_return(0,'保存成功',U('index/index'));
        }else{
            $this->assign('data',M('sysconfig')->find(1));
            $this->display();
        }
    }


    //网络图开关
    public function mapSwitch()
    {
        if(IS_POST){
            $param = I('post.');
            $param['id'] = 2;
            if(M('sysconfig')->save($param) === false){
                ajax_return(1,'保存失败');
            }

            ajax_return(0,'保存成功',U('index/index'));
        }else{
            $this->assign('data',M('sysconfig')->find(2));
            $this->display();
        }
    }

    public function sysControl()
    {
        $this->display();
    }

    //清空数据库/表

    public function dropTable()
    {
            if(IS_POST){


                $map['id'] = array('gt',1);
//                M('user')->where($map)->delete();
//                M('jd')->where($map)->delete();
//                M('tj')->where($map)->delete();
//                $save['zuo_zong'] = 0;
//                $save['you_zong'] = 0;
//                $save['zuo_peng'] = 0 ;
//                $save['you_peng'] = 0 ;
                M('user')->where($map)->save(array('z10'=>0));
                $map1['id'] = array('gt',0);
                M('address')->where($map1)->delete();
                M('cart')->where($map1)->delete();
                M('center_address')->where($map1)->delete();
                M('cha')->where($map1)->delete();
                M('check')->where($map1)->delete();
                M('daili')->where($map1)->delete();
                M('fmoney')->where($map1)->delete();
                M('login')->where($map1)->delete();
                M('money_detail')->where($map1)->delete();
                M('msg_list')->where($map1)->delete();
                M('order')->where($map1)->delete();
                M('recharge')->where($map1)->delete();
                M('suborder')->where($map1)->delete();
                M('upgrade_order')->where($map1)->delete();
                M('user_login')->where($map1)->delete();
                M('weixin')->where($map1)->delete();
                M('withdraw')->where($map1)->delete();
                ajax_return(0,'操作成功');
            }
    }


    public function change_password()
    {
        if(IS_POST){
            $param = I('post.');
            $param['password'] = md5($param['password']);
            $param['id'] = $this->admin['id'];
            if(md5($param['password_'])!=$this->admin['password']){
                ajax_return(1,'旧密码错误');
            }

            if(M('admin')->save($param) === false){
                ajax_return(1,'修改失败');
            }

            ajax_return(0,'修改成功',U('change_password'));
        }else{
            $this->display();
        }
    }

//日结
    public function jiesuan()
    {
        if(IS_POST){
            $db = M();
            $db->execute("call zhixing_ri");//正常
            ajax_return(0,'操作成功');
        }
    }

    //月结
    public function jiesuan_()
    {
        if(IS_POST){

            $db = M();
            $db->execute("call zhixing_yue");//正常
            ajax_return(0,'操作成功');
        }
    }


    //新增银行
    public function add_zhen()
    {
        $this->assign('title','添加镇区');
        $city = M('city')->select();
        $area = M('area')->select();

        $province = M('province')->select();
        $this->assign('p',$province);
        $this->assign('c',$city);
        $this->assign('a',$area);
        $this->display();
    }
////修改页面
//    public function edit_bank()
//    {
//        $this->assign('title','编辑银行');
//        $this->assign('data',M('bank')->find(I('get.id')));
//        $this->display('add_bank');
//    }
//新增修改银行

    public function  add_edit_zhen()
    {
        if(IS_POST){
            $param = I('post.');
            $bank  = M('zhen');
            if($param['id']){
                if($bank->save($param) ===  false){
                    ajax_return(1,'修改失败');
                }
            }else{
                if(!$bank->add($param)){
                    ajax_return(1,'新增失败');
                }

            }

            ajax_return(0,'保存成功',U('userList'));
        }
        $this->display();
    }



//新增银行
public function add_bank()
{
    $this->assign('title','新增银行');
    $this->display();
}
//修改页面
    public function edit_bank()
    {
        $this->assign('title','编辑银行');
        $this->assign('data',M('bank')->find(I('get.id')));
        $this->display('add_bank');
    }
//新增修改银行

public function  add_edit_Bank()
{
    if(IS_POST){
        $param = I('post.');
        $bank  = M('bank');
            if($param['id']){
                    if($bank->save($param) ===  false){
                        ajax_return(1,'修改失败');
                    }
            }else{
                if(!$bank->add($param)){
                    ajax_return(1,'新增失败');
                }

            }

            ajax_return(0,'保存成功',U('bankList'));
    }
    $this->display();
}


//银行列表

public function  bankList()
{

        $this->assign('data',M('bank')->select());
        $this->display();
}

//删除银行

public function bankDelete()
{
    if(IS_POST){
        if(!M('bank')->delete(I('post.id')))
        {
            ajax_return(1,'删除失败');
        }

        ajax_return(0,'删除成功',U('bankList'));
    }
}


    private function getAdminByUsername($username)
    {
        return M('admin')->where(array('username'=>$username))->find();
    }


    private function getAdminGroup()
    {
        return M('admin_group')->select();
    }






}