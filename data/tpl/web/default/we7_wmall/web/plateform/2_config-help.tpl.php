<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/nav', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('plateform/config-nav', TEMPLATE_INCLUDEPATH)) : (include template('plateform/config-nav', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-pills">
			<li <?php  if($op == 'list') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfconfig-help');?>"> 问题列表</a></li>
			<li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ptfconfig-help', array('op' => 'post'));?>">添加问题</a></li>
		</ul>
	</div>
</div>
<?php  if($op == 'list') { ?>
<form class="form-horizontal" action="" method="post">
	<div class="panel panel-default">
		<div class="panel-body table-responsive">
			<table class="table table-hover">
				<thead class="navbar-inner">
				<tr>
					<th>内容标题</th>
					<th>排序</th>
					<th>添加时间</th>
					<th style="width:400px; text-align:right;">操作</th>
				</tr>
				</thead>
				<tbody>
				<?php  if(is_array($item)) { foreach($item as $item) { ?>
					<tr>
						<input type="hidden" name="ids[]" value="<?php  echo $item['id'];?>">
						<td><input type="text" style="width:100px" name="title[]" class="form-control" value="<?php  echo $item['title'];?>"></td>
						<td><input type="text" style="width:100px" name="displayorder[]" class="form-control" value="<?php  echo $item['displayorder'];?>"></td>
						<td><?php  echo date('Y-m-d H:i:s', $item['addtime'])?></td>
						<td style="text-align:right;">
							<a href="<?php  echo $this->createWebUrl('ptfconfig-help', array('op' => 'post', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"> </i> 编辑</a>
							<a href="<?php  echo $this->createWebUrl('ptfconfig-help', array('op' => 'del', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后将不可恢复，确定删除吗?')) return false;"><i class="fa fa-times"> </i> 删除</a>
						</td>
					</tr>
				<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
			<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
			<input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" />
		</div>
	</div>
</form>
<?php  } ?>

<?php  if($op == 'post') { ?>
<form class="form-horizontal form" id="form1" action="" method="post" enctype="multipart/form-data">
<div class="panel panel-default">
	<div class="panel-heading">常见问题设置</div>
	<div class="panel-body">
		<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>问题标题</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control" name="title" value="<?php  echo $item['title'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>问题内容</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<?php  echo itpl_ueditor('content', $item['content']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>排序</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control" name="displayorder" value="<?php  echo $item['displayorder'];?>">
				<div class="help-block">数字越大越靠前</div>
			</div>
		</div>
	</div>
</div>
<div class="form-group col-sm-12">
	<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
	<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
</div>
</form>
<script type="text/javascript">
$(function(){
	$('#form1').submit(function(){
		if($.trim($(':text[name="title"]').val()) == '') {
			util.message('请填写内容标题');
			return false;
		}
	});
});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>