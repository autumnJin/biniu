<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/9 0009
 * Time: 17:43
 */
namespace Admin\Controller;

use Admin\Model\MenuModel;
use Think\Model;
use Think\Page;

class MenuController extends BaseController
{
    protected $menu;
    public function __construct()
    {
        parent::__construct();
        $this->menu = new MenuModel();
    }

    //菜单列表
    public function menulist()
    {
        $this->assign('title','菜单列表');
        $count = $this->menu->count();
        $this->assign('count',$count);
        $page = new Page($count,10);
        $this->assign('show',$page->show());
        $list = $this->menu->order('sort desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('data',$list);
        $this->display();
    }


    //新增和修改页面
    public function edit_menu()
    {
        $id = I('get.id');
        $this->assign('title','编辑菜单');
        $this->assign('id',I('get.id'));

        $this->assign('data',$this->menu->find($id));
        $this->assign('groups',$this->getAdminGroup());
        $pm = $this->menu->getParentMenu();
        array_unshift($pm,array('name'=>'顶级菜单','id'=>0));
        $this->assign('parent_menus',$pm);
        $this->display();
    }

    public function add_menu()
    {
        $this->assign('title','新增菜单');
        $this->assign('groups',$this->getAdminGroup());
        $pm = $this->menu->getParentMenu();
        array_unshift($pm,array('name'=>'顶级菜单','id'=>0));
        $this->assign('parent_menus',$pm);
        $this->display('edit_menu');
    }

    public function edit_add()
    {
       if(IS_POST){
           $param = I('post.');
           $param['url'] =  strtolower($param['url']);

           if($param['id']){
               //修改
               $id = $param['id'];
               if($this->menu->save($param) === false){
                   ajax_return(1,'修改失败',$this->menu->getLastSql());
               }
           }else{
               //新增
               if(!($id = $this->menu->add($param))){
                   ajax_return('1','新增失败');
               }
           }

//      if( $this->editPermission($param['group'],$id)){
//           ajax_return(1,'权限修改失败');
//      }

           ajax_return(0,'操作成功',U('menulist'));
       }
    }

    private function getAdminGroup()
    {
        return M('admin_group')->select();
    }

    private function editPermission($group,$permission)
    {
            $admin_group = M('admin_group');
            $tag = 0;
            foreach ($group as $k => $v){
                $admin_info = $admin_group->find($v['id']);
                $admin_info['permission'] = $admin_info['permission'].','.$permission;
                if($admin_group->save($admin_info) === false){
                    $tag = 1;
                }
            }

            return $tag;
    }


}