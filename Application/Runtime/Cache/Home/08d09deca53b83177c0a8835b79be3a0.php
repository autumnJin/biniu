<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=0,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/Public/Wap/css/earnings.css">
    <script src="/Public/Wap/js/1.js"></script>
</head>

<body>
<div class="header">
    <h2>转账信息</h2>
    <a href="javascript:history.back(-1)">
        <img src="/Public/Home/images/Return.png" alt="">
    </a>
</div>
<!--<div class="title">-->
<!--<div>推荐</div>-->
<!--<div>周返</div>-->
<!--<div>加速</div>-->
<!--</div>-->
<div class="intro">
    <div>转账时间</div>
    <div>转账金额</div>
    <div>转账信息</div>
</div>
<ul>
    <?php if(is_array($transferData)): $i = 0; $__LIST__ = $transferData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
            <div><?php echo (date('Y-m-d H:i:s',$vo["create_time"])); ?></div>
            <div><?php echo ($vo["amount"]); ?></div>
            <div><?php echo ($vo["tips"]); ?></div>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</body>

</html>