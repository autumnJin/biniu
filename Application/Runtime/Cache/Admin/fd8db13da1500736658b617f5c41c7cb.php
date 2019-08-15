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
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">会员列表</strong>  <small></small></div>
      </div>
      <hr>
      <form class="am-g" action="<?php echo U('userList');?>" method="get">
        <!--<div class="am-u-sm-12 am-u-md-1">-->
          <!--<div class="am-btn-toolbar">-->
            <!--<div class="am-btn-group am-btn-group-xs">-->
              <!--<a href="<?php echo U('user/userAdd');?>" type="button" class="am-btn am-btn-primary"><span class="am-icon-plus"></span>新增会员</a>-->
            <!--</div>-->
          <!--</div>-->
        <!--</div>-->
        <div class="am-u-sm-12 am-u-md-1">
          <input type="text" class="am-form-field" name="start_time"  value="<?php echo ($start_time); ?>" placeholder="开始时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',readOnly:true})" readonly/>
        </div>
        <div class="am-u-sm-12 am-u-md-1">
          <input type="text" class="am-form-field" name="end_time"  value="<?php echo ($end_time); ?>" placeholder="结束时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',readOnly:true})" readonly/>
        </div>


        <div class="am-u-sm-12 am-u-md-2">
          <div class="am-input-group am-input-group-sm">
            <input type="text" class="am-form-field" name="username" value="<?php echo ($username); ?>" placeholder="用户名精确查找">
          </div>
        </div>
        <!--<div class="am-u-sm-12 am-u-md-2">-->
          <!--<div class="am-input-group am-input-group-sm">-->
            <!--<input type="text" class="am-form-field" name="truename" value="<?php echo ($truename); ?>" placeholder="姓名查找">-->
          <!--</div>-->
        <!--</div>-->
        <?php $level = C('level'); ?>

        <div class="am-u-sm-12 am-u-md-2">
          <div class="am-form-group">
            <select data-am-selected="{btnSize: 'sm'}" name="level">
              <option value="0">会员级别</option>
              <?php if(is_array($level)): $i = 0; $__LIST__ = $level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($level == $key) echo 'selected' ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
          </div>
        </div>



        <div class="am-u-sm-12 am-u-md-1">
          <div class="am-input-group am-input-group-sm">
            <input class="am-btn am-btn-primary" value="搜索" id="search" type="submit"/>
            </span>
          </div>
        </div>

        <div class="am-u-sm-12 am-u-md-1">
          <div class="am-input-group am-input-group-sm">
            <input class="am-btn am-btn-primary" value="导出" type="submit" id="export"/>
            </span>
          </div>
        </div>
      </form>

      <div class="am-g">
        <div class="am-u-sm-12">
          <div class="am-form">
            <table class="am-table am-table-striped am-table-hover table-main">
              <thead>
              <tr>
                <th>序号</th>
                <th class="table-title">用户账号</th>
                <th class="table-title">手机号</th>
                <!--<th class="table-date am-hide-sm-only">姓名</th>-->
                <!--<th class="table-date am-hide-sm-only">微信号</th>-->
                <th class="table-date am-hide-sm-only">会员级别</th>
                <th class="table-date am-hide-sm-only">代理级别</th>
                <th class="table-date am-hide-sm-only">配套等级</th>
                <th class="table-date am-hide-sm-only">IOTE算力</th>
                <!--<th class="table-date am-hide-sm-only">连锁店级别</th>-->
                <th class="table-date am-hide-sm-only">推荐人</th>
                <th class="table-date am-hide-sm-only">充值积分</th>
                <th class="table-date am-hide-sm-only">流通积分</th>
                <th class="table-date am-hide-sm-only">购物积分</th>
                <th class="table-date am-hide-sm-only">兑换积分</th>
                <th class="table-date am-hide-sm-only">IOTE</th>
                <th class="table-date am-hide-sm-only">BTC</th>
                <th class="table-date am-hide-sm-only">USDT</th>
                <th class="table-date am-hide-sm-only">ETH</th>
                <th class="table-date am-hide-sm-only">IOTE奖金</th>
                <th class="table-date am-hide-sm-only">推荐人数</th>
                <!--<th class="table-date am-hide-sm-only">团队人数</th>-->
                <th class="table-date am-hide-sm-only">总业绩</th>
                <th class="table-date am-hide-sm-only">会员私钥</th>
                <th class="table-date am-hide-sm-only">注册时间</th>
                <th class="table-set">操作</th>
              </tr>
              </thead>
              <?php $reg_level = C('level'); $td_level = C('td_level'); $agent_level = C('agent_level'); $center_level = C('center_level'); ?>
              <tbody>
              <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                  <td><?php echo ($key+1); ?></td>
                  <td><?php echo ($vo['username']); ?></td>
                  <td><?php echo ($vo['phone']); ?></td>
                  <!--<td class="am-hide-sm-only"><?php echo ($vo['truename']); ?></td>-->
                  <!--<td class="am-hide-sm-only"><?php echo ($vo['weixin']); ?></td>-->
                  <td><?php echo ($reg_level[$vo['level']]); ?></td>
                  <td><?php echo ($td_level[$vo['td_level']]); ?></td>
                  <td>
                      <?php if($vo["pt_level"] == 1): ?>100USDT配套
                        <?php elseif($vo["pt_level"] == 2): ?>1000USDT配套
                        <?php elseif($vo["pt_level"] == 3): ?>5000USDT配套
                        <?php elseif($vo["pt_level"] == 4): ?>10000USDT配套
                        <?php else: ?>暂无配套<?php endif; ?>
                  </td>
                  <td><?php echo ($vo["z6"]); ?></td>
                  <!--<td><?php echo ($agent_level[$vo['agent_level']]); ?></td>-->
                  <!--<td><?php echo ($center_level[$vo['center_level']]); ?></td>-->
                  <td class="am-hide-sm-only"><?php echo ($vo['higher_name']); ?></td>
                  <td class="am-hide-sm-only"><a href="<?php echo U('rechargeByType',array('id'=>$vo['id'],'type'=>1));?>" title="点击充值"><?php echo ($vo['z1']); ?></a></td>
                  <td class="am-hide-sm-only"><a href="<?php echo U('rechargeByType',array('id'=>$vo['id'],'type'=>2));?>" title="点击充值"><?php echo ($vo['z2']); ?></a></td>
                  <td class="am-hide-sm-only"><a href="<?php echo U('rechargeByType',array('id'=>$vo['id'],'type'=>3));?>" title="点击充值"><?php echo ($vo['z3']); ?></a></td>
                  <td class="am-hide-sm-only"><a href="<?php echo U('rechargeByType',array('id'=>$vo['id'],'type'=>4));?>" title="点击充值"><?php echo ($vo['z4']); ?></a></td>
                  <td class="am-hide-sm-only"><a href="<?php echo U('rechargeByType',array('id'=>$vo['id'],'type'=>5));?>" title="点击充值"><?php echo ($vo['z5']); ?></a></td>
                  <td class="am-hide-sm-only"><a href="<?php echo U('rechargeByType',array('id'=>$vo['id'],'type'=>7));?>" title="点击充值"><?php echo ($vo['z7']); ?></a></td>
                  <td class="am-hide-sm-only"><a href="<?php echo U('rechargeByType',array('id'=>$vo['id'],'type'=>8));?>" title="点击充值"><?php echo ($vo['z8']); ?></a></td>
                  <td class="am-hide-sm-only"><a href="<?php echo U('rechargeByType',array('id'=>$vo['id'],'type'=>9));?>" title="点击充值"><?php echo ($vo['z9']); ?></a></td>
                  <td class="am-hide-sm-only"><?php echo ($vo['z10']); ?></td>
                  <td class="am-hide-sm-only"><?php echo ($vo['tj_count']); ?></td>
                  <!--<td class="am-hide-sm-only"><a href="#" title="点击充值"><?php echo ($vo['tuandui']); ?></a></td>-->
                  <td class="am-hide-sm-only"><?php echo ($vo['zuo_zong']); ?></td>
                  <td class="am-hide-sm-only"><?php echo ($vo['eth_key']); ?></td>


                  <td class="am-hide-sm-only"><?php echo (date("Y-m-d H:i:s",$vo['create_time'])); ?></td>
                  <td>
                    <div class="am-btn-toolbar">
                      <div class="am-btn-group am-btn-group-xs">
                        <a  href="<?php echo U('userEdit',array('id'=>$vo['id']));?>" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>查看详细</a>&nbsp;&nbsp;
                        <?php if($vo['status'] == 1): ?><!--<a  href="javascript:" class="useractive" user_id=<?php echo ($vo['id']); ?> class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>开通</a>--><?php endif; ?>
                        <!--<a  href="<?php echo U('Service/editService',array('id'=>$vo['id']));?>" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 设置商家</a>&nbsp;&nbsp;-->
                        <!--<a  href="<?php echo U('Service/add_daili',array('id'=>$vo['id']));?>" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 设置代理</a>&nbsp;&nbsp;-->
                        <a  href="#" data-id="<?php echo ($vo['id']); ?>" class="am-btn am-btn-default am-btn-xs am-text-secondary change-ps"><span class="am-icon-pencil-square-o"></span>重置登录密码123456</a>&nbsp;&nbsp;
                        <a  href="#" data-id="<?php echo ($vo['id']); ?>" class="am-btn am-btn-default am-btn-xs am-text-secondary change-ps2"><span class="am-icon-pencil-square-o"></span>重置支付密码123456</a>&nbsp;&nbsp;
                        <?php $text = $vo['is_f'] == 1?'冻结':'解封'; ?>
                        <a  href="javascript:" class="dongjie" user_id=<?php echo ($vo['id']); ?> class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span><?php echo ($text); ?></a>
                        <a  href="<?php echo U('userFront',array('id'=>$vo['id']));?>" target="_blank">登入前台</a>&nbsp;&nbsp;
                        <!--<a  href="javascript:" class="del" user_id=<?php echo ($vo['id']); ?> class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>删除</a>-->
                        <?php if($vo['pt_level'] > 0): ?><a  href="javascript:" class="tb" user_id=<?php echo ($vo['id']); ?> class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>退本</a>
                          <?php if($vo['is_open'] == 0): ?><a  href="javascript:" class="open" user_id=<?php echo ($vo['id']); ?> class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>配套激活</a>
                            <a  href="javascript:" class="back" user_id=<?php echo ($vo['id']); ?> class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>取消激活</a><?php endif; endif; ?>

                      </div>
                    </div>
                  </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
              </tbody>
            </table>

            <div class="am-cf">
              共 <?php echo ($count); ?> 条记录
              <div class="am-fr">
                <ul class="am-pagination">
                  <?php echo ($show); ?>
                </ul>
              </div>
            </div>
            <hr />
        </div>
                      <style>
                        .admin-content{
                          overflow-x: scroll;
                        }
                        .admin-content::-webkit-scrollbar{
                          display: block;
                        }
                        .admin-content::-webkit-scrollbar-thumb{
                          background-color: #aaaaaa;
                        }
                      </style>
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



  <script>
    $(function () {
        var url = "<?php echo U('activeUser');?>";
        $('.useractive').click(function () {
            $.post(url,{user_id:$(this).attr('user_id')},function (data) {
                layer.msg(data.msg,{time:1000},function () {
                    if(data.code){
                        return false;
                    }else{
                        window.location.href="<?php echo U('User/userList');?>";
                    }
                })
            },'json')
        });


        var url1 = "<?php echo U('dongjie');?>";
        $('.dongjie').click(function () {
            $.post(url1,{id:$(this).attr('user_id')},function (data) {
                layer.msg(data.msg,{time:1000},function () {
                    if(data.code){
                        return false;
                    }else{
                        window.location.href=data.data;
                    }
                })
            },'json')
        });

        $('#pro').change(function(){
            $.ajax({
                type:"post",
                url:"<?php echo U('Public/area_choose');?>",
                data:'pro_id='+$('#pro').val(),
                dataType:"json",
                success:function(data){
                    $('#city').html(data);
                }
            });
        });

        var searchurl = "<?php echo U('userList');?>";
        $('#search').click(function () {

            $('form').attr('action',searchurl);
        });

        //重置密码
        $('.change-ps').click(function(){
            $.ajax({
                type:"post",
                url:"<?php echo U('changePassword');?>",
                data: {
                    'userId': $(this).attr('data-id')
                },
                dataType:"json",
                success:function(data){
                    alert(data.msg);
                    if(data.code == 1)
                    {
                        window.location.reload();
                    }
                }
            });
        });

      //重置支付密码
      $('.change-ps2').click(function(){
        $.ajax({
          type:"post",
          url:"<?php echo U('changePassword2');?>",
          data: {
            'userId': $(this).attr('data-id')
          },
          dataType:"json",
          success:function(data){
            alert(data.msg);
            if(data.code == 1)
            {
              window.location.reload();
            }
          }
        });
      });

        var exporturl = "<?php echo U('exportuser');?>";
        $('#export').click(function () {

            $('form').attr('action',exporturl);
        });

        var url11 = "<?php echo U('deleteUser');?>";
        $('.del').click(function () {

            if(confirm('确认删除此会员吗?')){
                $.post(url11,{id:$(this).attr('user_id')},function (data) {
                    layer.msg(data.msg,{time:1000},function () {
                        if(data.code){
                            return false;
                        }else{
                            window.location.href=data.data;
                        }
                    })
                },'json')
            }
        });

      var url12 = "<?php echo U('backPT');?>";
      $('.tb').click(function () {
        if(confirm('确认此会员退本吗?')){
          $.post(url12,{id:$(this).attr('user_id')},function (data) {
            layer.msg(data.msg,{time:1000},function () {
              if(data.code){
                return false;
              }else{
                window.location.href=data.data;
              }
            })
          },'json')
        }
      });

      var url13 = "<?php echo U('MachineOpen');?>";
      $('.open').click(function () {
        if(confirm('确认激活码吗?')){
          $.post(url13,{id:$(this).attr('user_id')},function (data) {
            layer.msg(data.msg,{time:1000},function () {
              if(data.code){
                return false;
              }else{
                window.location.href=data.data;
              }
            })
          },'json')
        }
      });

      var url14 = "<?php echo U('MachineBack');?>";
      $('.back').click(function () {
        if(confirm('确认取消激活码吗?')){
          $.post(url14,{id:$(this).attr('user_id')},function (data) {
            layer.msg(data.msg,{time:1000},function () {
              if(data.code){
                return false;
              }else{
                window.location.href=data.data;
              }
            })
          },'json')
        }
      });
    })
  </script>

</body>
</html>