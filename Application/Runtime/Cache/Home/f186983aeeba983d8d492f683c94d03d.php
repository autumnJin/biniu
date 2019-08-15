<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HPAY</title>
    <link rel="stylesheet" href="/Public/Wap/css/mui.min.css">
    <link rel="stylesheet" href="/Public/Wap/css/discover.css">

    <script src="/Public/Wap/js/zepto.min.js"></script>
    <script src="/Public/Wap/js/mui.min.js"></script>
    <script src="/Public/Wap/js/1.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Wap/css/common.css"/>


    <!--<link rel="stylesheet" type="text/css" href="/Public/Wap/css/swiper.min.css"/>-->
    <!--<script src="/Public/Wap/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
    <!--<script src="/Public/Wap/js/main.js" type="text/javascript" charset="utf-8"></script>-->
    <!--<script src="/Public/common/js/common.js" type="text/javascript" charset="utf-8"></script>-->
 <!---->
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    html {
        font-size: 13.3333333333333vw;
    }
    .header{
        background: linear-gradient(to right, #1e91ff, #075ffe);
        height: 1.16rem;
        line-height: 1.4rem;
        color: #fff;
        text-align: center;
        font-size: .34rem;
        border-bottom: 1px solid #ececec;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 .2rem;
    }
    .header a{
        width: .2rem;
        display: inline-block;
    }
    .header a img{
        width: 100%;
    }
    .container{
        width: 100%;
        padding: .2rem;
        font-size: 14px;
    }
    #waitPay .second .box .txt{
        width: 4rem;
    }
</style>
<div id="waitPay">

    <header class="header">
        <a href="javascript:window.history.go(-1)"><img src="/Public/Wap/img/arrowl.png"></a>
        <div>我的订单</div>
        <a href="javascript:void(0)" style="opacity: 0"><img src="/Public/Wap/img/arrowl.png"></a>
    </header>
    <div class="info">
        <div class="container">
            <?php if($orderInfo['status'] == 1){ $s = '待付款'; }else if($orderInfo['status'] == 2 && $orderInfo['wuliu_status'] !=5 && $orderInfo['wuliu_status'] !=6){ $s = '待发货'; }else if($orderInfo['wuliu_status'] == 5){ $s = '待收货'; }else if($orderInfo['wuliu_status'] == 6){ $s = '已收货'; }else{} ?>
            <div class="p1">订单时间：<?php echo (date("Y-m-d",$orderInfo['create_time'])); ?> <span><?php echo ($s); ?></span></div>
        </div>
    </div>
    <section class="first">
        <div class="container">
            <div class="p1"><?php echo ($orderInfo["receiver"]); ?> <span><?php echo ($orderInfo["phone"]); ?></span></div>
            <div class="p3"><?php echo ($orderInfo["address"]); ?></div>
            <div class="p3"><?php echo ($orderInfo["wallet_address"]); ?></div>
        </div>
    </section>
    <section class="second">
        <?php if(is_array($orderInfo['suborder'])): $i = 0; $__LIST__ = $orderInfo['suborder'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="box">
            <?php $format = C('format'); ?>
            <div class="container">
                <div class="pic"><img src="<?php echo ($vo["path"]); ?>"></div>
                <div class="txt">
                    <div class="p1">
                        <?php echo ($vo['goodInfo']['name']); ?>
                    </div>
                    <div class="p3">
                        ￥<?php echo ($vo['goodInfo']['price']); ?> / <?php echo ($format[$vo['goodInfo']['format']]); ?>
                        <span>x<?php if(count($orderInfo['suborder']) != 1): echo ($vo["num"]); else: echo ($orderInfo["num"]); endif; ?></span>
                    </div>
                </div>
                <!--<a class="mores" href=""  style="width: 1.5rem">退款成功</a>-->
            </div>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </section>
    <section class="third">
        <div class="container">
            <div class="tiles">备注</div>
            <div class="p1"><?php echo ($orderInfo["tips"]); ?></div>
            <div class="p3">合计：<span>￥<?php echo ($orderInfo["amount"]); ?></span></div>
        </div>
    </section>
    <section class="fourth">
        <div class="container">
            <div class="p1">订单编号：<?php echo ($orderInfo["order_id"]); ?></div>
            <div class="p1">下单时间：<?php echo (date("Y-m-d H:i:s",$orderInfo['create_time'])); ?></div>
            <!--<div class="p1">成交时间：2018-06-25</div>-->
        </div>
    </section>
    <div class="container">
        <div class="exce">
            <?php if($orderInfo['status'] == 1): ?><a href="<?php echo U('pay',array('order_id'=>$orderInfo['order_id']));?>">去付款</a>
                <a class="del active" o_id="<?php echo ($orderInfo['id']); ?>" href="#">取消订单</a><?php endif; ?>
            <?php if($orderInfo['wuliu_status'] == 5): ?><a href="http://m.kuaidi100.com/result.jsp?nu=<?php echo ($orderInfo['wuliu']); ?>">去付款</a>
                <a class="recevice active" o_id="<?php echo ($orderInfo['id']); ?>" href="#">确认收货</a><?php endif; ?>
        </div>
    </div>
</div>
<script src="/Public/Wap/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/Wap/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/Wap/js/main.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/Wap/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(function () {
        $('.del').click(function () {
            if(confirm('确定删除吗?')){
                var url = "<?php echo U('deleteorder');?>";
                var id = $(this).attr('o_id');
                $.post(url,{id:id},function (data) {
                    alert(data.msg);
                    if(data.code){
                        return;
                    }else{
                        window.location.href=data.data;
                    }
                },'json')
            }
        });
        $('.recevice').click(function () {
            if(confirm('确定收货吗?')){
                var url = "<?php echo U('recevice');?>";
                var id = $(this).attr('o_id');
                $.post(url,{id:id},function (data) {
                    alert(data.msg);
                    if(data.code){
                        return;
                    }else{
                        window.location.href=data.data;
                    }
                },'json')
            }
        });
    })
</script>