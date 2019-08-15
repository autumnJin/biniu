<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HPAY</title>
</head>

<body>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    html {
        font-size: 13.3333333333333vw;
    }
    ul,li{
        list-style: none;
    }
    .mall{
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .mall li{
        width: 45%;
        padding: .2rem;
        margin: .15rem;
        box-sizing: border-box;
        border: solid 1px silver;

    }
    .mall li img{
        width: 100%;
        height: 2rem;
        background-color: #eaeaea;
        box-shadow: 0 0 .3rem #eaeaea;
    }
    .mall li p{
        font-size: .24rem;
        text-align: center;
    }
    .mall li p span{
        font-size: .28rem;
        color: #ff0000;
    }
    .mall li div{
        width: 100%;
        line-height: .4rem;
        background-color: rgb(0, 110, 255);
        text-align: center;
        border-radius: .08rem;
        font-size: .24rem;
        color: #fff;
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
</style>
<header class="header">
    <a href="/index.php/Discover/index.html"><img src="/Public/Wap/img/arrowl.png"></a>
    <p>云矿池</p>
    <a href="javascript:void(0)" style="opacity: 0"><img src="/Public/Wap/img/arrowl.png"></a>
</header>
<div>
    <ul class="mall">
        <li>
            <img src="/Public/Home/images/kj_1.png" alt="">
            <p>USDT：<span>100</span></p>
            <p>IOTE奖金余额：<span><?php echo ($UserInfo["z10"]); ?></span></p>
            <div class="buy" value="1">立即购买</div>
        </li>
        <li>
            <img src="/Public/Home/images/kj_2.png" alt="">
            <p>USDT：<span>1000</span></p>
            <p>IOTE奖金余额：<span><?php echo ($UserInfo["z10"]); ?></span></p>
            <div class="buy" value="2">立即购买</div>
        </li>
<!--        <li>-->
<!--            <img src="/Public/Home/images/kj_3.png" alt="">-->
<!--            <p>USDT：<span>5000</span></p>-->
<!--            <div class="buy" value="3">立即购买</div>-->
<!--        </li>-->
<!--        <li>-->
<!--            <img src="/Public/Home/images/kj_4.png" alt="">-->
<!--            <p>USDT：<span>10000</span></p>-->
<!--            <div class="buy" value="4">立即购买</div>-->
<!--        </li>-->
    </ul>
</div>
<div class="record">
    <h5>购买/升级记录</h5>
    <ul>
        <li>

            <span>数量</span>
            <span>时间</span>
            <span>备注</span>
        </li>
        <?php if(is_array($Data)): $i = 0; $__LIST__ = $Data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
                <span><?php echo ($v["amount"]); ?></span>
                <span><?php echo (date("m/d H:i",$v["create_time"])); ?></span>
                <span><?php echo ($v["tips"]); ?></span>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
<style>
    .record{
        padding: 0 .2rem;
    }
    .record h5{
        font-size: .28rem;
        font-weight: 700;
        text-align: center;
        margin-top: .4rem;
        line-height: .8rem;
    }
    .record ul li{
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .24rem;
        line-height: .6rem;
        border-bottom: 1px solid #eaeaea;
        text-align: center;
        color: #646464;
    }
    .record ul li span:first-child{
        width: 25%;
    }
    .record ul li span:nth-child(2){
        width: 25%;
    }
    .record ul li span:last-child{
        width: 50%;
    }
</style>
<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<input type="hidden" value="<?php echo ($config['ptr99']); ?>" id="ptr99"/>
<script>
    $('.buy').on('click',function(){
        var pt_level = $(this).attr('value');
        var ptr99=$('#ptr99').val();
        if(ptr99==="2"){
            if(pt_level==='1'){
                alert("已售罄");return false;//20190710临时关闭微型售罄
            }
        }

        if(confirm('确定要购买吗？')) {
            $.ajax({
                type: "post",
                url: "<?php echo U('Discover/buyMachine');?>",
                data: {
                    pt_level: pt_level,
                },
                dataType: "json",
                success: function (data) {
                    if (data.code == 1) {
                        alert(data.msg);
                    } else {
                        alert(data.msg);
                        window.location.href = "<?php echo U('Discover/myMachine');?>";
                    }
                }
            });
        }

    })
</script>

</body>
</html>