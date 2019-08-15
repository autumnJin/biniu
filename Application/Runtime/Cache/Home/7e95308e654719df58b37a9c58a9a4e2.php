<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>钱包</title>
  <link rel="stylesheet" href="/Public/Home/css/ming_common.css">
  <link rel="stylesheet" href="/Public/Home/css/ming.css">
</head>

<body>
  <header class="header">
    <a href='javascript:history.back(-1)'><img src="http://hb90508.zhongbkj.com/Public/Home/images/Return.png"
        alt=""></a>
    <p>钱包</p>
    <span class="kongge"></span>
  </header>
  <section class="content">
    <div class="content_header">
      <!-- <div class="content_header_money">
        <p>总资产</p>
        <p>123456.00</p>
        <p>≈ 0 CNY</p>
      </div> -->
      <ul>
        <li><a href="<?php echo U('Property/zhuanshou');?>"><img src="/Public/Home/images/shoukuan.png" alt=""><span>充币</span></a></li>
        <li><a href="<?php echo U('Property/zhuanzhang');?>"><img src="/Public/Home/images/zhuanzhang.png" alt=""><span>提币</span></a></li>
      </ul>
    </div>
    <div class="qianbao">
      <h5>充提记录</h5>
      <ul>

        <?php if(is_array($coinListData)): $i = 0; $__LIST__ = $coinListData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="bi_record">

                <?php if($vo['type'] == 1): ?><p><span>类型:</span><span>充币</span></p>

                <?php else: ?>

                    <p><span>类型:</span><span>提币</span></p><?php endif; ?>

                <p><span>币种:</span><span><?php echo (strtoupper($vo['coinname'])); ?></span></p>
                
                <p><span>数量:</span><span><?php echo ($vo['amount']); ?></span></p>

                <?php if($vo['status'] == 1): ?><p><span>状态</span><span style="color: green;">已完成</span></p>

                <?php elseif($vo['status'] == 2): ?>

                    <p><span>状态</span><span style="color: red;">审核中</span></p>

                <?php else: ?>

                    <p><span>状态</span><span style="color: red;">已驳回</span></p><?php endif; ?>

                <?php if($vo['endtime'] == 0): ?><p><span>时间:</span><span>---</span></p>

                <?php else: ?>

                    <p><span>时间:</span><span><?php echo (date('Y-m-d H:i:s',$vo['endtime'])); ?></span></p><?php endif; ?>

            </li><?php endforeach; endif; else: echo "" ;endif; ?>

      </ul>
    </div>
  </section>

  <style>
    .qianbao {
      padding: 0 2.5%;
      box-sizing: border-box;
    }

    .bi_record {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      line-height: .7rem;
      font-size: .28rem;
      border-bottom: 1px solid #eaeaea;
      padding: .3rem 0;
    }

     .bi_record p {
      width: 50%;
    }

    .bi_record p:last-child {
      width: 100%;
    } 

    .bi_record p>span:first-child {
      margin-right: .2rem;
    }

    .bi_record p>span:last-child {
      font-weight: 700;
    }
  </style>

</body>

</html>