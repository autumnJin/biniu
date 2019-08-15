<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/Public/Wap/css/mui.min.css">
    <link rel="stylesheet" href="/Public/Wap/css/market.css">
    <script src="/Public/Wap/js/zepto.min.js"></script>
    <script src="/Public/Wap/js/mui.min.js"></script>
    <script src="/Public/Wap/js/1.js"></script>
    <title>HPAY</title>
</head>

<body>

<div class="header">行情</div>
<div class="title">
    <div>名称</div>
    <div>实时价</div>
    <div>涨跌幅</div>
</div>
<ul>

    <li>
        <div>
            <!--<img src="/Public/Home/images/WFX.png" alt="">-->
            <img src="https://cdn.mytoken.org/Fh8zKdAhi7svn4O389-iNg4JLOPQ" alt="">
            <span>IOTE</span>
        </div>
        <div class="wfx_price">503.21</div>
        <div>
            <button>+33.00%</button>
            <!--<?php if($RewardConfig["hapyfloat"] >= 0): ?>-->
            <!--<button>+<?php echo ($RewardConfig["hapyfloat"]); ?>%</button>-->
                <!--<?php else: ?>-->
                <!--<button style="background: red"><?php echo ($RewardConfig["hapyfloat"]); ?>%</button>-->
            <!--<?php endif; ?>-->

        </div>
    </li>
    <li>
        <div>
            <img src="/Public/Home/images/BTC.png" alt="">
            <span>BTC</span>
        </div>
        <div id="aaa">503.21</div>
        <div>
            <button>+33.00%</button>
        </div>
    </li>
  	 <li>
      <div>
          <img src="https://s1.bqiapp.com/coin/20181030_72_webp/tether_200_200.webp" alt="">
          <span>USDT</span>
      </div>
      <div id="iii">503.21</div>
      <div>
          <button>+33.00%</button>
      </div>
	</li>
    <li>
        <div>
            <img src="/Public/Home/images/ETH.png" alt="">
            <span>ETH</span>
        </div>
        <div id="bbb">503.21</div>
        <div>
            <button>+33.00%</button>
        </div>
    </li>
    <li>
        <div>
            <img src="/Public/Home/images/LTC.png" alt="">
            <span>LTC</span>
        </div>
        <div id="ccc">503.21</div>
        <div>
            <button>+33.00%</button>
        </div>
    </li>
    <li>
        <div>
            <img src="http://coin-web.oss-cn-hangzhou.aliyuncs.com/static/images/coins/OMG.png" alt="">
            <span>OMG</span>
        </div>
        <div id="ddd">503.21</div>
        <div>
            <button>+33.00%</button>
        </div>
    </li>
    <li>
        <div>
            <img src="https://huobi-1253283450.cos.ap-beijing.myqcloud.com/1534608359310_Vp8VUP13FG1FbMQA1R-c.jpg" alt="">
            <span>XRP</span>
        </div>
        <div id="eee">503.21</div>
        <div>
            <button>+33.00%</button>
        </div>
    </li>
    <li>
        <div>
            <img src="http://coin-web.oss-cn-hangzhou.aliyuncs.com/static/images/coins/BCH.png" alt="">
            <span>BCH</span>
        </div>
        <div id="fff">503.21</div>
        <div>
            <button>+33.00%</button>
        </div>
    </li>
    <li>
        <div>
            <img src="http://coin-web.oss-cn-hangzhou.aliyuncs.com/static/images/coins/EOS.png" alt="">
            <span>EOS</span>
        </div>
        <div id="ggg">503.21</div>
        <div>
            <button>+33.00%</button>
        </div>
    </li>
  	<li>
      <div>
          <img src="https://bidong.lianxueqiu.com/picture/logo/Ethereum%20Classic.jpg?x-oss-process=image/resize,w_30" alt="">
          <span>ETC</span>
      </div>
      <div id="hhh">503.21</div>
      <div>
          <button>+33.00%</button>
      </div>
	</li>
</ul>

<nav class="mui-bar mui-bar-tab">
    <a class="mui-tab-item " href="<?php echo U('Property/index');?>">
        <img src="/Public/Home/images/zc1.png" alt="">
        <span class="mui-tab-label">资产</span>
    </a>
    <a class="mui-tab-item mui-active" href="<?php echo U('Hangqing/index');?>">
        <img src="/Public/Home/images/hq2.png" alt="">
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

</body>
<script>
    mui('body').on('tap', 'a', function () { document.location.href = this.href; });

    ajax_get();
    setInterval(function(){
        ajax_get()
    }, 60000);

    function ajax_get(){
        $.ajax({
            type:"post",
            url:"<?php echo U('Demo/index');?>",
            data:{
            },
            dataType:"json",
            success:function(data){
               // console.log(data);
                if(data){
                  
                    $('#aaa').text((parseFloat(data.btc.close)*6.74).toFixed(4));
                    var btc1 = ((data.btc.close - data.btc.open)/data.btc.open)*100;               	
                    $('#aaa').parent().find('button').text(btc1.toFixed(2)+'%');
                    if(btc1 < 0){
                        $("#aaa").parent().find('button').addClass('reduce');
                    }else{
                        $('#aaa').parent().find('button').text('+'+btc1.toFixed(2)+'%');
                    }
                      
                    $('#bbb').text((parseFloat(data.eth.close)*6.74).toFixed(4));
                    var eth1 = ((data.eth.close - data.eth.open)/data.eth.open)*100;
                    $('#bbb').parent().find('button').text(eth1.toFixed(2)+'%');
                    if(eth1 < 0){
                        $("#bbb").parent().find('button').addClass('reduce')
                    }else{
                     	 $('#bbb').parent().find('button').text('+'+eth1.toFixed(2)+'%');
                    }
                  
                    $('#ccc').text((parseFloat(data.ltc.close)*6.74).toFixed(4));
                  	var ltc1 = ((data.ltc.close - data.ltc.open)/data.ltc.open)*100;
                    $('#ccc').parent().find('button').text(ltc1.toFixed(2)+'%');
                    if(ltc1 < 0){
                        $("#ccc").parent().find('button').addClass('reduce');
                    }else{
                      	$('#ccc').parent().find('button').text('+'+ltc1.toFixed(2)+'%');
                    }
                  
                    $('#ddd').text((parseFloat(data.omg.close)*6.74).toFixed(4));
                  	var omg1 = ((data.omg.close - data.omg.open)/data.omg.open)*100;
                    $('#ddd').parent().find('button').text(omg1.toFixed(2)+'%');
                    if(omg1 < 0){
                        $("#ddd").parent().find('button').addClass('reduce');
                    }else{
                     	$('#ddd').parent().find('button').text('+'+omg1.toFixed(2)+'%');   
                    }
                  
                    $('#eee').text((parseFloat(data.xrp.close)*6.74).toFixed(4));
                  	var xrp1 = ((data.xrp.close - data.xrp.open)/data.xrp.open)*100;
                    $('#eee').parent().find('button').text(xrp1.toFixed(2)+'%');
                    if(xrp1 < 0){
                        $("#eee").parent().find('button').addClass('reduce');
                    }else{
                      	$('#eee').parent().find('button').text('+'+xrp1.toFixed(2)+'%');
                    }
                  
                    $('#fff').text((parseFloat(data.bch.close)*6.74).toFixed(4));
                  	var bch1 = ((data.bch.close - data.bch.open)/data.bch.open)*100;
                    $('#fff').parent().find('button').text(bch1.toFixed(2)+'%');
                    if(bch1 < 0){
                        $("#fff").parent().find('button').addClass('reduce');
                    }else{
                    	 $('#fff').parent().find('button').text('+'+bch1.toFixed(2)+'%');
                    }
                  
                    $('#ggg').text((parseFloat(data.eos.close)*6.74).toFixed(4));
                  	var eos1 = ((data.eos.close - data.eos.open)/data.eos.open)*100;
                    $('#ggg').parent().find('button').text(eos1.toFixed(2)+'%');
                    if(eos1 < 0){
                        $("#ggg").parent().find('button').addClass('reduce');
                    }else{
                    	$('#ggg').parent().find('button').text('+'+eos1.toFixed(2)+'%');
                    }
                  
                    $('#hhh').text((parseFloat(data.etc.close)*6.74).toFixed(4));
                  	var etc1 = ((data.etc.close - data.etc.open)/data.etc.open)*100;
                    $('#hhh').parent().find('button').text(etc1.toFixed(2)+'%');
                    if(etc1 < 0){
                        $("#hhh").parent().find('button').addClass('reduce');
                    }else{
                        $('#hhh').parent().find('button').text('+'+etc1.toFixed(2)+'%');
                    }
                  
                }else{
                    alert(data.msg);
                    // window.location.href=data.data;
                }
            }
        });
        $.ajax({
            type:"post",
            url:"<?php echo U('Property/price2');?>",
            data:{
            },
            dataType:"json",
            success:function(res){
                // console.log(res.change);
                //console.log(res.price);
                if(res){
                    $('.wfx_price').text(parseFloat((res.wfx.close)*6.74).toFixed(4));

                    $('.wfx_price').parent().find('button').text(parseFloat(res.wfx.daily_change_perc).toFixed(2)+'%');
                    if(res.wfx.daily_change_perc < 0){
                        $(".wfx_price").parent().find('button').addClass('reduce');
                    }else{
                        $('.wfx_price').parent().find('button').text('+'+parseFloat(res.wfx.daily_change_perc).toFixed(2)+'%');
                    }
                }else{
                    alert(res.msg);
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
                    $('#iii').text(parseFloat(res.rate).toFixed(4));
                   
                    $('#iii').parent().find('button').text(res.change+'%');
                    if(res.change < 0){
                      $("#iii").parent().find('button').addClass('reduce');
                    }else{
                      $('#iii').parent().find('button').text('+'+res.change+'%');
                    }
              }else{
                 alert(res.msg);
              }
            }
        });
    }

</script>
<style>
    body ul li div button.reduce{
        background-color: #ff0000;
    }
</style>
</html>