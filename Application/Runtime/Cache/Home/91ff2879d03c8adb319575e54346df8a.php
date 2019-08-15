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
</style>
<div id="address">
    <header class="header">
        <a href="javascript:history.back(-1)" style="width: 1.5rem;text-align: left;"><img src="/Public/Wap/img/arrowl.png" style="width: .2rem;"></a>
        <div>收货地址</div>
        <a href="<?php echo U('add_address_');?>" style="width: 1.5rem;font-size: 10px;color: #fff;">添加新地址</a>
    </header>
    <div class="content">
        <ul>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <div class="top">
                    <div class="container">
                        <div class="p1"><?php echo ($vo["receiver"]); ?><span><?php echo ($vo["phone"]); ?></span></div>
                        <div class="p3"><?php echo ($vo["address"]); ?></div>
                        <div class="p3"><?php echo ($vo["wallet_address"]); ?></div>
                    </div>
                </div>
                <div class="down">
                    <div class="container">
                        <div class="left">
                            <input class="setdefault_" type="radio" <?php if($vo['is_default'] == 2) echo 'checked' ?> name="vals" a_id="<?php echo ($vo['id']); ?>" />
                            <span>设为默认</span>
                        </div>
                        <div class="right">
                            <a href="<?php echo U('edit_address',array('id'=>$vo['id']));?>"><img src="/Public/Wap/img/edit.png" alt="">编辑</a>
                            <a href="javascript:void(0);" class="del" a_id="<?php echo ($vo['id']); ?>"><img src="/Public/Wap/img/del.png" alt="">删除</a>
                        </div>
                    </div>
                </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <a id="create" href="">确定</a>
    </div>
</div>
<style>.content ul{
    width: 100%;
    padding: .2rem;
}
.content{
    background-color: #fff;
}
.container{
    width: 100%;
}</style>
<script>
$(function () {
    $('.del').click(function () {
        var url = "<?php echo U('deleteaddress');?>";
        var id = $(this).attr('a_id');
        $.post(url,{id:id},function (data) {
            alert(data.msg);
            if(data.code){
                return;
            }else{
                window.location.href=data.data;
            }
        },'json')
    });

    $('.setdefault_').click(function () {
        var url = "<?php echo U('setdeaultaddress');?>";
        var id = $(this).attr('a_id');
        $.post(url,{id:id},function (data) {
            alert(data.msg);
            if(data.code){
                return;
            }else{
                window.location.href=data.data;
            }
        },'json')
    })
})
</script>