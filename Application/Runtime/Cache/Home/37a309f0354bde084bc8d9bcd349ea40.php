<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/Public/Wap/css/notice.css">
    <script src="/Public/Wap/js/1.js"></script>
    <style>
        #statement .content {
            padding-top: .5rem;

            line-height: .5rem;

        }
        p span{
            padding:0rem,1rem;
        }
    </style>

</head>
<body>
    <div class="header">
        <a href="javascript:history.back(-1)"><img src="/Public/Home/images/Return.png" alt=""></a>
        <h2>公告</h2>
    </div>
    <div>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="us">
                <a href="<?php echo U('newsdetail',array('id'=>$vo['id']));?>"><?php echo ($key+1); ?> : <?php echo ($vo['title']); ?></a>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>

    <style>
        .us{
            padding: 0 .2rem;
            box-sizing: border-box;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
        .us a{
            font-size: .24rem;
            color: #646464;
            text-decoration: none;
        }
        /*111*/
    </style>

</body>

</html>