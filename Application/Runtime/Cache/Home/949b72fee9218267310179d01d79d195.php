<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=0,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/Public/Wap/css/wfxrecord.css">
    <link rel="stylesheet" href="/Public/Wap/css/btcrecord.css">
    <link rel="stylesheet" href="/Public/Wap/css/ltcrecord.css">
    <link rel="stylesheet" href="/Public/Wap/css/ethrecord.css">
    <script src="/Public/Wap/js/1.js"></script>
</head>


<body>
<div class="header">
    <a href="javascript:history.back(-1)"><img src="/Public/Home/images/Return.png" alt=""></a>
    <i>WFX</i>
    <span><?php echo ($wfx["z5"]); ?></span>
    <p class="wfx_money">0.00</p>
</div>
<div class="title">
    <div>全部</div>
    <div>转入</div>
    <div>转出</div>
</div>
<ul>
    <?php if(is_array($wfxrecord)): $i = 0; $__LIST__ = $wfxrecord;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
            <img src="/Public/Home/images/sd2.png" alt="">
            <span><?php echo ($vo["tips"]); ?></span>
            <?php if($vo["flag"] == '+'): ?><p>增加</p>
                <?php else: ?>
                <p>减少</p><?php endif; ?>
            <em><?php echo (date('Y-m-d H:i:s',$vo["create_time"])); ?></em>
            <i><?php echo ($vo["amount"]); ?></i>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
    <!--<li>-->
        <!--<img src="/Public/Home/images/sd2.png" alt="">-->
        <!--<span>兑换扣款</span>-->
        <!--<p>[WFX-减少]</p>-->
        <!--<em>2019-04-10</em>-->
        <!--<i>100.00000</i>-->
    <!--</li>-->
    <!--<li>-->
        <!--<img src="/Public/Home/images/sd2.png" alt="">-->
        <!--<span>兑换扣款</span>-->
        <!--<p>[WFX-减少]</p>-->
        <!--<em>2019-04-10</em>-->
        <!--<i>100.00000</i>-->
    <!--</li>-->
    <!--<li>-->
        <!--<img src="/Public/Home/images/sd2.png" alt="">-->
        <!--<span>兑换扣款</span>-->
        <!--<p>[WFX-减少]</p>-->
        <!--<em>2019-04-10</em>-->
        <!--<i>100.00000</i>-->
    <!--</li>-->
    <!--<li>-->
        <!--<img src="/Public/Home/images/sd2.png" alt="">-->
        <!--<span>兑换扣款</span>-->
        <!--<p>[WFX-减少]</p>-->
        <!--<em>2019-04-10</em>-->
        <!--<i>100.00000</i>-->
    <!--</li>-->
    <!--<li>-->
        <!--<img src="/Public/Home/images/sd2.png" alt="">-->
        <!--<span>兑换扣款</span>-->
        <!--<p>[WFX-减少]</p>-->
        <!--<em>2019-04-10</em>-->
        <!--<i>100.00000</i>-->
    <!--</li>-->
</ul>
</body>
<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script>

    ajax_get();
    setInterval(function(){
        ajax_get()
    }, 10000);

    function ajax_get() {
        $.ajax({
            type:"post",
            url:"<?php echo U('price2');?>",
            data:{
            },
            dataType:"json",
            success:function(data){

                // console.log(data);
                if(data){
                    $('.wfx_money').text("≈￥"+(parseFloat(data.wfx.data[0].price)*<?php echo ($wfx["z5"]); ?>).toFixed(2));
                }else{
                    alert(data.msg);
                    // window.location.href=data.data;
                }
            }
        });
    }
</script>
</html>