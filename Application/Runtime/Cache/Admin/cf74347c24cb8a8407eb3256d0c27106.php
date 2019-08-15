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
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">提币管理</strong>  <small></small></div>
            </div>

            <hr>

            <form class="am-g" action="<?php echo U();?>" method="get">
                <select data-am-selected="{btnSize: 'sm'}" name="status">
                    <option value="0" <?php if($status == "") echo 'selected' ?>>全部</option>
                    <option value="2" <?php if($status == 2) echo 'selected' ?>>待审核</option>
                    <option value="1" <?php if($status == 1) echo 'selected' ?>>已完成</option>
                    <option value="3" <?php if($status == 3) echo 'selected' ?>>已驳回</option>
                </select>

                <input type="text" class="" name="phone" value="<?php echo ($phone); ?>"  placeholder="手机号查询">
                <button class="am-btn am-btn-primary" type="submit">搜索</button>
                <!-- <div class="am-u-sm-12 am-u-md-1">
                  <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                      <a href="<?php echo U('user/exportOrder');?>" type="button" class="am-btn am-btn-primary"><span class="am-icon-plus"></span>提现未处理</a>
                    </div>
                  </div>

                </div>
                <div class="am-u-sm-12 am-u-md-1">
                  <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                      <a href="<?php echo U('user/exportOrder1');?>" type="button" class="am-btn am-btn-primary"><span class="am-icon-plus"></span>提现已处理</a>
                    </div>
                  </div>

                </div> -->
                <!--   <div class="am-u-sm-12 am-u-md-2">
                    <input type="text" class="am-form-field" name="start_time"  value="<?php echo ($start_time); ?>" placeholder="开始时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',readOnly:true})" readonly/>
                  </div>
                  <div class="am-u-sm-12 am-u-md-2">
                    <input type="text" class="am-form-field" name="end_time"  value="<?php echo ($end_time); ?>" placeholder="结束时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',readOnly:true})" readonly/>
                  </div>
                  <div class="am-u-sm-12 am-u-md-2">
                    <div class="am-input-group am-input-group-sm">
                      <input type="text" class="am-form-field" name="username" value="<?php echo ($username); ?>" placeholder="会员用户名">
                    </div>
                  </div>
                  <div class="am-u-sm-12 am-u-md-2">
                    <div class="am-form-group">
                      <select data-am-selected="{btnSize: 'sm'}" name="status">
                        <option value="2" <?php if($status == 2) echo 'selected' ?>>待审核</option>
                        <option value="1" <?php if($status == 1) echo 'selected' ?>>已完成</option>
                        <option value="3" <?php if($status == 3) echo 'selected' ?>>已驳回</option>
                      </select>
                    </div>-->
                <!--</div>-->

                <!-- <div class="am-u-sm-12 am-u-md-2">
                  <div class="am-input-group am-input-group-sm">

                    <span class="am-input-group-btn">
                    <button class="am-btn am-btn-primary" type="submit">搜索</button>
                  </span>
                  </div>
                </div> -->
                        <input class="am-btn am-btn-primary" value="导出" type="submit" id="export"/>
            </form>
            <div>
                <div>btc余额：<?php echo ($balance); ?></div>
                <div class="x123">
                    复审钱包地址：0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16
                    ——ETH余额：<span class="eth_ll"></span>
                    ——USDT余额： <span class="usdt_ll"></span>
                    ——IOTE余额： <span class="iote_ll"></span>
                </div>
                <div class="x123">
                    钱包地址：0x35a9FD0Cf8ADc77452E946AFED3518184C2D15D1
                    ——ETH余额：<span class="eth_ll"></span>
                    ——USDT余额： <span class="usdt_ll"></span>
                    ——IOTE余额： <span class="iote_ll"></span>
                </div>
                <div class="x123">
                    钱包地址：0x19A5219F54c436C426a50461Ebc4a68a3B00beD8
                    ——ETH余额：<span class="eth_ll"></span>
                    ——USDT余额： <span class="usdt_ll"></span>
                    ——IOTE余额： <span class="iote_ll"></span>
                </div>
                <div class="x123">
                    钱包地址：0x48211ebc204DaFa0f5FB7AD7b26667F9F7764319
                    ——ETH余额：<span class="eth_ll"></span>
                    ——USDT余额： <span class="usdt_ll"></span>
                    ——IOTE余额： <span class="iote_ll"></span>
                </div>
                <div class="x123">
                    钱包地址：0x28A0D357770AA0fa4C7e9F9e7F6227aBD64EB312
                    ——ETH余额：<span class="eth_ll"></span>
                    ——USDT余额： <span class="usdt_ll"></span>
                    ——IOTE余额： <span class="iote_ll"></span>
                </div>
                <div class="x123">
                    钱包地址：0xA55e379c75E2698a7e542c50D36807e2407dce72
                    ——ETH余额：<span class="eth_ll"></span>
                    ——USDT余额： <span class="usdt_ll"></span>
                    ——IOTE余额： <span class="iote_ll"></span>
                </div>
                <div class="x123">
                    钱包地址：0x9e63f8300C502E037BA66752eDC8e1234C445Ec3
                    ——ETH余额：<span class="eth_ll"></span>
                    ——USDT余额： <span class="usdt_ll"></span>
                    ——IOTE余额： <span class="iote_ll"></span>
                </div>
                <!--<div class="x123">-->
                    <!--IOTE钱包地址：0x79A571a1D192Ad5F58b2cF8CA7Bc8315C4a4fb2a-->
                    <!--——ETH余额：<span class="eth_ll"></span>-->
                    <!--——USDT余额： <span class="usdt_ll"></span>-->
                    <!--——IOTE余额： <span class="iote_ll"></span>-->
                <!--</div>-->

            </div>

            <button class="am-btn am-btn-primary yijian">一键通过</button>
            <span class="auto_value"></span>
            <div class="am-g">
                <div class="am-u-sm-12">
                    <div class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="all"></th>
                                <th class="table-title">序号</th>
                                <th class="table-set">操作</th>
                                <th class="table-title">账户名</th>
                                <th class="table-title">手机号</th>
                                <th class="table-type">币种名称</th>
                                <th class="table-type">提币地址</th>
                                <th class="table-type">充币数量</th>
                                <th class="table-type">交易hash</th>
                                <!-- <th class="table-type">到账金额</th> -->
                                <th class="table-type">状态</th>
                                <th class="table-type">手续费</th>
                                <!--                 <th class="table-author am-hide-sm-only">银行卡号</th>
                                                <th class="table-date am-hide-sm-only">开户银行</th>
                                                <th class="table-date am-hide-sm-only">银行支行</th>
                                                <th class="table-date am-hide-sm-only">持卡人</th>
                                                <th class="table-date am-hide-sm-only">微信</th>
                                                <th class="table-date am-hide-sm-only">支付宝</th> -->
                                <th class="table-date am-hide-sm-only">提交时间</th>
                                <th class="table-date am-hide-sm-only">确认时间</th>
                                <th class="table-date am-hide-sm-only">平台钱包</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php if(empty($data)): ?><tr>
                                    <td>暂无数据</td>
                                </tr><?php endif; ?>
                            <?php $tixian = C('WITHDRAW_STATUS'); $type = C('account_type'); ?>
                            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                    <td>
                                        <?php if($vo["status"] == 2): ?><input type="checkbox" class="every" id="<?php echo ($vo["id"]); ?>" value="<?php echo ($vo["id"]); ?>" coin="<?php echo ($vo["coinname"]); ?>" n="<?php echo ($vo["address"]); ?>" x="<?php echo ($vo["id"]); ?>" m="<?php echo ($vo["amount"]); ?>"><?php endif; ?>
                                    </td>
                                    <td><?php echo ($vo['id']); ?></td>
                                    <td>
                                        <?php if($vo['status'] == 2): ?><!-- 操作BTC -->
                                            <?php if($vo['status'] == 2 AND $vo['coinname'] == btc): ?><div class="am-dropdown" data-am-dropdown="">

                                                    <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle=""><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>

                                                    <ul class="am-dropdown-content">

                                                        <li class="tbtc" id="<?php echo ($vo['id']); ?>"><a href="#">待审核</a></li>

                                                        <li><a href="<?php echo U('doReject',array('id'=>$vo['id'],'status'=>3,'userid'=>$vo['userid'],'amount'=>$vo['amount'],'coinname'=>$vo['coinname']));?>">待驳回</a></li>

                                                    </ul>

                                                </div><?php endif; ?>

                                            <!-- 操作ETH -->
                                            <?php if($vo['status'] == 2 AND $vo['coinname'] == eth): ?><div class="am-dropdown" data-am-dropdown="">

                                                    <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle=""><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>

                                                    <ul class="am-dropdown-content">

                                                        <li class="teth" id="<?php echo ($vo['id']); ?>" m="<?php echo ($vo["amount"]); ?>" n="<?php echo ($vo["address"]); ?>" x="<?php echo ($vo["id"]); ?>"><a href="#">待审核</a></li>

                                                        <li><a href="<?php echo U('doReject',array('id'=>$vo['id'],'status'=>3,'userid'=>$vo['userid'],'amount'=>$vo['amount'],'coinname'=>$vo['coinname']));?>">待驳回</a></li>

                                                    </ul>

                                                </div><?php endif; ?>

                                            <!-- 操作USDT -->

                                            <?php if($vo['status'] == 2 AND $vo['coinname'] == usdt): ?><div class="am-dropdown" data-am-dropdown="">

                                                    <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle=""><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>

                                                    <ul class="am-dropdown-content">

                                                        <li class="tusdt" id="<?php echo ($vo['id']); ?>" m="<?php echo ($vo["amount"]); ?>" n="<?php echo ($vo["address"]); ?>" x="<?php echo ($vo["id"]); ?>"><a href="#">待审核</a></li>

                                                        <li><a href="<?php echo U('doReject',array('id'=>$vo['id'],'status'=>3,'userid'=>$vo['userid'],'amount'=>$vo['amount'],'coinname'=>$vo['coinname']));?>">待驳回</a></li>

                                                    </ul>

                                                </div><?php endif; ?>


                                            <!-- 操作iote -->

                                            <?php if($vo['status'] == 2 AND $vo['coinname'] == iote): ?><div class="am-dropdown" data-am-dropdown="">

                                                    <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle=""><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>

                                                    <ul class="am-dropdown-content">

                                                        <li class="tiote" id="<?php echo ($vo['id']); ?>" m="<?php echo ($vo["amount"]); ?>" n="<?php echo ($vo["address"]); ?>" x="<?php echo ($vo["id"]); ?>"><a href="#">待审核</a></li>

                                                        <li><a href="<?php echo U('doReject',array('id'=>$vo['id'],'status'=>3,'userid'=>$vo['userid'],'amount'=>$vo['amount'],'coinname'=>$vo['coinname']));?>">待驳回</a></li>

                                                    </ul>

                                                </div><?php endif; ?>

                                            <!-- 操作iote -->

                                            <?php if($vo['status'] == 2 AND $vo['coinname'] == 'iote奖金'): ?><div class="am-dropdown" data-am-dropdown="">

                                                    <button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle=""><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>

                                                    <ul class="am-dropdown-content">

                                                        <li class="tiote" id="<?php echo ($vo['id']); ?>" m="<?php echo ($vo["amount"]); ?>" n="<?php echo ($vo["address"]); ?>" x="<?php echo ($vo["id"]); ?>"><a href="#">待审核</a></li>

                                                        <li><a href="<?php echo U('doReject',array('id'=>$vo['id'],'status'=>3,'userid'=>$vo['userid'],'amount'=>$vo['amount'],'coinname'=>$vo['coinname']));?>">待驳回</a></li>

                                                    </ul>

                                                </div><?php endif; ?>

                                            <?php else: ?>
                                            ---<?php endif; ?>
                                    </td>
                                    <td><?php echo ($vo['username']); ?></td>
                                    <td><a href="#"><?php echo ($vo['phone']); ?></a></td>
                                    <td><a href="#"><?php echo (strtoupper($vo['coinname'])); ?></a></td>
                                    <!--<td><a href="#"><?php echo ($vo['address']); ?></a></td>-->

                                    <?php if($vo['coinname'] != btc): ?><td><a href="https://etherscan.io/address/<?php echo ($vo['address']); ?>" target="_blank">
                                            <?php echo ($vo['address']); ?></a></td>
                                        <?php else: ?>
                                        <td><a href="https://btc.com/<?php echo ($vo['address']); ?>" target="_blank">
                                            <?php echo ($vo['address']); ?></a></td><?php endif; ?>
                                    <td><?php echo ($vo['amount']); ?></td>

                                    <!-- <td><?php echo ($vo['sxf']); ?></td> -->
                                    <!-- <td><?php echo ($vo['amount'] - $vo['sxf']); ?></td> -->
                                    <?php if($vo['coinname'] != btc): ?><td><a href="https://etherscan.io/tx/<?php echo ($vo['hash']); ?>" target="_blank">
                                            <?php echo ($vo['hash']); ?></a></td>
                                        <?php else: ?>
                                        <td><a href="https://btc.com/<?php echo ($vo['hash']); ?>" target="_blank">
                                            <?php echo ($vo['hash']); ?></a></td><?php endif; ?>
                                    <td>
                                        <?php echo ($tixian[$vo['status']]); ?>
                                    </td>
                                    <td><?php echo ($vo['fee']); ?></td>
                                    <!-- <td class="am-hide-sm-only">
                                        <?php echo ($vo['bank_num']); ?>
                                    </td>
                                    <td class="am-hide-sm-only">
                                      <?php echo ($vo['bank_name']); ?>
                                    </td> -->

                                    <!-- <td class="am-hide-sm-only">
                                      <?php echo ($vo['bank_tree']); ?>
                                    </td>
                                    <td class="am-hide-sm-only">
                                      <?php echo ($vo['bank_user']); ?>
                                    </td>
                                    <td class="am-hide-sm-only">
                                      <?php echo ($vo['weixin']); ?>
                                    </td>
                                    <td class="am-hide-sm-only">
                                      <?php echo ($vo['zfb']); ?>
                                    </td> -->
                                    <td class="am-hide-sm-only"><?php echo (date("Y-m-d H:i:s",$vo['addtime'])); ?></td>
                                    <?php if($vo['endtime'] == 0): ?><td class="am-hide-sm-only">---</td>
                                        <?php else: ?>

                                        <td class="am-hide-sm-only"><?php echo (date("Y-m-d H:i:s",$vo['endtime'])); ?></td><?php endif; ?>

                                    <td>

                                        <?php if($vo['coinname'] == btc): echo ($balance); ?>

                                            <?php elseif($vo['coinname'] == eth): ?>

                                            <span class="eth"></span>

                                            <?php elseif($vo['coinname'] == usdt): ?>

                                            <span class="usdt"></span>

                                            <?php elseif($vo['coinname'] == iote): ?>

                                            <span class="iote"></span><?php endif; ?>

                                    </td>


                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                        <div class="am-cf">
                            共 <?php echo ($count); ?> 条记录
                            <div class="am-fr">
                                <ul class="am-pagination">
                                    <?php echo ($page); ?>

                                </ul>
                            </div>
                        </div>
                        <hr/>
                    </div>

                </div>

            </div>
        </div>

        <footer class="admin-content-footer">
            <hr>
            <p class="am-padding-left">© 2019 AllMobilize, Inc. Licensed under MIT license.</p>
        </footer>

    </div>

    <!-- 引入js -->

    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/Home/js/web3.1.js"></script>
    <!--<script src="/Public/Admin/js/withdrawcoin.js"></script>-->

    <!-- 查询平台钱包和转账 -->

    <script type="text/javascript">

        $('#all').click(function () {
            // console.log(this.checked);
            // $(".every").attr('checked',this.checked);
            $(".every").prop('checked',this.checked);
        })

        $('.every').click(function () {
            $flag=true;
            $(".every").each(function () {
                if(!this.checked){
                    $flag=false;
                }
            })
            $("#all").prop('checked',$flag);
        })

        $(".yijian").click(function () {
            // alert(123);return false;
            $flag=true;
            if(confirm("确定执行此操作吗")){
                $arr=[];
                $(".every").each(function () {
                    if(this.checked){
                        $arr.push($(this).val());
                        // alert($(this).attr('n'));
                        if($(this).attr('coin')=='iote'){
                            tiote($(this));
                        }
                        if($(this).attr('coin')=='btc'){
                            // tiote();
                            tbtc($(this));
                        }
                        if($(this).attr('coin')=='eth'){
                            // tiote();
                            teth($(this));
                        }
                        if($(this).attr('coin')=='usdt'){
                            // tiote();
                            tusdt($(this));
                        }
                    }
                });
                if($flag==true){
                    alert('批量审核已完成');
                    window.location.reload();
                }else {
                    alert('部分会员审核未通过，请手动驳回');
                    window.location.reload();
                }
                // window.location.reload();
                // alert($arr+"||"+$flag);
                // $.ajax({
                //     type:"post",
                //     dataType:"json",
                //     url:"<?php echo U('yijian_sure');?>",
                //     data:{
                //         arr:$arr,
                //     },
                //     success:function (data) {
                //         if(data.code>0){
                //             alert(data.message);
                //             window.location.reload();
                //         }else {
                //             alert(data.message);
                //         }
                //     }
                // })
            }

        })




        if (typeof web3 !== 'undefined') {
            web3 = new Web3(web3.currentProvider);
        }
        else {
            // web3 = new Web3('https://mainnet.infura.io/JLEYzEEavNnSni91CvPF');
            // web3 = new Web3(new Web3.providers.HttpProvider("https://ropsten.infura.io/v3/96e3bf3bd1164bc4a5d8d9bb3dca6d3c"));
            // infura申请的地址
            web3 = new Web3(new Web3.providers.HttpProvider("https://mainnet.infura.io/v3/96e3bf3bd1164bc4a5d8d9bb3dca6d3c"));
        }

        //循环查每个钱包的eth余额
        $eth_ll='';
        $address_arr=["0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16","0x35a9FD0Cf8ADc77452E946AFED3518184C2D15D1","0x19A5219F54c436C426a50461Ebc4a68a3B00beD8","0x48211ebc204DaFa0f5FB7AD7b26667F9F7764319","0x28A0D357770AA0fa4C7e9F9e7F6227aBD64EB312","0xA55e379c75E2698a7e542c50D36807e2407dce72","0x9e63f8300C502E037BA66752eDC8e1234C445Ec3"];
        $eth_arr=document.getElementsByClassName('eth_ll');
        for($i=0;$i<$eth_arr.length;$i++){
            (function($i){
                web3.eth.getBalance($address_arr[$i], function(err, resp){
                    if(!err){
                        $eth_ll = web3.utils.fromWei(resp, 'ether');
                        // console.log($eth_ll);
                        $(".eth_ll").eq($i).text($eth_ll);
                    }else{
                        console.log(err);
                    }
                });
            })($i);

        }
        // web3.eth.getBalance($address_arr[0], function(err, resp){
        //     if(!err){
        //         $eth_ll = web3.utils.fromWei(resp, 'ether');
        //         $(".eth_ll").eq(0).append($eth_ll);
        //     }else{
        //         console.log(err);
        //     }
        // });
        // web3.eth.getBalance($address_arr[1], function(err, resp){
        //     if(!err){
        //         $eth_ll = web3.utils.fromWei(resp, 'ether');
        //         $(".eth_ll").eq(1).append($eth_ll);
        //     }else{
        //         console.log(err);
        //     }
        // });
        // web3.eth.getBalance($address_arr[2], function(err, resp){
        //     if(!err){
        //         $eth_ll = web3.utils.fromWei(resp, 'ether');
        //         $(".eth_ll").eq(2).append($eth_ll);
        //     }else{
        //         console.log(err);
        //     }
        // });
        // web3.eth.getBalance($address_arr[3], function(err, resp){
        //     if(!err){
        //         $eth_ll = web3.utils.fromWei(resp, 'ether');
        //         $(".eth_ll").eq(3).append($eth_ll);
        //     }else{
        //         console.log(err);
        //     }
        // });
        // web3.eth.getBalance($address_arr[4], function(err, resp){
        //     if(!err){
        //         $eth_ll = web3.utils.fromWei(resp, 'ether');
        //         $(".eth_ll").eq(4).append($eth_ll);
        //     }else{
        //         console.log(err);
        //     }
        // });
        // web3.eth.getBalance($address_arr[5], function(err, resp){
        //     if(!err){
        //         $eth_ll = web3.utils.fromWei(resp, 'ether');
        //         $(".eth_ll").eq(5).append($eth_ll);
        //     }else{
        //         console.log(err);
        //     }
        // });
        // web3.eth.getBalance($address_arr[6], function(err, resp){
        //     if(!err){
        //         $eth_ll = web3.utils.fromWei(resp, 'ether');
        //         $(".eth_ll").eq(6).append($eth_ll);
        //     }else{
        //         console.log(err);
        //     }
        // });



        var address = "0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16";

        //查询eth余额
        var eth = '';
        web3.eth.getBalance(address, function(err, resp){
            if(!err){
                eth = web3.utils.fromWei(resp, 'ether');
                $(".eth").append(eth);
            }else{
                console.log(err);
            }
        });

        //循环查每个钱包usdt的余额
        $usdt_arr=document.getElementsByClassName('usdt_ll');
        for($i=0;$i<$usdt_arr.length;$i++){
            (function ($i) {
                var usdtContractAddress1 = '0xdac17f958d2ee523a2206206994597c13d831ec7';
                var usdtContract1 = new web3.eth.Contract([{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_upgradedAddress","type":"address"}],"name":"deprecate","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"deprecated","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_evilUser","type":"address"}],"name":"addBlackList","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"upgradedAddress","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"balances","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"maximumFee","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"_totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"unpause","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_maker","type":"address"}],"name":"getBlackListStatus","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"},{"name":"","type":"address"}],"name":"allowed","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"paused","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"who","type":"address"}],"name":"balanceOf","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"pause","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"getOwner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"newBasisPoints","type":"uint256"},{"name":"newMaxFee","type":"uint256"}],"name":"setParams","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"amount","type":"uint256"}],"name":"issue","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"amount","type":"uint256"}],"name":"redeem","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"remaining","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"basisPointsRate","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"isBlackListed","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_clearedUser","type":"address"}],"name":"removeBlackList","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"MAX_UINT","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_blackListedUser","type":"address"}],"name":"destroyBlackFunds","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[{"name":"_initialSupply","type":"uint256"},{"name":"_name","type":"string"},{"name":"_symbol","type":"string"},{"name":"_decimals","type":"uint256"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"amount","type":"uint256"}],"name":"Issue","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"amount","type":"uint256"}],"name":"Redeem","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"newAddress","type":"address"}],"name":"Deprecate","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"feeBasisPoints","type":"uint256"},{"indexed":false,"name":"maxFee","type":"uint256"}],"name":"Params","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_blackListedUser","type":"address"},{"indexed":false,"name":"_balance","type":"uint256"}],"name":"DestroyedBlackFunds","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_user","type":"address"}],"name":"AddedBlackList","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_user","type":"address"}],"name":"RemovedBlackList","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"owner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"anonymous":false,"inputs":[],"name":"Pause","type":"event"},{"anonymous":false,"inputs":[],"name":"Unpause","type":"event"}], usdtContractAddress1, {
                    from : $address_arr[$i]
                });

                var usdt1 = '';

                usdtContract1.methods.balanceOf($address_arr[$i]).call(function(err, tkns){
                    if (!err) {
                        usdt1 = web3.utils.fromWei(tkns, 'mwei');
                        $(".usdt_ll").eq($i).append(usdt1);
                    }else{
                        console.log(err)
                    }

                })
            })($i);

        }


        //查询usdt余额
        var usdtContractAddress = '0xdac17f958d2ee523a2206206994597c13d831ec7';
        var usdtContract = new web3.eth.Contract([{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_upgradedAddress","type":"address"}],"name":"deprecate","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"deprecated","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_evilUser","type":"address"}],"name":"addBlackList","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"upgradedAddress","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"balances","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"maximumFee","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"_totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"unpause","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_maker","type":"address"}],"name":"getBlackListStatus","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"},{"name":"","type":"address"}],"name":"allowed","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"paused","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"who","type":"address"}],"name":"balanceOf","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"pause","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"getOwner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"newBasisPoints","type":"uint256"},{"name":"newMaxFee","type":"uint256"}],"name":"setParams","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"amount","type":"uint256"}],"name":"issue","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"amount","type":"uint256"}],"name":"redeem","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"remaining","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"basisPointsRate","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"isBlackListed","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_clearedUser","type":"address"}],"name":"removeBlackList","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"MAX_UINT","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_blackListedUser","type":"address"}],"name":"destroyBlackFunds","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[{"name":"_initialSupply","type":"uint256"},{"name":"_name","type":"string"},{"name":"_symbol","type":"string"},{"name":"_decimals","type":"uint256"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"amount","type":"uint256"}],"name":"Issue","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"amount","type":"uint256"}],"name":"Redeem","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"newAddress","type":"address"}],"name":"Deprecate","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"feeBasisPoints","type":"uint256"},{"indexed":false,"name":"maxFee","type":"uint256"}],"name":"Params","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_blackListedUser","type":"address"},{"indexed":false,"name":"_balance","type":"uint256"}],"name":"DestroyedBlackFunds","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_user","type":"address"}],"name":"AddedBlackList","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_user","type":"address"}],"name":"RemovedBlackList","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"owner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"anonymous":false,"inputs":[],"name":"Pause","type":"event"},{"anonymous":false,"inputs":[],"name":"Unpause","type":"event"}], usdtContractAddress, {
            from : '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16'
        });

        var usdt = '';

        usdtContract.methods.balanceOf(address).call(function(err, tkns){
            if (!err) {
                usdt = web3.utils.fromWei(tkns, 'mwei');
                $(".usdt").append(usdt);
            }else{
                console.log(err)
            }

        })

        //循环查每个钱包的iote余额

        // var ioteContractAddress1 = '0xba1ed22c69ad00739ee2b4abd70e270be9e87ee2';
        // var ioteContract1 = new web3.eth.Contract([{"constant":false,"inputs":[{"name":"addr","type":"address"},{"name":"state","type":"bool"}],"name":"setTransferAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"mintingFinished","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"}],"name":"setReleaseAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"receiver","type":"address"},{"name":"amount","type":"uint256"}],"name":"mint","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"burnAmount","type":"uint256"}],"name":"burn","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"mintAgents","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"},{"name":"state","type":"bool"}],"name":"setMintAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"value","type":"uint256"}],"name":"upgrade","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_name","type":"string"},{"name":"_symbol","type":"string"}],"name":"setTokenInformation","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"upgradeAgent","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"releaseTokenTransfer","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"upgradeMaster","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_subtractedValue","type":"uint256"}],"name":"decreaseApproval","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"}],"name":"balanceOf","outputs":[{"name":"balance","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"},{"name":"state","type":"bool"}],"name":"setLockAddress","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"fromWhom","type":"address"}],"name":"transferToOwner","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"getUpgradeState","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"transferAgents","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"released","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"canUpgrade","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"lockAddresses","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"totalUpgraded","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"releaseAgent","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_addedValue","type":"uint256"}],"name":"increaseApproval","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"agent","type":"address"}],"name":"setUpgradeAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"isToken","outputs":[{"name":"weAre","type":"bool"}],"payable":false,"stateMutability":"pure","type":"function"},{"constant":false,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"BURN_ADDRESS","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"master","type":"address"}],"name":"setUpgradeMaster","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[{"name":"_name","type":"string"},{"name":"_symbol","type":"string"},{"name":"_initialSupply","type":"uint256"},{"name":"_decimals","type":"uint256"},{"name":"_mintable","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"fromWhom","type":"address"},{"indexed":false,"name":"amount","type":"uint256"}],"name":"OwnerReclaim","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"newName","type":"string"},{"indexed":false,"name":"newSymbol","type":"string"}],"name":"UpdatedTokenInformation","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"_from","type":"address"},{"indexed":true,"name":"_to","type":"address"},{"indexed":false,"name":"_value","type":"uint256"}],"name":"Upgrade","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"agent","type":"address"}],"name":"UpgradeAgentSet","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"addr","type":"address"},{"indexed":false,"name":"state","type":"bool"}],"name":"MintingAgentChanged","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"receiver","type":"address"},{"indexed":false,"name":"amount","type":"uint256"}],"name":"Minted","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"burner","type":"address"},{"indexed":false,"name":"burnedAmount","type":"uint256"}],"name":"Burned","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"owner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Transfer","type":"event"}], ioteContractAddress1, {
        //     from : "0x35a9FD0Cf8ADc77452E946AFED3518184C2D15D1"
        // });
        //
        // var iote1 = '';
        // ioteContract1.methods.balanceOf("0x35a9FD0Cf8ADc77452E946AFED3518184C2D15D1").call(function(err, tkns){
        //     if (!err) {
        //         iote1 = web3.utils.fromWei(tkns, 'ether');
        //         console.log(iote1);
        //         $(".iote_ll").eq(1).append(iote1);
        //     }else{
        //         console.log(err)
        //     }
        //
        // })




        $iote_arr=document.getElementsByClassName('iote_ll');
        for($i=0;$i<$iote_arr.length;$i++){
            (function ($i) {
                var ioteContractAddress1 = '0xad7195e2f5e4f104cc2ed31cb719efd95b9eb490';
                var ioteContract1 = new web3.eth.Contract([{"constant":false,"inputs":[{"name":"addr","type":"address"},{"name":"state","type":"bool"}],"name":"setTransferAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"mintingFinished","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"}],"name":"setReleaseAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"receiver","type":"address"},{"name":"amount","type":"uint256"}],"name":"mint","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"burnAmount","type":"uint256"}],"name":"burn","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"mintAgents","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"},{"name":"state","type":"bool"}],"name":"setMintAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"value","type":"uint256"}],"name":"upgrade","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_name","type":"string"},{"name":"_symbol","type":"string"}],"name":"setTokenInformation","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"upgradeAgent","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"releaseTokenTransfer","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"upgradeMaster","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_subtractedValue","type":"uint256"}],"name":"decreaseApproval","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"}],"name":"balanceOf","outputs":[{"name":"balance","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"},{"name":"state","type":"bool"}],"name":"setLockAddress","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"fromWhom","type":"address"}],"name":"transferToOwner","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"getUpgradeState","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"transferAgents","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"released","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"canUpgrade","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"lockAddresses","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"totalUpgraded","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"releaseAgent","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_addedValue","type":"uint256"}],"name":"increaseApproval","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"agent","type":"address"}],"name":"setUpgradeAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"isToken","outputs":[{"name":"weAre","type":"bool"}],"payable":false,"stateMutability":"pure","type":"function"},{"constant":false,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"BURN_ADDRESS","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"master","type":"address"}],"name":"setUpgradeMaster","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[{"name":"_name","type":"string"},{"name":"_symbol","type":"string"},{"name":"_initialSupply","type":"uint256"},{"name":"_decimals","type":"uint256"},{"name":"_mintable","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"fromWhom","type":"address"},{"indexed":false,"name":"amount","type":"uint256"}],"name":"OwnerReclaim","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"newName","type":"string"},{"indexed":false,"name":"newSymbol","type":"string"}],"name":"UpdatedTokenInformation","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"_from","type":"address"},{"indexed":true,"name":"_to","type":"address"},{"indexed":false,"name":"_value","type":"uint256"}],"name":"Upgrade","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"agent","type":"address"}],"name":"UpgradeAgentSet","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"addr","type":"address"},{"indexed":false,"name":"state","type":"bool"}],"name":"MintingAgentChanged","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"receiver","type":"address"},{"indexed":false,"name":"amount","type":"uint256"}],"name":"Minted","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"burner","type":"address"},{"indexed":false,"name":"burnedAmount","type":"uint256"}],"name":"Burned","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"owner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Transfer","type":"event"}], ioteContractAddress1, {
                    from : $address_arr[$i]
                });

                var iote1 = '';
                ioteContract1.methods.balanceOf($address_arr[$i]).call(function(err, tkns){
                    if (!err) {
                        iote1 = web3.utils.fromWei(tkns, 'ether');
                        console.log(iote1);
                        $(".iote_ll").eq($i).append(iote1);
                    }else{
                        console.log(err)
                    }

                })
            })($i);
        }


        //查询iote余额
        var ioteContractAddress = '0xad7195e2f5e4f104cc2ed31cb719efd95b9eb490';
        // var ioteContractAddress = '0x79A571a1D192Ad5F58b2cF8CA7Bc8315C4a4fb2a';
        var ioteContract = new web3.eth.Contract([{"constant":false,"inputs":[{"name":"addr","type":"address"},{"name":"state","type":"bool"}],"name":"setTransferAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"mintingFinished","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"}],"name":"setReleaseAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"receiver","type":"address"},{"name":"amount","type":"uint256"}],"name":"mint","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"burnAmount","type":"uint256"}],"name":"burn","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"mintAgents","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"},{"name":"state","type":"bool"}],"name":"setMintAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"value","type":"uint256"}],"name":"upgrade","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_name","type":"string"},{"name":"_symbol","type":"string"}],"name":"setTokenInformation","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"upgradeAgent","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"releaseTokenTransfer","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"upgradeMaster","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_subtractedValue","type":"uint256"}],"name":"decreaseApproval","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"}],"name":"balanceOf","outputs":[{"name":"balance","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"addr","type":"address"},{"name":"state","type":"bool"}],"name":"setLockAddress","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"fromWhom","type":"address"}],"name":"transferToOwner","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"getUpgradeState","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"transferAgents","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"released","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"canUpgrade","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"lockAddresses","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"totalUpgraded","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"releaseAgent","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_addedValue","type":"uint256"}],"name":"increaseApproval","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"agent","type":"address"}],"name":"setUpgradeAgent","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"isToken","outputs":[{"name":"weAre","type":"bool"}],"payable":false,"stateMutability":"pure","type":"function"},{"constant":false,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"BURN_ADDRESS","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"master","type":"address"}],"name":"setUpgradeMaster","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[{"name":"_name","type":"string"},{"name":"_symbol","type":"string"},{"name":"_initialSupply","type":"uint256"},{"name":"_decimals","type":"uint256"},{"name":"_mintable","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"fromWhom","type":"address"},{"indexed":false,"name":"amount","type":"uint256"}],"name":"OwnerReclaim","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"newName","type":"string"},{"indexed":false,"name":"newSymbol","type":"string"}],"name":"UpdatedTokenInformation","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"_from","type":"address"},{"indexed":true,"name":"_to","type":"address"},{"indexed":false,"name":"_value","type":"uint256"}],"name":"Upgrade","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"agent","type":"address"}],"name":"UpgradeAgentSet","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"addr","type":"address"},{"indexed":false,"name":"state","type":"bool"}],"name":"MintingAgentChanged","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"receiver","type":"address"},{"indexed":false,"name":"amount","type":"uint256"}],"name":"Minted","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"burner","type":"address"},{"indexed":false,"name":"burnedAmount","type":"uint256"}],"name":"Burned","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"owner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Transfer","type":"event"}], ioteContractAddress, {
            from : '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16'
        });

        var iote = '';
        ioteContract.methods.balanceOf(address).call(function(err, tkns){
            if (!err) {
                iote = web3.utils.fromWei(tkns, 'ether');
                $(".iote").append(iote);
            }else{
                console.log(err)
            }

        })

        //btc转账
        $('.tbtc').click(function(event) {

            // alert('暂未开放！');
            // return false;

            if(confirm("确认操作？")){

                var id = $(this).attr('id');

                $.ajax({
                    type: 'POST',
                    url: '<?php echo U("doWithdrawBTC");?>',
                    data: {
                        'id':id
                    },

                    dataType: 'json',

                    success: function(data){
                        if (data.code == 0) {
                            alert(data.msg);
                            window.location.reload();
                            return;
                        } else {
                            alert(data.msg);
                            window.location.reload();
                            // window.location ="<?php echo U('withdrawCoin');?>";
                        }

                    }
                });

            }
            else
            {
                return;
            }
        });


        //eth转账
        $('.teth').click(function(){

            // alert('暂未开放！');
            // return false;

            if(confirm("确认操作？")){

                var from = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';
                var amount = parseFloat($(this).attr("m"));
                var number = parseFloat($(this).attr("m"));
                var to = $(this).attr("n");
                var id = $(this).attr('x');

                if(!web3.utils.isAddress(to)){
                    alert('ETH钱包地址不正确');
                    return false;
                }

                web3.eth.getBalance(from, function(err, resp){
                    if(!err){

                        balance = web3.utils.fromWei(resp, 'ether');
                        console.log(balance);
                        web3.eth.getGasPrice(function(err, res){
                            if(!err)
                            {
                                price = web3.utils.fromWei(res, 'ether');
                                //console.log(price);
                                limit = 26000;
                                fee = parseFloat(price) * limit;
                                //console.log(fee);
                                //console.log(number);
                                num = parseFloat(fee) + parseFloat(number);
                                //console.log(fee);
                                //console.log(number);
                                //console.log(num);
                                if(parseFloat(num) > parseFloat(balance))
                                {
                                    alert('平台钱包ETH余额不足');
                                    return false;
                                }
                            }
                        });

                    }else{
                        console.log(err);
                    }
                });

                web3.eth.getTransactionCount(from, function(err, count){
                    if(!err){

                        var tcount = count;
                        amount = web3.utils.toWei(amount.toString());
                        web3.eth.getGasPrice().then(function(gasPrice){
                            var rawTransaction = {
                                "from": from,
                                "nonce": "0x" + tcount.toString(16),
                                "gasPrice": web3.utils.toHex(gasPrice),
                                "gasLimit": web3.utils.toHex(26000),
                                "to": to,
                                "value": amount,
                                "data": ''
                            };

                            var privKey = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';

                            web3.eth.accounts.signTransaction(rawTransaction, privKey, function(err,signed){
                                if(err){
                                    console.log(err);
                                    return ;
                                }
                                web3.eth.sendSignedTransaction(signed.rawTransaction, function(err, result){
                                    if(!err){
                                        console.log(result);
                                        //传送数据
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo U("doWithdrawETH");?>',
                                            data: {
                                                'txhash': result,
                                                'id' : id
                                            },
                                            dataType: 'json',

                                            success: function(data){
                                                if (data.code == 0) {
                                                    alert(data.msg);
                                                    window.location.reload();
                                                    // window.location ="<?php echo U('withdrawCoin');?>";
                                                } else {
                                                    alert(data.msg);
                                                    return;
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
                        console.log(error);
                    }
                });

            }
            else
            {
                return;
            }

        });

        //usdt_omni转账
        $('.tusdt_omni').click(function(){

            // alert('暂未开放！');
            // return false;

            if(confirm("确认操作？")){

                var id = $(this).attr('id');

                $.ajax({
                    type: 'POST',
                    url: '<?php echo U("doWithdrawUSDT");?>',
                    data: {
                        'id':id
                    },

                    dataType: 'json',

                    success: function(data){
                        if (data.code == 0) {
                            alert(data.msg);
                            window.location.reload();
                            return;
                        } else {
                            alert(data.msg);
                            window.location.reload();
                            // window.location ="<?php echo U('withdrawCoin');?>";
                        }

                    }
                });

            }
            else
            {
                return;
            }

        });
        //usdt转账
        $('.tusdt').click(function(){

            // alert('暂未开放！');
            // return false;

            if(confirm("确认操作？")){

                var from = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';
                var amount = parseFloat($(this).attr("m"));
                var to = $(this).attr("n");
                var id = $(this).attr('x');

                //验证数量
                if(!web3.utils.isAddress(to)){
                    alert('钱包地址不正确');
                    return false;
                }

                web3.eth.getTransactionCount(from, function(err, count){

                    if(!err){
                        var tcount = count;
                        usdtContract.methods.balanceOf(from).call( function(err, tkns){
                            if (!err) {
                                var balance = web3.utils.fromWei(tkns, 'mwei');
                                console.log(balance);
                                var b = new web3.utils.BN(balance)

                                if(b.toNumber() < amount){
                                    alert('平台钱包USDT余额不足');
                                    return false;
                                }

                                amount = web3.utils.toWei(amount.toString(), 'mwei');

                                web3.eth.getGasPrice().then(function(gasPrice){

                                    var rawTransaction = {
                                        "from": from,
                                        "nonce": "0x" + tcount.toString(16),
                                        "gasPrice": web3.utils.toHex(gasPrice),
                                        "gasLimit": web3.utils.toHex(60000),
                                        "to": usdtContractAddress,
                                        "value": "0x0",
                                        "data": usdtContract.methods.transfer(to, amount).encodeABI()
                                    };

                                    var privKey = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';

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
                                                    url: '<?php echo U("doWithdrawETH");?>',
                                                    data: {
                                                        'txhash': result,
                                                        'id' : id
                                                    },
                                                    dataType: 'json',

                                                    success: function(data){

                                                        if (data.code == 0) {
                                                            alert(data.msg);
                                                            window.location.reload();
                                                            // window.location ="<?php echo U('withdrawCoin');?>";
                                                        } else {
                                                            alert(data.msg);
                                                            return;
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
            else
            {
                return;
            }

        });


        //iote转账
        $('.tiote').click(function(){

            //alert('暂未开放！');
            //return false;

            if(confirm("确认操作？")){

                var from = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';
                var amount = parseFloat($(this).attr("m"));

                var to = $(this).attr("n");
                var id = $(this).attr('x');

                //验证数量
                if(!web3.utils.isAddress(to)){
                    alert('钱包地址不正确');
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
                                    alert('平台钱包iote余额不足');
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

                                    var privKey = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';
                                    // var privKey = '0x77fb29ad850b42cadab9101a5865eac7bae774e13038117162ab34e82bfcfd58';

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
                                                    url: '<?php echo U("doWithdrawETH");?>',
                                                    data: {
                                                        'txhash': result,
                                                        'id' : id
                                                    },
                                                    dataType: 'json',

                                                    success: function(data){
                                                        //提币失败
                                                        if (data.code == 0) {
                                                            alert(data.msg);
                                                            window.location.reload();
                                                            // window.location ="<?php echo U('withdrawCoin');?>";
                                                        } else {
                                                            alert(data.msg);
                                                            window.location.reload();
                                                            return;
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
            else
            {
                return;
            }

        });

        //iote转账
        function tiote(obj){
            var from = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';
            // var from = '0x79A571a1D192Ad5F58b2cF8CA7Bc8315C4a4fb2a ';
            var amount = parseFloat(obj.attr("m"));
            var to = obj.attr("n");
            var id = obj.attr('x');
            // alert(to);
            //验证数量

            if(!web3.utils.isAddress(to)){
                alert('钱包地址不正确');
                $flag=false;
                layer.msg(id+"会员钱包地址不正确");
                return true;
            }
            // console.log(web3);
            web3.eth.getTransactionCount(from, function(err, count){

                alert(from);return false;
                if(!err){
                    var tcount = count;
                    ioteContract.methods.balanceOf(from).call( function(err, tkns){
                        if (!err) {
                            var balance = web3.utils.fromWei(tkns, 'ether');
                            console.log(balance);
                            var b = new web3.utils.BN(balance)

                            if(b.toNumber() < amount){
                                alert('平台钱包iote余额不足');
                                $flag=false;
                                layer.msg(id+"平台钱包iote余额不足");
                                return true;
                            }

                            // alert('iote');
                            // return true;
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

                                var privKey = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';
                                // var privKey = '0x77fb29ad850b42cadab9101a5865eac7bae774e13038117162ab34e82bfcfd58';

                                web3.eth.accounts.signTransaction(rawTransaction, privKey, function(err,signed){

                                    if(err){
                                        $flag=false;
                                        // console.log(err);
                                        layer.msg(id+'会员审核不通过');
                                        return true;
                                    }

                                    web3.eth.sendSignedTransaction(signed.rawTransaction, function(err, result){
                                        if(!err){
                                            // alert('没出错');
                                            //传送数据
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo U("doWithdrawETH");?>',
                                                data: {
                                                    'txhash': result,
                                                    'id' : id
                                                },
                                                dataType: 'json',

                                                success: function(data){

                                                    if (data.code == 0) {
                                                        // alert(data.msg);
                                                        $flag=false;
                                                        // window.location ="<?php echo U('withdrawCoin');?>";
                                                        layer.msg(id+'会员审核不通过');
                                                        return true;
                                                    } else {
                                                        console.log(data.msg);
                                                        // window.location.reload();
                                                        alert(data.msg);
                                                        // return;
                                                    }

                                                }
                                            });
                                        }else{
                                            $flag=false;
                                            layer.msg(id+'会员审核不通过');
                                            return true;
                                            // console.log(err);
                                        }
                                    })
                                })

                            })

                        }else{
                            $flag=false;
                            layer.msg(id+'会员审核不通过');
                            return true;
                            // console.log(err);
                        }

                    })
                }else{
                    $flag=false;
                    layer.msg(id+'会员审核不通过');
                    return true;
                    // console.log(error);
                }

            });
        }


        //btc转账
        function tbtc(obj){
            // alert('btc');
            // return true;
            var id = obj.attr('id');

            $.ajax({
                type: 'POST',
                url: '<?php echo U("doWithdrawBTC");?>',
                data: {
                    'id':id
                },

                dataType: 'json',

                success: function(data){
                    if (data.code != 2) {
                        $flag=false;
                        layer.msg(id+'会员审核不通过');
                    } else {
                        window.location.reload();
                    }

                }
            });

        }




        //eth转账
        function teth(obj){
            var from = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';
            var amount = parseFloat(obj.attr("m"));
            var number = parseFloat(obj.attr("m"));
            var to = obj.attr("n");
            var id = obj.attr('x');

            if(!web3.utils.isAddress(to)){
                // alert('ETH钱包地址不正确');
                $flag=false;
                layer.msg(id+'钱包地址不正确');
                return true;
            }

            web3.eth.getBalance(from, function(err, resp){
                if(!err){

                    balance = web3.utils.fromWei(resp, 'ether');
                    console.log(balance);
                    web3.eth.getGasPrice(function(err, res){
                        if(!err)
                        {
                            price = web3.utils.fromWei(res, 'ether');
                            //console.log(price);
                            limit = 26000;
                            fee = parseFloat(price) * limit;
                            //console.log(fee);
                            //console.log(number);
                            num = parseFloat(fee) + parseFloat(number);
                            //console.log(fee);
                            //console.log(number);
                            //console.log(num);
                            if(parseFloat(num) > parseFloat(balance))
                            {
                                // alert('平台钱包ETH余额不足');
                                $flag=false;
                                layer.msg(id+'会员平台钱包ETH余额不足');
                                return true;
                            }
                        }
                    });

                }else{
                    $flag=false;
                    // console.log(err);
                    layer.msg(id+'会员审核不通过');
                    return true;
                }
            });

            // alert('eth');
            // return true;
            web3.eth.getTransactionCount(from, function(err, count){
                if(!err){

                    var tcount = count;
                    amount = web3.utils.toWei(amount.toString());
                    web3.eth.getGasPrice().then(function(gasPrice){
                        var rawTransaction = {
                            "from": from,
                            "nonce": "0x" + tcount.toString(16),
                            "gasPrice": web3.utils.toHex(gasPrice),
                            "gasLimit": web3.utils.toHex(26000),
                            "to": to,
                            "value": amount,
                            "data": ''
                        };

                        var privKey = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';

                        web3.eth.accounts.signTransaction(rawTransaction, privKey, function(err,signed){
                            if(err){
                                // console.log(err);
                                $flag=false;
                                layer.msg(id+'会员审核不通过');
                                return true;
                            }
                            web3.eth.sendSignedTransaction(signed.rawTransaction, function(err, result){
                                if(!err){
                                    console.log(result);
                                    //传送数据
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo U("doWithdrawETH");?>',
                                        data: {
                                            'txhash': result,
                                            'id' : id
                                        },
                                        dataType: 'json',

                                        success: function(data){
                                            if (data.code == 0) {
                                                $flag=false;
                                                layer.msg(id+'会员审核不通过');
                                                return true;
                                            } else {
                                                window.location.reload();
                                            }

                                        }
                                    });
                                }else{
                                    $flag=false;
                                    // console.log(err);
                                    layer.msg(id+'会员审核不通过');
                                    return true;
                                }
                            })
                        })

                    })

                }else{
                    $flag=false;
                    layer.msg(id+'会员审核不通过');
                    return true;
                    // console.log(error);
                }
            });
        }

        //usdt转账
        function tusdt(obj){
            var from = '0xF4aC5D9be4aEa89b4e607752bcBD31D0A7dFfE16';
            var amount = parseFloat(obj.attr("m"));
            var to = obj.attr("n");
            var id = obj.attr('x');

            //验证数量
            if(!web3.utils.isAddress(to)){
                // alert('钱包地址不正确');
                $flag=false;
                layer.msg(id+'会员钱包地址不正确');
                return true;
            }

            web3.eth.getTransactionCount(from, function(err, count){

                if(!err){
                    var tcount = count;
                    usdtContract.methods.balanceOf(from).call( function(err, tkns){
                        if (!err) {
                            var balance = web3.utils.fromWei(tkns, 'mwei');
                            console.log(balance);
                            var b = new web3.utils.BN(balance)

                            if(b.toNumber() < amount){
                                // alert('平台钱包USDT余额不足');
                                $flag=false;
                                layer.msg(id+'会员平台钱包USDT余额不足');
                                return true;
                            }


                            // alert('usdt');
                            // return true;
                            amount = web3.utils.toWei(amount.toString(), 'mwei');

                            web3.eth.getGasPrice().then(function(gasPrice){

                                var rawTransaction = {
                                    "from": from,
                                    "nonce": "0x" + tcount.toString(16),
                                    "gasPrice": web3.utils.toHex(gasPrice),
                                    "gasLimit": web3.utils.toHex(60000),
                                    "to": usdtContractAddress,
                                    "value": "0x0",
                                    "data": usdtContract.methods.transfer(to, amount).encodeABI()
                                };

                                var privKey = '0x54C9FC6CF41F649863E6AFAC511E418D7A70E814814598FE5C6634326DCEC791';

                                web3.eth.accounts.signTransaction(rawTransaction, privKey, function(err,signed){

                                    if(err){
                                        $flag=false;
                                        // console.log(err);
                                        layer.msg(id+'会员审核不通过');
                                        return true;
                                    }

                                    web3.eth.sendSignedTransaction(signed.rawTransaction, function(err, result){
                                        if(!err){
                                            //传送数据
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo U("doWithdrawETH");?>',
                                                data: {
                                                    'txhash': result,
                                                    'id' : id
                                                },
                                                dataType: 'json',

                                                success: function(data){

                                                    if (data.code == 0) {
                                                        // alert(data.msg);
                                                        $flag=false;
                                                        // window.location ="<?php echo U('withdrawCoin');?>";
                                                        layer.msg('操作失败');
                                                        // } else {
                                                        //     alert(data.msg);
                                                        //     return;
                                                    }else{
                                                        window.location.reload();
                                                    }

                                                }
                                            });
                                        }else{
                                            layer.msg(id+'会员审核不通过');
                                            // console.log(err);
                                            $flag=false;
                                            return true;
                                        }
                                    })
                                })

                            })

                        }else{
                            // console.log(err)
                            $flag=false;
                            layer.msg(id+'会员审核不通过');
                            return true;
                        }

                    })
                }else{
                    // console.log(error);
                    $flag=false;
                    layer.msg(id+'会员审核不通过');
                    return true;
                }

            });
        }





        var exporturl = "<?php echo U('exportCoin');?>";
        $('#export').click(function () {

            $('form').attr('action',exporturl);
        });


    </script>


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



</body>
</html>