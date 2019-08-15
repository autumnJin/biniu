/**
 * Created by Administrator on 2017/4/12 0012.
 */


    // $('.form-horizontal').validate({
    //     // rules:{
    //     //     confirmpsd1new: {
    //     //         required: true,
    //     //         equalTo: "#confirmpsd1",
    //     //     },
    //     //
    //     //     confirmpsd2new:{
    //     //         required: true,
    //     //         equalTo: "#confirmpsd2",
    //     //     }
    //     // }
    // });


    function  ajax_sub(url,data,btn) {

        //   var btn_sub = $('.btn-sub');
                var btn_name = btn.html();
               $.ajax({
                   cache: true,
                   type: "POST",
                   url:url,
                   data:data,// 你的formid
                   async: false,
                   dataType:'json',
                   beforeSend:function () {
                       btn.html('正在提交');
                       btn.attr({ 'disabled': true })
                   },
                   error: function(data) {
                       alert('请先登录');
                       window.location.href="/index.php/Public/login";
                   },
                   success: function(data) {
                       if(data.msg){
                           alert(data.msg);
                       }
                        if(data.code){
                            return false;
                        }else{
                            if(data.data){
                                window.location.href=data.data;
                            }
                        }
                   },
                   complete:function () {
                       btn.removeAttr("disabled");
                       btn.html(btn_name);

                   }
               })


    }

function  ajax_sub_(url,data,btn) {
    //   var btn_sub = $('.btn-sub');
    var btn_name = btn.val;
    $.ajax({
        cache: true,
        type: "POST",
        url:url,
        data:data,// 你的formid
        async: false,
        dataType:'json',
        beforeSend:function () {
            btn.attr({ 'disabled': true })
        },
        error: function(data) {
            alert("Connection error");
        },
        success: function(data) {
            alert(data.msg);
            if(data.code){
                return false;
            }else{
                if(data.data){
                    window.location.href=data.data;
                }
            }
        },
        complete:function () {
            btn.removeAttr("disabled");

        }
    })


}


