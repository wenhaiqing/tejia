<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/header', TEMPLATE_INCLUDEPATH)) : (include template('delivery/header', TEMPLATE_INCLUDEPATH));?>
<div class="page register">
	<header class="bar bar-nav common-bar-nav">
		<h1 class="title">申请配送员</h1>
	</header>
	<div class="content">
		<form action="" method="post" id="form-account">
			<input type="hidden" name="openid" value="<?php  echo $fans['openid'];?>"/>
			<input type="hidden" name="nickname" value="<?php  echo $fans['nickname'];?>"/>
			<input type="hidden" name="avatar" value="<?php  echo $fans['avatar'];?>"/>
			<div class="avatar">
				<img src="<?php  echo $fans['avatar'];?>" width="80" alt=""/>
				<br>
				<span><?php  echo $fans['nickname'];?></span>
			</div>
			<div class="list-block">
				<ul>
					<?php  if($dy_config['mobile_verify_status'] == 1) { ?>
					<li>
						<div class="item-content verify-code">
							<div class="item-inner">
								<div class="item-title label">手机</div>
								<div class="item-input">
									<input type="text" name="mobile" placeholder="手机号">
								</div>
								<div class="item-button">
									<a class="button button-success" href="javascript:;" id="btn-code">获取验证码</a>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">验证码</div>
								<div class="item-input">
									<input type="text" name="code" placeholder="输入手机收到的验证码">
								</div>
							</div>
						</div>
					</li>
					<?php  } else { ?>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">手机</div>
								<div class="item-input">
									<input type="text" name="mobile" placeholder="手机号">
								</div>
							</div>
						</div>
					</li>
					<?php  } ?>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">密码</div>
								<div class="item-input">
									<input type="password" name="password" placeholder="1-8位密码">
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">确认密码</div>
								<div class="item-input">
									<input type="password" name="repassword" placeholder="1-8位密码">
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">真实姓名</div>
								<div class="item-input">
									<input type="text" name="title" placeholder="真实姓名">
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">性别</div>
								<div class="item-input">
									<input type="text" name="sex" placeholder="性别">
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">年龄</div>
								<div class="item-input">
									<input type="text" name="age" placeholder="年龄">
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="content-padded color-danger">*真实姓名将作为提现验证身份重要依据, 请认真填写</div>
			<?php  if(!empty($dy_config['agreement'])) { ?>
			<div class="content-padded text-right color-gray">
				我已阅读并同意 <a href="javascript:;" class="color-danger open-popup" data-popup=".popup-dy-agreement">《配送员入驻协议》</a>
			</div>
			<?php  } ?>
			<div class="content-padded">
				<a href="javascript:;" class="button button-big button-fill button-success" id="btn-account">申请</a>
			</div>
		</form>
	</div>
</div>
<div class="popup popup-dy-agreement">
	<div class="page">
		<header class="bar bar-nav common-bar-nav">
			<h1 class="title">入驻协议</h1>
			<button class="button button-link button-nav pull-right close-popup">关闭</button>
		</header>
		<div class="content" style="background: #FFF">
			<div class="content-padded">
				<?php  echo $dy_config['agreement'];?>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		var $mobile_verify_status = "<?php  echo $dy_config['mobile_verify_status'];?>";
		if($mobile_verify_status == 1) {
			$('#btn-code').click(function(){
				if($(this).hasClass('disabled')) {
					return false;
				}
				var mobile = $.trim($(':text[name="mobile"]').val());
				if(!mobile) {
					$.toast('请输入手机号');
					return false;
				}
				var reg = /^1[34578][0-9]{9}/;
				if(!reg.test(mobile)) {
					$.toast('手机号格式错误');
					return false;
				}
				var $this = $(this);
				$this.addClass("disabled");
				var downcount = 60;
				$this.html(downcount + "秒后重新获取");
				var timer = setInterval(function(){
					downcount--;
					if(downcount <= 0){
						clearInterval(timer);
						$this.html("重新获取验证码");
						$this.removeClass("disabled");
						downcount = 60;
					}else{
						$this.html(downcount + "秒后重新获取");
					}
				}, 1000);

				$.post("<?php  echo $this->createMobileUrl('cmncode', array('sid' => 0, 'product' => $_W['we7_wmall2']['config']['title'] . '配送员申请'))?>", {mobile: mobile}, function(data){
					if(data != 'success') {
						$.toast(data);
					} else {
						$.toast('验证码发送成功, 请注意查收');
					}
				});
				return false;
			});
		}

		$('#btn-account').click(function(){
			if($(this).hasClass('disabled')) {
				return false;
			}
			var openid = $.trim($('#form-account :hidden[name="openid"]').val());
			if(!openid) {
				$.toast("获取微信信息错误");
				return false;
			}
			var mobile = $.trim($('#form-account :text[name="mobile"]').val());
			var reg = /^1[34578][0-9]{9}$/;
			if(!reg.test(mobile)) {
				$.toast("手机号格式错误");
				return false;
			}
			var code = '';
			if($mobile_verify_status == 1) {
				code = $.trim($('#form-account :text[name="code"]').val());
				if(!code) {
					$.toast("验证码不能为空");
					return false;
				}
			}
			var password = $.trim($('#form-account :password[name="password"]').val());
			if(!password) {
				$.toast('密码不能为空');
				return false;
			}
			var repassword = $.trim($('#form-account :password[name="repassword"]').val());
			if(repassword != password) {
				$.toast('两次密码输入不一致');
				return false;
			}
			var title = $.trim($('#form-account :text[name="title"]').val());
			if(!title) {
				$.toast('真实姓名不能为空');
				return false;
			}
			var sex = $.trim($('#form-account :text[name="sex"]').val());
			if(!sex || (sex != '男' && sex != '女')) {
				$.toast('性别有误');
				return false;
			}
			var age = parseInt($.trim($('#form-account :text[name="age"]').val()));
			if(isNaN(age)) {
				$.toast('年龄不合法');
				return false;
			}

			var params = {
				password: password,
				mobile: mobile,
				code: code,
				title: title,
				openid: openid,
				nickname: $.trim($('#form-account :hidden[name="nickname"]').val()),
				avatar: $.trim($('#form-account :hidden[name="avatar"]').val()),
				sex: sex,
				age: age
			}
			$('#btn-account').addClass('disabled');
			$.post("<?php  echo $this->createMobileUrl('dyregister')?>", params, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno != 0) {
					$('#btn-account').removeClass('disabled');
					$.toast(result.message.message);
					return false;
				} else {
					$.toast('注册成功', "<?php  echo $this->createMobileUrl('dyregister');?>");
					return false;
				}
			});
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/common', TEMPLATE_INCLUDEPATH)) : (include template('delivery/common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('delivery/footer', TEMPLATE_INCLUDEPATH)) : (include template('delivery/footer', TEMPLATE_INCLUDEPATH));?>