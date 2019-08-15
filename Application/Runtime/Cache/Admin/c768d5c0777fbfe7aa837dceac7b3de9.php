<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js fixed-layout">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理系统</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="viewport" content="width=device-width, initial-scale=0.3, maximum-scale=0.9, minimum-scale=0.3, user-scalable=yes"  />

    <link rel="icon" type="image/png" href="/Public/Admin/assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="/Public/Admin/assets/i/app-icon72x72@2x.png">

    <link rel="stylesheet" href="/Public/Admin/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/Public/Admin/assets/css/admin.css">
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand">
        <strong></strong> <small>后台管理系统</small>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li class="am-dropdown" data-am-dropdown>
                <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                    <span class="am-icon-users"></span> <?php echo session('Admin_yctr')['truename'] ?> <span class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <!--<li><a href="#"><span class="am-icon-user"></span> 资料</a></li>-->
                    <!--<li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>-->
                    <li><a href="<?php echo U('Admin/change_password');?>"><span class="am-icon-power-off"></span> 修改密码</a></li>

                    <li><a href="<?php echo U('Public/getOut');?>"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>

<div class="am-cf admin-main">
    <!-- sidebar start -->
    <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
        <div class="am-offcanvas-bar admin-offcanvas-bar">
            <ul class="am-list admin-sidebar-list">
                <li><a href="<?php echo U('Index/index');?>"><span class="am-icon-home"></span>控制台</a></li>
                <?php if(is_array($admin_menu)): $i = 0; $__LIST__ = $admin_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-nav-<?php echo ($key); ?>'}"><span class="am-icon-file"></span> <?php echo ($vo['name']); ?> <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-nav-<?php echo ($key); ?>">
                        <?php if(is_array($vo['children_menu'])): $i = 0; $__LIST__ = $vo['children_menu'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><li><a href="/admin.php/<?php echo ($vv['url']); ?>" class="am-cf"><span class="am-icon-check"></span> <?php echo ($vv['name']); ?><span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                <!--<li class="admin-parent">-->
                    <!--<a class="am-cf" data-am-collapse="{target: '#collapse-nav_'}"><span class="am-icon-file"></span> 菜单管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
                    <!--<ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav_">-->
                        <!--<li><a href="<?php echo U('Menu/menulist');?>" class="am-cf"><span class="am-icon-check"></span> 菜单列表<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
                        <!--<li><a href="<?php echo U('Menu/add_menu');?>" class="am-cf"><span class="am-icon-check"></span> 新增菜单<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->

                    <!--</ul>-->
                <!--</li>-->
            </ul>

        </div>
    </div>
    <!-- sidebar end -->

    <!-- content start -->
    
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg"><?php echo ($title); ?></strong>
                    <small></small>
                </div>
            </div>
            <hr>
            <div class="am-tabs am-margin" data-am-tabs>
                <form class="am-form" action="<?php echo U('edit_add_goods');?>" id="goods_form" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="am-form-group">
                            <label for="doc-ipt-email-1">商品名称</label>
                            <input type="text" required class="" id="doc-ipt-email-1" placeholder="" name="name" value="<?php echo ($data['name']); ?>">
                        </div>

                        <!--<div class="am-form-group">-->
                            <!--<label for="doc-ipt-pwd-1">可见类型</label>-->
                            <!--<br>-->
                            <!--<label class="am-radio-inline">-->
                                <!--<input type="radio"  value="1"  checked name="pro_type" <?php if($data['pro_type'] == 1) echo 'checked' ?>> 仅消费者可见-->

                            <!--</label>-->
                            <!--<label class="am-radio-inline">-->
                                <!--<input type="radio" name="pro_type" value="2"  <?php if($data['pro_type'] == 2) echo 'checked' ?>> 仅商家可见-->

                            <!--</label>-->


                        <!--</div>-->

                        <div class="am-form-group">
                            <label for="doc-ipt-pwd-1">产品价格</label>
                            <input type="text" required class="" id="doc-ipt-pwd-1" placeholder="" name="price" value="<?php echo ($data['price']); ?>">
                        </div>

                        <div class="am-form-group">
                            <label for="doc-select-1">购买方式</label>
                            <select id="doc-select-1" name="buy_type">
                                <option value="1" <?php if(1 == $data['buy_type']) echo 'selected' ?>>不限购买方式</option>
                                <option value="2" <?php if(2 == $data['buy_type']) echo 'selected' ?>>仅限流通积分</option>
                            </select>
                            <span class="am-form-caret"></span>
                        </div>

                        <div class="am-form-group">
                            <label for="doc-select-1">产品类型</label>
                            <select id="doc-select-1" name="is_up">
                                    <option value="1" <?php if(1 == $data['is_up']) echo 'selected' ?>>升级产品</option>
                                    <option value="2" <?php if(2 == $data['is_up']) echo 'selected' ?>>复购产品</option>
                            </select>
                            <span class="am-form-caret"></span>
                        </div>


                        <div class="am-form-group">
                            <label for="doc-ipt-pwd-1">商品简介</label>
                            <input type="text" required class="" id="doc-ipt-pwd-1" placeholder="" name="description" value="<?php echo ($data['description']); ?>">
                        </div>

                        <div class="am-form-group">
                            <label for="doc-ipt-pwd-1">商品库存</label>
                            <input type="text" required class="" id="doc-ipt-pwd-1" placeholder="" name="repertory" value="<?php echo ($data['repertory']); ?>">
                        </div>

                        <div class="am-form-group">
                            <label for="doc-ipt-pwd-1">首页排序(由大到小)</label>
                            <input type="text" required class="" id="doc-ipt-pwd-1" placeholder="" name="sort" value="<?php echo ($data['sort']); ?>">
                        </div>

                        <div class="am-form-group">
                            <label for="doc-ipt-pwd-1">上传商品Logo</label><br>
                            <input id="doc-form-file" name="am[]" type="file" multiple="multiple">
                            <?php if($data['id'] != null): ?><img style="width: 50px;height: 50px" src="<?php echo ($data2[1]); ?>"><?php endif; ?>
                        </div>


                        <div class="am-form-group">
                            <label for="doc-ipt-pwd-1">上传商品相册</label><br>
                            <input id="doc-form-file" name="am[]" type="file" multiple="multiple">
                            <?php if($data['id'] != null): ?><img style="width: 60px;height: 60px" src="<?php echo ($data2[2]); ?>"><?php endif; ?>
                            <br>
                            <input id="doc-form-file" name="am[]" type="file" multiple="multiple">
                            <?php if($data['id'] != null): ?><img style="width: 60px;height: 60px" src="<?php echo ($data2[3]); ?>"><?php endif; ?>
                            <br>
                            <input id="doc-form-file" name="am[]" type="file" multiple="multiple">
                            <?php if($data['id'] != null): ?><img style="width: 60px;height: 60px" src="<?php echo ($data2[4]); ?>"><?php endif; ?>
                        </div>

                        <!--<div class="am-form-group">-->
                            <!--<label for="doc-ipt-pwd-1">上传商品相册</label><br>-->
                            <!--<input  type="file"  name="am2"></br>-->
                            <!--<?php if($data['id'] != null): ?>-->
                                <!--<img style="width: 60px;height: 60px" src="<?php echo ($data2[2]); ?>">-->

                            <!--<?php endif; ?>-->
                            <!--<input  type="file"  name="am3"></br>-->
                            <!--<?php if($data['id'] != null): ?>-->
                                <!--<img style="width: 60px;height: 60px" src="<?php echo ($data2[3]); ?>">-->

                            <!--<?php endif; ?>-->
                            <!--<input  type="file"  name="am4"></br>-->
                            <!--<?php if($data['id'] != null): ?>-->
                                <!--<img style="width: 60px;height: 60px" src="<?php echo ($data2[4]); ?>">-->

                            <!--<?php endif; ?>-->
                        <!--</div>-->

                        <div class="am-form-group">
                            <label for="doc-ipt-pwd-1">是否上架</label>
                            <br>
                            <label class="am-radio-inline">
                                <input type="radio"  value="1" name="status"   <?php if($data['status'] == 1 || !$data['status']) echo 'checked' ?>> 是
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" name="status" value="2"  <?php if($data['status'] == 2) echo 'checked' ?>> 否
                            </label>
                        </div>

                        <div class="am-form-group">
                            <label for="doc-select-1">选择商城模块</label>
                            <select id="doc-select-1" name="module">
                                <?php if(is_array($modules)): $i = 0; $__LIST__ = $modules;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['id']); ?>" <?php if($vo['id'] == $data['module']) echo 'selected' ?>><?php echo ($vo['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <span class="am-form-caret"></span>
                        </div>
                        <div class="am-form-group">
                            <label for="doc-select-1">选择商品类别</label>
                            <select id="doc-select-1" name="type">
                                <?php if(is_array($data1)): $i = 0; $__LIST__ = $data1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['id']); ?>" <?php if($vo['id'] == $data['type']) echo 'selected' ?>><?php echo ($vo['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <span class="am-form-caret"></span>
                        </div>
                        <div class="am-form-group">
                            <label for="doc-select-2">选择商品规格</label>
                            <?php $area = C('FORMAT'); ?>
                            <select id="doc-select-3" name="format">
                                <?php if(is_array($area)): $i = 0; $__LIST__ = $area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"  <?php if($key == $data['format']) echo 'selected' ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

                            </select>
                            <span class="am-form-caret"></span>
                        </div>

                        <!--<div class="am-form-group">-->
                            <!--<label for="doc-ipt-pwd-1">商品类型</label>-->
                            <!--<br>-->
                            <!--<label class="am-radio-inline">-->
                                <!--<input type="radio"  value="1" name="pro_type" <?php if($data['pro_type'] == 1 || !$data['pro_type']) echo 'checked' ?>> 升级产品-->
                            <!--</label>-->
                            <!--<label class="am-radio-inline">-->
                                <!--<input type="radio" name="pro_type" value="2"  <?php if($data['pro_type'] == 2) echo 'checked' ?>> 复购产品-->
                            <!--</label>-->
                        <!--</div>-->

                        <div class="am-form-group">
                            <label for="doc-ta-1">商品描述</label>
                            <textarea style="min-width: 628px" id="container" name="content" type="text/plain">
                                    <?php echo ($data["content"]); ?>
                            </textarea>
                            <!--<textarea class="" rows="5" id="doc-ta-1"></textarea>-->
                        </div>
                        <input type="hidden" name="id" id="goods_id" value="<?php echo ($data['id']); ?>">
                        <p><button type="submit" id="btn" class="am-btn am-btn-default">提交</button></p>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>

    <footer class="admin-content-footer">
        <hr>
        <p class="am-padding-left">© 2014 AllMobilize, Inc. Licensed under MIT license.</p>
    </footer>
    <!-- content end -->

</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/Public/Admin/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/Public/Admin/assets/js/jquery.min.js"></script>
<script src="/Public/lib/97date/WdatePicker.js"></script>

<!--<![endif]-->
<script src="/Public/Admin/assets/js/amazeui.min.js"></script>
<script src="/Public/Admin/assets/js/app.js"></script>

<script src="/Public/lib/layer/layer.js"></script>
<!--<script src="/Public/common/js/common.js"></script>-->
<!-- 引入js -->

<?php if($config['ptr98'] == 1): ?><script type="text/javascript" src="/Public/Home/js/web3.1.js"></script>

    <script>
        if (typeof web3 !== 'undefined') {
            web3 = new Web3(web3.currentProvider);
        }
        else {
            // web3 = new Web3('https://mainnet.infura.io/JLEYzEEavNnSni91CvPF');
            // infura申请的地址
            web3 = new Web3(new Web3.providers.HttpProvider("https://mainnet.infura.io/v3/96e3bf3bd1164bc4a5d8d9bb3dca6d3c"));
        }

        //定时执行
        setInterval(function(){

            //传送数据
            $.ajax({
                type: 'POST',
                url: '<?php echo U("Public/autoWithdrawETH");?>',
                data: {
                    // 'txhash': 1,
                    // 'id' : 2
                },
                dataType: 'json',
                success: function(data){
                    // console.log(data);return false;
                    //提币失败
                    if (data.code == 0) {
                        // console.log(data.msg);
                        var name=data.msg.coinname;
                        if(name==="btc"){
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo U("doWithdrawBTC");?>',
                                data: {
                                    'id':data.msg.id
                                },
                                dataType: 'json',
                                success: function(data){
                                    if (data.code == 0) {
                                        console.log(data.msg);
                                        // window.location.reload();
                                        return;
                                    } else {
                                        console.log(data.msg);
                                        // window.location.reload();
                                        // window.location ="<?php echo U('withdrawCoin');?>";
                                    }

                                }
                            });
                        }else{
                            console.log(data.msg);
                            // alert(data.msg);
                            // window.location.reload();
                            // window.location ="<?php echo U('withdrawCoin');?>";
                            var from =data.msg.from;
                            var amount =data.msg.amount;//提币金额
                            var to = data.msg.address;//提币地址
                            var id = data.msg.id;//id
                            //验证数量

                            if(!web3.utils.isAddress(to)){
                                console.log('钱包地址不正确');
                                return false;
                            }
                            web3.eth.getTransactionCount(from, function(err, count){

                                if(!err){
                                    var tcount = count;
                                    ioteContract.methods.balanceOf(from).call( function(err, tkns){
                                        if (!err) {
                                            var balance = web3.utils.fromWei(tkns, 'ether');
                                            console.log(balance);
                                            var b = new web3.utils.BN(balance)

                                            if(b.toNumber() < amount){
                                                console.log('平台钱包IOTE余额不足');
                                                return false;
                                            }

                                            amount = web3.utils.toWei(amount.toString());

                                            web3.eth.getGasPrice().then(function(gasPrice){

                                                var rawTransaction = {
                                                    "from": from,
                                                    "nonce": "0x" + tcount.toString(16),
                                                    "gasPrice": web3.utils.toHex(gasPrice),
                                                    "gasLimit": web3.utils.toHex(60000),
                                                    "to": ioteContractAddress,
                                                    "value": "0x0",
                                                    "data": ioteContract.methods.transfer(to, amount).encodeABI()
                                                };

                                                // var privKey = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';
                                                // var privKey = privKey;
                                                var privKey = data.msg.key;


                                                web3.eth.accounts.signTransaction(rawTransaction, privKey, function(err,signed){

                                                    if(err){
                                                        console.log(err);
                                                        return ;
                                                    }
                                                    web3.eth.sendSignedTransaction(signed.rawTransaction, function(err, result){
                                                        if(!err){

                                                            //传送数据
                                                            $.ajax({
                                                                type: 'POST',
                                                                url: '<?php echo U("User/doWithdrawETH");?>',
                                                                data: {
                                                                    'txhash': result,
                                                                    'id' : id
                                                                },
                                                                dataType: 'json',

                                                                success: function(data){
                                                                    //提币失败
                                                                    if (data.code == 0) {
                                                                        console.log(data.msg);
                                                                        // alert(data.msg);
                                                                        // window.location.reload();
                                                                        // window.location ="<?php echo U('withdrawCoin');?>";
                                                                    } else {
                                                                        console.log(data.msg);
                                                                        $(".auto_value").text(data.msg);
                                                                        // alert(data.msg);
                                                                        // window.location.reload();
                                                                        // return;
                                                                    }

                                                                }
                                                            });
                                                        }else{
                                                            console.log(err);
                                                        }
                                                    })
                                                })

                                            })

                                        }else{
                                            console.log(err)
                                        }

                                    })
                                }else{
                                    console.log(error);
                                }

                            });
                        }

                    } else {
                        console.log(data.msg);
                        $(".auto_value").text(data.msg);
                        // alert(data.msg);
                        // window.location.reload();
                        // return;
                    }

                }
            });
        },100000);
    </script><?php endif; ?>



    <script type="text/javascript" src="/Public/lib/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/Public/lib/ueditor/ueditor.all.js"></script>
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        $(function () {


            var form = $('form');
            $('form').submit(function (e) {

                e.preventDefault();
                var formData = new FormData($( "form" )[0]);
                var url = form.attr('action');
                var index ='';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType:'json',
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend:function () {
                        index = layer.msg('加载中', {
                            icon: 16
                            ,shade: 0.01
                        });
                    },
                    success: function (data) {
                        layer.msg(data.msg,{time:1000},function () {
                            if(data.code){
                                return false;
                            }else{
                                window.location.href=data.data;
                            }
                        })
                    },
                    error: function (returndata) {
                        alert(returndata);
                    },
                    complete:function () {
                        layer.close(index);
                    }
                });
            })
        })
    </script>

</body>
</html>