!(function(){
	// $(document).on('click','#getCode',function(){
	    $("#getCode").on('click',function(){
		var num=59;
            var that=$(this);
            var phone=$('#phone').val();
		if (phone=='') {
			alert('请输入注册的手机号码');
		}else if(!(/^1[34578]\d{9}$/.test(phone))){
			alert('手机号码格式不正确');
		}else{
		    $.post('http://www.ghaglobal.com/index.php/Public/sendCode',{"phone":phone},function(data){
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
//	13554087066

	$(document).on('click','#forget input[type=submit]',function(){
		var passwords=$("#forget #password").val();
		var confirmpwd=$("#forget #confirmpwd").val();
		if (passwords!=confirmpwd) {
			alert('两次输入的密码不一样！');
		}
	})
	$(document).on('click','#goback',function(){
		window.history.back();
	})
})();
!(function(){
	var mySwiper = new Swiper("#banner .swiper-container",{
	    autoplay: {
		    delay: 4000,
		    stopOnLastSlide: false,
		    disableOnInteraction: false,
	    },
	    loop:true,
	    pagination: {
		    el: '.swiper-pagination',
		     clickable :true,
		},
	});
})();
// !(function(){
//   $(document).on('click','#getCodes',function(){
//     var num=59;
//     var that=this;
//     var timer=setInterval(function(){
//       $(that).attr('id','');
//       $(that).text(num+'s');
//       num--;
//       if(num==0){
//         $(that).attr('id','getCode');
//         clearInterval(timer);
//         $(that).text('重新发送验证码');
//       }
//     },1000);
//   })
// })();
!(function(){
  $(document).on('click',"#paystyle .content li .box",function(){
      $("#paystyle .content li .box").removeClass('active');
      $(this).addClass('active');
  })
})();
!(function(){
  $(document).on('click',"#getMoney .content li .box",function(){
      $("#getMoney .content li .box").removeClass('active');
      $(this).addClass('active');
  })
})();
!(function(){
  $(document).on('click',"#register  #regd",function(e){
      e.preventDefault();
      $("#register .navs a").removeClass('active');
      $("#register .navs a").eq(1).addClass('active');
       $('#register .forms').removeClass('active');
      $('#register .forms').eq(1).addClass('active');
  })
})();

!(function(){
  $(document).on('click',"#lokpsd",function(){
      if ($(this).siblings('input').prop('type')=='password') {
        $(this).siblings('input').prop('type','text');
        $(this).prop('src','../img/eyeopen.png');
        $(this).css('top','0.2rem');
      }else{
         $(this).siblings('input').prop('type','password');
         $(this).prop('src','../img/eyes.png');
         $(this).css('top','0.4rem');
      };
  })
})();
!(function(){
  $(document).on('click',"#submitOrder #forlogistics",function(){
      $("#submitOrder #logistics").addClass('active');
  })
})();
!(function(){
  $(document).on('click',"#register .navs a",function(e){
      e.preventDefault();
      $("#register .navs a").removeClass('active');
      $(this).addClass('active');
      $('#register .forms').removeClass('active');
      $('#register .forms').eq($(this).index()).addClass('active');
  })
})();
!(function(){
  $(document).on('click',"#chekall",function(){
  	  if($(this).prop('checked')){
          $(this).siblings('span').text('取消');
          $('#shoppingCart .boxs .one input').prop('checked',true);
  	  }else{
  	  	$(this).siblings('span').text('全选');
  	  	$('#shoppingCart .boxs .one input').prop('checked',false);
  	  }
  })
})();

!(function(){
  $(document).on('click',"#edit",function(){
  	  if ($(this).text()=='编辑') {
  	  	$(this).text('完成');
  	  	$("#shoppingCart .cartpay .two").css('display','none');
  	  	$('#shoppingCart #balance').removeClass('active');
  	  	$('#shoppingCart #delete').addClass('active');
  	  }else{
  	  	$(this).text('编辑');
  	  	$("#shoppingCart .cartpay .two").css('display','block');
  	  	$('#shoppingCart #delete').removeClass('active');
  	  	$('#shoppingCart #balance').addClass('active');
  	  }
  })
})();

!(function(){
    function updatanums(){
    	var total=$('#total');
        var prices=$('#prices');
    	total.text('x'+parseInt(nums.val()));
    }
    $(document).on('click','#books',function(){
		$('#confirmorder').css('display','block');
	})
   var nums=$('#nums');
    $(document).on('click','#confirmorder #cancel',function(){
		$(this).parents('#confirmorder').css('display','none');
	})
   $(document).on('click','#add',function(){
        nums.val(parseInt(nums.val())+1);
        updatanums();
	})
   $(document).on('click','#reduce',function(){
        if (parseInt(nums.val())==1) {
        	nums.val(nums.val());
        }else{
        	nums.val(parseInt(nums.val())-1);
        	updatanums();
        }
	})
})();
!(function(){
    $(document).on('change','#selectImg',function(){
        var reader=new FileReader();
        reader.onload=function(e){
          $('#selectImg').siblings(".myi").attr('src',reader.result);
        }  
       reader.readAsDataURL(this.files[0]);
    })
    $(document).on('change','#selectImgs',function(){
        var reader=new FileReader();
        reader.onload=function(e){
          $('#selectImgs').siblings(".myi").attr('src',reader.result);
        }  
       reader.readAsDataURL(this.files[0]);
    })
})();