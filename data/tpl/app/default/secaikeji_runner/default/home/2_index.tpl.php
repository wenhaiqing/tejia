<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/header_base', TEMPLATE_INCLUDEPATH)) : (include template('default/common/header_base', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/libs/weui/weui.css"/>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/libs/jquery_weui/jquery-weui.css"/>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/libs/ionic/css/ionic.css"/>
<div class="container" id="pjax-container" style="margin-top:0px;">
	<style>
		.active{color:#04BE02 !important;}
		.tabs-striped .tab-item.tab-item-active, .tabs-striped .tab-item.active, .tabs-striped .tab-item.activated {
			margin-top: -2px;
			border-style: solid;
			border-width: 2px 0 0 0;
			border-color: #04BE02;
		}
		.h44{height:44px;}
		.badge-calm{background-color:#04BE02 !important;}
		img.icon{width: 1em;height: 1em !important;margin-top: 5px;margin-bottom: 5px;}
	</style>
	<div class="page">
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/footerbar', TEMPLATE_INCLUDEPATH)) : (include template('default/common/footerbar', TEMPLATE_INCLUDEPATH));?>
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/home/header', TEMPLATE_INCLUDEPATH)) : (include template('default/home/header', TEMPLATE_INCLUDEPATH));?>
		<div class="hd">
			<div class="list">
				<?php  $navs = M('navs')->getall('user_home')?>
				<?php  if(is_array($navs)) { foreach($navs as $nav) { ?>
				<a class="item item-icon-left item-icon-right" style="padding-top: 12px;"  href="<?php  echo $nav['link']?>">
					<i style="font-size: 1.3em;color: #5d2f18;" class="icon <?php  echo $nav['icon']?>"></i>
					<h2 class="title"><?php  echo $nav['title'];?></h2>
					<i class="icon ion-ios-arrow-right"></i>
				</a>
				<?php  } } ?>
			</div>

		</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/footer', TEMPLATE_INCLUDEPATH)) : (include template('default/common/footer', TEMPLATE_INCLUDEPATH));?>
