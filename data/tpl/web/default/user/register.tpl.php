<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<link href="./resource/css/login.css" rel="stylesheet">
<script>
	$('#form1').submit(function(){
		if($.trim($(':text[name="username"]').val()) == '') {
			util.message('没有输入用户名.', '', 'error');
			return false;
		}
		if($('#password').val() == '') {
			util.message('没有输入密码.', '', 'error');
			return false;
		}
		if($('#password').val() != $('#repassword').val()) {
			util.message('两次输入的密码不一致.', '', 'error');
			return false;
		}
/* 		<?php  if(is_array($extendfields)) { foreach($extendfields as $item) { ?>
		<?php  if($item['required']) { ?>
			if (!$.trim($('[name="<?php  echo $item['field'];?>"]').val())) {
				util.message('<?php  echo $item['title'];?>为必填项，请返回修改！', '', 'error');
				return false;
			}
		<?php  } ?>
		<?php  } } ?>
 */		<?php  if($setting['register']['code']) { ?>
		if($.trim($(':text[name="code"]').val()) == '') {
			util.message('没有输入验证码.', '', 'error');
			return false;
		}
		<?php  } ?>
	});
	var h = document.documentElement.clientHeight;
	$(".login").css('min-height',h);
</script>
<div class="register-container container">
	<div class="row">
	    <div class="col-md-3"></div>
	    <div class="register col-md-7">
	        <form action="" method="post" role="form" id="form1">
	            <a href="/index.php" class="login-logo" style="margin-bottom: 30px;">
               		<img src="<?php  if(!empty($_W['setting']['copyright']['blogo'])) { ?><?php  echo tomedia($_W['setting']['copyright']['blogo']);?><?php  } else { ?>./resource/images/top-logo.png<?php  } ?>">
               	</a>
               	<div class="form-group form-item">
               		<div class="col-md-3">
	            		<label for="username">帐号名称：<span class="star">*</span></label>
	            	</div>
	            	<div class="col-md-9">
	           			<input name="username" id="username" type="text" class="form-control" placeholder="请填写登陆账号">
	           		</div>
	           	</div>
	           	<br>
	           	<div class="form-group form-item">
	           		<div class="col-md-3">
		            	<label for="password">登陆密码：<span class="star">*</span></label>
		            </div>
		            <div class="col-md-9">
		            	<input name="password" type="password" id="password" class="form-control" placeholder="请设置登陆密码">
		            </div>
		        </div>
		        <div class="form-group form-item">
		        	<div class="col-md-3">
		            	<label for="repassword">确认密码：</label>
		            </div>
					<div class="col-md-9">
		            	<input name="password" type="password" id="repassword" class="form-control" placeholder="请再次输入密码">
		            </div>
				</div>
					<?php  if($extendfields) { ?>
						<?php  if(is_array($extendfields)) { foreach($extendfields as $item) { ?>
							<div class="form-group form-item">
								<div class="col-md-3">
								<label ><?php  echo $item['title'];?>：<?php  if($item['required']) { ?><span style="color:red">*</span><?php  } ?></label>
								</div>
								<div class="col-md-9">
								<?php  echo tpl_fans_form($item['field'])?>
								</div>
							</div>
						<?php  } } ?>
					<?php  } ?>
					<?php  if($setting['register']['code']) { ?>
						<div class="form-group form-item">
							<div class="col-md-3">
							<label style="display:block;">注册证码:<span style="color:red;">*</span></label>
							</div>
							<div class="col-md-4">
							<input name="code" type="text" class="form-control" placeholder="请输入验证码" style="width:98%;display:inline;margin-right:1px">
							</div>
							<div class="col-md-3">
							<img src="<?php  echo url('utility/code');?>" class="img-rounded" style="cursor:pointer;" onclick="this.src='<?php  echo url('utility/code');?>' + Math.random();" />
							</div>
						</div>
					<?php  } ?>
					<!--div class="form-group">
						<label>邀请码:<span style="color:red">*</span></label>
						<input name="invitation" type="text" class="form-control" placeholder="请输入邀请码">
					</div-->
				<input type="submit" name="submit" value="申请注册" class="login-btn" ></input>
	            <input name="token" value="<?php  echo $_W['token'];?>" type="hidden" />
	            <div class="reg-btn">
                    <a href="<?php  echo url('user/login');?>">返回登录</a>
                </div>
	        </form>
	    </div>
	</div>
</div>