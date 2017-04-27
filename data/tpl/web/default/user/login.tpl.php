<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<link href="./resource/css/login.css" rel="stylesheet">
<div class="register-container container">
    <div class="row clearfix">
        <div class="col-md-3"></div>
        <div class="register col-md-7">
            <form action="" method="post" role="form" id="form1" onsubmit="return formcheck();">
                <a href="/index.php" class="login-logo">
                <img src="<?php  if(!empty($_W['setting']['copyright']['blogo'])) { ?><?php  echo tomedia($_W['setting']['copyright']['blogo']);?><?php  } else { ?>./resource/images/top-logo.png<?php  } ?>">
                </a>
                <div class="form-group">
                    <label for="username">账号：</label>
                    <input type="text" id="username" name="username" placeholder="输入您的账号" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">密码：</label>
                    <input type="password" id="password" name="password" placeholder="输入您的密码" class="form-control">
                </div>
				<?php  if(!empty($_W['setting']['copyright']['verifycode'])) { ?>
					<div class="form-group input-group">
						<div class="input-group-addon"><i class="fa fa-info"></i></div>
						<input name="verify" type="text" class="form-control input-lg" style="width:200px;" placeholder="请输入验证码">
						<a href="javascript:;" id="toggle" style="text-decoration: none"><img id="imgverify" src="<?php  echo url('utility/code')?>" style="height:46px;" title="点击图片更换验证码"/> 看不清？换一张</a>
					</div>
				<?php  } ?>
				<?php  if(!empty($_W['setting']['copyright']['demo'])) { ?><font color="red">[温馨提示]：默认测试账号：test，密码：test654321</font><?php  } ?>
                <input type="submit" name="submit" value="登录平台" class="login-btn">
                <input name="token" value="<?php  echo $_W['token'];?>" type="hidden" />
                <div class="reg-btn">
                    <a href="<?php  echo url('user/register');?>">立即注册</a>
                </div>
                <?php  if(!empty($_W['setting']['copyright']['is_check'])) { ?><br>
                <h2 style="text-align:center;margin-bottom: 30px;"></h2>
                <div class="self-check">
                    <h3>账号自助审核</h3>
                                        <p><span style="font-size: 18px;">如果您注册的账号没有通过审核<br>请扫描二维码关注后发送：<b>审核+用户名</b><br>例如你注册用户名是<b>wechat</b><br>则发送：<b>审核wechat（不用+号）</b></span><br><img src="<?php  if(!empty($_W['setting']['copyright']['ewm'])) { ?><?php  echo tomedia($_W['setting']['copyright']['ewm']);?><?php  } else { ?>./resource/images/ewm.jpg<?php  } ?>" width="300" height="300" style="margin-top: 12px;"></p>
                </div>
				<?php  } ?>
            </form>
        </div>
    </div>
</div>
<script>
function formcheck() {
	if($('#remember:checked').length == 1) {
		cookie.set('remember-username', $(':text[name="username"]').val());
	} else {
		cookie.del('remember-username');
	}
	return true;
}
var h = document.documentElement.clientHeight;
$(".login").css('min-height',h);
$('#toggle').click(function() {
	$('#imgverify').prop('src', '<?php  echo url('utility/code')?>r='+Math.round(new Date().getTime()));
	return false;
});
<?php  if(!empty($_W['setting']['copyright']['verifycode'])) { ?>
	$('#form1').submit(function() {
		var verify = $(':text[name="verify"]').val();
		if (verify == '') {
			alert('请填写验证码');
			return false;
		}
	});
<?php  } ?>
</script>
</body>
</html>
