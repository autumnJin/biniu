<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=\, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="/Public/Home/css/ming_common.css">
  <link rel="stylesheet" href="/Public/Home/css/ming.css">
</head>

<body>
  <header class="header">
    <a href='javascript:history.back(-1)'><img src="http://hb90508.zhongbkj.com/Public/Home/images/Return.png"
        alt=""></a>
    <p>卖出</p>
    <span class="kongge"></span>
  </header>
  <section class="zhuanzhang">
    <div class="zhuanzhang_choose">
      <div>
        <!--<img src="https://bbtcdn.8btc.com/data/attachment/common/c8/common_2_icon.svg" alt="">-->
        <!--<span>BTC</span>  -->

        <img src="https://bbtcdn.8btc.com/data/attachment/common/c8/common_2_icon.svg" alt="">
        <span>WFX</span><span style="margin-left: 0.5rem;"><?php echo ($user["z5"]); ?></span>
      </div>
      <div>
        <!--<img src="/Public/Home/images/youjiantou.png" alt="">-->
      </div>
    </div>
    <div class="zhuanzhang_input">
      <form action="<?php echo U(sell);?>" id="cp" method="post">
      <!--<section>-->
        <!--<p>钱包地址</p>-->
        <!--<input type="text" placeholder="点击添加地址">-->
      <!--</section>-->
      <section>
        <p>卖出数量</p>
        <input type="text" placeholder="填写卖出数量" name="amount">
      </section>
        <section>
          <p>最低数量</p>
          <input type="text" placeholder="填写最低买入数量" name="low_num">
        </section>
      <section>
        <p>密码</p>
        <input type="password" name="password" placeholder="请输入支付密码">
      </section>
      <div class="zhuanzhang_btn" id="btn">
        确定
      </div>
      </form>
    </div>
    <div class="qianbao">
      <h5>记录</h5>
      <ul>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
            <div class="record">
              <div><img src="/Public/Home/images/test_info.jpg" alt=""></div>
              <div class="record_list_content">
                <!--<p class="record_list_name"><?php echo ($vo["username"]); ?><span>购买USDT</span></p>-->
                <!--<p>编号：456456-45das-456</p>-->
                <p>时间：<?php echo (date('Y-m-d H:i:s',$vo["add_time"])); ?></p>

                <!--<p>挂售数量：<?php echo ($vo["sell_num"]); ?> WFX</p>-->
                <p>最低买入数量：<?php echo ($vo["low_num"]); ?> WFX</p>
                <p>已卖出的数量：<?php echo ($vo["sell"]); ?> WFX</p>
                <p>剩余数量：<?php echo ($vo["lave"]); ?> WFX</p>
              </div>
              <div class="record_list_status">
                <p class="doing">
                  <?php if($vo["status"] == 0): ?>挂卖中
                    <?php elseif($vo["status"] == 1): ?>
                        已售空
                    <?php else: ?>
                        已下架<?php endif; ?>
                </p>
                <p><?php echo ($vo["sell_num"]); ?>WFX</p>
              </div>
            </div>
          </li><?php endforeach; endif; else: echo "" ;endif; ?>

        <!--<li>-->
          <!--<div class="record">-->
            <!--<div><img src="/Public/Home/images/test_info.jpg" alt=""></div>-->
            <!--<div class="record_list_content">-->
              <!--<p class="record_list_name">JackSon<span>购买USDT</span></p>-->
              <!--<p>编号：456456-45das-456</p>-->
              <!--<p>时间：2019-01-14 10:10:10</p>-->
              <!--<p>单价：6.92 CNY</p>-->
              <!--<p>数量：72.6125145 USDT</p>-->
            <!--</div>-->
            <!--<div class="record_list_status">-->
              <!--<p class="doing">交易进行中</p>-->
              <!--<p>500CNY</p>-->
            <!--</div>-->
          <!--</div>-->
        <!--</li>-->
        <!--<li>-->
          <!--<div class="record">-->
            <!--<div><img src="/Public/Home/images/test_info.jpg" alt=""></div>-->
            <!--<div class="record_list_content">-->
              <!--<p class="record_list_name">JackSon<span>购买USDT</span></p>-->
              <!--<p>编号：456456-45das-456</p>-->
              <!--<p>时间：2019-01-14 10:10:10</p>-->
              <!--<p>单价：6.92 CNY</p>-->
              <!--<p>数量：72.6125145 USDT</p>-->
            <!--</div>-->
            <!--<div class="record_list_status">-->
              <!--<p class="doing">交易进行中</p>-->
              <!--<p>500CNY</p>-->
            <!--</div>-->
          <!--</div>-->
        <!--</li>-->
      </ul>
    </div>
  </section>

  <div class="dialog hide">
    <div class="dialog_content">
      <ul>
        <li>
          <div class="content_bi_list">
            <div><img src="https://bbtcdn.8btc.com/data/attachment/common/c8/common_2_icon.svg" alt="">
            </div>
            <div class="">
              <p class="content_bi_type"><span>BTC</span><span>0</span></p>
              <p class="content_bi_money"><span>321321.123CNY</span><span>≈0CNY</span></p>
            </div>
          </div>
        </li>
        <li>
          <div class="content_bi_list">
            <div><img src="https://bbtcdn.8btc.com/data/attachment/common/32/common_72_icon.svg" alt="">
            </div>
            <div class="">
              <p class="content_bi_type"><span>ETH</span><span>0</span></p>
              <p class="content_bi_money"><span>321321.123CNY</span><span>≈0CNY</span></p>
            </div>
          </div>
        </li>
        <li>
          <div class="content_bi_list">
            <div><img src="https://bbtcdn.8btc.com/data/attachment/common/32/common_72_icon.svg" alt="">
            </div>
            <div class="">
              <p class="content_bi_type"><span>ETH</span><span>0</span></p>
              <p class="content_bi_money"><span>321321.123CNY</span><span>≈0CNY</span></p>
            </div>
          </div>
        </li>
        <li>
          <div class="content_bi_list">
            <div><img src="https://bbtcdn.8btc.com/data/attachment/common/32/common_72_icon.svg" alt="">
            </div>
            <div class="">
              <p class="content_bi_type"><span>ETH</span><span>0</span></p>
              <p class="content_bi_money"><span>321321.123CNY</span><span>≈0CNY</span></p>
            </div>
          </div>
        </li>
        <li>
          <div class="content_bi_list">
            <div><img src="https://bbtcdn.8btc.com/data/attachment/common/32/common_72_icon.svg" alt="">
            </div>
            <div class="">
              <p class="content_bi_type"><span>ETH</span><span>0</span></p>
              <p class="content_bi_money"><span>321321.123CNY</span><span>≈0CNY</span></p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>

  <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $("#btn").click(function () {
      $.ajax({
        type:"post",
        url:"<?php echo U('Otc/sell');?>",
        data: $("#cp").serialize(),
        dataType:"json",
        success:function(data){
          if(data.code > 0){
            alert(data.message);
            window.location.href = "<?php echo U('Otc/sell');?>";
          }else{
            alert(data.message);
          }
        }
      });
    });

    // $('body').on('click',function(){
    //   $('.dialog').addClass('hide');
    // })
    // $(".zhuanzhang_choose").on('click', function (e) {
    //   $(".dialog").removeClass('hide')
    //   e.stopPropagation();
    // })
    // $(".dialog_content").on('click', function(e){
    //   e.stopPropagation();
    // })
  </script>
</body>

</html>