<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6 0006
 * Time: 16:27
 */

namespace Admin\Controller;
use Think\Image;
use Think\Page;
use Think\Upload;

class GoodsController extends BaseController
{
    protected $goods;
    public function __construct()
    {
        parent::__construct();
    }

    //商品列表
    public function goodslist()
    {

        $join = 'left join '.C('DB_PREFIX').'goods_class as gc on gc.id = g.type';
        $count = M('goods')->alias('g')->join($join)->order('create_time desc')->field('gc.name as gc_name,g.*')->count();
        $page = new Page($count,20);
        $this->assign('page',$page->show());
        $data = M('goods')->alias('g')->join($join)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->field('gc.name as gc_name,g.*')->select();
        $gi = M('goods_img');
        foreach ($data as $k => $v)
        {
            $map['goods_id'] = $v['id'];
            $map['type'] = 1;
            $data[$k]['logopath'] = $gi->where($map)->getField('path');
            $data[$k]['sell'] = M('order')->where('goods_id = "'.$v['id'].'"')->count('id');
        }
        $this->assign('count',$count);
        $this->assign('data',$data);
            $this->display();
    }

    //添加商品
    public function add_goods()
    {
        $this->assign('title','新增商品');
        $this->assign('data1',$this->getGoodsClass());
        //商城模块
        $this->assign('modules',M('belong')->order('sort asc')->select());

        $this->display('add_goods');
    }

    public function add_goods1()
    {
        $this->assign('title','新增商品');
        $this->display('add_goods1');
    }


    public function adlist()
    {

        $data = M('ad')->order('create_time')->select();
        $this->assign('data',$data);
        $this->display();
    }

    //编辑商品
    public function edit_goods()
    {
        $id = I('get.id');
        $data = M('goods')->find($id);
        if(!$data){
            $this->error('商品不存在');
        }
        $map['goods_id'] = $id;
        $data2 = M('goods_img')->where($map)->getField('type,path');
        $this->assign('data2',$data2);
        $this->assign('data',$data);
        $this->assign('title','编辑商品');
        $this->assign('data1',$this->getGoodsClass());
        //商城模块
        $this->assign('modules',M('belong')->order('sort asc')->select());
        $this->display('add_goods');
    }

    //删除商品

    public function  del_goods()
    {
        if(IS_POST){
            $param = I('post.id');
            if(!M('goods')->delete($param))
            {


                ajax_return(1,'删除失败');
            }


            ajax_return(0,'删除成功',U('goodslist'));

        }
    }

    public function  del_goods1()
    {
        if(IS_POST){
            $param = I('post.id');
            if(!M('ad')->delete($param))
            {


                ajax_return(1,'删除失败');
            }


            ajax_return(0,'删除成功',U('adlist'));

        }
    }

    private function getGoodsClass()
    {
        return M('goods_class')->select();
    }


    public function xiajia_goods()
    {
        if(IS_POST){
            $param = I('post.');
            $param['status'] = $param['status'] == 1 ? 2:1;
            if(!M('goods')->save($param))
            {


                ajax_return(1,'操作失败');
            }


            ajax_return(0,'操作成功',U('goodslist'));
        }
    }

    /**
     *
     */
    public function edit_add_goods()
    {
        if(IS_POST){
            $param = I('post.');

            $g =M('goods');
            $gi = M('goods_img');
            $param['content'] = htmlspecialchars_decode($param['content']);
            $upload = new \Think\Upload();// 实例化上传类
            $upload->saveName = 'getOrderNum';

            $image = new \Think\Image();  //实例化图像处理类




            if($param['id']){

                if($g->save($param) === false){
                    ajax_return(1,'商品编辑失败',U('goodslist'));
                }

                foreach ($_FILES as $k1=> $v1)
                {
                    foreach($v1['size'] as $k2=>$v2){
                        if($v1['size'][$k2]>0){
                            if(!$info   =   $upload->upload()){
                                ajax_return(1,$upload->getError(),U('goodslist'));
                            }

                            foreach ($info as $k1 => $v1){
                                $imgsrc = '/Uploads/'.$v1['savepath'].$v1['savename'];
//                            $image->open('.'.$imgsrc);
//                            $image->thumb(220,220,\Think\Image::IMAGE_THUMB_FIXED)->save('.'.$imgsrc);
                                $where['goods_id'] = $param['id'];
                                $where['type'] = substr($k1,-1)+1;
                                $save['path'] = $imgsrc;
                                $gi->where($where)->save($save);
                            }
                        }
                    }
                }


            }else{

                foreach ($_FILES as $k1=> $v1){
                    if($v1['size'] == 0){
                        ajax_return(1,'请上传完整图片',U('goodslist'));

                    }

                    //$arr[] = $info;
                }
                $param['create_time'] = time();
                if(!$id = $g->add($param)){
                    ajax_return(1,'新增失败',U('goodslist'));
                }

                if(!$info   =   $upload->upload($_FILES)){
                    ajax_return(1,$upload->getError());
                }




                foreach ($info as $k => $v) {

                    $imgsrc = '/Uploads/'.$v['savepath'].$v['savename'];
                    //$image->open('.'.$imgsrc);
                    // $image->thumb(220,220,\Think\Image::IMAGE_THUMB_FIXED)->save('.'.$imgsrc);
                    $add['goods_id'] = $id;
                    $add['type'] = substr($k,-1)+1;
                    $add['path'] = $imgsrc;
                    $gi->add($add);

                }



            }
            ajax_return(0,'保存成功',U('goodslist'));
        }
    }


    public function edit_add_goods1()
    {
        if(IS_POST){
            $param = I('post.');



            $g =M('goods');
            $gi = M('goods_img');
            $param['content'] = htmlspecialchars_decode($param['content']);
            $upload = new \Think\Upload();// 实例化上传类
            $image = new \Think\Image();  //实例化图像处理类
            if($param['id']){

                if($g->save($param) === false){
                    $this->error('商品编辑失败');
                }

                foreach ($_FILES as $k1=> $v1)
                {
                    if($v1['size']>0){
                        if(!$info   =   $upload->upload()){
                            $this->error($upload->getError());
                        }

                        foreach ($info as $k1 => $v1){
                            $imgsrc = '/Uploads/'.$v1['savepath'].$v1['savename'];
                            $image->open('.'.$imgsrc);
                            $image->thumb(190,190,\Think\Image::IMAGE_THUMB_FIXED)->save('.'.$imgsrc);
                            $where['goods_id'] = $param['id'];
                            $where['type'] = substr($k1,-1);
                            $save['path'] = $imgsrc;
                            $gi->where($where)->save($save);
                        }

                        break;
                    }
                }

            }else{

                if(!$info   =   $upload->upload()){
                    $this->error($upload->getError());
                }

                $imgsrc = '/Uploads/'.$info['logo1']['savepath'].$info['logo1']['savename'];


                $param['create_time'] = time();
                $param['logo'] = $imgsrc;
                if(!$id = M('ad')->add($param)){
                    $this->error('新增失败');
                }








            }

            $this->success('保存成功');
        }
    }





    //商品分类

    public function goodsClass()
    {
        $this->assign('data',M('goods_class')->order('sort asc')->select());
        $this->display();
    }

    public function goodsBelong()
    {
        $this->assign('data',M('belong')->order('sort asc')->select());
        $this->display();
    }

    //*商品大类*//
    public function add_goodsBelong()
    {

        $this->assign('title','添加商品大类');
        $this->display();
    }
    //编辑分类

    public function edit_goodsBelong()
    {

        $this->assign('title','编辑商品大类');
        $this->assign('data',M('belong')->find(I('id')));
        $this->display('add_goodsbelong');
    }
    //添加编辑商品分类  暂时未作图片处理

    public function add_edit_goodsBelong()
    {
        if(IS_POST){
            $param = I('post.');
            $goodsclass = M('belong');
            if($param['id']){
                //编辑操作
                if($goodsclass->save($param) ===  false){
                    ajax_return(1,'编辑失败');
                }
            }else{
                //添加操作
                if(!$goodsclass->add($param)){
                    ajax_return(1,'添加失败');
                }
            }

            ajax_return(0,'保存成功',U('goodsBelong'));
        }
    }

    //添加分类
    public function add_goodsclass()
    {
        $this->assign('b',M('belong')->select());
        $this->assign('title','添加商品分类');
        $this->display();
    }
    //编辑分类

    public function edit_goodsclass()
    {
        $this->assign('b',M('belong')->select());
        $this->assign('title','编辑商品分类');
        $this->assign('data',M('goods_class')->find(I('id')));
        $this->display('add_goodsclass');
    }

    //添加编辑商品分类  暂时未作图片处理
    public function add_edit_goodsclass()
    {
        if(IS_POST){
            $param = I('post.');
            $goodsclass = M('goods_class');
            if($param['id']){
                //编辑操作
                if($goodsclass->save($param) === false){
                    ajax_return(1,'编辑失败');
                }
            }else{
                //添加操作
                if(!$goodsclass->add($param)){
                    ajax_return(1,'添加失败');
                }
            }

            ajax_return(0,'保存成功',U('goodsClass'));
        }
    }

    //轮播图
    public function lunbo()
    {

        if(IS_POST)
        {
            $id = I('post.id');
            if(M('lunbo')->where(['id'=> $id])->delete())
            {
                $this->ajaxReturn(array('code'=>'1','message'=>'轮播图删除成功!'));
            } else {
                $this->ajaxReturn(array('code'=>'0','message'=>'轮播图删除失败!'));
            }
        }

        $this->assign('data',M('lunbo')->select());
        $this->display();
    }

    //轮播图新增

    public function add_lunbo()
    {
        $this->assign('title','新增轮播图');
        $this->display();
    }

    //轮播图编辑


    public function edit_lunbo()
    {

        $this->assign('data',M('lunbo')->find(I('get.id')));
        $this->assign('title','编辑轮播图');
        $this->display('add_lunbo');
    }

    public function add_edit_lunbo()
    {
        if(IS_POST){
            $param = I('post.');
            $upload = new Upload();
            $image =  new Image();
            $upload->maxSize = C('MAX_SIZE.goods');
            //设置上传文件类型
            $upload->allowExts = explode(',', 'jpg,png,jpeg');
            //设置附件上传目录
            // $upload->rootPath = C('UPLOAD_PATH');

//               if(!is_dir($upload->rootPath)){
//                   mkdir($upload->rootPath);
//                   chmod($upload->rootPath,0777);
//               }
            $upload->autoSub = true;
            $upload->subName = array('date','Ymd');
            $upload->savePath = '';
            $upload->saveRule = 'uniqid';
            $info  = $upload->upload();

            if(!$info){
                ajax_return(1,$upload->getError());
            }
            $param['logo'] = '/Uploads/'.$info['logo']['savepath'].$info['logo']['savename'];
           # $image->open('.'.$param['logo']);
            #$image->thumb(700,450,\Think\Image::IMAGE_THUMB_FIXED)->save($param['logo']);
            $lunbo = M('lunbo');
            if($param['id']){
                if($lunbo->save($param) === false){
                    ajax_return(1,'编辑失败');
                }
            }else{
                if(!$lunbo->add($param)){
                    ajax_return(1,'添加失败');
                }
            }
            ajax_return(0,'保存成功',U('goods/lunbo'));
        }
    }

    //轮播图新增和编辑
    public function add_edit_lunbo1()
    {
           if(IS_POST){
               $param = I('post.');
               $upload = new \Think\Upload();
               $image =  new Image();
               $upload->maxSize = C('MAX_SIZE.goods');
               //设置上传文件类型
               $upload->allowExts = explode(',', 'jpg,png,jpeg');
               //设置附件上传目录
               $upload->rootPath = C('UPLOAD_PATH');

               if(!is_dir($upload->rootPath)){
                   mkdir($upload->rootPath);
                   chmod($upload->rootPath,0777);
               }
               $upload->autoSub = true;
               $upload->subName = array('date','Y-m-d');
               $upload->savePath = '';
               $upload->saveRule = 'uniqid';
               $info  = $upload->upload();



               if(!$info){
                   ajax_return(1,$upload->getError());
               }
               $param['logo'] = C('UPLOAD_PATH').$info['logo']['savepath'].$info['logo']['savename'];
             //  $image->open($param['logo']);
              // $image->thumb(700,450,\Think\Image::IMAGE_THUMB_FIXED)->save($param['logo']);
               $lunbo = M('lunbo');
               if($param['id']){
                   if($lunbo->save($param) === false){
                       ajax_return(1,'编辑失败');
                   }
               }else{
                   if(!$lunbo->add($param)){
                       ajax_return(1,'添加失败');
                   }
               }
               ajax_return(0,'保存成功',U('goods/lunbo'));
           }
    }

    //基础设置
    public function front()
    {
        $this->assign('data',M('front')->select());
        $this->display();
    }


    //基础设置修改

    public function edit_front()
    {
        if(IS_POST){

        }
    }


}