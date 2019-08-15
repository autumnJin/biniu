<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HPAY</title>
    <link rel="stylesheet" href="/Public/Wap/css/mui.min.css">
    <link rel="stylesheet" href="/Public/Wap/css/duihuan.css">
    <script src="/Public/Wap/js/zepto.min.js"></script>
    <!--<script src="/Public/Wap/js/mui.min.js"></script>-->
    <script src="/Public/Wap/js/1.js"></script>
</head>

<body>
<div class="header">
    <h2>闪兑</h2>
</div>
<div class="quick">
    <div class="quick-t">
        <img src="/Public/Home/images/Tr.png" alt="">
        <div>
            <select name="coin1" id="coin1">
                <option value="5">IOTE</option>
                <!--<option value="7">BTC</option>-->
                <!--<option value="8">USDT</option>-->
                <!--<option value="9">ETH</option>-->
            </select>
        </div>
        <div>
            <select name="coin2" id="coin2">
                <option value="5">IOTE</option>
                <option value="7">BTC</option>
                <option value="8">USDT</option>
                <option value="9">ETH</option>
            </select>
        </div>
        <div><input type="text" class="num1"></div>
        <div><input type="text" class="num2"></div>
    </div>
    <div class="quick-b" id="aa">
        快速闪兑
    </div>
</div>

<style>
    .quick-t select,.quick input{
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        line-height: .6rem;
        border: 0;
    }
</style>

<div class="content">
    <div class="title">
        <div>全部</div>
        <div>价格</div>
        <div>状态</div>
    </div>
    <ul>
        <?php if(is_array($exchange_list)): foreach($exchange_list as $key=>$vo): ?><li>
                <div>
                    <img src="/Public/Home/images/BTC.png" alt="">
                    <?php if($vo['to_coin'] == 7): ?><span>IOTE/BTC</span><?php endif; ?>
                    <?php if($vo['to_coin'] == 8): ?><span>IOTE/USDT</span><?php endif; ?>
                    <?php if($vo['to_coin'] == 9): ?><span>IOTE/ETH</span><?php endif; ?>
                </div>
                <div><?php echo ($vo["price"]); ?></div>
                <div>
                    <?php if($vo['status'] == 0): ?><button>待审</button><?php endif; ?>
                    <?php if($vo['status'] == 1): ?><button>成功</button><?php endif; ?>
                    <?php if($vo['status'] == -1): ?><button>驳回</button><?php endif; ?>
                </div>
            </li><?php endforeach; endif; ?>
        <!--<li>-->
        <!--<div>-->
        <!--<img src="/Public/Home/images/BTC.png" alt="">-->
        <!--<span>WFX/BTC</span>-->
        <!--</div>-->
        <!--<div>503.21</div>-->
        <!--<div>-->
        <!--<button>成功</button>-->
        <!--</div>-->
        <!--</li>-->
        <!--<li>-->
        <!--<div>-->
        <!--<img src="/Public/Home/images/BTC.png" alt="">-->
        <!--<span>WFX/BTC</span>-->
        <!--</div>-->
        <!--<div>503.21</div>-->
        <!--<div>-->
        <!--<button>驳回</button>-->
        <!--</div>-->
        <!--</li>-->
        <!--<li>-->
        <!--<div>-->
        <!--<img src="/Public/Home/images/BTC.png" alt="">-->
        <!--<span>WFX/BTC</span>-->
        <!--</div>-->
        <!--<div>503.21</div>-->
        <!--<div>-->
        <!--<button>待审</button>-->
        <!--</div>-->
        <!--</li>-->
        <!--<li>-->
        <!--<div>-->
        <!--<img src="/Public/Home/images/BTC.png" alt="">-->
        <!--<span>WFX/BTC</span>-->
        <!--</div>-->
        <!--<div>503.21</div>-->
        <!--<div>-->
        <!--<button>待审</button>-->
        <!--</div>-->
        <!--</li>-->
    </ul>
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
    <a class="mui-tab-item mui-active" href="<?php echo U('Duihuan/index');?>">
        <img src="/Public/Home/images/sd2.png" alt="">
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
<input type="hidden" value="<?php echo ($config["hapy"]); ?>" id="hapy"/>
<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script>

    //IOTE实时价格
    var hapy = $("#hapy").val();
    $(".num2").val(hapy);
    $(document).ready(function() {
        $("#coin2").change(function () {
            var value=$(this).val();
            $.ajax({
                type:"POST",
                url: "<?php echo U('Duihuan/coin');?>",
                data:{type:value},
                dataType: "json",
                success: function (data){
                    console.log(data);
                    if(data.code > 0){
                        $('.num2').val(data.message);
                    }
                }
            });
        });
    });


    $('#aa').click(function(){
        alert('功能暂未开放');return false;
        var coin1=$('#coin1').val();
        var coin2=$('#coin2').val();
        var num1=$('.num1').val();
        var num2=$('.num2').val();
        if(num1==''||num2==''){
            alert('请输入兑换金额');return false;
        }
        if(coin1===coin2){
            alert('请换一种币兑换');return false;
        }
        $.ajax({
            type: "POST",
            // url: "<?php echo U('User/change');?>",
            url: "/index.php/Duihuan/index",
            data: {
                coin1:$('#coin1').val(),
                coin2:$('#coin2').val(),
                num1:$('.num1').val(),
                num2:$('.num2').val(),
                // password2:$('#password2').val(),
            },
            dataType: "json",
            success: function (data){
                if(data.code > 0){
                    alert(data.message);
                    // window.location.href = "<?php echo U('User/change');?>";
                    window.location.href = "<?php echo U('Duihuan/index');?>";
                }else{
                    alert(data.message);
                }
            }
        });
    })
    mui('body').on('tap', 'a', function () { document.location.href = this.href; });
    $('#aa').click(function(){
        alert('功能暂未开放');
    });
</script>
</body>

</html>