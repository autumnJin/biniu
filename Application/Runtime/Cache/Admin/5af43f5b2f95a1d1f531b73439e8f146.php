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
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">参数设置</strong>  <small></small></div>
      </div>
      <hr>
      <div class="am-g">
        <div class="am-u-sm-12">
          <form class="am-form" action="<?php echo U('rewardConfig');?>" method="post">
            <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
            <table class="am-table am-table-striped am-table-hover table-main">
              <!--<thead>-->
              <!--</thead>-->
              <tbody>
              <tr>
                <td colspan="3">激活返币</td>
                <td><input type="text" name="ptr1" value="<?php echo ($data["ptr1"]); ?>"></td>
                <td colspan="11">激活返购物币</td>
              </tr>

              <tr>
                <td colspan="3">推荐奖励</td>
                <td><input type="text" name="ptr2" value="<?php echo ($data["ptr2"]); ?>"></td>
                <td colspan="2">推荐奖励(一代)%</td>
                <td><input type="text" name="ptr3" value="<?php echo ($data["ptr3"]); ?>"></td>
                <td colspan="2">推荐奖励(二代)%</td>
                <td><input type="text" name="ptr25" value="<?php echo ($data["ptr25"]); ?>"></td>
                <td colspan="2">推荐奖励(三代)%</td>
                <td></td>
                <td colspan="2"></td>
              </tr>

              <tr>
                <td colspan="3">周返奖励</td>
                <td><input type="text" name="ptr4" value="<?php echo ($data["ptr4"]); ?>"></td>
                <td colspan="2">总返倍数</td>
                <td><input type="text" name="ptr26" value="<?php echo ($data["ptr26"]); ?>"></td>
                <td colspan="2">日返还比例</td>
                <td></td>
                <td colspan="2"></td>
                <td></td>
                <td colspan="2"></td>
              </tr>

              <tr>
                <td colspan="3">每单金额</td>
                <td><input type="text" name="ptr8" value="<?php echo ($data["ptr8"]); ?>"></td>
                <td colspan="11">每单金额</td>
              </tr>

              <!--<tr>-->
                <!--<td colspan="3">团队奖励</td>-->
                <!--<td><input type="text" name="ptr9" value="<?php echo ($data["ptr9"]); ?>"></td>-->
                <!--<td colspan="11">奖励比例</td>-->
              <!--</tr>-->
              <tr>
                <td colspan="3">加速释放</td>
                <td><input type="text" name="ptr10" value="<?php echo ($data["ptr10"]); ?>"></td>
                <td colspan="2">一层比例%</td>
                <td><input type="text" name="ptr11" value="<?php echo ($data["ptr11"]); ?>"></td>
                <td colspan="2">二层比例%</td>
                <td><input type="text" name="ptr12" value="<?php echo ($data["ptr12"]); ?>"></td>
                <td colspan="2">三层比例%</td>
                <td><input type="text" name="ptr13" value="<?php echo ($data["ptr13"]); ?>"></td>
                <td colspan="2">四层比例%</td>
              </tr>
              <tr>
                <td colspan="3"></td>
                <td><input type="text" name="ptr14" value="<?php echo ($data["ptr14"]); ?>"></td>
                <td colspan="2">五层比例%</td>
                <td><input type="text" name="ptr15" value="<?php echo ($data["ptr15"]); ?>"></td>
                <td colspan="2">六层比例%</td>
                <td><input type="text" name="ptr16" value="<?php echo ($data["ptr16"]); ?>"></td>
                <td colspan="2">七层比例%</td>
                <td><input type="text" name="ptr17" value="<?php echo ($data["ptr17"]); ?>"></td>
                <td colspan="2">八层比例%</td>
              </tr>
              <tr>
                <td colspan="3"></td>
                <td><input type="text" name="ptr18" value="<?php echo ($data["ptr18"]); ?>"></td>
                <td colspan="2">九层比例%</td>
                <td><input type="text" name="ptr19" value="<?php echo ($data["ptr19"]); ?>"></td>
                <td colspan="2">十层比例%</td>
                <td><input type="text" name="ptr20" value="<?php echo ($data["ptr20"]); ?>"></td>
                <td colspan="2">十一到十五层比例%</td>
                <td><input type="text" name="ptr21" value="<?php echo ($data["ptr21"]); ?>"></td>
                <td colspan="2">无限层比例%</td>
              </tr>

              <tr>
                <td colspan="3">奖励拨比</td>
                <td><input type="text" name="ptr5" value="<?php echo ($data["ptr5"]); ?>"></td>
                <td colspan="2">流通积分比例%</td>
                <td><input type="text" name="ptr6" value="<?php echo ($data["ptr6"]); ?>"></td>
                <td colspan="2">购物积分比例%</td>
                <td><input type="text" name="ptr7" value="<?php echo ($data["ptr7"]); ?>"></td>
                <td colspan="2">兑换积分比例%</td>
                <td></td>
                <td colspan="2"></td>
              </tr>

              <tr>
                <td colspan="3">公共参数</td>
                <td><input type="text" name="j16" value="<?php echo ($data["j16"]); ?>"></td>
                <td colspan="2">提现手续费</td>
                <td><input type="text" name="j17" value="<?php echo ($data["j17"]); ?>"></td>
                <td colspan="2">兑冲手续费</td>
                <td><input type="text" name="ptr22" value="<?php echo ($data["ptr22"]); ?>"></td>
                <td colspan="2">提现整数倍</td>
                <td><input type="text" name="ptr23" value="<?php echo ($data["ptr23"]); ?>"></td>
                <td colspan="2">提现日封顶</td>
              </tr>

              <tr>
                <td colspan="3">资产兑换</td>
                <td><input type="text" name="ptr27" value="<?php echo ($data["ptr27"]); ?>"></td>
                <td colspan="2">1流通积分/兑换积分:Hpay</td>
                <td></td>
                <td colspan="2"></td>
                <td></td>
                <td colspan="2"></td>
                <td></td>
                <td colspan="2"></td>
              </tr>

              <tr>
                <td colspan="3">账户信息</td>
                <td><input type="text" name="bank_name" value="<?php echo ($data["bank_name"]); ?>"></td>
                <td colspan="2">收款银行</td>
                <td><input type="text" name="bank_zhi" value="<?php echo ($data["bank_zhi"]); ?>"></td>
                <td colspan="2">银行支行</td>
                <td><input type="text" name="bank_num" value="<?php echo ($data["bank_num"]); ?>"></td>
                <td colspan="2">银行账户</td>
                <td><input type="text" name="bank_user" value="<?php echo ($data["bank_user"]); ?>"></td>
                <td colspan="2">开户姓名</td>
              </tr>

              <tr>
                <td colspan="3">客服</td>
                <td><input type="text" name="qq" value="<?php echo ($data["qq"]); ?>"></td>
                <td colspan="2">客服QQ</td>
                <td></td>
                <td colspan="2"></td>
                <td></td>
                <td colspan="2"></td>
                <td></td>
                <td colspan="2"></td>
              </tr>
              </tbody>
            </table>
            <hr>
              <table class="am-table am-table-striped am-table-hover table-main">
                <!--<thead>-->
                <!--</thead>-->
                <tbody>

                <!--<tr>-->
                  <!--<div class="am-form-group">-->
                    <!--<label class="am-u-sm-3 am-form-label">会员转账</label>-->
                    <!--<div class="am-u-sm-9">-->
                      <!--<label class="am-radio-inline">-->
                        <!--<input type="radio" name="ptr81" value="1"  <?php if($data['ptr81'] == 1) echo 'checked' ?> data-am-ucheck checked> 开-->

                      <!--</label>-->
                      <!--<label class="am-radio-inline">-->
                        <!--<input type="radio" name="ptr81" value="2" <?php if($data['ptr81'] == 2) echo 'checked' ?> data-am-ucheck > 关-->
                      <!--</label>-->
                    <!--</div>-->
                  <!--</div>-->
                <!--</tr>-->
                <tr>
                  <td colspan="3"> 自动审核</td>
                  <td style="width: 14rem;">
                    <label class="am-radio-inline">
                      <input type="radio" name="ptr98" value="1"  <?php if($data['ptr98'] == 1) echo 'checked' ?> data-am-ucheck checked> 开

                    </label>
                    <label class="am-radio-inline">
                      <input type="radio" name="ptr98" value="2" <?php if($data['ptr98'] == 2) echo 'checked' ?> data-am-ucheck > 关
                    </label>
                  </td>

                  <td colspan="2">微矿机</td>
                  <td style="width: 14rem;">
                    <label class="am-radio-inline">
                      <input type="radio" name="ptr99" value="1"  <?php if($data['ptr99'] == 1) echo 'checked' ?> data-am-ucheck checked> 未售罄

                    </label>
                    <label class="am-radio-inline">
                      <input type="radio" name="ptr99" value="2" <?php if($data['ptr99'] == 2) echo 'checked' ?> data-am-ucheck > 售罄
                    </label>
                  </td>
                </tr>


              <tr>
                <td colspan="3">HAPY</td>
                <td><input type="text" name="hapy" value="<?php echo ($data["hapy"]); ?>"></td>
                <td colspan="2">HAPY当前价格</td>
                <td><input type="text" name="hapyfloat" value="<?php echo ($data["hapyfloat"]); ?>"></td>
                <td colspan="2">HAPY涨幅比例</td>
                <td></td>
                <td colspan="2"></td>
                <td></td>
                <td colspan="2"></td>
              </tr>

              <tr>
                <td colspan="3">HAPY提币</td>

                <td><input type="text" name="ptr68" value="<?php echo ($data["ptr68"]); ?>"></td>
                <td colspan="2">提币次数</td>

                <td></td>
                <td colspan="2"></td>
              </tr>


              <tr>
                <td colspan="3">HAPY提币BTC</td>
                <td><input type="text" name="ptr77" value="<?php echo ($data["ptr77"]); ?>"></td>
                <td colspan="2">最低提币限额</td>
                <td><input type="text" name="ptr69" value="<?php echo ($data["ptr69"]); ?>"></td>
                <td colspan="2">每日最高提币限额</td>
                <td><input type="text" name="ptr73" value="<?php echo ($data["ptr73"]); ?>"></td>
                <td colspan="2">提币手续费（0.01表示1%）</td>
                <td></td>
                <td colspan="2"></td>
              </tr>

              <tr>
                <td colspan="3">HAPY提币ETH</td>
                <td><input type="text" name="ptr78" value="<?php echo ($data["ptr78"]); ?>"></td>
                <td colspan="2">最低提币限额</td>
                <td><input type="text" name="ptr70" value="<?php echo ($data["ptr70"]); ?>"></td>
                <td colspan="2">每日最高提币限额</td>
                <td><input type="text" name="ptr74" value="<?php echo ($data["ptr74"]); ?>"></td>
                <td colspan="2">提币手续费（0.01表示1%）</td>
                <td></td>
                <td colspan="2"></td>
              </tr>

              <tr>
                <td colspan="3">HAPY提币USDT</td>
                <td><input type="text" name="ptr79" value="<?php echo ($data["ptr79"]); ?>"></td>
                <td colspan="2">最低提币限额</td>
                <td><input type="text" name="ptr71" value="<?php echo ($data["ptr71"]); ?>"></td>
                <td colspan="2">每日最高提币限额</td>
                <td><input type="text" name="ptr75" value="<?php echo ($data["ptr75"]); ?>"></td>
                <td colspan="2">提币手续费（0.01表示1%）</td>
                <td></td>
                <td colspan="2"></td>
              </tr>

              <tr>
                <td colspan="3">HAPY提币IOTE</td>
                <td><input type="text" name="ptr80" value="<?php echo ($data["ptr80"]); ?>"></td>
                <td colspan="2">最低提币限额</td>
                <td><input type="text" name="ptr72" value="<?php echo ($data["ptr72"]); ?>"></td>
                <td colspan="2">每日最高提币限额</td>
                <td><input type="text" name="ptr76" value="<?php echo ($data["ptr76"]); ?>"></td>
                <td colspan="2">提币手续费（0.01表示1%）</td>
                <td></td>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td colspan="3">HAPY提币IOTE奖金</td>
                <td><input type="text" name="ptr94" value="<?php echo ($data["ptr94"]); ?>"></td>
                <td colspan="2">最低提币限额</td>
                <td><input type="text" name="ptr95" value="<?php echo ($data["ptr95"]); ?>"></td>
                <td colspan="2">每日最高提币限额</td>
                <td><input type="text" name="ptr96" value="<?php echo ($data["ptr96"]); ?>"></td>
                <td colspan="2">提币手续费（0.01表示1%）</td>
                <td><input type="text" name="ptr97" value="<?php echo ($data["ptr97"]); ?>"></td>
                <td colspan="2">奖金提币次数</td>
                <td colspan="2"></td>
              </tr>
              <tr>
                <div class="am-form-group">
                  <label class="am-u-sm-3 am-form-label">会员转账</label>
                  <div class="am-u-sm-9">
                    <label class="am-radio-inline">
                      <input type="radio" name="ptr81" value="1"  <?php if($data['ptr81'] == 1) echo 'checked' ?> data-am-ucheck checked> 开

                    </label>
                    <label class="am-radio-inline">
                      <input type="radio" name="ptr81" value="2" <?php if($data['ptr81'] == 2) echo 'checked' ?> data-am-ucheck > 关
                    </label>
                  </div>
                </div>
              </tr>
              <hr>
<!--              <tr>-->
<!--                <td colspan="3">分享赚钱</td>-->

<!--                <td><input type="text" name="ptr84" value="<?php echo ($data["ptr84"]); ?>"></td>-->
<!--                <td colspan="2">推荐临时会员赠送奖励</td>-->

<!--                <td></td>-->
<!--                <td colspan="2"></td>-->
<!--              </tr>-->


              <tr>
                <td colspan="3">HAPY签到</td>

                <td><input type="text" name="ptr62" value="<?php echo ($data["ptr62"]); ?>"></td>
                <td colspan="2">签到数量/次</td>

                <td></td>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td colspan="3">挖矿算力</td>
<!--                <td><input type="text" name="ptr85" value="<?php echo ($data["ptr85"]); ?>"></td>-->
<!--                <td colspan="2">临时会员挖矿算力(0.001表示1%)</td>-->
                <td><input type="text" name="ptr86" value="<?php echo ($data["ptr86"]); ?>"></td>
                <td colspan="2">挖矿算力(0.001表示1%)</td>
                <td></td>
                <td colspan="2"></td>
              </tr>

              <tr>
                <td colspan="3">分享收益</td>
                <td><input type="text" name="ptr63" value="<?php echo ($data["ptr63"]); ?>"></td>
                <td colspan="2">第一代百分比(0.3表示30%)</td>
                <td><input type="text" name="ptr64" value="<?php echo ($data["ptr64"]); ?>"></td>
                <td colspan="2">第二代百分比(0.3表示30%)</td>
<!--                <td><input type="text" name="ptr65" value="<?php echo ($data["ptr65"]); ?>"></td>-->
<!--                <td colspan="2">第三代 - 第六代百分比(0.3表示30%)</td>-->
<!--                <td><input type="text" name="ptr66" value="<?php echo ($data["ptr66"]); ?>"></td>-->
<!--                <td colspan="2">第七代 - 第十代百分比(0.3表示30%)</td>-->
<!--                <td><input type="text" name="ptr67" value="<?php echo ($data["ptr67"]); ?>"></td>-->
<!--                <td colspan="2">第五-十代百分比(0.3表示30%)</td>-->
                <td></td>
                <td colspan="2"></td>
              </tr>

              <tr>
                <td colspan="3">团队收益</td>
                <td><input type="text" name="ptr88" value="<?php echo ($data["ptr88"]); ?>"></td>
                <td colspan="2">v1团队收益比例(0.3表示30%)</td>
                <td><input type="text" name="ptr89" value="<?php echo ($data["ptr89"]); ?>"></td>
                <td colspan="2">v2团队收益比例(0.3表示30%)</td>
                <td><input type="text" name="ptr90" value="<?php echo ($data["ptr90"]); ?>"></td>
                <td colspan="2">v3团队收益比例(0.3表示30%)</td>
                <td><input type="text" name="ptr91" value="<?php echo ($data["ptr91"]); ?>"></td>
                <td colspan="2">v4团队收益比例(0.3表示30%)</td>
                <td><input type="text" name="ptr92" value="<?php echo ($data["ptr92"]); ?>"></td>
                <td colspan="2">v5团队收益比例(0.3表示30%)</td>
                <td><input type="text" name="ptr93" value="<?php echo ($data["ptr93"]); ?>"></td>
                <td colspan="2">v6团队收益比例(0.3表示30%)</td>
              </tr>

              <tr>
                <td colspan="3">兑换比例</td>
                <td colspan="2">100 USDT = </td>
                <td><input type="text" name="ptr87" value="<?php echo ($data["ptr87"]); ?>"></td>
                <td colspan="2">IOTE</td>
<!--                <td><input type="text" name="ptr86" value="<?php echo ($data["ptr86"]); ?>"></td>-->
<!--                <td colspan="2">会员挖矿算力(0.001表示1%)</td>-->
                <td></td>
                <td colspan="2"></td>
              </tr>
                <tr>
                  <td colspan="3">商城支付钱包地址</td>
                  <td colspan="6"><input type="text" name="pay_address" value="<?php echo ($data["pay_address"]); ?>"></td>
                </tr>
                <!-- <tr>
                  <td colspan="3">烧伤开关</td>
                  <td colspan="6">
                    <select name="sskg">
                      <option value="1" <?php if($data["sskg"] == 1): ?>selected<?php endif; ?>>开</option>
                      <option value="0" <?php if($data["sskg"] == 0): ?>selected<?php endif; ?>>关</option>
                    </select>
                  </td>
                </tr>-->
              </tbody>
            </table>
            <tr>
              <td><button type="submit" id="btn" class="am-btn am-btn-primary">提交</button></td>
            </tr>
          </form>
        </div>

      </div>
    </div>
    <footer class="admin-content-footer">
      <hr>
      <p class="am-padding-left">© 2019 AllMobilize, Inc. Licensed under MIT license.</p>
    </footer>
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
       var form = $('form');
       $('form').submit(function (e) {
           e.preventDefault();
           var btn = $('#sub');
           btn.button('loading');
           $.post(form.attr('action'),form.serialize(),function (data) {
               btn.button('reset');
               layer.msg(data.msg,{time:1000},function () {
                   if(data.code){
                       return false;
                   }else{
                       window.location.href=data.data;
                   }
               })
           },'json')
       })
   })
</script>

</body>
</html>