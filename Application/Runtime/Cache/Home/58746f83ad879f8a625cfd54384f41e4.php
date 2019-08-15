<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HPAY</title>
    <link rel="stylesheet" href="/Public/Wap/css/mui.min.css">
    <link rel="stylesheet" href="/Public/Wap/css/discover.css">

    <script src="/Public/Wap/js/zepto.min.js"></script>
    <script src="/Public/Wap/js/mui.min.js"></script>
    <script src="/Public/Wap/js/1.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Wap/css/common.css"/>


    <!--<link rel="stylesheet" type="text/css" href="/Public/Wap/css/swiper.min.css"/>-->
    <!--<script src="/Public/Wap/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
    <!--<script src="/Public/Wap/js/main.js" type="text/javascript" charset="utf-8"></script>-->
    <!--<script src="/Public/common/js/common.js" type="text/javascript" charset="utf-8"></script>-->
 <!---->
</head>
<style>
#updateAddress .content .forms .names .trueAddress {
    width: 16%;
}
#updateAddress .content .forms #pro,#updateAddress .content .forms #city,#updateAddress .content .forms #area {
    width: 23%;
    margin-left: 2%;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: .1rem 0;
}
#updateAddress .content .forms .names .trueAddress,#updateAddress .content .forms #pro,#updateAddress .content .forms #city,#updateAddress .content .forms #area {
    display: inline-block;
    float: left;
}
#updateAddress .content .forms .names label{
    font-size: 12px;
}
#container {
    display: none;
}#updateAddress .content .forms .names input, #updateAddress .content .forms .names textarea{
    font-size: 12px;
 }
#updateAddress .content .forms #btn{
    height: 40px;
    font-size: 14px;
    margin-top: 20px;
    line-height: 40px;
    padding: 0;
}
</style>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    html {
        font-size: 13.3333333333333vw;
    }
    .header{
        background: linear-gradient(to right, #1e91ff, #075ffe);
        height: 1.16rem;
        line-height: 1.4rem;
        color: #fff;
        text-align: center;
        font-size: .34rem;
        border-bottom: 1px solid #ececec;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 .2rem;
    }
    .header a{
        width: .2rem;
        display: inline-block;
    }
    .header a img{
        width: 100%;
    }
    .container{
        width: 100%;
        padding: .2rem;
    }
</style>
<div id="updateAddress">

    <header class="header">
        <a href="javascript:history.back(-1)"><img src="/Public/Wap/img/arrowl.png"></a>
        <div>添加地址</div>
        <a href="javascript:void(0)" style="opacity: 0"><img src="/Public/Wap/img/arrowl.png"></a>
    </header>


    <div class="content">
        <div class="container">
            <div class="forms">
                <form action="">
                    <div class="names">
                        <label>收货人</label>
                        <input id="user-name" name="receiver" type="text" placeholder="" value="<?php echo ($data["receiver"]); ?>" />
                    </div>
                    <div class="names">
                        <label>联系电话</label>
                        <input id="user-phone" name="phone" type="tell" placeholder="" value="<?php echo ($data["phone"]); ?>" />
                    </div>

                    <div class="names">
                        <label>钱包地址</label>
                        <input id="wallet_address" name="wallet_address" type="text" placeholder="" value="<?php echo ($data["wallet_address"]); ?>" />
                    </div>

                    <div class="names">
                        <label class="trueAddress">所在地</label>
                        <select  id="pro" name="prince">
                            <option value="0">省份</option>
                            <?php if(is_array($p)): $i = 0; $__LIST__ = $p;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["provinceid"]); ?>"  <?php if($vo['provinceid'] == $data['prince']) echo 'selected' ?>><?php echo ($vo["province"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <select  id="city"  name="city" required>
                            <option value="0">市</option>
                            <?php if($data != null): if(is_array($c)): $i = 0; $__LIST__ = $c;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["cityid"]); ?>" <?php if($v['cityid'] == $data['city']) echo 'selected' ?>><?php echo ($v["city"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>

                        </select>
                        <select  id="area" name="area" required>
                            <option value="0">区</option>
                            <?php if($data != null): if(is_array($a)): $i = 0; $__LIST__ = $a;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["areaid"]); ?>" <?php if($v['areaid'] == $data['area']) echo 'selected' ?>><?php echo ($v["area"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                        </select>
                    </div>
                    <div class="names">
                        <label>详细地址：</label>
                        <textarea required  name="street" id="user-intro" placeholder="输入详细地址"><?php echo ($data["street"]); ?></textarea>
                    </div>
                    <input type="hidden" id="id" value="<?php echo ($data["id"]); ?>" >
                    <input class="getDate" type="button" id="btn" name="" value="添加">
                </form>
            </div>
            <div id="container"></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
<script>
$(function(){
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
    $('#city').change(function(){
        $.ajax({
            type:"post",
            url:"<?php echo U('Public/city_choose');?>",
            data:'city_id='+$('#city').val(),
            dataType:"json",
            success:function(data){
                $('#area').html(data);
            }
        });
    });
//提交数据
    $('.getDate').click(function(){
        //获取经纬度
        let map = new BMap.Map("container");
        let localSearch = new BMap.LocalSearch(map);
        localSearch.enableAutoViewport(); //允许自动调节窗体大小
        function searchByStationName() {
            map.clearOverlays();//清空原来的标注
            let keyword = document.getElementById("user-intro").value;
            localSearch.setSearchCompleteCallback(function (searchResult) {
                let poi = searchResult.getPoi(0); //poi.point.lng:经度, poi.point.lat:纬度
                if(poi == undefined)
                {
                    var lng = 0; //poi.point.lng:经度
                    var lat = 0; //poi.point.lat:纬度
                } else {
                    var lng = poi.point.lng; //poi.point.lng:经度
                    var lat = poi.point.lat; //poi.point.lat:纬度
                }

                //验证
                if($('#user-name').val() == '' || $('#user-phone').val() == '')
                {
                    alert('请填写完整的地址信息！');return;
                }
                if($('#pro').val() == '' || $('#city').val() == '')
                {
                    alert('请填写完整的地址信息！');return;
                }

                if($('#wallet_address').val() == '' )
                {
                    alert('请填写钱包地址！');return;
                }

                //发送请求
                $.ajax({
                    type:"post",
                    url:"<?php echo U('User/add_address_');?>",
                    data:{
                        'id': $('#id').val(),
                        'prince': $('#pro').val(),
                        'city': $('#city').val(),
                        'area': $('#area').val(),
                        'street': keyword,
                        'receiver': $('#user-name').val(),
                        'phone': $('#user-phone').val(),
                        'wallet_address': $('#wallet_address').val(),
                        'longitude': lng,
                        'latitude': lat,
                    },
                    dataType:"json",
                    success:function(data){
                        if(data.code == 1)
                        {
                            alert(data.msg);
                            return;
                        }
                        if(data.code == 0)
                        {
                            alert(data.msg);
                            window.location.href = data.data;
                        }
                    }
                });
            });
            localSearch.search(keyword);
        }

        //执行搜索经纬度
        searchByStationName();
    })
});
</script>