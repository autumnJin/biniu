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
	.container .p1 a {
		color: #666;
	}
	.heads{
		background: linear-gradient(to right, #1e91ff, #075ffe);
	}
</style>
<div id="statement">
	<div class="heads">
		<div class="container">
			<div class="p1">公告</div>
			<!--<a href="javascript:void(0);" id="goback"><img src="/Public/Wap/img/arrowl.png"></a>-->
			<a href="<?php echo U('User/index');?>" id="goback"><img src="/Public/Wap/img/arrowl.png"></a>
		</div>
	</div>
	<div class="content">
		<div class="container">
			<div class="container">
				<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="p1">
						<a href="<?php echo U('User/newsdetail',array('id'=>$vo['id']));?>"><?php echo ($key+1); ?> : <?php echo ($vo['title']); ?></a>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
	</div>
</div>
</body>
<script src="/Public/Wap/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/Wap/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/Wap/js/main.js" type="text/javascript" charset="utf-8"></script>
</html>