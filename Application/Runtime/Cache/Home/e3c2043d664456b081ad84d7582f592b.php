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
        width: 95%;
        padding: .2rem;
        margin: .15rem;
        box-sizing: border-box;
        border: solid 1px silver;

    }
    .mall li img{
        width: 100%;
        height: 4rem;
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
        line-height: .6rem;
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
    .btn_x{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .mall li div.btn_x > div{
        width: 100%;
        margin: 0 .2rem;
        background-color: rgb(0, 110, 255);
    }
    #getMoney .content .froms .names input{
        height: .8rem;
    }
</style>
<header class="header">
    <a href="/index.php/Discover/index.html"><img src="/Public/Wap/img/arrowl.png"></a>
    <p>我的配套</p>
    <a href="javascript:void(0)" style="opacity: 0"><img src="/Public/Wap/img/arrowl.png"></a>
</header>
<div>
    <ul class="mall">
        <?php if($UserInfo["pt_level"] == 1): ?><li>
                <img src="/Public/Home/images/kj_1.png" alt="">
                <p>USDT：<span>100</span>&nbsp;&nbsp;&nbsp;IOTE奖金余额：<span><?php echo ($UserInfo["z10"]); ?></span></p>
                <div class="btn_x">
                    <?php if($UserInfo["is_open"] == 1): ?><div class="up">前往升级</div>
                        <?php else: ?>
                        <div>等待激活</div>
<!--                    <div class="back" value="1">点击退本</div>--><?php endif; ?>
                </div>
            </li>
        <?php elseif($UserInfo["pt_level"] == 2): ?>
            <li>
                <img src="/Public/Home/images/kj_2.png" alt="">
                <p>USDT：<span>1000</span>&nbsp;&nbsp;&nbsp;IOTE奖金余额：<span><?php echo ($UserInfo["z10"]); ?></span></p>
                <div class="btn_x">
                    <?php if($UserInfo["is_open"] == 1): ?><!--                        <div class="up">前往升级</div>-->
                        <?php else: ?>
                        <div>等待激活</div>
                        <!--                    <div class="back" value="1">点击退本</div>--><?php endif; ?>
<!--                    <div class="back" value="2">点击退本</div>-->
                </div>
            </li>
        <?php elseif($UserInfo["pt_level"] == 3): ?>
            <li>
                <img src="/Public/Home/images/kj_3.png" alt="">
                <p>USDT：<span>5000</span>&nbsp;&nbsp;&nbsp;IOTE奖金余额：<span><?php echo ($UserInfo["z10"]); ?></span></p>
                <div class="btn_x">
                   <?php if($UserInfo["is_open"] == 1): ?><!--                        <div class="up">前往升级</div>-->
                        <?php else: ?>
                        <div class="open">等待激活</div><?php endif; ?>
<!--                   <div class="back" value="3">点击退本</div>-->
              </div>
            </li>
        <?php elseif($UserInfo["pt_level"] == 4): ?>
            <li>
                <img src="/Public/Home/images/kj_4.png" alt="">
                <p>USDT：<span>10000</span>&nbsp;&nbsp;&nbsp;IOTE奖金余额：<span><?php echo ($UserInfo["z10"]); ?></span></p>
                <div class="btn_x">
                    <?php if($UserInfo["is_open"] == 1): else: ?>
                       <div class="open">等待激活</div><?php endif; ?>
<!--                    <div class="back" value="4">点击退本</div>-->
                </div>
            </li>
        <?php else: ?>
            <li>
                <p style="height: 4rem;font-size: 18px;font-weight:bolder;line-height: 4rem;">暂无配套</p>
                <div class="btn_x">
                    <div id="buy">立即购买</div>
                </div>
            </li><?php endif; ?>
    </ul>
    <div class="record">
        <h5>收益记录</h5>
        <ul class="lists">
            <li>
                <span>类型</span>
                <span>数量</span>
                <span>时间</span>
            </li>
            <?php if(is_array($Data)): $i = 0; $__LIST__ = $Data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
                    <span>
                        <?php if($v["reward_type"] == 52): ?>直推
                        <?php elseif($v["reward_type"] == 53): ?>每日
                        <?php elseif($v["reward_type"] == 54): ?>分享
                        <?php elseif($v["reward_type"] == 55): ?>团队<?php endif; ?>
                    </span>
                    <span><?php echo ($v["amount"]); ?></span>
                    <span><?php echo (date("Y-m-d H:i:s",$v["create_time"])); ?></span>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
<!--            <span><?php echo ($Show); ?></span>-->
            <li>
                <p class="showmore" onclick="moredata()">加载更多</p>
            </li>
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

        .showmore{
            width: 100%;
            text-align:center;
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
</div>
<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script>
  	let page = 2
  	function moredata() {
    	$.ajax({
            url: '<?php echo U('');?>',
            method: 'post',
            data: {page:page},
            success: function (data) {
                $('.showmore').parent().remove()
                let res = JSON.parse(data)
                let str = ''
                for (let i=0 ; i<res.data.length; i++){
                    let time = res.data[i].create_time

                    // let time = new Date(parseInt(timex))
                    let txt1
                    if(res.data[i].reward_type == 52){
                        txt1 = '直推'
                    } else if(res.data[i].reward_type == 53){
                        txt1 = '每日'
                    } else if(res.data[i].reward_type == 54){
                        txt1 = '分享'
                    } else if(res.data[i].reward_type == 55){
                        txt1 = '团队'
                    }
                    str += `<li><span>${txt1}</span>
                            <span>${res.data[i].amount}</span>
                            <span>${time}</span></li>`
                }
                str += `<li>
                            <p class="showmore" onclick="moredata()">加载更多</p>
                        </li>`
                $(".lists").append(str)
                page += 1
            }
        })
    }
  
    // $(".showmore").on('click', moredata)

    $('#buy').on('click',function(){

        window.location.href="<?php echo U('Discover/machine');?>";

    })

    $('.up').on('click',function(){
        if(confirm('是否确定升级配套？如提交升级申请却未及时支付，将暂停收益发放！')) {
            window.location.href = "<?php echo U('Discover/machine');?>";
        }
    })

    $('.open').on('click',function(){

        if(confirm('确定要激活吗？')){
            $.ajax({
                type:"post",
                url:"<?php echo U('Discover/MachineOpen');?>",
                data:{},
                dataType:"json",
                success:function(data){
                    if(data.code==1){
                        alert(data.msg);
                    }else{
                        alert(data.msg);
                        window.location.reload();
                    }
                }
            });
        }

    })

    $('.back').on('click',function () {
        var day = "<?php echo ($Day); ?>";
        var pt_level = $(this).attr('value');
        if(day < 30){
            if(confirm('确定要退本吗？配套购买或升级未满30天所产生的奖金将从本金中扣除，请谨慎操作！')){
                $.ajax({
                    type:"post",
                    url:"<?php echo U('Discover/backMachine');?>",
                    data:{
                        pt_level:pt_level,
                        status:1,
                    },
                    dataType:"json",
                    success:function(data){
                        if(data.code==1){
                            alert(data.msg);
                        }else{
                            alert(data.msg);
                            window.location.reload();
                        }
                    }
                });
            }
        }else{
            if(confirm('确定要退本吗？退本后将无法再获得收益，请谨慎操作！')){
                $.ajax({
                    type:"post",
                    url:"<?php echo U('Discover/backMachine');?>",
                    data:{
                        pt_level:pt_level,
                        status:2,
                    },
                    dataType:"json",
                    success:function(data){
                        if(data.code==1){
                            alert(data.msg);
                        }else{
                            alert(data.msg);
                            window.location.reload();
                        }
                    }
                });
            }
        }

    })
</script>

</body>
</html>