<?php
return array(
    //'配置项'=>'配置值'


    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
        '__WAPADDONS__' => __ROOT__ . '/Public/Wap/Addons',
        '__WAPIMG__'    => __ROOT__ . '/Public/Wap/img',
        '__WAPCSS__'    => __ROOT__ . '/Public/Wap/css',
        '__WAPJS__'     => __ROOT__ . '/Public/Wap/js',
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
    'UPLOAD_PATH'=>'./Uploads/',

    'AREA'=>array(
        1 => '热销',
        2 => '零售专区',
        3 => '新品上架',
        4 => '复消专区'
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
        5 => '已发货',
    ),

    'TIXIAN'=>array(
        2 => '充值账户',
        5 => '银行卡'
    ),

    'TIXIAN_STATUS'=>array(
        1=> '待审核',
        2=> '通过',
        3 => '驳回'
    ),


    'account_type'=>array(
        1 => '钱包',
        2 => '里程资产',
        3 => '虚拟币',
        4 => '消费积分',
    )

,'liu_shui'=>array(
        1 => '提现',
        2 => '充值',
        3 => '转账',
        4 => '购物',
        5 => '收到转账',
        6=>  '赠送',
        7=>'报单'
    ),

    'goods_type'=>array(
        1=>'注册单',
        2=>'零售单',
    ),
    'COIN_TYPE'=>array(
//        5 => 'WFX',
        5 => 'IOTE',
        6 => '算力钱包',
        7 => 'BTC',
        8 => 'USDT',
        9 => 'ETH'
    )
);

