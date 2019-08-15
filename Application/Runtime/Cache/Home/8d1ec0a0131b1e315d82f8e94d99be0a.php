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
    <i>USDT</i>
    <span><?php echo ($usdt["z8"]); ?></span>
    <p class="usdt_price"></p>
</div>
<div class="title">
    <div>全部</div>
    <div>转入</div>
    <div>转出</div>
</div>
<ul>
    <li>
        <img src="/Public/Home/images/sd2.png" alt="">
        <span>兑换扣款</span>
        <p>[WFX-减少]</p>
        <em>2019-04-10</em>
        <i>100.00000</i>
    </li>
    <li>
        <img src="/Public/Home/images/sd2.png" alt="">
        <span>兑换扣款</span>
        <p>[WFX-减少]</p>
        <em>2019-04-10</em>
        <i>100.00000</i>
    </li>
    <li>
        <img src="/Public/Home/images/sd2.png" alt="">
        <span>兑换扣款</span>
        <p>[WFX-减少]</p>
        <em>2019-04-10</em>
        <i>100.00000</i>
    </li>
    <li>
        <img src="/Public/Home/images/sd2.png" alt="">
        <span>兑换扣款</span>
        <p>[WFX-减少]</p>
        <em>2019-04-10</em>
        <i>100.00000</i>
    </li>
    <li>
        <img src="/Public/Home/images/sd2.png" alt="">
        <span>兑换扣款</span>
        <p>[WFX-减少]</p>
        <em>2019-04-10</em>
        <i>100.00000</i>
    </li>
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
            url:"<?php echo U('Hangqing/api');?>",
            data:{
            },
            dataType:"json",
            success:function(res){
                // console.log(res.change);
                //console.log(res.price);
                if(res){
                    $('.usdt_price').text("≈￥"+(parseFloat(res.rate)*<?php echo ($usdt["z8"]); ?>).toFixed(2));
                    // $('.usdt').text((parseFloat(res.rate)*<?php echo ($data["z8"]); ?>).toFixed(2));
                    // $('#iii').text(parseFloat(res.rate).toFixed(4));
                    //
                    // $('#iii').parent().find('button').text(res.change+'%');
                    // if(res.change < 0){
                    //     $("#iii").parent().find('button').addClass('reduce');
                    // }else{
                    //     $('#iii').parent().find('button').text('+'+res.change+'%');
                    // }
                }else{
                    alert(res.msg);
                }
            }
        });
    }
</script>
</html>