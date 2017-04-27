<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'display' && !isset($_GPC['status'])) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('tixian', array('eid' => $eid));?>">全部</a></li>
	<li <?php  if(isset($_GPC['status']) && $_GPC['status'] == 0) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('tixian', array('eid' => $eid, 'status' => 0));?>">处理中</a></li>
	<li <?php  if($_GPC['status'] == 1) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('tixian', array('eid' => $eid, 'status' => 1));?>">已提现</a></li>
	<li <?php  if($_GPC['status'] == -1) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('tixian', array('eid' => $eid, 'status' => -1));?>">已取消</a></li>
	<li <?php  if($_GPC['status'] == -2) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('tixian', array('eid' => $eid, 'status' => -2));?>">失败</a></li>
	<?php  if($op == 'post') { ?><li class="active"><a href="<?php  echo $this->createWebUrl('tixian', array('eid' => $eid));?>">编辑</a></li><?php  } ?>
</ul>
<?php  if($op=='display') { ?>
<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
			<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
			<input type="hidden" name="a" value="<?php  echo $_GPC['a'];?>">
			<input type="hidden" name="eid" value="<?php  echo $_GPC['eid'];?>">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">昵称(uid)</label>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xs-4">
					<input type="text" class="form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" />
				</div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-xs-4">
					<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</div>
			</div>
		</form>
	</div>
</div>
<form action="" method="get">
<input type="hidden" name="c" value="site">
<input type="hidden" name="a" value="entry">
<input type="hidden" name="do" value="pay">
<input type="hidden" name="eid" value="<?php  echo $eid;?>">
<div class="panel panel-default ">
	<div class="table-responsive panel-body">
		<table class="table table-hover">
			<thead class="navbar-inner">
			<tr>
				<th style="width: 50px">
					<input type="checkbox" id="checkall">
				</th>
				<th style="width: 170px">昵称(uid)</th>
				<th>真实姓名</th>
				<th>提现金额</th>
				<th style="width: 70px">状态</th>
				<th>申请时间</th>
				<th>支付时间</th>
				<th>管理员</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody>
			<?php  if(is_array($list)) { foreach($list as $li) { ?>
			<tr>
				<td>
					<input type="checkbox" name="id[]" value="<?php  echo $li['id'];?>" data-status="<?php  echo $li['status'];?>" <?php  if($li['status']==1||$li['status']==-1) { ?>disabled<?php  } ?>>
				</td>
				<td>
					<div class="clearfix">
						<div class="pull-left" style="width: 40px;height: 40px; overflow: hidden; border-radius: 50%;">
							<img src="<?php  echo tomedia($li['avatar'])?>" onerror="this.src='../app/resource/images/heading.jpg'" style="width: 100%" />
						</div>
						<div class="pull-left" style="line-height: 40px; margin-left: 10px;">
							<?php  if($li['nickname']!='') { ?><?php  echo $li['nickname'];?><?php  } else { ?><?php  echo $li['uid'];?><?php  } ?>
						</div>
					</div>
				</td>
				<td><?php  echo $li['member']['realname'];?></td>
				<td>¥<?php  echo $li['money'];?></td>
				<td>
					<?php  if($li['status']==1) { ?>
					<span class="label label-success"><?php  echo runner_get_status_title(1)?></span>
					<?php  } else if($li['status']==0) { ?>
					<span class="label label-primary"><?php  echo runner_get_status_title(0)?></span>
					<?php  } else if($li['status']==-1) { ?>
					<span class="label label-default"><?php  echo runner_get_status_title(-1)?></span>
					<?php  } else if($li['status']==-2) { ?>
					<span title="<?php  echo $li['reason'];?>" class="label label-danger"><?php  echo runner_get_status_title(-2)?></span>
					<?php  } ?>
				</td>
				<td><?php  echo $li['insert_time'];?></td>
				<td><?php  echo $li['update_time'];?></td>
				<td><?php  echo $li['user']['username'];?></td>
				<td>
					<?php  if($li['status']!=1&&$li['status']!=-1) { ?>
					<a onclick="return confirm('确认已经手动提现吗？'); return false;" href="<?php  echo $this->createWebUrl('tixian', array('op'=>'pay', 'eid' => $eid, 'id' => $li['id']))?>" title="提现" data-toggle="tooltip" data-placement="top" class="btn btn-default btn-sm"><i class="fa fa-dollar"></i></a>
					<?php  } ?>
					<a href="<?php  echo $this->createWebUrl('tixian', array('op'=>'post','eid' => $eid, 'id' => $li['id']))?>" title="编辑" data-toggle="tooltip" data-placement="top" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
					<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('tixian', array('op'=>'delete', 'eid' => $eid, 'id' => $li['id']))?>" title="删除" data-toggle="tooltip" data-placement="top" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
				</td>
			</tr>
			<?php  } } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<input onclick="return confirm('确认支付提现吗？'); return false;" name="submit" type="submit" value="批量提现" class="btn btn-primary col-lg-1">
	<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
</div>
<?php  echo $pager;?>
</form>
<script>
	$('#checkall').click(function() {
		if ($(this).prop('checked')) {
			$('input[type=checkbox]').each(function(){
				var status = $(this).attr('data-status');
				if (status != 1 && status != -1) {
					$(this).prop('checked', true);
				}
			});
		} else {
			$('input[type=checkbox]').each(function(){
				var status = $(this).attr('data-status');
				if (status != 1 && status != -1) {
					$(this).prop('checked', false);
				}
			});
		}
	});
</script>
<?php  } ?>
<?php  if($op == 'post') { ?>
<form class="form-horizontal form" action="" method="post" enctype="multipart/form-data">
	<div class="panel panel-default">
		<div class="panel-heading">提现数据</div>
		<div class="panel-body">
			<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">昵称</label>
				<div class="col-sm-8 col-xs-12">
					<input type="text" class="form-control" placeholder="" value="<?php  echo $item['nickname'];?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">头像</label>
				<div class="col-sm-8 col-xs-12">
					<div class="pull-left" style="width: 40px;height: 40px; overflow: hidden; border-radius: 50%;">
						<img src="<?php  echo tomedia($item['avatar'])?>" onerror="this.src='../app/resource/images/heading.jpg'" style="width: 100%" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">UID</label>
				<div class="col-sm-8 col-xs-12">
					<input type="text" class="form-control" placeholder="" value="<?php  echo $item['uid'];?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">openid</label>
				<div class="col-sm-8 col-xs-12">
					<input type="text" class="form-control" placeholder="" value="<?php  echo $item['from_user'];?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">真实姓名</label>
				<div class="col-sm-8 col-xs-12">
					<input type="text" class="form-control" placeholder="" name="realname" value="<?php  echo $user['realname'];?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">银行卡账号</label>
				<div class="col-sm-8 col-xs-12">
					<input type="text" class="form-control" placeholder="" name="realname" value="<?php  echo $user['banknum'];?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">支付宝账号</label>
				<div class="col-sm-8 col-xs-12">
					<input type="text" class="form-control" placeholder="" name="realname" value="<?php  echo $user['aliname'];?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">提现金额</label>
				<div class="col-sm-8 col-xs-12">
					<input type="text" class="form-control" placeholder="" name="money" value="<?php  echo $item['money'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">回复备注</label>
				<div class="col-sm-8 col-xs-12">
					<textarea class="form-control" name="message" placeholder="提现申请不通过时，可填写相关说明信息"><?php  echo $item['message'];?></textarea>
					<span class="help-block">当状态变更为已提现、处理中、取消时，前台会员可在提现记录里看到回复备注内容(点击状态即可展示)</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">提现状态</label>
				<div class="col-sm-8 col-xs-12">
					<label class="checkbox-inline">
						<input type="radio" name="status" value="0" <?php  if($item['status']==0) { ?>checked<?php  } ?>> 处理中
					</label><br/>
					<label class="checkbox-inline">
						<input type="radio" name="status" value="-1" <?php  if($item['status']==-1) { ?>checked<?php  } ?>> 取消
					</label><br/>
					<label class="checkbox-inline">
						<input type="radio" name="status" value="-2" <?php  if($item['status']==-2) { ?>checked<?php  } ?>> 失败
					</label><br/>
					<label class="checkbox-inline">
						<input type="radio" name="status" value="1" <?php  if($item['status']==1) { ?>checked<?php  } ?>> 已提现
					</label><br/>
					<span class="help-block">提现状态可在此手动修改，当操作提现时，将根据支付状态自动更新提现状态</span>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
			<input name="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</div>
</form>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>