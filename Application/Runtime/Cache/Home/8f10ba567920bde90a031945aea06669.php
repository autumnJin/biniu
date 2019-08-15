<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=0,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HPAY</title>
    <link rel="stylesheet" href="/Public/Wap/css/changepwd.css">
    <script src="/Public/Wap/js/1.js"></script>
</head>

<body>
<div class="header">
    <h2>修改支付密码</h2>
    <a href="<?php echo U('User/save_password');?>">
        <img src="/Public/Home/images/Return.png" alt="">
    </a>
</div>
<div class="old">
    <span>原密码</span>
    <input type="text" placeholder="请输入原密码" id="password_old">
</div>
<div class="new">
    <span>新密码</span>
    <input type="text" placeholder="请输入新密码" id="new_password">
</div>
<div class="new2">
    <span>确认密码</span>
    <input type="text" placeholder="请确认新密码" id="sure_password">
</div>
<button id="sub">确认</button>
</body>
</html>
<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    $('#sub').click(function(){
        $.ajax({
            type:"post",
            url:"<?php echo U('User/change_password2');?>",
            data:{
                password_old:$('#password_old').val(),
                new_password:$('#new_password').val(),
                sure_password:$('#sure_password').val(),
            },
            dataType:"json",
            success:function(data){
                if(data.code==1){
                    alert(data.msg);
                }else{
                    alert(data.msg);
                    window.location.href=data.data;
                }
            }
        });
    });
</script>