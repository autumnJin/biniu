<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=\, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>充币</title>
  <link rel="stylesheet" href="/Public/Home/css/ming_common.css">
  <link rel="stylesheet" href="/Public/Home/css/ming.css">
</head>

<body>
  <header class="header">
    <a href='javascript:history.back(-1)'><img src="http://hb90508.zhongbkj.com/Public/Home/images/Return.png"
        alt=""></a>
    <p>充币</p>
    <span class="kongge"></span>
  </header>

    <?php if($isAddress == 1): ?><section class="zhuanzhang">
            <div class="chongzhi">
                <div class="copy_btn"  id="addr">点击生成充币地址</div>
            </div>
        </section>

    <?php else: ?>

    <section class="zhuanzhang">
    <div class="zhuanzhang_choose">
        <select name="" id="charge">
            <option value="1">BTC</option>
            <option value="2">ETH</option>
            <option value="3">USDT</option>
            <option value="6">USDT_OMNI</option>
            <!--<option value="4">WFX</option>-->
            <option value="4">IOTE</option>
          </select>

    </div>
    <div class="chongzhi">
      <div id="codeaa"></div>
      <input type="text" id="copyVal" readonly value="<?php echo ($coinAddress); ?>">
      <div class="copy_btn" style="cursor: pointer" onclick="" data-clipboard-target="#copyVal">点击复制地址</div>
      <div class="copy_msg">
        提示：请不要向上述的地址充值任何非<span id="coin" style="color: red;">ETH</span>资产，否则资产将无法找回。
      </div>
    </div>
    </section><?php endif; ?>

    <style>
      .zhuanzhang_choose select{
        width: 100%;
        font-size: .3rem;
      }
      .zhuanzhang_choose{
        overflow: hidden;
      }
      #codeaa{
        display: flex;
        justify-content: center;
      }
    </style>



    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script src="/Public/Home/js/jquery.qrcode.min.js"></script>

<!--     <script type="text/javascript">

        $.ajax({

                type : 'POST',
                url:"<?php echo U('Property/zhuanshou');?>",
                dataType : 'json',
                data:{
                    coinname:1,
                },
                success : function(data){

                    if(data.code == 1){
                        //alert(data.msg);
                    }else
                    {
                        alert(data.data);
                    }
                }
            })


    </script> -->

    <script>
      var copyBtn = new ClipboardJS('.copy_btn');
      copyBtn.on("success",function(e){
          alert('复制成功');
          e.clearSelection();
      });
      copyBtn.on("error",function(e){
          //复制失败；
          alert('复制失败');
      });

    $('#codeaa').qrcode({
        render:'table',
        text:"<?php echo ($coinAddress); ?>",
        size: "150"

    });

    </script>

    <!-- 获取地址 -->
    <script type="text/javascript">

        $('#charge').change(function(){
            $("#codeaa div").remove()
            //生成BTC地址
            var coinname = $("#charge").val();
            //传输数据
            $.ajax({
                type : 'POST',
                url:"<?php echo U('Property/coinName');?>",
                dataType : 'json',
                data:{
                    coinname:coinname,
                },
                success : function(data){

                    if(data.code == 1){
                        //alert(data.msg);
                    }else
                    {
                        $("#copyVal").val(data.data);

                        $("#coin").text(data.msg);

                        $('#codeaa').qrcode({
                            render:'table',
                            text:data.data,
                            size: "150"

                        });
                    }
                }
            })
        });
    </script>


    <!-- 引入js -->
    <script type="text/javascript" src="/Public/Home/js/web3.1.js"></script>

    <!-- 生成钱包地址 -->
    <script type="text/javascript">

        if (typeof web3 !== 'undefined') {
            web3 = new Web3(web3.currentProvider);
        }
        else {
            web3 = new Web3('https://mainnet.infura.io/JLEYzEEavNnSni91CvPF');
        }


        $('#addr').click(function(){

            //生成BTC地址

            //传输数据
            $.ajax({

                type : 'POST',
                url:"<?php echo U('Property/btcAddress');?>",
                dataType : 'json',
                data:{
                    coinname:'btc',
                },
                success : function(data){

                    if(data.code == 1){
                        alert(data.msg);
                        setTimeout(function(){ window.location.reload(); }, 1000);
                    }else
                    {
                        alert(data.msg);
                        setTimeout(function(){ window.location.reload(); }, 1000);
                        //window.location.reload();
                    }
                }
            })


            //生成ETH地址

            function RndNum(n){
                var rnd="";
                for(var i=0;i<n;i++)
                    rnd+=Math.floor(Math.random()*10);
                return rnd;
            }

            var password = RndNum(8);
            var account = web3.eth.accounts.create(password);
            var key = account.privateKey;
            var address = account.address;

            //传输数据
            $.ajax({
                type : 'POST',
                url:"<?php echo U('Property/ethAddress');?>",
                dataType : 'json',
                data:{
                    address:address,
                    key:key
                },
                success : function(data){

                    if(data.code == 1){
                        alert(data.msg);
                        setTimeout(function(){ window.location.reload(); }, 1000);
                    }else
                    {
                        alert(data.msg);
                        setTimeout(function(){ window.location.reload(); }, 1000);
                    }
                }
            })



        });


    </script>

</body>
</html>