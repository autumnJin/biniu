<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=0,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/Public/Wap/css/mui.min.css">
    <link rel="stylesheet" href="/Public/Wap/css/property.css">
    <script src="/Public/Wap/js/1.js"></script>
    <script src="/Public/Wap/js/zepto.min.js"></script>
    <script src="/Public/Wap/js/mui.min.js"></script>
    <title>HPAY</title>
</head>

<body>
<div class="header">
    <h2>HPAY</h2>
    <i><img src="/Public/Home/images/money.png" alt=""></i>
    <span>HPAY资产</span>
    <p><?php echo ((isset($data["z5"]) && ($data["z5"] !== ""))?($data["z5"]): '0.00'); ?></p>
</div>

<div class="price">
    <div>
        <span class="wfx_price"></span>
        <em>当前价格</em>
    </div>
    <div>
        <span><?php echo ($data["z5"]); ?></span>
        <em>当前拥有</em>
    </div>
</div>

<div style="margin-bottom:80px;overflow:hidden">
    <!--<div class="wfx">-->
        <!--<img src="/Public/Home/images/WFX.png" alt="">-->
        <!--<a href="<?php echo U('Property/wfxrecord');?>" class="aa">HPAY</a>-->
        <!--<p><span></span> CNY</p>-->
        <!--<em><span></span> CNY</em>-->
        <!--<i><?php echo ((isset($data["z5"]) && ($data["z5"] !== ""))?($data["z5"]):'0.00'); ?></i>-->
    <!--</div>-->
    <div class="wfx">
        <img src="https://cdn.mytoken.org/Fh8zKdAhi7svn4O389-iNg4JLOPQ" alt="">
        <a href="<?php echo U('Property/wfxrecord');?>" class="aa">IOTE</a>
        <p><span></span> CNY</p>
        <em><span></span> CNY</em>
        <i><?php echo ((isset($data["z5"]) && ($data["z5"] !== ""))?($data["z5"]):'0.00'); ?></i>
    </div>
    <div class="btc">
        <img src="/Public/Home/images/BTC.png" alt="">
        <a href="<?php echo U('Property/btcrecord');?>" class="aa">BTC</a>
        <p><span></span> CNY</p>
        <em><span></span> CNY</em>
        <i><?php echo ($data["z7"]); ?></i>
    </div>
    <div class="eth">
        <img src="/Public/Home/images/ETH.png" alt="">
        <a href="<?php echo U('Property/ethrecord');?>" class="aa">ETH</a>
        <p><span></span> CNY</p>
        <em><span></span> CNY</em>
        <i><?php echo ($data["z9"]); ?></i>
    </div>
    <!--<div class="ltc">-->
        <!--<img src="/Public/Home/images/LTC.png" alt="">-->
        <!--<a href="<?php echo U('Property/ltcrecord');?>" class="aa">LTC</a>-->
        <!--<p><span></span> CNY</p>-->
        <!--<em><span></span> CNY</em>-->
        <!--<i>0.00</i>-->
    <!--</div>-->
    <div class="usdtx">
        <img src="https://s1.bqiapp.com/coin/20181030_72_webp/tether_200_200.webp" alt="">
        <a href="<?php echo U('Property/usdtrecord');?>" class="aa">USDT</a>
        <p><span></span> CNY</p>
        <em><span></span> CNY</em>
        <i><?php echo ($data["z8"]); ?></i>
    </div>
</div>
<style>
    .usdtx{
        width: 90%;
        height: 1.4rem;
        line-height: 0.5rem;
        border-bottom: 1px solid #eeeeee;
        border-radius: 0.2rem;
        position: relative;
        background-color: #fff;
        margin: 0 auto;
        margin-top: 0.2rem;
        padding-top: 0.2rem;
        box-sizing: border-box;
    }
    body .usdtx img{
        position: absolute;
        top: 0.3rem;
        left: 0.3rem;
        width: 0.8rem;
        height: 0.8rem;
    }
    body .usdtx a{
        text-decoration: none;
        font-size: 0.28rem;
        color: #222222;
        display: block;
        margin-left: 1.2rem;
    }
    body .usdtx p{
        margin: 0;
        color: #8a8d90;
        font-size: 0.22rem;
        margin-left: 1.2rem;
        display: inline-block;
    }
    body .usdtx em{
        font-size: 0.22rem;
        float: right;
        font-style: normal;
        display: inline-block;
        margin-right: 0.3rem;
        color: #8a8d90;
    }
    body .usdtx i{
        font-style: normal;
        font-size: 0.27rem;
        float: right;
        color: #222222;
        position: absolute;
        top: 0.2rem;
        right: 0.35rem;
    }
</style>
<nav class="mui-bar mui-bar-tab">
    <a class="mui-tab-item mui-active" href="<?php echo U('Property/index');?>">
        <img src="/Public/Home/images/zc2.png" alt="">
        <span class="mui-tab-label">资产</span>
    </a>
    <a class="mui-tab-item " href="<?php echo U('Hangqing/index');?>">
        <img src="/Public/Home/images/hq1.png" alt="">
        <span class="mui-tab-label">行情</span>
    </a>
    <a class="mui-tab-item" href="<?php echo U('Duihuan/index');?>">
        <img src="/Public/Home/images/sd1.png" alt="">
        <span class="mui-tab-label">闪兑</span>
    </a>
    <a class="mui-tab-item" href="<?php echo U('Discover/index');?>">
        <img src="/Public/Home/images/fx1.png" alt="">
        <span class="mui-tab-label">发现</span>
    </a>
    <a class="mui-tab-item" href="<?php echo U('User/index');?>">
        <img src="/Public/Home/images/my1.png" alt="">
        <span class="mui-tab-label">我的</span>
    </a>

</nav>

<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>

<script>
    mui('body').on('tap', 'a', function () { document.location.href = this.href; });
    $('.aa').click(function(){
        alert('功能暂未开放');
        return false;
    });


    ajax_get();
    setInterval(function(){
        ajax_get()
    }, 60000);

    function ajax_get(){
        $.ajax({
            type:"post",
            url:"<?php echo U('Property/price2');?>",
            data:{
                // type:'BTC',
            },
            dataType:"json",
            success:function(data){
                console.log(data);
                if(data){
                    $(".wfx_price").text(parseFloat((data.wfx.close)*6.74).toFixed(4));
                    $('.wfx>p>span').text(parseFloat((data.wfx.close)*6.74).toFixed(4));
                    $('.wfx>em>span').text((parseFloat((data.wfx.close)*6.74)*<?php echo ($data["z5"]); ?>).toFixed(2));

                    $(".btc>p>span").text(parseFloat(data.btc.close).toFixed(2));
                    $(".btc>em>span").text((parseFloat(data.btc.close)*<?php echo ($data["z7"]); ?>).toFixed(2));

                    $(".eth>p>span").text(parseFloat(data.eth.close).toFixed(2));
                    $(".eth>em>span").text((parseFloat(data.eth.close)*<?php echo ($data["z9"]); ?>).toFixed(2));


                    // $(".ltc>p>span").text(parseFloat(data.ltc.close).toFixed(2));
                    // $(".ltc>em>span").text((parseFloat(data.ltc.close)*<?php echo ($data["z10"]); ?>).toFixed(2));


                }else{
                    alert(data.msg);
                    // window.location.href=data.data;
                }
            }
        });

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
                    $('.usdtx>p>span').text(parseFloat(res.rate).toFixed(2));
                    $('.usdtx>em>span').text((parseFloat(res.rate)*<?php echo ($data["z8"]); ?>).toFixed(2));

                }else{
                    alert(res.msg);
                }
            }
        });
    }
</script>


</body>

</html>