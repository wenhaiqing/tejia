<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plugin/navs', TEMPLATE_INCLUDEPATH)) : (include template('plugin/navs', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('navs', TEMPLATE_INCLUDEPATH)) : (include template('navs', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading">
		使用手册
	</div>
	
	<div class="panel-body">
	     <div class="media">
		    <h4 class="media-heading">1、手机端底部导航空白？没有导航？</h4>
		  答:参数设置--导航设置--客户端/服务端/个人中心/物流中心--点击‘一键生成’</br>
           <h4 class="media-heading">2、点击我要发货-信息没有生成？</h4>
		  答:参数设置--帮我送--保存设置--帮我送页面DIY--保存数据
		</div>
		<div class="media">
		  <a class="media-body" href="http://wiki.012wz.com/" target="_blank">
		    <h4 class="media-heading">阿里大鱼短信接口配置</h4>
		  </a>
		</div>
		<div class="media">
		  <a class="media-body" href="http://wiki.012wz.com/" target="_blank">
		    <h4 class="media-heading">一直提示请在微信中打开是怎么回事？</h4>
		  </a>
		</div>
		
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>