<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/template/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/template/navs', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading">
		身份证查询接口
		<a href="http://apistore.baidu.com/apiworks/servicedetail/1480.html" target="_blank" class="btn btn-default">前往注册</a>
	</div>
	<div class="panel-body">
	<form action="" method="post"  class="form-horizontal" role="form" enctype="multipart/form-data" id="form1">
		<div class="form-group">
			<div class="col-sm-10 col-xs-12">
				<div class="input-group">
				<div class="input-group-addon">apikey</div>
				<input type="text" name="apikey" class="form-control" value="<?php  echo $settings['apikey'];?>" />
				</div>
			</div>
		</div>
			<div class="panel panel-default">
				<div class="panel-heading">总开关</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 control-label">开启身份验证审核</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="radio" name="open_card_check" value="1" <?php  if($settings['open_card_check']==1) { ?>checked="checked"<?php  } ?> class=""/>开启
							<input type="radio" name="open_card_check" class="" value="0" <?php  if($settings['open_card_check']==0) { ?>checked="checked"<?php  } ?>/>关闭
						</div>
					</div>
				</div>
			</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
				<input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
	</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
