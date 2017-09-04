<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/header-gw', TEMPLATE_INCLUDEPATH));?>
<ol class="breadcrumb">
	<li><a href="./?refresh"><i class="fa fa-home"></i></a></li>
	<li><a href="<?php  echo url('system/welcome');?>">系统</a></li>
	<li class="active">站点信息设置</li>
</ol>
<ul class="nav nav-tabs">
	<li<?php  if($do == 'copyright') { ?> class="active"<?php  } ?>><a href="<?php  echo url('system/site');?>">站点信息</a></li>
</ul>
<div class="clearfix">
	<form action="" method="post"  class="form-horizontal" role="form" enctype="multipart/form-data" id="form1">
		<h5 class="page-header">关闭站点</h5>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关闭站点</label>
			<div class="col-sm-10 col-xs-12">
				<label class="radio-inline">
					<input type="radio" name="status" <?php  if($settings['status'] == 1) { ?> checked="checked" <?php  } ?> value="1" /> 是
				</label>
				<label class="radio-inline">
					<input type="radio" name="status" <?php  if($settings['status'] == 0) { ?> checked="checked" <?php  } ?> value="0" /> 否
				</label>
			</div>
		</div>
		<div class="form-group reason" <?php  if($settings['status'] == 0) { ?> style="display:none;" <?php  } ?>>
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关闭原因</label>
			<div class="col-sm-10 col-xs-12">
				<textarea style="height:150px;" class="form-control" cols="70" name="reason" autocomplete="off"><?php  echo $settings['reason'];?></textarea>
				<input type="hidden" name="reasons" value="<?php  echo $settings['reason'];?>">
			</div>
		</div>
	<h5 class="page-header">登录站点</h5>
	<div class="form-group">
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">是否开启验证码</label>
		<div class="col-sm-10 col-xs-12">
			<label class="radio-inline">
			<input type="radio" name="verifycode" <?php  if($settings['verifycode'] == 1) { ?> checked="checked" <?php  } ?> value="1" /> 是
			</label>
			<label class="radio-inline">
				<input type="radio" name="verifycode" <?php  if($settings['verifycode'] == 0) { ?> checked="checked" <?php  } ?> value="0" /> 否
			</label>
			</div>
	</div>
	<div class="form-group">
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">是否开启域名防封机制</label>
		<div class="col-sm-10 col-xs-12">
			<label class="radio-inline">
			<input type="radio" name="is_dns" <?php  if($settings['is_dns'] == 1) { ?> checked="checked" <?php  } ?> value="1" /> 是
			</label>
			<label class="radio-inline">
				<input type="radio" name="is_dns" <?php  if($settings['is_dns'] == 0) { ?> checked="checked" <?php  } ?> value="0" /> 否
			</label>
			<div class="help-block">设置“是”后，会员登陆微信端，手机端等入口，需绑定域名，并使用自己的域名登陆。</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">是否开启测试账号</label>
		<div class="col-sm-10 col-xs-12">
			<label class="radio-inline">
			<input type="radio" name="demo" <?php  if($settings['demo'] == 1) { ?> checked="checked" <?php  } ?> value="1" /> 是
			</label>
			<label class="radio-inline">
				<input type="radio" name="demo" <?php  if($settings['demo'] == 0) { ?> checked="checked" <?php  } ?> value="0" /> 否
			</label>
			<div class="help-block">设置“是”后，登陆界面回显示：测试账号test,密码test654321。</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">是否开启用户前台审核</label>
		<div class="col-sm-10 col-xs-12">
			<label class="radio-inline">
			<input type="radio" name="is_check" <?php  if($settings['is_check'] == 1) { ?> checked="checked" <?php  } ?> value="1" /> 是
			</label>
			<label class="radio-inline">
				<input type="radio" name="is_check" <?php  if($settings['is_check'] == 0) { ?> checked="checked" <?php  } ?> value="0" /> 否
			</label>
			<div class="help-block">设置“是”后，会员登陆界面，会提示扫描二维码回复关键词审核用户。</div>
		</div>
	</div>
	<h5 class="page-header">版权信息</h5>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">是否显示首页</label>
			<div class="col-sm-10 col-xs-12">
				<label for="showhomepage_1" class="radio-inline"><input type="radio" name="showhomepage" value="1" id="showhomepage_1" <?php  if(!empty($settings['showhomepage'])) { ?> checked<?php  } ?>> 是</label>&nbsp;&nbsp;&nbsp;
				<label for="showhomepage_2" class="radio-inline"><input type="radio" name="showhomepage" value="0" id="showhomepage_2" <?php  if(empty($settings['showhomepage'])) { ?> checked<?php  } ?>> 否</label>
				<div class="help-block">设置“否”后，打开地址时将直接跳转到登录页面，否则会跳转到首页。</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">网站简称</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="smname" class="form-control" value="<?php  echo $settings['smname'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">网站标题</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="sitename" class="form-control" value="<?php  echo $settings['sitename'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">网站URL</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="url" class="form-control" value="<?php  echo $settings['url'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">平台域名</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="sitehost" class="form-control" value="<?php  echo $settings['sitehost'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">支付域名</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="payhost" class="form-control" value="<?php  echo $settings['payhost'];?>" />
				<span class="help-block">设置支付域名，方便代理商充值(比如：支付宝，有域名限制！这里就填写你签协议的域名。格式：www.012wz.com)。</span>
			</div>
			
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">keywords</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="keywords" class="form-control" value="<?php  echo $settings['keywords'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">description</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="description" class="form-control" value="<?php  echo $settings['description'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">favorite icon</label>
			<div class="col-sm-10 col-xs-12">
				<?php  echo tpl_form_field_image('icon', $settings['icon'], '', array('global' => true, 'extras' => array('image'=> ' width="32" ')));?>
				<span class="help-block">favorite icon</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">前台二维码</label>
			<div class="col-sm-10 col-xs-12">
				<?php  echo tpl_form_field_image('ewm', $settings['ewm'], '', array('ewm' => true));?>
				<span class="help-block">此logo是指首页及登录页面logo，建议尺寸 220x220。</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">前台LOGO</label>
			<div class="col-sm-10 col-xs-12">
				<?php  echo tpl_form_field_image('flogo', $settings['flogo'], '', array('global' => true));?>
				<span class="help-block">此logo是指首页及登录页面logo。</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">前台幻灯片</label>
			<div class="col-sm-10 col-xs-12">
				<?php  echo tpl_form_field_multi_image('slides', $settings['slides'], '', array('global' => true, 'thumb' => 0));?>
				<span class="help-block">设置首页幻灯片。</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">前台幻灯片上显示文字</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" class="form-control" name="notice" value="<?php  echo $settings['notice'];?>"/>
				<span class="help-block">该文字显示在幻灯片上。</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">后台LOGO</label>
			<div class="col-sm-10 col-xs-12">
				<?php  echo tpl_form_field_image('blogo', $settings['blogo'], '', $options = array('global' => true));?>
				<span class="help-block">此logo是指登陆页面、登录后公众号列表及系统页面的logo，建议尺寸 420x95。</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">第三方统计代码</label>
			<div class="col-sm-10 col-xs-12">
				<textarea style="height:150px;" class="form-control" cols="70" name="statcode" autocomplete="off"><?php  echo $settings['statcode'];?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">底部右侧信息（上）</label>
			<div class="col-sm-10 col-xs-12">
				<textarea style="height:150px;" class="form-control" cols="70" name="footerright" autocomplete="off"><?php  echo $settings['footerright'];?></textarea>
				<span class="help-block">自定义底部右侧信息，支持HTML</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">底部左侧信息（下）</label>
			<div class="col-sm-10 col-xs-12">
				<textarea style="height:150px;" class="form-control" cols="70" name="footerleft" autocomplete="off"><?php  echo $settings['footerleft'];?></textarea>
				<span class="help-block">自定义底部左侧信息，支持HTML</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">联系人</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="person" class="form-control" value="<?php  echo $settings['person'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">联系电话</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="phone" class="form-control" value="<?php  echo $settings['phone'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">QQ</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="qq" class="form-control" value="<?php  echo $settings['qq'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">邮箱</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="email" class="form-control" value="<?php  echo $settings['email'];?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">公司名称</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="company" value="<?php  echo $settings['company'];?>"  class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关于我们</label>
			<div class="col-sm-10 col-xs-12">
				<?php  echo tpl_ueditor('companyprofile', $settings['companyprofile']);?>
				<span class="help-block">该文字显示在个人中心->关于我们中</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">详细地址</label>
			<div class="col-sm-10 col-xs-12">
				<input type="text" name="address" value="<?php  echo $settings['address'];?>"  class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">地理位置</label>
			<div class="col-sm-10 col-xs-12">
				<?php  echo tpl_form_field_coordinate('baidumap', $settings['baidumap'])?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
				<input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
	<script type="text/javascript">
			$("#form1").submit(function() {
				if ($("input[name='status']:checked").val() == 1) {
					if ($("textarea[name='reason']").val() == '') {
						util.message('请填写站点关闭原因');
						return false;
					}
				}
			});
			$("input[name='status']").click(function() {
				if ($(this).val() == 1) {
					$(".reason").show();
					var reason = $("input[name='reasons']").val();
					$("textarea[name='reason']").text(reason);
				} else {
					$(".reason").hide();
				}
			});
	</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-gw', TEMPLATE_INCLUDEPATH));?>
