<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0, maximum-scale=1.0,user-scalable=0">
    <meta name="format-detection" content="telephone=no"/>
    <title><?php  if(!empty($title)) { ?><?php  echo $title;?> - <?php  } else if(!empty($_W['page']['title'])) { ?><?php  echo $_W['page']['title'];?> - <?php  } ?><?php  if(!empty($_W['page']['sitename'])) { ?><?php  echo $_W['page']['sitename'];?><?php  } else { ?><?php  echo $_W['account']['name'];?><?php  } ?></title>
    <script>
        var timer = null;
        // jssdk config 对象
        jssdkconfig = <?php  echo json_encode($_W['account']['jssdkconfig']);?> || {};
        // 是否启用调试
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
<body ontouchstart>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/share_base', TEMPLATE_INCLUDEPATH)) : (include template('default/common/share_base', TEMPLATE_INCLUDEPATH));?>