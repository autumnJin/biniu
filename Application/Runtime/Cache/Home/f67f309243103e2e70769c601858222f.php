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

</head>
<!--11-->
<body>
<div class="header">发现应用</div>


<div class="banner" style="overflow:hidden;">
    <div class="swiper-container" id="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="/Public/Home/images/banner_1.png" alt=""></div>
            <div class="swiper-slide"><img src="/Public/Home/images/banner_2.png" alt=""></div>
            <div class="swiper-slide"><img src="/Public/Home/images/banner_3.png" alt=""></div>
            <div class="swiper-slide"><img src="/Public/Home/images/banner_5.png" alt=""></div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>


<div class="hot">
    <div class="title">热门应用</div>
    <div class="content">
        <div>
            <a href="<?php echo U('Discover/machine');?>">
                <img src="/Public/Home/images/Ore.png" alt="">
                <p>云矿池</p>
            </a>
        </div>
        <div>
            <a href="<?php echo U('Goods/GoodsLists');?>">
                <img src="/Public/Home/images/sm.png" alt="">
                <p>商城</p>
            </a>
        </div>
        <div>
            <a href="<?php echo U('Discover/myMachine');?>">
                <img src="/Public/Home/images/mining.png" alt="">
                <p>挖矿</p>
            </a>
        </div>
    </div>
</div>
<div class="circle">
    <div class="title">生态圈</div>
    <div class="content">
        <div class="aa">
            <img src="/Public/Home/images/cf.png" alt="">
            <p>众筹</p>
        </div>
        <div class="aa">
            <img src="/Public/Home/images/candy.png" alt="">
            <p>糖果</p>
        </div>
        <div class="aa">
            <img src="/Public/Home/images/re.png" alt="">
            <p>地产</p>
        </div>
        <div>
          <a href="https://b1.run">
            <img src="/Public/Home/images/exchange.png" alt="">
            <p>bigone</p>
          </a>
        </div>
        <div class="aa">
            <img src="/Public/Home/images/To loan.png" alt="">
            <p>借贷</p>
        </div>
        <div class="aa">
            <img src="/Public/Home/images/gc.png" alt="">
            <p>竞猜</p>
        </div>
    </div>
</div>



<nav class="mui-bar mui-bar-tab">
    <a class="mui-tab-item " href="<?php echo U('Property/index');?>">
        <img src="/Public/Home/images/zc1.png" alt="">
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
    <a class="mui-tab-item mui-active" href="<?php echo U('Discover/index');?>">
        <img src="/Public/Home/images/fx2.png" alt="">
        <span class="mui-tab-label">发现</span>
    </a>
    <a class="mui-tab-item" href="<?php echo U('User/index');?>">
        <img src="/Public/Home/images/my1.png" alt="">
        <span class="mui-tab-label">我的</span>
    </a>

</nav>
<link href="https://cdn.bootcss.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/Swiper/4.5.0/js/swiper.min.js"></script>
<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    // var swiper = new Swiper('#swiper');
    mui('body').on('tap', 'a', function () { document.location.href = this.href; });
        $('.aa').click(function(){
            alert('功能暂未开放');
        });
    var swiper = new Swiper('.swiper-container',{
        autoplay: true,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
        },
    });
</script>

</body>

</html>