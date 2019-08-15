<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=0,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HAPY</title>
    <link rel="stylesheet" href="/Public/Wap/css/share.css">
    <script src="/Public/Wap/js/1.js"></script>
</head>
<body>
<div class="header">
    <a href="<?php echo U('User/index');?>"><img src="/Public/Home/images/Return.png" alt=""></a>
    <h2>分享推广</h2>
</div>
<div class="content">
    <div class="title">扫码推荐给朋友</div>
    <div class="pic">
        <img src="<?php echo ($QrCodeUrl); ?>" alt="">
    </div>
    <!--<div class="save">保存图片</div>-->
</div>
<div style="margin-top: 280px;">
    <input type="text" id="url" value="<?php echo ($url); ?>" readonly style="width: 100%;border:0;background: transparent;padding: 0 20px;box-sizing: border-box;position:absolute;left:-9999px;">
    <div class="copy" style="cursor: pointer;margin-top: 30px;" onclick="" data-clipboard-target="#url">复制推广链接</div>
</div>
<!--<input type="text" id="copyVal" readonly value="<?php echo ($QrCodeUrl); ?>">-->

<!--<div class="copy">复制推广链接</div>-->
<!--<div class="copy_btn copy" style="cursor: pointer" onclick="" data-clipboard-target="#copyVal">复制推广链接</div>-->
</div>
</body>
</html>
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/clipboard.js/2.0.0/clipboard.min.js"></script>
<script src="/Public/Home/js/jquery.qrcode.min.js"></script>
<script>
    var copyBtn = new ClipboardJS('.copy');
    copyBtn.on("success",function(e){
        alert('复制成功');
        e.clearSelection();
    });
    copyBtn.on("error",function(e){
        //复制失败；
        alert('复制失败');
    });
</script>