<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/header1', TEMPLATE_INCLUDEPATH)) : (include template('default/common/header1', TEMPLATE_INCLUDEPATH));?>
<div class="container" id="pjax-container" style="margin-top:0px;">
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template($template_content, TEMPLATE_INCLUDEPATH)) : (include template($template_content, TEMPLATE_INCLUDEPATH));?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/footer', TEMPLATE_INCLUDEPATH)) : (include template('default/common/footer', TEMPLATE_INCLUDEPATH));?>