<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/template/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/template/navs', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading">
		阿里大鱼短信设置
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal" role="form" id="form1" >
			<div class="form-group">
			    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">快递注册</label>
			    <div class="col-sm-8 col-lg-9 col-xs-12">
			        <label class="radio-inline">
			            <input type="radio" name="sms_open" value="1" <?php  if($ali_sms['sms_open']==1) { ?>checked="checked"<?php  } ?>> 开启
			        </label>
			        <label class="radio-inline">
			            <input type="radio" name="sms_open" value="0" <?php  if($ali_sms['sms_open']==0) { ?>checked="checked"<?php  } ?>> 关闭
			        </label>
			        <span class="help-block"></span>
			    </div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">用户注册</label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<label class="radio-inline">
						<input type="radio" name="user_open" value="1" <?php  if($ali_sms['user_open']==1) { ?>checked="checked"<?php  } ?>> 开启
					</label>
					<label class="radio-inline">
						<input type="radio" name="user_open" value="0" <?php  if($ali_sms['user_open']==0) { ?>checked="checked"<?php  } ?>> 关闭
					</label>
					<span class="help-block"></span>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">发单验证</label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<label class="radio-inline">
						<input type="radio" name="post_open" value="1" <?php  if($ali_sms['post_open']==1) { ?>checked="checked"<?php  } ?>> 开启
					</label>
					<label class="radio-inline">
						<input type="radio" name="post_open" value="0" <?php  if($ali_sms['post_open']==0) { ?>checked="checked"<?php  } ?>> 关闭
					</label>
					<span class="help-block"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">短信接口</label>
			</div>
			<div id="sms_api_type_1" >
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">阿里大于短信模版ID</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" name="moban_num" value="<?php  echo $ali_sms['moban_num'];?>" class="form-control"/>
						<span class="help-block">您好！您的验证码是${verify}，请注意查收！</span>
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
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
