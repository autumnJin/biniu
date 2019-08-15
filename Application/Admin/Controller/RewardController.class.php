<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/31 0031
 * Time: 13:41
 */


namespace Admin\Controller;

use Think\Page;

class RewardController extends BaseController
{
    public function detail()
    {


        $param = I('get.');
        if ($param['start_time'] && !$param['end_time']) {
            $where['f.create_time'] = array('gt', strtotime($param['start_time']));
        }
        if ($param['end_time'] && !$param['start_time']) {
            $where['f.create_time'] = array('lt', strtotime($param['end_time']));
        }

        if ($param['start_time'] && $param['end_time']) {
            $where['f.create_time'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));

        }
        if($param['username']){
            $where['u.username'] = $param['username'];
            $this->assign('username',$param['username']);
        }

        if($param['reward_type']){
            $where['f.reward_type'] = $param['reward_type'];
        }

        $fmoney = M('fmoney');
        $join = 'left join '.C('DB_PREFIX').'user as u on u.id = f.user_id';
        $count = $fmoney->alias('f')->join($join)->order('f.create_time desc')->where($where)->count();
        $this->assign('count',$count);
        $Page = new Page($count,20);
        $list = $fmoney->alias('f')->join($join)->order('f.create_time desc')->where($where)->limit($Page->firstRow.','.$Page->listRows)->field('f.*,u.username')->select();
        $user = M('user');
        foreach ($list as $k=>$v){
            $data = $user->field('username')->find($v['from_id']);
            $list[$k]['from_id'] = $data['username'];
        }
        $this->assign('page',$Page->show());
        $this->assign('list',$list);
        $this->display();
    }


    //奖金参数设置
    public function rewardConfig()
    {
        if(IS_POST){
            $param = I('post.');

           if($param['amount']){
               $l = M('level');
               foreach ($param['amount'] as $k => $v){
                   $map['id'] = $k+1;
                   $map['amount'] =  $v;
                    $l->save($map);
               }
           }
            if(M('reward_config')->save($param) === false){
                ajax_return(1,'保存失败');
            }

            ajax_return(0,'保存成功',U(''));
        }else{

            $this->assign('data',M('reward_config')->find());
            $this->assign('datal',M('level')->select());
            $this->display();
        }
    }


    public function detailByUser()
    {
        $param = I('get.');
        if ($param['start_time'] && !$param['end_time']) {
            $param['start_time'] = substr($param['start_time'], 0, -1);
            $where['c.cha_date'] = array('gt', strtotime($param['start_time']));
        }
        if ($param['end_time'] && !$param['start_time']) {
            $param['end_time'] = substr($param['end_time'], 0, -1);
            $where['c.cha_date'] = array('lt', strtotime($param['end_time']));
        }

        if ($param['start_time'] && $param['end_time']) {
            $param['start_time'] = substr($param['start_time'], 0, -1);
            $param['end_time'] = substr($param['end_time'], 0, -1);
            $where['c.cha_date'] = array(array('gt', strtotime($param['start_time'])), array('lt', strtotime($param['end_time'])));

        }
        if($param['username']){
            $where['u.username'] = $param['username'];
            $this->assign('username',$param['username']);
        }

        $join = 'left join '.C('DB_PREFIX').'user as u on u.id = c.owner';
        $c = M('cha');
        $count = $c->alias('c')->join($join)->where($where)->order('c.cha_date desc')->group('c.owner')->field('count(*)')->select();
        $page = new Page(count($count),20);
        $data = $c->alias('c')->join($join)->where($where)->limit($page->firstRow.','.$page->listRows)->order('c.cha_date desc')->group('c.owner')->
        field('u.username,u.truename,sum(cha_001) as c1,sum(cha_002) as c2,sum(cha_013) as c13
        ')->select();
        $all = $c->alias('c')->join($join)->where($where)->field('sum(cha_001) as c1,sum(cha_002) as c2,sum(cha_013) as c13')->find();
        $this->assign('data',$data);
        $this->assign('all',$all);
        $this->assign('page',$page->show());
        $this->display();
    }



}