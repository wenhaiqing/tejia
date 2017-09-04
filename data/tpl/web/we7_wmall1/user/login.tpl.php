<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<style>
	html,body,h1,h2,h3{font-family: arial, 'Hiragino Sans GB', 'Microsoft Yahei', '微软雅黑', '宋体', \5b8b\4f53, Tahoma, Arial, Helvetica, STHeiti;}
	.login-container{width:640px; margin: 150px auto;}
	.panel-heading h3{text-align: center; font-size: 35px; padding: 0; color: #666; font-weight: bold}
	.input-group-addon.code{padding: 0}
</style>
<div class="clearfix login-container">
	<form class="" action="" method="post" role="form" id="form1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3>商户后台系统</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<div class="input-group input-group-lg">
						<span class="input-group-addon">账号</span>
						<input type="text" name="username" class="form-control" placeholder="请输入账号名">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
						<span class="input-group-addon">密码</span>
						<input type="password" name="password" class="form-control" placeholder="请输入密码">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
						<span class="input-group-addon">验证码</span>
						<input type="text" name="verify" class="form-control" placeholder="请输入右侧图中字符">
						<span class="input-group-addon code">
							<a href="javascript:;" id="toggle" style="text-decoration: none">
								<img id="imgverify" src="<?php  echo $_W['siteroot'].'web/'.url('utility/code')?>" title="点击图片更换验证码"/>
							</a>
						</span>
					</div>
				</div>
				<button class="btn btn-lg btn-primary" type="submit" id="submit" name="submit" value="登录">登录</button>
				<input name="token" value="<?php  echo $_W['token'];?>" type="hidden" />
			</div>
		</div>
	</form>
</div>
<script>
	$('#toggle').click(function() {
		$('#imgverify').prop('src', '<?php  echo $_W['siteroot'].url("utility/code")?>r='+Math.round(new Date().getTime()));
		return false;
	});
</script>
</body>
</html>

