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
    <span>钱包资产</span>
    <p><?php echo ((isset($data["z5"]) && ($data["z5"] !== ""))?($data["z5"]): '0.00'); ?></p>
</div>

<div class="price">
    <div>
        <span><?php echo ($data1["hapy"]); ?></span>
        <em>当前价格</em>
    </div>
    <div>
        <span><?php echo ($data["z5"]); ?></span>
        <em>当前拥有</em>
    </div>
</div>

<div style="margin-bottom:80px;overflow:hidden">
    <div class="wfx">
        <img src="/Public/Home/images/WFX.png" alt="">
        <a href="<?php echo U('Property/wfxrecord');?>" class="aa">WFX</a>
        <p><span></span> CNY</p>
        <em><span></span> CNY</em>
        <i><?php echo ((isset($data["z5"]) && ($data["z5"] !== ""))?($data["z5"]):'0.00'); ?></i>
    </div>
    <div class="btc">
        <img src="/Public/Home/images/BTC.png" alt="">
        <a href="<?php echo U('Property/btcrecord');?>" class="aa">BTC</a>
        <p><span class="btc1_price"></span> CNY</p>
        <em><span class="btc1"></span> CNY</em>
        <i><?php echo ($data["z7"]); ?></i>
    </div>
    <div class="eth">
        <img src="/Public/Home/images/ETH.png" alt="">
        <a href="<?php echo U('Property/ethrecord');?>" class="aa">ETH</a>
        <p><span></span> CNY</p>
        <em><span></span> CNY</em>
        <i><?php echo ($data["z9"]); ?></i>
    </div>
    <div class="ltc">
        <img src="/Public/Home/images/LTC.png" alt="">
        <a href="<?php echo U('Property/ltcrecord');?>" class="aa">LTC</a>
        <p><span></span> CNY</p>
        <em><span></span> CNY</em>
        <i>0.00</i>
    </div>
  	 <div class="usdtx">
        <img src="https://s1.bqiapp.com/coin/20181030_72_webp/tether_200_200.webp" alt="">
        <a href="<?php echo U('Property/usdtrecord');?>" class="aa">USDT</a>
        <p><span class="usdt_price"></span> CNY</p>
        <em><span class="usdt"></span> CNY</em>
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
        $('.wfx>p>span').text(<?php echo ($data1["hapy"]); ?>);
        $('.wfx>em>span').text((<?php echo ($data["z5"]); ?>*<?php echo ($data1["hapy"]); ?>).toFixed(2));
        $.ajax({
            type:"post",
            url:"<?php echo U('price');?>",
            data:{
                type:'BTC',
            },
            dataType:"json",
            success:function(data){
                // console.log(data);
                if(data){
                    // alert(data.btc.close);
                    $(".btc1_price").text(parseFloat(data.close).toFixed(2));
                    $(".btc1").text((parseFloat(data.close)*<?php echo ($data["z7"]); ?>).toFixed(2));
                    // $('.eth>p>span').text((parseFloat(data.eth.close)*<?php echo ($data["z9"]); ?>).toFixed(2));
                    // $('.eth>em>span').text((parseFloat(data.eth.close)*<?php echo ($data["z9"]); ?>).toFixed(2));
                    //
                    // $('.ltc>p>span').text((parseFloat(data.ltc.close)*<?php echo ($data["z9"]); ?>).toFixed(2));
                    // $('.ltc>em>span').text((parseFloat(data.ltc.close)*<?php echo ($data["z9"]); ?>).toFixed(2));
                    //
                    // $('.btc1').text((parseFloat(data.btc.close)*<?php echo ($data["z7"]); ?>).toFixed(2));
                    // $('.btc>em>span').text((parseFloat(data.btc.close)*<?php echo ($data["z7"]); ?>).toFixed(2));
                    // $('.btc>em>span').text((parseFloat(data.btc.close)*<?php echo ($data["z7"]); ?>).toFixed(2));
                    // $('#aaa').text((parseFloat(data.btc.close)*6.74).toFixed(4));
                    // var btc1 = ((data.btc.close - data.btc.open)/data.btc.open)*100;
                    // $('#aaa').parent().find('button').text(btc1.toFixed(2)+'%');
                    // if(btc1 < 0){
                    //     $("#aaa").parent().find('button').addClass('reduce');
                    // }else{
                    //     $('#aaa').parent().find('button').text('+'+btc1.toFixed(2)+'%');
                    // }
                    //
                    // $('#bbb').text((parseFloat(data.eth.close)*6.74).toFixed(4));
                    // var eth1 = ((data.eth.close - data.eth.open)/data.eth.open)*100;
                    // $('#bbb').parent().find('button').text(eth1.toFixed(2)+'%');
                    // if(eth1 < 0){
                    //     $("#bbb").parent().find('button').addClass('reduce')
                    // }else{
                    //     $('#bbb').parent().find('button').text('+'+eth1.toFixed(2)+'%');
                    // }
                    //
                    // $('#ccc').text((parseFloat(data.ltc.close)*6.74).toFixed(4));
                    // var ltc1 = ((data.ltc.close - data.ltc.open)/data.ltc.open)*100;
                    // $('#ccc').parent().find('button').text(ltc1.toFixed(2)+'%');
                    // if(ltc1 < 0){
                    //     $("#ccc").parent().find('button').addClass('reduce');
                    // }else{
                    //     $('#ccc').parent().find('button').text('+'+ltc1.toFixed(2)+'%');
                    // }
                    //
                    // $('#ddd').text((parseFloat(data.omg.close)*6.74).toFixed(4));
                    // var omg1 = ((data.omg.close - data.omg.open)/data.omg.open)*100;
                    // $('#ddd').parent().find('button').text(omg1.toFixed(2)+'%');
                    // if(omg1 < 0){
                    //     $("#ddd").parent().find('button').addClass('reduce');
                    // }else{
                    //     $('#ddd').parent().find('button').text('+'+omg1.toFixed(2)+'%');
                    // }
                    //
                    // $('#eee').text((parseFloat(data.xrp.close)*6.74).toFixed(4));
                    // var xrp1 = ((data.xrp.close - data.xrp.open)/data.xrp.open)*100;
                    // $('#eee').parent().find('button').text(xrp1.toFixed(2)+'%');
                    // if(xrp1 < 0){
                    //     $("#eee").parent().find('button').addClass('reduce');
                    // }else{
                    //     $('#eee').parent().find('button').text('+'+xrp1.toFixed(2)+'%');
                    // }
                    //
                    // $('#fff').text((parseFloat(data.bch.close)*6.74).toFixed(4));
                    // var bch1 = ((data.bch.close - data.bch.open)/data.bch.open)*100;
                    // $('#fff').parent().find('button').text(bch1.toFixed(2)+'%');
                    // if(bch1 < 0){
                    //     $("#fff").parent().find('button').addClass('reduce');
                    // }else{
                    //     $('#fff').parent().find('button').text('+'+bch1.toFixed(2)+'%');
                    // }
                    //
                    // $('#ggg').text((parseFloat(data.eos.close)*6.74).toFixed(4));
                    // var eos1 = ((data.eos.close - data.eos.open)/data.eos.open)*100;
                    // $('#ggg').parent().find('button').text(eos1.toFixed(2)+'%');
                    // if(eos1 < 0){
                    //     $("#ggg").parent().find('button').addClass('reduce');
                    // }else{
                    //     $('#ggg').parent().find('button').text('+'+eos1.toFixed(2)+'%');
                    // }
                    //
                    // $('#hhh').text((parseFloat(data.etc.close)*6.74).toFixed(4));
                    // var etc1 = ((data.etc.close - data.etc.open)/data.etc.open)*100;
                    // $('#hhh').parent().find('button').text(etc1.toFixed(2)+'%');
                    // if(etc1 < 0){
                    //     $("#hhh").parent().find('button').addClass('reduce');
                    // }else{
                    //     $('#hhh').parent().find('button').text('+'+etc1.toFixed(2)+'%');
                    // }

                }else{
                    alert(data.msg);
                    // window.location.href=data.data;
                }
            }
        });
        $.ajax({
            type:"post",
            url:"<?php echo U('price');?>",
            data:{
                type:'ETH',
            },
            dataType:"json",
            success:function(data){
                // console.log(data);
                if(data){
                    // alert(data.btc.close);
                    $(".eth>p>span").text(parseFloat(data.close).toFixed(2));
                    $(".eth>em>span").text((parseFloat(data.close)*<?php echo ($data["z9"]); ?>).toFixed(2));

                }else{
                    alert(data.msg);
                    // window.location.href=data.data;
                }
            }
        });
        $.ajax({
            type:"post",
            url:"<?php echo U('price');?>",
            data:{
                type:'LTC',
            },
            dataType:"json",
            success:function(data){
                // console.log(data);
                if(data){
                    // alert(data.btc.close);
                    $(".ltc>p>span").text(parseFloat(data.close).toFixed(2));
                    $(".ltc>em>span").text((parseFloat(data.close)*<?php echo ($data["z10"]); ?>).toFixed(2));

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
                    $('.usdt_price').text(parseFloat(res.rate).toFixed(2));
                    $('.usdt').text((parseFloat(res.rate)*<?php echo ($data["z8"]); ?>).toFixed(2));
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


</body>

</html>