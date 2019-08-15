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
    .mall{
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
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

    .photo{
        width: 100%;
    }
    .photo img{
        width: 100%;
    }
    .name{
        width: 100%;
        padding: .2rem;
        font-size: .32rem;
        font-weight: 700;
        text-align: center;
    }
    .description{
        width: 100%;
        padding: .1rem;
        font-size: .28rem;
        font-weight: 700;
        text-align: center;
        color: silver;
    }

    .price{
        width: 100%;
        padding: .1rem;
        font-size: .28rem;
        font-weight: 700;
        text-align: center;
    }

    .money{
        color:red;
    }

    .content{
        width: 100%;
        padding: .1rem;
    }

    .title{
        width: 27.5%;
        float: left;
        padding: .1rem;
        font-size: .5rem;
        font-weight: 700;
        border-bottom: 2px solid blue;
    }



    .content img{
        max-width: 100%;
    }

</style>
<header class="header">
    <a href="/index.php/Goods/GoodsLists.html"><img src="/Public/Wap/img/arrowl.png"></a>
    <p>产品详情</p>
    <a href="javascript:void(0)" style="opacity: 0"><img src="/Public/Wap/img/arrowl.png"></a>
</header>
<div class="mall">
    <div class="photo">
        <div class="swiper-container" id="swiper">
            <div class="swiper-wrapper">
                <?php if(is_array($Photo)): $i = 0; $__LIST__ = $Photo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="swiper-slide"><img src="<?php echo ($v); ?>" alt=""></div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="name">
        <?php echo ($GoodsInfo["name"]); ?>
    </div>
    <div class="description">
        <?php echo ($GoodsInfo["description"]); ?>
    </div>
    <?php $area = C('FORMAT'); ?>
    <div class="price">IOTE <span class="money"><?php echo ($GoodsInfo["price"]); ?></span><span style="color: silver">&nbsp;/&nbsp;</span><?php echo ($area[$GoodsInfo['format']]); ?></div>
    <div class="content">
        <div class="title">产品详情</div>
        <?php echo ($GoodsInfo["content"]); ?>
    </div>
</div>
<div class="footer">
    <a href="<?php echo U('Goods/MakeOrder',array('goods_id'=>$GoodsInfo['id']));?>" style="text-decoration:none;color: white"><ul>立即购买</ul></a>
</div>

<style>
    .footer{
        position: fixed;
        width: 100%;
        bottom: 0;
        height: 1rem;
        line-height: 1rem;
        background-color: #FF0000;
        color: #fff;
        font-size: .4rem;
        text-align: center;
    }
    .mall{
        margin-bottom: 1rem;
        overflow: hidden;
    }
</style>

<link href="https://cdn.bootcss.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/Swiper/4.5.0/js/swiper.min.js"></script>
<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>

</body>
</html>