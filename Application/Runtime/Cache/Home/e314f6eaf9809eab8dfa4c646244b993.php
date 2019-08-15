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
    <link rel="stylesheet" type="text/css" href="/Public/Wap/css/common.css"/>


    <!--<link rel="stylesheet" type="text/css" href="/Public/Wap/css/swiper.min.css"/>-->
    <!--<script src="/Public/Wap/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
    <!--<script src="/Public/Wap/js/main.js" type="text/javascript" charset="utf-8"></script>-->
    <!--<script src="/Public/common/js/common.js" type="text/javascript" charset="utf-8"></script>-->
 <!---->
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    html {
        font-size: 13.3333333333333vw;
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
    .container{
        width: 100%;
        padding: .2rem;
        font-size: 12px;
    }
    #getMoney .content .froms .names input{
        height: .8rem;
    }
</style>
<div id="getMoney">
<!--    <div class="heads">-->
<!--        <div class="container">-->
<!--            <div class="p1">IOTE奖金互转</div>-->
<!--            &lt;!&ndash;<a href="javascript:void(0);" id="goback"><img src="/Public/Wap/img/arrowl.png"></a>&ndash;&gt;-->
<!--            <a href="<?php echo U('User/index');?>" id="goback"><img src="/Public/Wap/img/arrowl.png"></a>-->
<!--        </div>-->
<!--    </div>-->
    <header class="header">
        <a href="javascript:history.back(-1)" style="width: 1.5rem;text-align: left;"><img src="/Public/Wap/img/arrowl.png" style="width: .2rem;"></a>
        <div>IOTE奖金互转</div>
        <a href="javascript:void(0)" style="width: 1.5rem;font-size: 10px;color: #fff;"></a>
    </header>
    <div class="content">
        <div class="froms">
            <div class="container">
                <form action="<?php echo U(transfer);?>" id="cp" method="post">
                    <div class="names">
                        <label for="">IOTE奖金余额</label>
                        <input type="text" value="<?php echo ($user_info["z10"]); ?>" readonly>
                    </div>
                    <div class="names">
                        <label for="">转入账号</label>
                        <input type="text" name="username" placeholder="请输入转入账号">
                    </div>
                    <div class="names">
                        <label for="">转出数量</label>
                        <input type="text" name="amount" placeholder="请输入转出数量">
                    </div>
                    <div class="names">
                        <label for="">支付密码</label>
                        <input type="password" name="password" placeholder="请输入支付密码">
                    </div>
                    <div class="names">
                    <label for="">短信验证码</label>
                    <input type="hidden" id="phone" name="phone" value="<?php echo ($user_info["phone"]); ?>" />
                    <input type="text" id="code" name="code" placeholder="请输入验证码">
                    <a href="javascript:void(0);" class="getcode" id="getCode">获取验证码</a>
                    </div>
                    <input type="button" id="btn" name="" value="确 认">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/Public/Wap/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/Wap/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/Wap/js/main.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(function() {
        $('#btn').click(function () {
            $.ajax({
                type: "POST",
                url: "<?php echo U('User/transfer');?>",
                data: $("#cp").serialize(),
                dataType: "json",
                success: function (data){
                    if(data.code > 0){
                        alert(data.message);
                        window.location.href = "<?php echo U('User/index');?>";
                    }else{
                        alert(data.message);
                    }
                },
            })
        })

        $("#getCode").on('click',function(){
            var num=59;
            var that=$(this);
            var phone=$('#phone').val();
            if (phone=='') {
                alert('请输入注册的手机号码');
                return false;
            }else if(!(/^1[34578]\d{9}$/.test(phone))){
                alert('手机号码格式不正确');
                return false;
            }else{
                $.post("<?php echo U('Public/sendCode');?>",{"phone":phone},function(data){
                    alert(data.message);
                    console.log(data)
                    var timer=setInterval(function(){
                        that.attr('id','');
                        that.text(num+'s');
                        that.addClass('active');
                        num--;
                        if(num==0){
                            that.attr('id','getCode');
                            clearInterval(timer);
                            that.text('重新发送验证码');
                        }
                    },1000);
                })
            }
        })
    });
</script>
</html>