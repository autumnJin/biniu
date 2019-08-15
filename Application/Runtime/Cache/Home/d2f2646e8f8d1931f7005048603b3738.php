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

    .name{
        height: .7rem;
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
    <p>HPAY商城</p>
    <a href="javascript:void(0)" style="opacity: 0"><img src="/Public/Wap/img/arrowl.png"></a>
</header>
<div>
    <ul class="mall">
        <?php if(is_array($GoodsLists)): $i = 0; $__LIST__ = $GoodsLists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
                <img src="<?php echo ($v["logo"]); ?>" alt="">
                <p class="name"><?php echo ($v["name"]); ?></p>
                <p>IOTE：<span><?php echo ($v["price"]); ?></span></p>
                <a href="<?php echo U('Goods/GoodsDetail',array('id'=>$v['id']));?>" style="text-decoration:none;color: white"><div class="buy">立即购买</div></a>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>

<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>