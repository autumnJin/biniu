<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=0,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HPAY</title>
    <link rel="stylesheet" href="/Public/Wap/css/person.css">
    <script src="/Public/Wap/js/1.js"></script>
</head>
<body>
<div class="header">
    <a href="<?php echo U('User/index');?>"><img src="/Public/Home/images/Return.png" alt=""></a>
    <h2>个人资料</h2>
</div>
<div class="content">
    <input type="hidden" id="id" value="<?php echo ($data["id"]); ?>">
    <!--<div class="head">-->
        <!--<span>头像</span>-->
        <!--<img src="/Public/Home/images/arrow.png" alt class="arrow">-->
        <!--<img src="/Public/Home/images/candy.png" alt class="tou">-->
    <!--</div>-->
    <div class="name">
        <span>昵称</span>
        <input type="text" id="truename" value="<?php echo ($data["username"]); ?>" />
    </div>
    <div class="tel">
        <span>手机号ID</span>
        <em><?php echo ($data["phone"]); ?></em>

    </div>
    <div class="time">
        <span>注册时间</span>
        <em><?php echo (date("Y-m-d",$data['create_time'])); ?></em>
    </div>
    <div class="bank">
        <span>银行卡</span>
        <em>
            <select id="bank_name">
                <?php if(is_array($bank_info)): $i = 0; $__LIST__ = $bank_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($data['bank_name'] == $vo['id']) echo 'selected' ?>><?php echo ($vo['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            <input type="text" id="bank_num" value="<?php echo ($data["bank_num"]); ?>" />
        </em>
    </div>
    <div class="zfb">
        <span>支付宝</span>
        <input type="text" id="zfb" value="<?php echo ($data["zfb"]); ?>" />
    </div>
</div>
<div id="sub" >保存修改</div>
<div class="logout"  >退出登录</div>
<style>
    #sub{
        width: 60%;
        height: 0.8rem;
        line-height: .8rem;
        border: 0;
        outline: 0;
        background-color: #468fff;
        margin-top: 0.5rem;
        margin-left: 20%;
        color: #fff;
        font-size: 0.25rem;
        border-radius: 0.4rem;
        text-align: center;
    }
    .name input,.zfb input,.bank input{
        line-height: .5rem;
        border: 0;
        border-bottom: 1px solid #a9a9a9;
        outline: none;
        padding-left: .2rem;
    }
    .bank select{
        border-radius: .1rem;
        height: .5rem;
        line-height: .5rem;
    }
    .content span{
        display: inline-block;
        width: 1.5rem;
    }
    .content > div {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .bank input{
        width: 2.5rem;
    }
    body .content .name em, body .content .time em, body .content .bank em, body .content .zfb em, body .content .tel em{
        margin-top: 0;
    }
</style>
</body>
</html>
<script src="/Public/common/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    $('#sub').click(function(){
        $.ajax({
            type:"post",
            url:"<?php echo U('User/user_info');?>",
            data:{
                zfb:$('#zfb').val(),
                bank_name:$('#bank_name').val(),
                bank_num:$('#bank_num').val(),
                truename:$('#truename').val(),
                id:$('#id').val(),
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

    $('.logout').click(function(){
        window.location.href="<?php echo U('Public/getOut');?>"
    })
</script>