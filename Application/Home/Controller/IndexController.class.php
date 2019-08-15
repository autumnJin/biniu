<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //获取前三个首页推荐产品
        $where['a.status'] = 1;//上架
        $join = 'left join '.C('DB_PREFIX').'goods_img as g on a.id = g.goods_id';
        $groomGoods = M('goods')->where($where)
                                ->alias('a')
                                ->join($join)
                                ->order('sort desc')
                                ->limit(3)
                                ->field('a.*,g.path')
                                ->select();

        $this->assign('groomGoods',$groomGoods);
        $this->assign('goodsList',$this->getGoodsList());   //升级专区
        $this->assign('goodsList2',$this->getGoodsList2()); //复购专区
        $this->assign('g_class',$this->getClass());
        $this->assign('lunbo',$this->getLunBo());
        $this->assign('news',$this->getNews());
        $config = M('reward_config')->find(1);
        $this->assign('qq',$config['qq']);
        $this->display();
    }

    /**
     * 升级专区产品
     */
    public function uplevel(){
        //获取前三个首页推荐产品
        $where['a.status'] = 1;//上架
        $join = 'left join '.C('DB_PREFIX').'goods_img as g on a.id = g.goods_id';
        $groomGoods = M('goods')->where($where)
            ->alias('a')
            ->join($join)
            ->order('sort desc')
            ->limit(3)
            ->field('a.*,g.path')
            ->select();

        $this->assign('groomGoods',$groomGoods);
        $this->assign('goodsList',$this->getGoodsList());
        $this->assign('goodsList2',$this->getGoodsList2());
        $this->assign('g_class',$this->getClass());
        $this->assign('lunbo',$this->getLunBo());
        $this->assign('news',$this->getNews());
        $config = M('reward_config')->find(1);
        $this->assign('commission',$config['duipeng_2']);
        $this->display();
    }
    public function index3(){
        $this->assign('data',$this->getGoodsList1());
        $this->assign('g_class',$this->getClass());
        $this->assign('lunbo',$this->getLunBo());

        $this->display();
    }

    //轮播图
    private function getLunBo()
    {
        return M('lunbo')->select();
    }


    private function getVipGoods()
    {
        $map['pro_type'] = 1;
        $map['status'] = 1;
        $data = array();
        $data = M('goods')->where($map)->select();
        $gi = M('goods_img');
        foreach ($data as  $k=>$v)
        {
            $img =$gi->where(array('goods_id'=>$v['id']))->select();

            $data[$k]['img'] =$img;
        }
        return $data;
    }

    public function news()
    {

        $this->assign('data',M('news')->where()->select());
        $this->display();
    }


    public function newsdetail()
    {
        $id = I('get.id',0);
        if($id){
            $this->assign('data',M('news')->find($id));
        }
        $this->display();
    }


    public function sort()
    {
        $this->assign('data',$this->getClass());
        $this->display();
    }
    //商城公告模块
    public function getNews()
    {

        $map['status'] = 1;
        return M('news')->where($map)->order('create_time desc')->limit(7)->field('id,title')->select();
    }

    private function getClass()
    {
        $w['status'] = 1;
        $b = M('belong')->where($w)->select();
        $gc = M('goods_class');
        foreach ($b as  $k=>$v){
            $map['belong'] = $v['id'];
            $children = $gc->where($map)->select();
            $arr[$k]['b_name'] =$v['name'];
            $arr[$k]['children'] =$children;
        }



        return $arr;
    }

    private function getGoodsBigList($flag = 1)
    {
        $data = M('belong')->select();
        $g= M('goods');
        $gi = M('goods_img');
        foreach ($data as $k=> $v)
        {

            $map['type'] = $v['id'];
            $map['status'] = 1;

            $children = $g->where($map)->order('create_time desc')->limit(4)->select();
            if($children){
                $arr[$k]['children'] = $g->where($map)->select();
                $arr[$k]['name'] = $v['name'];
                $arr[$k]['c_id'] = $v['id'];
                foreach ($arr[$k]['children'] as $k1=> $v1)
                {
                    $img =$gi->where(array('goods_id'=>$v1['id']))->select();
                    $arr[$k]['children'][$k1]['img'] =$img;
                }
            }

        }


        return $arr;
    }

    private function getGoodsList($flag = 1)    //升级区
    {
        $data = M('belong')->order('sort asc')->select();
        $g= M('goods');
        $gi = M('goods_img');
        foreach ($data as $k=> $v)
        {
            $map['module'] = $v['id'];
            $map['status'] = 1;
            $map['is_up'] = 1;
            $children = $g->where($map)->order('create_time desc')->limit(4)->select();
            if($children){
                $arr[$k]['children'] = $g->where($map)->select();
                $arr[$k]['name'] = $v['name'];
                $arr[$k]['c_id'] = $v['id'];
                foreach ($arr[$k]['children'] as $k1=> $v1)
                {
                    $img =$gi->where(array('goods_id'=>$v1['id']))->select();
                    $arr[$k]['children'][$k1]['img'] =$img;
                }
            }
        }
        return $arr;
    }

    private function getGoodsList2($flag = 1)   //复购区
    {
        $data = M('belong')->order('sort asc')->select();
        $g= M('goods');
        $gi = M('goods_img');
        foreach ($data as $k=> $v)
        {
            $map['module'] = $v['id'];
            $map['status'] = 1;
            $map['is_up'] = 2;
            $children = $g->where($map)->order('create_time desc')->limit(4)->select();
            if($children){
                $arr[$k]['children'] = $g->where($map)->select();
                $arr[$k]['name'] = $v['name'];
                $arr[$k]['c_id'] = $v['id'];
                foreach ($arr[$k]['children'] as $k1=> $v1)
                {
                    $img =$gi->where(array('goods_id'=>$v1['id']))->select();
                    $arr[$k]['children'][$k1]['img'] =$img;
                }
            }
        }
        return $arr;
    }

    private function getGoodsList1($flag = 1)
    {
        $arr = M('ad')->select();
        return $arr;
    }

    public function selectpay(){
        header('Content-Type: text/html; charset=UTF-8');
        $order_num = I('id');
        $order = M('recharge')->where('order_num = "'.$order_num.'"')->find();
        if(!$order){
            $this->error('非法参数');
        }
        Vendor('WxPayv3.JSAPI');  
        $tools = new \JsApiPay();
        $openid = $tools->GetOpenid();
        $total_money = $order['amount'];

        $input = new \WxPayUnifiedOrder();
        $input->SetBody("余额充值");//商品或支付单简要描述
        $input->SetAttach($order['order_num']); //附加数据
        $input->SetOut_trade_no($order['order_num']);//传的值
        $input->SetTotal_fee($total_money*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("余额充值");
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/index.php/index/notifydfc';
        $input->SetNotify_url($url);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openid);


        $or = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($or);

        $this->assign('jsApiParameters',$jsApiParameters);
        $this->assign("total_money",$total_money);
        $this->assign('order',$order);
        $this->display();
    }


    public function notifydfc()
    {
        Vendor('WxPayv3.JSAPI');  
        $xmlObj = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA']); //解析回调数据
        $out_trade_no = $xmlObj->out_trade_no;//订单号
        $total_fee = $xmlObj->total_fee;//支付价格
        $openid = $xmlObj->openid;//
        $queryorder = new \MicroPay();
        $rejg = $queryorder->query($out_trade_no);

        if ($rejg) {
            $order = M('recharge')->where('order_num = "' . $out_trade_no . '"')->find();
            if ($order['status'] == 2) {
                file_put_contents("no.txt", $out_trade_no.'订单已经支付');
                $this->redirect('User/index');
                exit();
            } else {
                //$sub_where['sum_id'] = $order['id'];
                $sum['status'] = '2';
                //  $sum['payment'] = '1';//在线支付
                M('recharge')->where('id = "' . $order['id'] . '"')->save($sum);
                $user = M('user')->find($order['user_id']);
                $save['id'] = $order['user_id'];
                $save['pocket']  = $user['pocket']+$order['amount'];
                //$save['status']  = 2;
                M('user')->save($save);

                $map['user_id'] = $user['id'];
                $map['amount'] = $order['amount'];
                $map['type'] = 1;
                $map['create_time'] = time();
                $map['tips'] = '账户充值';
                // $map['account'] = $account;
                $map['flag'] = '+';
                M('money_detail')->add($map);

//                $db = M();
//                $a = $order['user_id'];
//                $where['level'] = $order['level'];
//
//                $c = M('config')->where($where)->count();
//                $b = $order['level'];
//                $aa = $db->execute("call jiangjin($a,$c,$b)");//正常


                // $m1 = '0.91';
                // $m2 = '0.92';
                // $m3 = '0.93';

                // $this->redirect('User/index');

            }
        }
    }

}