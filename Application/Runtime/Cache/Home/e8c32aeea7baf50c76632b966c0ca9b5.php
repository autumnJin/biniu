<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=\, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>提币</title>
  <link rel="stylesheet" href="/Public/Home/css/ming_common.css">
  <link rel="stylesheet" href="/Public/Home/css/ming.css">
</head>

<body>
  <header class="header">
    <a href='javascript:history.back(-1)'><img src="http://hb90508.zhongbkj.com/Public/Home/images/Return.png"
        alt=""></a>
    <p>提币</p>
    <span class="kongge"></span>
  </header>
  <section class="zhuanzhang">
    <div class="zhuanzhang_choose">
        <select name="" id="coinname">
            <option value="1">BTC</option>
            <option value="2">ETH</option>
            <option value="3">USDT</option>
            <!--<option value="6">USDT_OMNI</option>-->
            <!--<option value="4">WFX</option>-->
            <option value="4">IOTE</option>
            <option value="5">IOTE奖金</option>
          </select>
    </div>
    <div class="zhuanzhang_input">

      <section>
        <p>钱包地址</p>
        <input type="text" id="address" placeholder="请输入提币地址">
      </section>

      <section>
        <p>提币数量</p>
        <input type="text" id="amount" placeholder="请输入提币数量">
      </section>

      <section>
        <p>账户余额</p>
        <input type="text" id="balance" value="<?php echo ($accountBalance); ?>" placeholder="">
      </section>

      <section>
        <p>支付密码</p>
        <input type="password" id="password"  placeholder="请输入支付密码">
      </section>

      <section>
        <p>手机号码</p>
        <!--<input class="phoneSend" type="text" name="phone" id="phone" placeholder="请输入手机号码" value="<?php echo ($userData["phone"]); ?>" disabled style="background: url('/Public/Wap/img/phone.png') no-repeat;">-->
        <input class="phoneSend" type="text" name="phone" id="phone" placeholder="请输入手机号码" value="<?php echo ($userData["phone"]); ?>" disabled  >
      </section>
      <section>
        <!--<input type="text" name="code" placeholder="请输入验证码" id="code" style="background: url('/Public/Wap/img/codes.png') no-repeat;">-->
        <input type="text" name="code" placeholder="请输入验证码" id="code" >
        <a id="getCode" class="getCode"  href="javascript:void(0);">获取验证码</a>
      </section>
      <section>
        <p>手续费<span id="charge"></span>%</p>

      </section>
      <div class="zhuanzhang_btn" id="sure">
        确认
      </div>

    </div>

    <input type="hidden" id="ptr73" value="<?php echo ($config["ptr73"]); ?>"/>
    <input type="hidden" id="ptr74" value="<?php echo ($config["ptr74"]); ?>"/>
    <input type="hidden" id="ptr75" value="<?php echo ($config["ptr75"]); ?>"/>
    <input type="hidden" id="ptr76" value="<?php echo ($config["ptr76"]); ?>"/>
    <input type="hidden" id="ptr96" value="<?php echo ($config["ptr96"]); ?>"/>
  </section>
    <style>
      .zhuanzhang_choose select{
        width: 100%;
        font-size: .3rem;
      }
      .zhuanzhang_choose{
        overflow: hidden;
      }
      .getCode {
        position: absolute;
        right: 4%;
        /*top: 76%;*/
        top: 10.1rem;
        padding: 0 .16rem;
        color: #f75854;
        font-size: .26rem;
        line-height: .6rem;
        border-radius: .12rem;
        border: 1px solid #f7a09e;
      }
    </style>

    <!--<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>-->
  <!-- 引入js -->
  <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript" src="/Public/Home/js/web3.1.js"></script>
    <script type="text/javascript">
      let val1=$("#ptr73").val();
      $("#charge").text(parseFloat(val1)*100);
        $('#coinname').change(function(){

            //生成BTC地址
            var coinname = $("#coinname").val();

            if (coinname==='1'){
              let val1=$("#ptr73").val();
              $("#charge").text(parseFloat(val1)*100);
            } else if (coinname==='2'){
              let val2=$("#ptr74").val();
              $("#charge").text(parseFloat(val2)*100);
            } else if (coinname==='3'){
              let val3=$("#ptr75").val();
              $("#charge").text(parseFloat(val3)*100);
            } else if (coinname==='4'){
              let val4=$("#ptr76").val();
              $("#charge").text(parseFloat(val4)*100);
            }else if (coinname==='5'){
              let val5=$("#ptr96").val();
              $("#charge").text(parseFloat(val5)*100);
            }else if (coinname==='6'){
              let val3=$("#ptr75").val();
              $("#charge").text(parseFloat(val3)*100);
            }
            console.log(coinname);
            //传输数据
            $.ajax({
                type : 'POST',
                url:"<?php echo U('Property/getBalance');?>",
                dataType : 'json',
                data:{
                    coinname:coinname,
                },
                success : function(data){

                    if(data.code == 1){
                        //alert(data.msg);
                    }else
                    {
                        $("#balance").val(data.data);
                    }
                }
            })
        });
    </script>

    <script type="text/javascript">
      if (typeof web3 !== 'undefined') {
        web3 = new Web3(web3.currentProvider);
      }
      else {
        web3 = new Web3('https://mainnet.infura.io/JLEYzEEavNnSni91CvPF');
      }

      $('#sure').click(function(){

            //生成BTC地址
            var coinname = $("#coinname").val();
            var address = $("#address").val();
            //验证钱包地址
            if(coinname!=='1'){
              //验证数量
              if(!web3.utils.isAddress(address)){
                alert('钱包地址不正确');
                return false;
              }
            }


            var amount = $("#amount").val();
            var password = $("#password").val();
            var phone = $("#phone").val();
            var getCode = $("#code").val();
            if(getCode===''){
              alert("请填写验证码");return false;
            }
            //传输数据
            $.ajax({
                type : 'POST',
                url:"<?php echo U('Property/zhuanzhang');?>",
                dataType : 'json',
                data:{
                    coinname:coinname,
                    address:address,
                    amount:amount,
                    password:password,
                    phone:phone,
                    getCode:getCode
                },
                success : function(data){

                    if(data.code == 1){
                        alert(data.msg);
                        //setTimeout(function(){ window.location.reload(); }, 1000);
                    }else
                    {
                        alert(data.msg);
                        setTimeout(function(){ window.location.href="<?php echo U('Property/qianbao');?>"; }, 1000);
                    }
                }
            })
        });

        $("#getCode").on('click',function(){
          var num=59;
          var that=$(this);
          var phone=$('#phone').val();
          if (phone=='') {
            alert('请输入注册的手机号码');
          }else if(!(/^1[34578]\d{9}$/.test(phone))){
            alert('手机号码格式不正确');
          }else{
            $.post("<?php echo U('Public/sendCode');?>",{"phone":phone},function(data){
              alert(data.message);
              console.log(data)
              var timer=setInterval(function(){
                that.attr('id','');
                that.text(num+'s');
                that.addClass('active');
                num--;
                if(num==0){
                  that.attr('id','getCode');
                  clearInterval(timer);
                  that.text('重新发送验证码');
                }
              },1000);
            })
          }
        })
    </script>

</body>

</html>