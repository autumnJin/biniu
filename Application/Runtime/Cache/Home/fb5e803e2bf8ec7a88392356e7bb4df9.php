<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>HPAY</title>
	<link rel="stylesheet" href="/Public/Wap/css/register.css">
	<script src="/Public/Wap/js/1.js"></script>
</head>

<body>
<div class="header">
	<a href="login.html"><img src="/Public/Home/images/Return.png" alt=""></a>
	修改密码
</div>

<div class="tel" style="margin-top:2rem;">
	<input type="text" placeholder="手机号" id="phone">
	<img src="/Public/Home/images/Cell.png" alt="">
</div>
<div class="code">
	<input type="text" placeholder="验证码" id="code">
	<img src="/Public/Home/images/A.png" alt="">
	<a id="getCode" class="getCode"  href="javascript:void(0);">获取验证码</a>
</div>
<div class="password">
	<input type="text" placeholder="密码" id="password">
	<img src="/Public/Home/images/Pass.png" alt="">
</div>
<div class="password">
	<input type="text" placeholder="支付密码" id="password2">
	<img src="/Public/Home/images/Pass.png" alt="">
</div>

<button id="sub">点击保存</button>
<div class="other">
	<a href="<?php echo U('find_password');?>">已有账号 ?</a>
	<a href="<?php echo U('Public/login');?>">立即登录</a>
</div>
<style>
    .other{
        font-size: 17px;
    }
    input{
        line-height: 1rem;
        font-size: 17px;
        color: #fff;
    }
</style>
</body>

</html>

<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script>
	$(function() {
		// $(document).on('click','#getCode',function(){
		$("#getCode").on('click', function () {
			var num = 59;
			var that = $(this);
			var phone = $('#phone').val();
			if (phone == '') {
				alert('请输入注册的手机号码');
			} else if (!(/^1[34578]\d{9}$/.test(phone))) {
				alert('手机号码格式不正确');
			} else {
				$.post("<?php echo U('Public/sendCode');?>", {"phone": phone}, function (data) {
					alert(data.message);
					console.log(data)
					var timer = setInterval(function () {
						that.attr('id', '');
						that.text(num + 's');
						that.addClass('active');
						num--;
						if (num == 0) {
							that.attr('id', 'getCode');
							clearInterval(timer);
							that.text('重新发送验证码');
						}
					}, 1000);
				})
			}
		});

		$('#sub').click(function(){
			$.ajax({
				type:"post",
				url:"<?php echo U('Public/find_password');?>",
				data:{
					phone:$('#phone').val(),
					code:$('#code').val(),
					password:$('#password').val(),
					password2:$('#password2').val(),
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
	})
</script>