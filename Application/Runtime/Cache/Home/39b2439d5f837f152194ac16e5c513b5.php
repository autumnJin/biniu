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
#order .contents {
    margin-bottom: 0;
}
.page li,.page a {
    display: inline;
    font-size: .35rem;
    text-align: right;
    color: #333;
}
.page {
    text-align: right;
    margin-right: .2rem;
}
.truePay {
    color: red;}
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
#order .contents .box .top .txt{
    width: 2rem;
}
.container{
    width: 100%;
    padding: .2rem;        font-size: 14px;

}
    #order .navs ul li a{
        font-size: 14px;
    }
</style>
<div id="order">
    <header class="header">
        <a href="<?php echo U('User/index');?>"><img src="/Public/Wap/img/arrowl.png"></a>
        <div>我的订单</div>
        <a href="javascript:void(0)" style="opacity: 0"><img src="/Public/Wap/img/arrowl.png"></a>
    </header>
    <div class="navs">
        <ul class="nowPosition">
            <li data-status="0"><a href="<?php echo U('orderlist',array('status'=>0));?>">全部</a></li>
            <li data-status="1"><a href="<?php echo U('orderlist',array('status'=>1));?>">待付款</a></li>
            <li data-status="2"><a href="<?php echo U('orderlist',array('status'=>2));?>">待发货</a></li>
            <li data-status="5"><a href="<?php echo U('orderlist',array('status'=>5));?>">待收货</a></li>
        </ul>
    </div>
    <?php $format = C('format'); ?>
    <div class="contents">
        <?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="box">
        <?php if($vo['is_sub'] == 2): if(is_array($vo["children"])): $i = 0; $__LIST__ = $vo["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><div class="top">
            <div class="container">
                <a href="<?php echo U('orderShow',array('order_id'=>$vo['order_id']));?>">
                <div class="pic">
                    <img src="<?php echo ($vv["path"]); ?>">
                </div>
                <div class="txt">
                    <div class="p1"><?php echo ($vv["name"]); ?></div>
                    <div class="p3">￥<?php echo ($vv["price"]); ?></div>
                </div>
                <div class="del">
                    <?php if($vo['status'] == 1){ $s = '待付款'; }else if($vo['status'] == 2 && $vo['wuliu_status'] !=5 && $vo['wuliu_status'] !=6){ $s = '待发货'; }else if($vo['wuliu_status'] == 5){ $s = '待收货'; }else if($vo['wuliu_status'] == 6){ $s = '已收货'; }else{} ?>
                    <div class="p1"><?php echo ($s); ?></div>
                    <div class="p3"><?php echo ($vv["num"]); ?>：x1</div>
                </div>
                </a>
            </div>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php else: ?>
        <div class="top">
            <div class="container">
                <a href="<?php echo U('orderShow',array('order_id'=>$vo['order_id']));?>">
                    <div class="pic">
                        <img src="<?php echo ($vo["path"]); ?>">
                    </div>
                    <div class="txt">
                        <div class="p1"><?php echo ($vo["name"]); ?></div>
                        <div class="p3">￥<?php echo ($vo["price"]); ?></div>
                    </div>
                    <div class="del">
                        <?php if($vo['status'] == 1){ $s = '待付款'; }else if($vo['status'] == 2 && $vo['wuliu_status'] !=5 && $vo['wuliu_status'] !=6){ $s = '待发货'; }else if($vo['wuliu_status'] == 5){ $s = '待收货'; }else if($vo['wuliu_status'] == 6){ $s = '已收货'; }else{} ?>
                        <div class="p1"><?php echo ($s); ?></div>
                        <div class="p3"><?php echo ($vv["num"]); ?>：x1</div>
                    </div>
                </a>
            </div>
        </div><?php endif; ?>
            <div class="down">
                <div class="container">
                    <div style="float: left;color: #333;font-size: .26rem;line-height: .6rem;width: 100%">合计：IOTE<?php echo ($vo["amount"]); ?><span class="truePay"> / 实付：<?php echo ($vo["pay_amount"]); ?></span></div>
                    <?php if($vo['status'] == 1): ?><div class="left" style="width: 30%;float: left;text-align: center;padding: .15rem;color: #FF0000">
                            <strong class="minute_show" style="font-size: 16px">0分</strong>
                            <strong class="second_show" style="font-size: 16px">0秒</strong>
                            <input type="text" class="timeaa" value="<?php echo ($vo["over_time"]); ?>" style="display: none;">
                        </div><?php endif; ?>
                    <div class="right">
                        <?php if($vo['status'] == 1): ?><a href="<?php echo U('Goods/Pay',array('order_id'=>$vo['order_id']));?>">去付款</a>
                            <a class="del" id='del' o_id="<?php echo ($vo['id']); ?>" href="#">取消订单</a><?php endif; ?>
                        <?php if($vo['wuliu_status'] == 5): ?><a href="http://m.kuaidi100.com/result.jsp?nu=<?php echo ($vo['wuliu']); ?>">物流信息</a>
                            <a class="recevice" o_id="<?php echo ($vo['id']); ?>" href="#">确认收货</a><?php endif; ?>
                    </div>
                </div>
            </div>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>

</div>
<script>
    $(function () {
      
        //当前位置
        $('.nowPosition li').each(function(){
            if($(this).attr('data-status') == '<?php echo ($status); ?>')
            {
                $(this).addClass('active');
            }
        });
      
        $('#del').click(function () {
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

<script type="text/javascript">
    let arrtime = []
    $(".left").each(function(index) {
        arrtime.push($(".left").eq(index).find(".timeaa").val())
    })

    for (let i = 0; i < arrtime.length; i++) {
        let obj = $(".left").eq(i)
        var intDiff = parseInt(arrtime[i]);//倒计时总秒数量
        timer(obj, intDiff);
    }
    function timer(obj, intDiff){
        console.log(obj)
        window.setInterval(function(){
            var day=0,
                hour=0,
                minute=0,
                second=0;//时间默认值
            if(intDiff > 0){
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            obj.find('.day_show').html(day+"天");
            obj.find('.hour_show').html('<s id="h"></s>'+hour+'时');
            obj.find('.minute_show').html('<s></s>'+minute+'分');
            obj.find('.second_show').html('<s></s>'+second+'秒');
            // $('#day_show').html(day+"天");
            // $('#hour_show').html('<s id="h"></s>'+hour+'时');
            // $('#minute_show').html('<s></s>'+minute+'分');
            // $('#second_show').html('<s></s>'+second+'秒');
            intDiff--;
        }, 1000);
    }
    $(function(){
    });
</script>