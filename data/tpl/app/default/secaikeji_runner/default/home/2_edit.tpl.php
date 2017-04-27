<?php defined('IN_IA') or exit('Access Denied');?><style>
img.avatar{
	float: left;
    max-height: 5em;
    margin-right: 1em;
}
</style>
<style>
	.button.button-calm.button-outline {
		border-color: #D68202;
		background: transparent;
		color: #D68202;
	}
	.button {
		border-color: transparent;
		background-color: #f8f8f8;
		color: #444;
		position: relative;
		display: inline-block;
		margin: 0;
		padding: 0 12px;
		min-width: 52px;
		min-height: 17px;
		border-width: 1px;
		border-style: solid;
		border-radius: 4px;
		vertical-align: top;
		text-align: center;
		text-overflow: ellipsis;
		font-size: 16px;
		line-height: 32px;
		cursor: pointer;
	}
	.weui_input{
		text-align:left;
	}
</style>
<div class="bar bar-header">
	<button class="button button-clear" onclick="window.history.go(-1)">
		<i class="icon ion-ios-arrow-back dark"></i>
		<span class="dark">返回</span>
	</button>
	<button class="button button-clear" id="save">
		<span class="dark">保存</span>
	</button>
</div>
<div class="page">
	<div class="h44"></div>
	<div class="hd">
		<div class="weui_cells weui_cells_form">
	        <div class="weui_cell">
	            <div class="weui_cell_bd weui_cell_primary">
	                <div class="weui_uploader">
	                    <div class="weui_uploader_hd weui_cell">
	                        <div class="weui_cell_bd weui_cell_primary">我的头像</div>
	                        <div class="weui_cell_ft">0/1</div>
	                    </div>
	                    <div class="weui_uploader_bd">
	                        <img class="avatar" src="<?php  echo tomedia($user['avatar'])?>" alt="" />
	                        <div class="weui_uploader_input_wrp">
	                            <input class="weui_uploader_input" type="file" id="upload_image" accept="image/jpg,image/jpeg,image/png,image/gif" multiple="">
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
		<div class="weui_cells_title">昵称：</div>
		<div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" name="nickname" value="<?php  echo $user['nickname']?>" type="text" placeholder="请输入您的昵称">
                </div>
            </div>
        </div>
		<div class="weui_cells weui_cells_form">
			<div class="weui_cell weui_vcode"  style="min-height:3em;">
				<div class="weui_cell_hd"><label class="weui_label">手机号：</label></div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" type="number" style="padding-right:2em;" name="mobile" value="<?php  echo $member['mobile'];?>" placeholder="请输入您的电话号码">
				</div>
				<div class="weui_cell_ft">
					<?php  if(!empty($this->sms['user_open'])) { ?><button class="button button-outline button-calm" id="send" style="float:right;">立即发送</button><?php  } ?>
				</div>
			</div>
        </div>

		<?php  if(!empty($this->sms['user_open'])) { ?>
		<div class="weui_cells_title">手机验证码：</div>
		<div class="weui_cells weui_cells_form">
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="code" value="<?php  echo $user['code'];?>" type="text" placeholder="请输入您的手机验证码">
				</div>
			</div>
		</div>
		<?php  } ?>
        
        <div class="weui_cells_title">真实姓名：</div>
		<div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" name="realname" value="<?php  echo $user['realname'];?>" type="text" placeholder="请输入您真实姓名">
                </div>
            </div>
        </div>
		<div class="weui_cells_title">银行卡账号：</div>
		<div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" name="banknum" value="<?php  echo $user['banknum'];?>" type="text" placeholder="请输入您银行卡账号">
                </div>
            </div>
        </div>
		<div class="weui_cells_title">支付宝账号：</div>
		<div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" name="aliname" value="<?php  echo $user['aliname'];?>" type="text" placeholder="请输入您支付宝账号">
                </div>
            </div>
        </div>
	</div>
</div>

<script>
require(['jquery','core','base64upload'],function($,core){
	status = true;
	$('#footer').hide();
	$('#upload_image').localResizeIMG({
    	width: 120,
        quality: 0.8,
        success: function (result) {
        	console.log(result);
        	if (result.height > 1600) {
                status = false;
                core.tip("照片最大高度不超过1600像素");
            }
        	if (status) {
				core.loaded();
        		$('img.avatar').attr('src',result.base64);
        	}
        },
		before:function(){
			core.loading();
		}
    });
	var codeid = 0;
	$('#send').click(function(){
		var mobile = $('input[name="mobile"]').val();
		var reg = /^1[3|4|5|8|7][0-9]\d{4,8}$/;

		if (!reg.test(mobile)) {
			core.cancel('手机号码格式有误！请重新输入');
			return '';
		}
		var start = 0;
		var time = 30;
		var _this = $(this);
		_this.html('剩余'+time+'秒');
		_this.attr('disabled',true);

		timer = setInterval(function(){
			if(time == 0){
				_this.attr('disabled',false);
				_this.html('重新发送');
				clearInterval(timer);
			}else{
				time = time -1;
				_this.html('剩余'+time+'秒');
			}
		},1000);

		core.post('sms_code',{mobile:mobile},function(data){
			if(data.status == 0){
				core.cancel(data.message);
			}else{
				codeid = data.codeid;
			}
		});
	});
	
	$('#save').click(function(){
		var mobile = $('input[name="mobile"]').val();
		var realname = $('input[name="realname"]').val();
		var nickname = $('input[name="nickname"]').val();
		var aliname = $('input[name="aliname"]').val();
		var banknum = $('input[name="banknum"]').val();
		var avatar = $('img.avatar').attr('src');
		var reg = /^1[3|4|5|8|6|7|9][0-9]\d{4,8}$/;
		var code = $('input[name="code"]').val();
		if (!reg.test(mobile)) {
			core.cancel('手机号码格式有误！请重新输入');
			return '';
		}
		if(core.empty(realname)){
			core.cancel('请认真填写您的姓名');
			return '';
		}
		<?php  if(!empty($this->sms['user_open'])) { ?>
		if(core.empty(code)){
			core.cancel('请输入手机验证码');
			return '';
		}
		<?php  } ?>
		core.post('home_edit',{act:'post',mobile:mobile,realname:realname,nickname:nickname,aliname:aliname,banknum:banknum,avatar:avatar,codeid:codeid,code:code},function(){
			core.ok("数据保存成功",function(){
				window.location.href="<?php  echo $this->createMobileUrl('home')?>"
			});
		});
	});
});
</script>