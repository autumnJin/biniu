<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=0,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HPAY</title>
    <link rel="stylesheet" href="/Public/Wap/css/change.css">
    <script src="/Public/Wap/js/1.js"></script>
</head>
<body>
<div class="header">
    <h2>修改密码</h2>
    <a href="<?php echo U('User/index');?>">
        <img src="/Public/Home/images/Return.png" alt="">
    </a>
</div>
<div class="login">
    <span>修改登录密码</span>
    <a href="<?php echo U('User/password');?>"> <img src="/Public/Home/images/arrow.png" alt=""></a>
</div>
<div class="pay">
    <span>修改支付密码</span>
    <a href="<?php echo U('User/password2');?>"> <img src="/Public/Home/images/arrow.png" alt=""></a>
</div>
</body>
</html>