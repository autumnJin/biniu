<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>HPAY</title>
	<link rel="stylesheet" href="/Public/Wap/css/login.css">
	<script src="/Public/Wap/js/1.js"></script>
</head>

<body>

	<div class="header">
		<a href="<?php echo U('Index/index');?>"><img src="/Public/Home/images/Return.png" alt=""></a>
		登录
	</div>
	<div class="logo">
		<img src="/Public/Home/images/logo@3x.png" alt="">
	</div>
	<div class="logo2">
		<img src="/Public/Home/images/HPAY@3x.png" alt="">
	</div>
	<div class="user">
		<input type="text"  id="username" placeholder="请输入账号">
		<img src="/Public/Home/images/user.png" alt="">
	</div>
	<div class="password">
		<input type="password" id="password" placeholder="密码">
		<img src="/Public/Home/images/Pass.png" alt="">
	</div>
	<button id="sub">登录</button>
	<div class="other">
		<a href="find_password.html">忘记密码 ?</a>
		<a href="<?php echo U('Public/register');?>">注册</a>
	</div>

</body>	
</html>

<style>
	.user input,.password input{
		color: #fff;
		line-height: 1rem;
		font-size: 17px
	}
	.other{
		font-size: 17px
	}

	body .other a{
		margin-right:0;
	}
</style>

<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    $('#sub').click(function(){
        $.ajax({
            type:"post",
            url:"<?php echo U('Public/login');?>",
            data:{
                username:$('#username').val(),
                password:$('#password').val(),
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