<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0, maximum-scale=1.0,user-scalable=0">
    <meta name="format-detection" content="telephone=no"/>
    <title><?php  if(!empty($title)) { ?><?php  echo $title;?> - <?php  } else if(!empty($_W['page']['title'])) { ?><?php  echo $_W['page']['title'];?> - <?php  } ?><?php  if(!empty($_W['page']['sitename'])) { ?><?php  echo $_W['page']['sitename'];?><?php  } else { ?><?php  echo $_W['account']['name'];?><?php  } ?></title>

    <style>
        html,body{
            width:100%;
            overflow:hidden;
        }
        #app{
            width:100%;
            overflow:hidden;
        }
        .active{
            color:#04BE02 !important;
        }
        .vux-slider>.vux-swiper>.vux-swiper-item {
            overflow:hidden;
        }
        p{
            margin:0px;
        }
        .m-title {
            font-size: 10px;
            overflow:hidden;
        }
        .vux-timeline-item-head-first {
            width: 20px;
            height: 20px;
            left: -4px;
            top: 5px;
        }
        .vux-timeline-item-head, .vux-timeline-item-head-first {
            position: absolute;
            content: '';
            z-index: 99;
            border-radius: 99px;
        }
    </style>
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>public/libs/vux/vux.css?t=<?php  echo time()?>"/>
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>public/libs/ionic/css/ionic.css"/>

    <script src="<?php echo MODULE_URL;?>public/js/require.js"></script>
    <script src="<?php echo MODULE_URL;?>public/js/config.js"></script>

    <script>
        var jssdkconfig = <?php  echo json_encode($_W['account']['jssdkconfig']);?> || {};
        // �Ƿ����õ���
        jssdkconfig.debug = false;
        jssdkconfig.jsApiList = [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'
        ];
    </script>
</head>
<body>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/share', TEMPLATE_INCLUDEPATH)) : (include template('default/common/share', TEMPLATE_INCLUDEPATH));?>