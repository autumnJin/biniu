<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14 0014
 * Time: 17:24
 */

namespace Admin\Controller;

class NewsController extends BaseController
{
    public function newslist()
    {
        $this->assign('data',M('news')->select());
        $this->display();
    }


    public function  add_news()
    {
        $this->assign('title','添加公告');
        $this->display();

    }


    public function edit_news()
    {
        $this->assign('title','编辑公告');
        $this->assign('data',M('news')->find(I('get.id')));
        $this->display('add_news');

    }


    public function add_edit_news()
    {
        if(IS_POST){
            $news = M('news');
            $param = I('post.');
            $param['create_time'] =  time();
            $param['content'] = htmlspecialchars_decode($param['content']);
            if($param['id']){
                    if($news->save($param) === false){
                        ajax_return(1,'编辑失败');
                    }
            }else{
                if(!$news->add($param)){
                    ajax_return(1,'新增失败');
                }
            }

            ajax_return(0,'保存成功',U('newslist'));
        }
    }

    public function newslist2()
    {
        $this->assign('data',M('news2')->select());
        $this->display();
    }


    public function  add_news2()
    {
        $this->assign('title','添加公告');
        $this->display();

    }


    public function edit_news2()
    {
        $this->assign('title','编辑公告');
        $this->assign('data',M('news2')->find(I('get.id')));
        $this->display('add_news2');

    }


    public function add_edit_news2()
    {
        if(IS_POST){
            $news = M('news2');
            $param = I('post.');
            $param['create_time'] =  time();
            $param['content'] = htmlspecialchars_decode($param['content']);
            if($param['id']){
                if($news->save($param) === false){
                    ajax_return(1,'编辑失败');
                }
            }else{
                if(!$news->add($param)){
                    ajax_return(1,'新增失败');
                }
            }

            ajax_return(0,'保存成功',U('newslist2'));
        }
    }

    /**
     * 删除公告
     * User: ming
     * Date: 2019/7/3 11:26
     */
    public function deleteNews()
    {
        if(IS_POST){
            $id = I('post.id');

            if(!M('news')->delete($id)){
                ajax_return(1,'删除失败');
            }

            ajax_return(0,'删除成功',U('newslist'));
        }
    }

    /**
     * 删除通知
     * User: ming
     * Date: 2019/7/3 11:28
     */
    public function deleteNews2()
    {
        if(IS_POST){
            $id = I('post.id');

            if(!M('news2')->delete($id)){
                ajax_return(1,'删除失败');
            }

            ajax_return(0,'删除成功',U('newslist2'));
        }
    }
}

