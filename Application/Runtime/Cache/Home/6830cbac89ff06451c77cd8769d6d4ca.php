<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HPAY</title>
    <link rel="stylesheet" href="/Public/Wap/css/mui.min.css">
    <link rel="stylesheet" href="/Public/Wap/css/discover.css">
    <link rel="stylesheet" href="/Public/Wap/css/me.css">

    <script src="/Public/Wap/js/zepto.min.js"></script>
    <script src="/Public/Wap/js/mui.min.js"></script>
    <script src="/Public/Wap/js/1.js"></script>
    <style>
        html,body{
            height: 100%;
        }
    </style>
</head>


<body>
<div style="height: calc(100% - 50px);overflow-y: scroll;">

<div class="header">
    <h2>我的</h2>
    <img src="/Public/Home/images/candy.png" alt="">
    <div style="display:flex;justify-content:space-around;align-items: center;flex-direction: column;">
        <p style="margin-top:30px"><?php echo ($data["username"]); ?> <span style="display: inline;" id="sign">
            <?php if($sign == 1): ?>已签到
                <?php else: ?>
                 签到<?php endif; ?>

        </span></p>

        <p style="margin-top:10px">
            <!--<a href="<?php echo U('Property/zhuanshou');?>"><span class="ctbtn">充币</span></a>-->
           <span class="ctbtn">充币</span>
            <a href="<?php echo U('Property/zhuanzhang');?>"><span class="ctbtn">提币</span></a>
        </p>

        <!--<p style="margin-top:30px">   <a href="<?php echo U('Property/zhuanshou');?>"><img src="/Public/Home/images/shoukuan.png" alt=""><span>充币</span></a></p>-->
        <!--<p style="margin-top:30px">  <a href="<?php echo U('Property/zhuanzhang');?>"><img src="/Public/Home/images/zhuanzhang.png" alt=""><span>提币</span></a></p>-->

        <!-- <p>钱包地址：<?php echo ($data["payaddress"]); ?></p> -->

        <!--<section class="second">-->
            <!--<span class="gonggao">公告</span>-->
            <!--<div class="p11">-->
                <!--<div class="p1">-->
                    <!--<?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                        <!--<a class="tipList" href="<?php echo U('newsdetail',array('id'=>$vo['id']));?>"><?php echo ($vo['title']); ?></a>-->
                    <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                <!--</div>-->
            <!--</div>-->
        <!--</section>-->
    </div>
</div>
<style>
    body .header p{
        width: 70%;
        line-height: 2;
        margin-left: 0;
        text-align: left;
        margin-left: 30%;
    }
    .header a{
        color: #fff;
        font-size: .18rem;
        height: .5rem;
        align-items: center;
    }
    body .safe, body .user, body .other{
        height: 2.2rem;
    }
    .ctbtn{
        display: inline-block!important;
        width: 1.5rem;
        line-height: 2.5;
        text-align: center;
        margin: 0!important;
        background: #fff;
        color: #468fff!important;
        border-radius: .1rem;
    }
    .ctbtn:first-child{
        margin-right: .4rem!important;
    }
</style>
<!--<div class="price">-->
    <!--<div>-->
        <!--<span><?php echo ($hapy); ?></span>-->
        <!--<em>当前价格</em>-->
    <!--</div>-->
    <!--<div>-->
        <!--<span class="money"><?php echo ($data["z5"]); ?></span>-->
        <!--<em>当前拥有</em>-->
    <!--</div>-->
<!--</div>-->
    <div style="display: flex;justify-content: space-between;align-items: center;width: 95%;margin: 0 auto;">
        <span class="gonggao" style="flex-shrink: 0;font-size: .22rem;background-color:#f0ad4e;color: white;border-radius: 8px;padding: 0 .1rem;">公告</span>
        <marquee class="scroll" behavior="" direction="left" scrollamount="2">
            <?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a class="tipList" href="<?php echo U('notice',array('id'=>$vo['id']));?>" style="color: #333;font-size: .24rem"><?php echo ($vo['title']); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </marquee>
    </div>


    <div class="safe">
    <div class="title">
        <img src="/Public/Home/images/Safety C.png" alt>
        <span>安全</span>
    </div>
    <div class="content">
        <div>
            <img src="/Public/Home/images/cp.png" alt="">
            <a href="<?php echo U('User/save_password');?>">修改密码</a>
        </div>
        <div><img src="/Public/Home/images/sc.png" alt="">
            <a href="<?php echo U('User/user_info');?>">安全认证</a>
        </div>

    </div>
</div>
<!--<div class="user" style="height: 2.2rem;">-->
<div class="user" style="height: 2.8rem">
    <div class="title">
        <img src="/Public/Home/images/money.png" alt>
        <span>账户</span>
    </div>
    <div class="content">
        <!-- <div>
            <img src="/Public/Home/images/ta.png" alt="">
            <a href="<?php echo U('User/recharge1');?>">充值</a>
        </div> -->
        <!--<div>-->
            <!--<img src="/Public/Home/images/ta.png" alt="">-->
            <!--<a href="<?php echo U('User/rechargeWfx');?>">购买WFX</a>-->
        <!--</div>-->
        <div class="aa">
            <img src="/Public/Home/images/ta.png" alt="">
            <a href="<?php echo U('Property/qianbao');?>">充提币记录</a>
        </div>
        <div class="aa">
            <img src="/Public/Home/images/Profit.png" alt="">
            <a href="<?php echo U('User/earnings');?>">矿池奖金收益</a>
        </div>
        <div class="aa" style="border-right: 1px solid #ececec;">
            <img src="/Public/Home/images/cf.png" alt="">
            <a href="<?php echo U('User/tuijianlist');?>">我的团队</a>
        </div>

        <div>
            <img src="/Public/Home/images/sc.png" alt="">
            <a href="<?php echo U('User/address');?>">个人资料</a>
        </div>

        <div>
            <img src="/Public/Home/images/sc.png" alt="">
            <a href="<?php echo U('User/transfer');?>">会员转账</a>
        </div>
        <div>
            <img src="/Public/Home/images/ta.png" alt="">
            <a href="<?php echo U('User/transferlist');?>">转账明细</a>
        </div>
        <!--<div class="aa">-->
            <!--<img src="/Public/Home/images/Profit.png" alt="">-->
            <!--<a href="<?php echo U('Otc/exchange');?>">买卖交易</a>-->
        <!--</div>-->

    </div>
</div>
<style>
    body .user .content div a{
        margin-left: .8rem;
    }
</style>
    <div class="other">
        <div class="title">
            <img src="/Public/Home/images/fx2.png" alt>
            <span>我的订单</span>
        </div>
        <div class="content">
            <div  class="aa">
                <img src="/Public/Home/images/iconfont-evaluate.png" alt="">
                <a href="<?php echo U('orderlist',array('status'=>1));?>">待付款</a>
            </div>
            <div  class="aa">
                <img src="/Public/Home/images/iconfont-good.png" alt="">
                <a href="<?php echo U('orderlist',array('status'=>2));?>">待发货</a>
            </div>

            <div  class="aa" style="border-right: 1px solid #ececec;">
                <img src="/Public/Home/images/iconfont-middle.png" alt="">
                <a href="<?php echo U('orderlist',array('status'=>5));?>">待收货</a>
            </div>
            <div  class="aa">
                <img src="/Public/Home/images/iconfont-badon.png" alt="">
                <a href="<?php echo U('orderlist',array('status'=>0));?>">全部订单</a>
            </div>
            <!--<div class="aa">-->
            <!--<img src="/Public/Home/images/Profit.png" alt="">-->
            <!--<a href="<?php echo U('User/exchange');?>">算力钱包</a>-->
            <!--</div>-->
        </div>
    </div>
<div class="other">
    <div class="title">
        <img src="/Public/Home/images/Other.png" alt>
        <span>其他</span>
    </div>
    <div class="content">
        <div  class="aa">
            <img src="/Public/Home/images/Extension.png" alt="">
            <a href="<?php echo U('User/qrcode');?>">分享推广</a>
        </div>
        <div  class="aa">
            <img src="/Public/Home/images/Notice.png" alt="">
            <a href="<?php echo U('User/news2');?>">通知公告</a>
        </div>
        <!--<div class="aa">-->
            <!--<img src="/Public/Home/images/Profit.png" alt="">-->
            <!--<a href="<?php echo U('User/exchange');?>">算力钱包</a>-->
        <!--</div>-->
    </div>
</div>
<input type="hidden" class="user_id" value="<?php echo ($data["id"]); ?>"/>
<input type="hidden" class="ptr62" value="<?php echo ($config["ptr62"]); ?>"/>
<div class="logout">
    退出登录
</div>

</div>
<style>
    .logout{
        width: 60%;
        height: 0.8rem;
        line-height: .8rem;
        border: 0;
        outline: 0;
        background-color: #468fff;
        margin-top: 0.5rem;
        margin-left: 20%;
        color: #fff;
        font-size: 0.25rem;
        border-radius: 0.4rem;
        text-align: center;
    }
    .aa p{
        color: #222222;
        font-size: 0.22rem;
        margin-left: 0.3rem;
    }
</style>

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
    <a class="mui-tab-item" href="<?php echo U('Discover/index');?>">
        <img src="/Public/Home/images/fx1.png" alt="">
        <span class="mui-tab-label">发现</span>
    </a>
    <a class="mui-tab-item mui-active" href="<?php echo U('User/index');?>">
        <img src="/Public/Home/images/my2.png" alt="">
        <span class="mui-tab-label">我的</span>
    </a>

</nav>
<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(".ctbtn").on('click',function () {
        alert('Hpay暂时停止充币,开放时间另待通知!');return false;
    });
    mui('body').on('tap', 'a', function () { document.location.href = this.href; });
    // $('.aa').click(function(){
    //     alert('功能暂未开放');
    // }

    // $(".aa").on('click', function() {
    //     alert('功能暂未开放');
    //
    // })

    $('.logout').click(function(){
        window.location.href="<?php echo U('Public/getOut');?>"
    });

    $('#sign').click(function () {
        let ptr62=$('.ptr62').val();
        let money=$('.money').text();
        let price=parseFloat(ptr62)+parseFloat(money);

       $.ajax({
           type:'POST',
           url:"<?php echo U('User/sign');?>",
           dataType:"json",
           success:function(data){
               if(data.code==1){
                   alert(data.msg);
               }else{
                   alert(data.msg);
                   $("#sign").text('已签到');

                   $('.money').text(price.toFixed(2));
                   // window.location.href=data.data;
               }
           }
       });
    });
</script>

</body>

</html>