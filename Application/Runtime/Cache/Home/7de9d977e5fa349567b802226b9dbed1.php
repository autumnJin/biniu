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
<div id="myteam">
    <div class="heads">
        <div class="container">
            <div class="p1">我的团队</div>
            <!--<a href="javascript:void(0);" id="goback"><img src="/Public/Wap/img/arrowl.png"></a>-->
            <a href="<?php echo U('User/index');?>" id="goback"><img src="/Public/Wap/img/arrowl.png"></a>
        </div>
    </div>
    <div class="content">
        <ul>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <div class="container">
                    <a href="javascript:void(0);">
                        <img src="/Public/Wap/img/team.png" alt="">
                        <div class="txt">
                            <div class="p1">
                                <?php echo ($vo['username']); ?>
                                <span style="float: right;font-size: .22rem;margin-right: .5rem">配套等级：
                                    <?php if($vo["pt_level"] == 1): ?>100USDT
                                        <?php elseif($vo["pt_level"] == 2): ?>1000USDT
                                        <?php elseif($vo["pt_level"] == 3): ?>5000USDT
                                        <?php elseif($vo["pt_level"] == 4): ?>10000USDT
                                        <?php else: ?>暂无配套<?php endif; ?>
                                </span>
                            </div>
                            <div class="p3">注册时间: <?php echo (date("Y年m月d日 H:i:s",$vo['create_time'])); ?></div>
                        </div>
                    </a>
                </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>
</div>
</body>
<script src="/Public/Wap/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/Wap/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Public/Wap/js/main.js" type="text/javascript" charset="utf-8"></script>
</html>