<?php
namespace Admin\Controller;

use Think\Page;

class DetailController extends BaseController {

    public function index()
    {
       $username = I('get.username');
        $param = I('get.');
        if ($param['start_time'] && !$param['end_time']) {
            $map['create_time'] = array('gt', strtotime($param['start_time']));
            $this->assign('create_time',$map['create_time']);

        }
        if ($param['end_time'] && !$param['start_time']) {
            $map['create_time'] = array('lt', strtotime($param['end_time']));
            $this->assign('end_time',$map['end_time']);

        }

        if ($param['start_time'] && $param['end_time']) {
            $map['create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));
            $this->assign('create_time',$map['create_time']);

            $this->assign('end_time',$map['end_time']);


        }

        if ($param['type']) {
            $map['d.type'] = $param['type'];

            $this->assign('type',$param['type']);
        }


        if($username){
            $map['username'] = $username;
            $this->assign('username',$map['username']);
        }

        $detail = M('money_detail');
        $join ='left join '.C('DB_PREFIX').'user as u on u.id = d.user_id';
        $count = $detail->alias('d')->join($join)->where($map)->count();

        $this->assign('count',$count);
        $page = new Page($count,20);
        $list = $detail->alias('d')->join($join)->order('d.create_time desc')->where($map)->limit($page->firstRow.','.$page->listRows)->field('d.*,u.username')->select();
        $this->assign('list',$list);
        $this->assign('page',$page->show());
        $this->display();
    }

}

?>