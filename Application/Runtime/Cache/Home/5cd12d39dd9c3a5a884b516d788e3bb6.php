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

    .address{
        width: 100%;
        background: #fff;
        overflow: hidden;
        margin-bottom: .2rem;
    }

    .addcontent{
        overflow: hidden;
    }

    .p1 {
        overflow: hidden;
        padding: .2rem 0;
        border-bottom: 1px solid #cdcdcd;
        color: #222;
        font-size: .3rem;
        line-height: .5rem;
    }

    .titl .img {
        margin-top: .1rem;
        display: block;
        float: left;
        height: .3rem;
        overflow: hidden;
        margin-right: .16rem;
    }
    .p1 {
        padding-right: .4rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .p1 > div{
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }
    .p1 > div span {
        margin-left: .2rem;
    }
    .address_detail{
        font-size: .24rem;
        line-height: .6rem;
        color: #646464;
        text-indent: .2rem;
    }
    .goods{
        width: 100%;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        padding: .4rem;
        box-sizing: border-box;
        border-top: .3rem solid #f4f4f4;
        border-bottom: .3rem solid #f4f4f4;
    }
    .goodspic{
        width: 1.8rem;
        height: 1.8rem;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        border: 1px solid #eaeaea;
        -webkit-border-radius: .08rem;
        -moz-border-radius: .08rem;
        border-radius: .08rem;
        overflow: hidden;
        margin-right: .2rem;
    }
    .goodspic img{
        max-width: 100%;
        max-height: 100%;
    }
    .goodintroduct{
        width: 100%;
        font-size: .28rem;
        height: 1.8rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
    }
    .goodintroduct div p{
        color: #FF0000;
    }
    .goodintroduct > div{
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .choosenum span{
        display: inline-block;
        width: .4rem;
        height: .4rem;
        line-height: .4rem;
        text-align: center;
        border: 1px solid #eaeaea;
    }
    .choosenum input{
        display: inline-block;
        width: .6rem;
        height: .4rem;
        line-height: .4rem;
        border: 1px solid #eaeaea;
        margin: 0 .1rem;
        text-align: center;
    }
    .beizhu{
        width: 100%;
        box-sizing: border-box;
        padding: .4rem;
        font-size: .28rem;
    }
    .beizhu textarea{
        width: 100%;
        height: 2rem;
        margin: .2rem auto;
        background-color: #f6f6f6;
    }
    #tips::-webkit-input-placeholder{
        color: #ff0000;
        font-size: 18px;
    }
</style>
<header class="header">
    <a href="javascript:history.back(-1)"><img src="/Public/Wap/img/arrowl.png"></a>
    <p>提交订单</p>
    <a href="javascript:void(0)" style="opacity: 0"><img src="/Public/Wap/img/arrowl.png"></a>
</header>
<div class="mall">
    <div class="address">
        <div class="addcontent">
            <div class="p1">
                <div>
                    <img class="titl" src="/Public/Wap/img/titl_l.png">
                    <span>收货信息</span>
                </div>
                <a href="/index.php/User/address.html"><img src="/Public/Wap/img/mores.png" class="img"></a>
            </div>
            <?php if($Address == ''): ?><p class="address_detail">暂无默认收货地址</p>
                <?php else: ?>
                <p class="address_detail">姓名：<?php echo ($Address["receiver"]); ?></p>
                <p class="address_detail">电话：<?php echo ($Address["phone"]); ?></p>
                <p class="address_detail">地址：<?php echo ($Address["address"]); ?></p>
                <p class="address_detail">钱包地址：<?php echo ($Address["wallet_address"]); ?></p><?php endif; ?>

        </div>
    </div>
    <?php $area = C('FORMAT'); ?>
    <div class="goods">
        <div class="goodspic"><img src="<?php echo ($GoodsInfo["goods_logo"]); ?>" alt=""></div>
        <div class="goodintroduct">
            <p><?php echo ($GoodsInfo["name"]); ?></p>
            <div>
                <p>IOTE <span class="price"><?php echo ($GoodsInfo["price"]); ?></span><span style="color: silver"> /<?php echo ($area[$GoodsInfo['format']]); ?></span></p>
                <div class="choosenum">
                    <span onclick="reduce()">-</span>
                    <input id="num" type="text" value="1" readonly>
                    <span onclick="add()">+</span>
                </div>
            </div>
        </div>
    </div>
    <div class="beizhu">
        <p>备注</p>
        <textarea name="tips" id="tips" placeholder="1. 收货信息中的钱包地址为 用户自己的钱包地址. 必须填写!2. 支付时间为30分钟, 过期系统自动取消"></textarea>
    </div>
<!--    <div class="address">-->
<!--        <div class="addcontent">-->
<!--            <div class="p1">-->
<!--                <div>-->
<!--                    <span>物流方式</span>-->
<!--                </div>-->
<!--                <a href="/index.php/User/address.html" style="display:flex;align-items:center;color: #646464;text-decoration: none">快递<img src="/Public/Wap/img/mores.png" class="img" style="margin-left: .2rem"></a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>
<div class="footer">
    <p>合计：<span style="color: #FF0000;font-size: .32rem;font-weight: 700">IOTE</span> <span class="allprice" style="color: #FF0000;font-size: .32rem;font-weight: 700"><?php echo ($GoodsInfo["price"]); ?></span></p>
    <a href="javascript:" style="text-decoration:none;color: white" id="makeOrder"><ul>立即购买</ul></a>
</div>
<style>
    .footer{
        position: fixed;
        width: 100%;
        bottom: 0;
        height: 1rem;
        line-height: 1rem;
        font-size: .4rem;
        text-align: center;
        display: flex;justify-content: space-between;
        align-items: center;
    }
    .footer p{
        width: 100%;
        text-align: right;
        padding-right: .4rem;
        font-size: .24rem;
        box-sizing: border-box;
        border-top: 1px solid #eaeaea;
    }
    .footer a{
        flex-shrink: 0;
        display: inline-block;
        width: 2rem;
        background-color: #FF0000;
        color: #fff;
    }
    .mall{
        margin-bottom: 1rem;
        overflow: hidden;
    }
</style>

<link href="https://cdn.bootcss.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/Swiper/4.5.0/js/swiper.min.js"></script>
<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    function reduce () {
        let num = parseInt($("#num").val())
        if (num < 1) {
           num  = 1
        } else {
            num -= 1
        }
        if(num < 1){
             num = 1;
        }
        $("#num").val(num)
        chanegall(num)
    }
    function add () {
        let num = parseInt($("#num").val())
        num += 1
        $("#num").val(num)
        chanegall(num)
    }
    function chanegall (num) {
        let price = parseFloat($(".price").html())
        $(".allprice").html(price * num)
    }

    $("#makeOrder").on('click',function () {
        var goods_id = "<?php echo ($GoodsInfo["id"]); ?>";
        var address_id = "<?php echo ($Address["id"]); ?>";
        var num = $('#num').val();
        var tips = $('#tips').val();

        if(address_id == ''){
            alert('请完善收货信息！');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo U('Goods/MakeOrder');?>",
            data: {
                goods_id:goods_id,
                address_id:address_id,
                num:num,
                tips:tips,
            },
            dataType: "json",
            success: function (data){
                if(data.code > 0){
                    alert(data.message);
                    window.location.href = `/index.php/Goods/Pay/order_id/${data.order_id}`;
                }else{
                    alert(data.message);
                }
            },
        })
    })
</script>
</body>
</html>