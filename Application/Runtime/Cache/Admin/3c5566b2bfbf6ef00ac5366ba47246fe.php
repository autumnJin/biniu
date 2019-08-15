<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head><title>
  管理员登录
</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href="/Public/Admin/login/base.css" type="text/css" rel="stylesheet">
  <link href="/Public/Admin/login/index.css" type="text/css" rel="stylesheet">
  <link href="/Public/Admin/login/jquery.lightbox-0.5.css" type="text/css" rel="stylesheet">
  <link href="/Public/Admin/login/skin.css" type="text/css" rel="stylesheet"></head>


<body class="dx_body">
<form name="Form1" method="post" action="<?php echo U('');?>" id="Form1">

  <div class="dx_login">
    <table class="dx_table">
      <tbody><tr>
        <td>
          用户名
        </td>
        <td>
          <input name="username" type="text" maxlength="25" id="bianhao">
        </td>
      </tr>
      <tr>
        <td>
          密&nbsp;&nbsp;&nbsp; 码
        </td>
        <td>
          <input name="password" type="password" id="pass">
        </td>
      </tr>

      <tr>
        <td colspan="2" style="text-align: center">
          <input type="submit" name="Button_ok" value="登录" id="Button_ok" class="AllButton" style="border-style:None;">
          &nbsp;
        </td>
      </tr>
      </tbody></table>
  </div>
</form>


</body>
<script src="/Public/common/js/jquery.min.js"></script>
<script src="/Public/lib/layer/layer.js"></script>
<script>
$(function () {
    $('form').submit(function (event) {
        event.preventDefault();
        var url = $('form').attr('action');
        $.post(url,$('form').serialize(),function (data) {
            layer.msg(data.msg);
            if(data.code){
                return false;
            }else{
                window.location.href=data.data;
            }
        },'json')
    })
})
</script>
</body>
</html>