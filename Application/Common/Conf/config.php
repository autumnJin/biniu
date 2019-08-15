<?php
return array(
	//'配置项'=>'配置值'

    'LOAD_EXT_CONFIG' => 'db',


    'site_url' => 'http://tj0410.lgwsh.net/index.php',
    //微信配置
    'Token' => 'ms_2017',
    'APP_ID' => 'wxcbb7923b8289188b',
    'APPSECRET'=> '98c2d5df4a076001e541732c3a5f6537',

    //聚合数据  appkey

    //短信配置
    'SMS'=>array(
        'UID'=>'txhtsms0020',
        'PWD'=>'478db1cae8ab201a53f621e8e1d7762e'
    ),
    'URL_CASE_INSENSITIVE' =>true,

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
        '__ADMIN__'    =>__ROOT__ . '/Public/Admin/assets',
        '__COMMON__'  =>__ROOT__.'/Public/common',
        '__LIB__' => __ROOT__.'/Public/lib',
    ),

    'GOODS_LOGO_WIDTH' => 220,
    'GOODS_LOGO_HEIGHT' =>220,
    'GOODS_ALBUM_WIDTH' => 640,
    'GOODS_ALBUM_HEIGHT' => 300,
    'GOODS_BANNER_WIDTH' => 500,
    'GOODS_BANNER_HEIGHT' => 300,

    'DEFAULT_FILTER' => 'htmlspecialchars,stripslashes,trim',


    'MAX_SIZE'=>array(
        'header'=> 1048576,
        'goods' => 2097152,
        ),
    'UPLOAD_PATH'=>'/Uploads/',

    'AREA'=>array(
        1 => '热销',
        2 => '零售专区',
        3 => '新品上架',
        4 => '复消专区'
    ),

    //代理等级
    'agent_level'=>array(
      0=>'',
      1=>'县级代理',
      2=>'市级代理',
      3=>'省级代理',
      4=>'全国代理',
    ),

    //中心等级
    'center_level'=>array(
        0=>'',
        1=>'连锁店',
        2=>'运营中心',
        3=>'市级公司',
        4=>'省级公司',
    ),

    //用户等级
    'level'=>array(
        0=>'普通用户',
        1=>'正式会员',
    ),

    //团队等级
    'td_level'=>array(
        0=>'普通用户',
        1=>'站长',
        2=>'县代理',
        3=>'市代理',
        4=>'省代理',
        5=>'合伙人',
    ),


    'ROLE'=>array(
        1=>'普通会员',
        2=>'商家',

    ),

    'FORMAT'=>array(
        1=>'袋',
        2=>'盒',
        3=>'箱',
        4=>'个',
        5=>'瓶',
    ),

    'ORDER'=>array(
        1 => '待付款',
        2 => '已付款',
        3 => '已取消',
        5 => '已发货',
    ),

    'TIXIAN'=>array(
        2 => '充值账户',
        5 => '银行卡'
    ),

    'TIXIAN_STATUS'=>array(
        0=> '待审核',
        2=> '通过',
        3 => '驳回'
    ),

    'WITHDRAW_STATUS'=>array(
        1=> '已完成',
        2=> '待审核',
        3 => '已驳回'
    ),

    'leixing'=>array(
      5=>'IOTE',
      7=>'BTC',
        8=>'USDT',
        9=>'ETH',
    ),


    //奖金类型
    'reward_type'=>array(
        1 => '激活返还',
        2 => '推荐奖',
        3 => '周返',
        4 => '团队奖励',
        5 => '加速释放',
        6 => '复投',
        7 => '转出',
        8 => '转入',
        9 => '转换WFX',
        10 => '流通积分转换',
    ),

    'account_type'=>array(
        1 => '充值积分',
        2 => '流通积分',
        3 => '购物积分',
        4 => '兑换积分',
        5 => 'IOTE',
        7=>'BTC',
        8=>'USDT',
        9=>'ETH',
    ),


    'goods_type'=>array(
        1=>'注册单',
        2=>'零售单',
    ),

    "alipay" => array(
        //应用ID,您的APPID。
        'app_id' => "2018112062245644",

        //商户私钥，您的原始格式RSA私钥
        'merchant_private_key'=>'MIIEogIBAAKCAQEAupMYPmQb2YTGI4kWgREPRnHhDux0M+KK8tFVoXmkRdnYR7sBmYQ9BJdGFd1Bpp3WFxC2qIK+YB2kqwjz2BqhlS1BLWqTP5cEb+iA9fmA5dwqaG30yshDzOhDgcQ1gjRlejpFdOirYLS0ompRPQvDSRA/9ZXKPdm3Cfooc0mXfkFYaFoo5xxjEltokHmjGHuK2FB7XPWLwS01WADb+gCJNx2tup8E3SN/1uvUYRyuZpJajeMjgWViOQzlrL7j4NANDBi5f9eseTr0UkF4nD6L8TPhU32/FS6qXP+uOmYOJK2/PFxrFAYlzUIycS0VYYUueZPBwHXtcfYfyUxJbBallwIDAQABAoIBAB5r6aIStK/NBHm62p6E55a27tl+GJx1Le7Vzz6bFPwGv0tC5MnhVAmxmM3r286NIeF06jOjzeLiMn1o4km0XfBzBpOfMw9FUoXkxVJWMnxIX+nTM/z0lomMvaUlFwx5+qnpYnXjkj4ceO+aolBv4JHDQoqKuAVJwJyx23Kg50DAo528U1meSrgXtqRgli3IT65YxzLIbeUBeIzLAH+AiUxBiVMD4MrLp4BZoVR7C/LpKkhI6swgsTQrOOndqYDyP/fyo5+DXqYzGCQB4lr/ewToKtxoVAIRLxeBT6kHYb+ildUnH2+ApYsyJBXS/9uXPxFsi6Ldoop3IJSxDC0IrAECgYEA34ejvRJY9u8h3GdjVyzNjvQrvKiubFK23lmsqV1XOzAqzqvx2Uj5HKVd3f///1vILBEXdL6mmKm4sYi3Aayg617yjq3OC5Rpg/+G8fXEZ3xQvOtC1+ncCZVFaPstmwOPUa7siJ+Ts8oC4eI+Brxb7n+xPfE6/6BjKLV7usPL/JcCgYEA1a01E90oILaMIdbKb8x59o6biFVSp1OlZrPh8RpDzjlJE7+ji1dOH6LLTIZInB4SdDbckfCcQgp0nW2ECq0G6RYQeQ8aZOq3s4TYXf+yAjzApnpDzg2izpGTexfb3OWy0+a5asz9FLrDJBiDsQI63bzy0+80qqRaHXXOVRyavwECgYACP2frF8sjOIZbpAKAtueeP2BNNlkCp9ZE6BvvXAvrgXF8wIffCnfOzO7js5ZMaAzcPJPCzcP5FwPPbTOB5c18cGj5/E9tGGHzPNeLiVAfRkW9kJQMfcKDqieXhacQvvlq9dpVCV2/2hErWk4LXUuDW29Z0xonxeIZX7HNz/g2IwKBgFsPQnRhpk0ynkt5drHoSP2azotuGRg33GAFPr95+vVykkL5Q2AJZ8CxpsPI4j6tzh16l8sV5/F49TN1zXSjQjOo9IIyvoPNR1YYwgBlDF5Jt6v6pNS2GPDBN0GY7FiaBvio9dGe5CemY60JSW3wzldaw30wDpi+C61MXA8HbqcBAoGAB70N45quxyvEOK+rbkHaD/AYMc4WcGhqZiPUwO4dr53x8ImeENWU6dypFAaUqHxp4ZCnGcxcSWYpA+t/swJG8OXXITWak3bKAmfXvrxwLv/I8JAmnr0trnSlbZXfAgFKm43XOdXZYeGimkQSHhDosN315v0s0dHFnnxCL6x8Bww=',
        //异步通知地址
        'notify_url' => "http://yn91009.tianruisoft.com/index.php/Public/zfb_notify",

        //同步跳转
        'return_url' => "http://yn91009.tianruisoft.com/index.php/Public/zfb_return",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA2",

        //支付宝网关
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAo10kgyERW4u4Cm2DJskHRL7HbEKCrTFyqer2ZFyYbMGqlgLvVImO3UZcZwU6pV7NWBp+BIbYAU094EmX2kp/8uutKpC3lOWuL+JQKm/TDkKm1Tnr113TqD40K6E3sUNr5yW/gLhVR3m84iEim8b+r17+g8JSM0HzQZew5F+zBG6aJXggLVCiHNncAkdz35pj2dYC1MaxGEXCLsm3r5kX+mI3FUtpZCwEGnLK8cqpQkznJIzHsAPCP3WGjieIbdVLLnIr2zlo1YDleS08jlXCc9Ld4NCzD5R7Y1qJA5MnzRKVi2EgqMPbJrVzvsYNCYBQ+31i7q0DNsSA2wu+KAFdcwIDAQAB",

    ),
    //usdt的omoni版本链接信息 $coininfo=C('OMNI');
    "OMNI"=>array(
        'user'=>"usdtomni",
        'pass'=>"usdtomni",
        'ip'=>"47.245.58.232",
        'port'=>"60001",
        'address'=>"396emUCuHYwCMzjapvq2YLrTMS2doVsJAM",//手续费地址
        'center_address'=>"396emUCuHYwCMzjapvq2YLrTMS2doVsJAM",//平台钱包地址
    )
);

