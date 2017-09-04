<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/header-gw', TEMPLATE_INCLUDEPATH));?>
<ol class="breadcrumb">
	<li><a href="./?refresh"><i class="fa fa-home"></i></a></li>
	<li><a href="<?php  echo url('system/welcome');?>">系统</a></li>
	<li class="active">公告分类</li>
</ol>
<ul class="nav nav-tabs">
	<li <?php  if($do == 'category' || $do == 'category_post') { ?>class="active"<?php  } ?>><a href="<?php  echo url('article/notice/category');?>">公告分类</a></li>
	<li <?php  if($do == 'list') { ?>class="active"<?php  } ?>><a href="<?php  echo url('article/notice/list');?>">公告列表</a></li>
	<li <?php  if($do == 'post' && !$id) { ?>class="active"<?php  } ?>><a href="<?php  echo url('article/notice/post');?>">添加公告</a></li>
	<?php  if($do == 'post' && $id) { ?><li class="active"><a href="<?php  echo url('article/notice/post');?>">编辑公告</a></li><?php  } ?>
</ul>
<?php  if($do == 'category') { ?>
<div class="clearfix">
	<form action="<?php  echo url('article/notice/category');?>" method="post" class="form-horizontal" role="form">
		<div class="form-group">
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<a href="<?php  echo url('article/notice/category_post');?>" target="_blank" class="btn btn-success col-lg-1">添加分类</a>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">公告分类</div>
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th width="100">排序</th>
							<th width="300">分类名称</th>
							<th class="text-right">操作</th>
						</tr>
					</thead>
					<tbody>
					<?php  if(is_array($data)) { foreach($data as $da) { ?>
						<input type="hidden" name="ids[]" value="<?php  echo $da['id'];?>"/>
						<tr>
							<td><input type="text" name="displayorder[]" value="<?php  echo $da['displayorder'];?>" class="form-control"/></td>
							<td><input type="text" name="title[]" value="<?php  echo $da['title'];?>" class="form-control"/></td>
							<td class="text-right">
								<a href="<?php  echo url('article/notice/category_del', array('id' => $da['id']));?>" class="btn btn-default" onclick="if(!confirm('删除分类后，该分类下公告也会被删除，确定删除吗？')) return false;">删除</a>
							</td>
						</tr>
					<?php  } } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<input type="submit" class="btn btn-primary" name="submit" value="提交" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
</div>
<?php  } else if($do == 'category_post') { ?>
<div class="clearfix">
	<form action="<?php  echo url('article/notice/category_post');?>" method="post" class="form-horizontal" role="form">
		<div class="panel panel-default">
			<div class="panel-heading">公告分类</div>
			<div class="panel-body">
				<div id="tpl">
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">分类名称</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="title[]" vlaue="" placeholder="分类名称"/>
							<div class="help-block">请填写分类名称</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">排序</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="displayorder[]" vlaue="" placeholder="排序"/>
							<div class="help-block">数字越大，越靠前</div>
						</div>
					</div>
					<hr/>
				</div>
				<div id="container"></div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<a href="javascript:;" id="category-add"><i class="fa fa-plus-circle"></i> 继续添加分类</a>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<input type="submit" class="btn btn-primary" name="submit" value="提交" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
</div>
<?php  } ?>
<script>
	$(function(){
		$('#category-add').click(function(){
			var html = $('#tpl').html();
			$('#container').append(html);
			return false;
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-gw', TEMPLATE_INCLUDEPATH));?>
