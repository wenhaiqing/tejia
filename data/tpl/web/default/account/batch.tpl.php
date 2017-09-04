<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/header-gw', TEMPLATE_INCLUDEPATH));?>
	<ol class="breadcrumb">
		<li><a href="./?refresh"><i class="fa fa-home"></i></a></li>
		<li><a href="<?php  echo url('system/welcome');?>">系统</a></li>
		<li class="active">公众号列表</li>
	</ol>
	<div class="clearfix" style="margin-bottom:5em;">
		<form action="">
			<input type="hidden" name="c" value="account">
			<input type="hidden" name="a" value="batch">
			<div class="form-group">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="请输入微信公众号名称" name="keyword" value="<?php  echo $_GPC['keyword'];?>">
					<div class="input-group-btn">
						<button class="btn btn-default"><i class="icon-search"></i> 搜索</button>
					</div>
				</div>
			</div>
		</form>
		<div class="input-group">
			<a class="btn btn-primary" href="<?php  echo url('account/post-step');?>"><i class="fa fa-plus"></i> 添加公众号</a>
		</div>
		<br>
		<div class="panel panel-default">
			<div class="panel-body" style="overflow:auto;">
				<form action="" method="post" id="form-delete" class="table-responsive">
					<input type="hidden" name="c" value="account">
					<input type="hidden" name="a" value="batch">
					<input type="hidden" name="do" value="delete">
					<table class="table">
						<thead>
						<tr>
							<th style="width:60px;">选择</th>
							<th style="width:220px;">主公众号名称</th>
							<th style="width:150px;">服务套餐</th>
							<th style="width:170px;">是否设置服务到期时间</th>
							<th style="width:200px;">到期时间</th>
							<th style="width:120px;">到期前服务套餐</th>
							<th style="width:350px;">操作用户</th>
						</tr>
						<thead>
						<?php  if(is_array($list)) { foreach($list as $uni) { ?>
						<tr>
							<td><input type="checkbox" name="accoundid[]" value="<?php  echo $uni['uniacid'];?>"></td>
							<td><?php  echo $uni['name'];?></td>
							<td><?php  echo $uni['group']['name'];?></td>
							<td>
								<?php  if($uni['groupdata']['isexpire'] == 1) { ?>
								<span class="label label-success">是</span>
								<?php  } else { ?>
								<span class="label label-danger">否</span>
								<?php  } ?>
							</td>
							<td>
								<?php  if($uni['groupdata']['isexpire'] == 1) { ?>
								<?php  echo date('Y-m-d H:i', $uni['groupdata']['endtime'])?> <?php  if($uni['groupdata']['endtime'] <= TIMESTAMP) { ?><br/><span class="label label-warning">已到期</span><br> 仅能使用'基础服务'套餐功能<?php  } ?>
								<?php  } else { ?>
								<span class="label label-danger">不限制</span>
								<?php  } ?>
							</td>
							<td>
								<?php  if($uni['groupdata']['isexpire'] == 1) { ?>
								<?php  echo $groups[$uni['groupdata']['oldgroupid']]['name'];?>
								<?php  } else { ?>

								<?php  } ?>
							</td>
							<td style="white-space:normal; line-height:25px;">
								<?php  if(is_array($uni['userdata'])) { foreach($uni['userdata'] as $user) { ?>
								<?php  if($user['role'] == 'manager') { ?>
								<span class="label label-success" title="管理员"><?php  echo $user['username'];?></span>
								<?php  } else { ?>
								<span class="label label-danger" title="操作员"><?php  echo $user['username'];?></span>
								<?php  } ?>
								<?php  } } ?>
							</td>
						</tr>
						<?php  } } ?>
						<tr>
							<td><input type="checkbox" id="checkall" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});"></td>
							<td colspan="6">
								<input id="delete" class="btn btn-primary" value="删除" type="button"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input id="group" class="btn btn-primary" value="更改套餐" type="button"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?php  if($_W['isfounder']) { ?>
								<input id="operator" class="btn btn-primary" value="添加账号操作员" type="button">
								<?php  } ?>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	<?php  echo $pager;?>
	</div>
	<div id="footer-group" class="hide">
			<span name="submit" id="submit" class="pull-right btn btn-primary" onclick="$('#form-group').submit();">保存</span>
	</div>
	
	
<script>
	require(['bootstrap', 'util', 'biz'],function($, u, biz){
		$('.account .panel-heading a, .btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
		
		$('#delete').click(function(){
			var arr = '';
			var mode = '';
			$("[name='accoundid[]']:checked").each(function(){
				arr += mode + $(this).val();
				mode = ',';
			});
			if(arr == '') {
				u.message('您没有选择要操作的公众号');
				return;
			}
			if(confirm('您确定要删除吗')) {
				$('#form-delete').submit();
			}
		});
		
		$('#group').click(function(){
			var arr = '';
			var mode = '';
			$("[name='accoundid[]']:checked").each(function(){
				arr += mode + $(this).val();
				mode = ',';
			});
			if(arr == '') {
				u.message('您没有选择要操作的公众号');
				return;
			}
			$.get("<?php  echo url('account/batch/modal')?>" + '&arr=' + arr , function(data){
				var obj = u.dialog('公众号套餐更改', data, $('#footer-group').html());
				obj.modal('show');
			});
		});
		
		$('#operator').click(function(){
			var arr = '';
			var mode = '';
			$("[name='accoundid[]']:checked").each(function(){
				arr += mode + $(this).val();
				mode = ',';
			});
			if(arr == '') {
				u.message('您没有选择要操作的公众号');
				return;
			}
			var seletedUserIds = <?php  echo json_encode(array(1));?>;
			biz.user.browser(seletedUserIds, function(us){
				$.post('<?php  echo url('account/batch');?>', {'uniacidstr': arr, 'do': 'operator', uid: us}, function(dat){
					if(dat == 'success') {
						u.message('添加账号操作员成功', "<?php  echo url('account/batch')?>", 'success')
					} else {
						u.message('操作失败, 请稍后重试, 服务器返回信息为: ' + dat);
					}
				});
			},{mode:'invisible'});

		});
	});
	

	
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-gw', TEMPLATE_INCLUDEPATH));?>