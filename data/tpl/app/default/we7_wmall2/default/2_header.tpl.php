<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php  if(empty($title)) { ?><?php  echo $_W['we7_wmall2']['config']['title'];?><?php  } else { ?><?php  echo $title;?><?php  } ?></title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="../addons/we7_wmall2/resource/app/css/light7.min.css" />
		<link rel="stylesheet" href="../addons/we7_wmall2/resource/app/css/iconfont.css" />
		<link rel="stylesheet" href="../addons/we7_wmall2/resource/app/css/light7-swiper.min.css" />
		<link rel="stylesheet" href="../addons/we7_wmall2/resource/app/css/index.css?t=<?php  echo time()?>" />
		<script type='text/javascript' src='../addons/we7_wmall2/resource/app/js/jquery-2.2.1.min.js' charset='utf-8'></script>
		<script>
			$.config = {router: false}
		</script>
		<script type='text/javascript' src="../addons/we7_wmall2/resource/app/js/laytpl.dev.js"></script>
		<script type='text/javascript' src='../addons/we7_wmall2/resource/app/js/light7.min.js' charset='utf-8'></script>
		<script type='text/javascript' src='../addons/we7_wmall2/resource/app/js/i18n/cn.js' charset='utf-8'></script>
		<script type="text/javascript" src="../addons/we7_wmall2/resource/app/js/light7-swiper.min.js"></script>
		<script type="text/javascript" src="../addons/we7_wmall2/resource/app/js/common.js?t=1111"></script>
	</head>
	<body>
	<?php  echo register_jssdk(false);?>