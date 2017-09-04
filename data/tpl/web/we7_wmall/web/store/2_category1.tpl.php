<?php defined('IN_IA') or exit('Access Denied');?><?php  if($_W['role'] != 'operator') { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php  } else { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header-base', TEMPLATE_INCLUDEPATH)) : (include template('public/header-base', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'update') { ?>
<form class="form-horizontal form" action="<?php  echo $this->createWebUrl('category', array('op' => 'update'));?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="sid" value="<?php  echo $sid;?>">
	<div class="main">
		<div class="panel panel-default">
			<div class="panel-heading">添加商品分类</div>
			<div class="panel-body">
				<div id="tpl">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>分类名称</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="title" value="<?php  echo $info['title'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>分类简短描述</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="description" value="<?php  echo $info['description'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">分类排序</label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" class="form-control" name="displayorder" value="<?php  echo $info['displayorder'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否属县级分类</label>
						<div class="col-sm-9 col-xs-12">
							是<input type="radio" name="district" value="1" <?php  if($info['district'] == 1) { ?>checked<?php  } ?>>
							否<input type="radio" name="district" value="0" <?php  if($info['district'] == 0) { ?>checked<?php  } ?>>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否属市级分类</label>
						<div class="col-sm-9 col-xs-12">
							是<input type="radio" name="city" value="1" <?php  if($info['city'] == 1) { ?>checked<?php  } ?>>
							否<input type="radio" name="city" value="0" <?php  if($info['city'] == 0) { ?>checked<?php  } ?>>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">所属分类</label>
						<div class="col-sm-9 col-xs-12">
							<select name="pid" id="pid" style="width:30%">
								<option value="0">顶级分类</option>
								<?php  if(is_array($category)) { foreach($category as $li) { ?>
								
								<option value="<?php  echo $li['id'];?>" <?php  if($info['pid'] == $li['id'] || $_GPC['pid'] == $li['id']) { ?>selected<?php  } ?>><?php  echo $li['title'];?></option>
							<?php  } } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="require">* </span>商品缩略图</label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_image('thumb', $info['thumb']);?>
							<div class="help-block">推荐大小: 200*200 px;这是图片大小,可以在中间做圆形具体实物图</div>
						</div>
					</div>
					<hr>
				</div>
				<div id="tpl-container"></div>
				<!--<div class="form-group">-->
					<!--<label class="col-xs-12 col-sm-3 col-md-2 control-label">分类排序</label>-->
					<!--<div class="col-sm-9 col-xs-12" style="padding-top:7px">-->
						<!--<a href="javascipt:;" id="post-add"><i class="fa fa-plus-circle"></i> 继续添加</a>-->
					<!--</div>-->
				<!--</div>-->
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				<input type="hidden" name="id" value="<?php  echo $info['id'];?>">
				<input name="submit" id="submit" type="submit" value="提交" class="btn btn-primary col-lg-1">
			</div>	
		</div>
	</div>
</form>
<script type="text/javascript">
	require(['util'], function(u){
		$('#post-add').click(function(){
			$('#tpl-container').append($('#tpl').html());
		});
	});
</script>
<?php  } else if($op == 'list') { ?>
<div class="main">
	<div class="panel panel-default">
		<div class="panel-body">
			<a class="btn btn-primary" href="<?php  echo $this->createWebUrl('category', array('op' => 'post'));?>"/><i class="fa fa-plus-circle"> </i> 添加商品分类</a>
			<a class="btn btn-success" href="javascript:;" onclick="$('.file-container').slideToggle()">批量导入分类</a>
		</div>
	</div>
	<div class="panel panel-default file-container">
		<div class="panel-body">
			<form action="<?php  echo $this->createWebUrl('category', array('op' => 'export'));?>" method="post" class="form-inline form-file" enctype="multipart/form-data">
				<div class="form-group">
					<input type="file" name="file" value="">
				</div>
				<input type="submit" name="submit" value="导入" class="btn btn-primary"/>
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
				<a class="btn btn-primary" href="<?php  echo $_W['siteroot'];?>/addons/we7_wmall/resource/excel/goods_category.xls">下载导入模板</a>
			</form>
		</div>
	</div>
	<form class="form-horizontal" action="" method="post">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
						<tr>
							<th>分类名称</th>
							<th>排序</th>
							<th>商品数</th>
							<th>是否显示</th>
							<th style="width:150px; text-align:right;">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($lists)) { foreach($lists as $item) { ?>
						<tr>
							<input type="hidden" name="ids[]" value="<?php  echo $item['id'];?>">
							<td><input type="text" style="width:130px" name="title[]" class="form-control" value="<?php  echo $item['title'];?>"></td>
							<td><input type="text" style="width:100px" name="displayorder[]" class="form-control" value="<?php  echo $item['displayorder'];?>"></td>
							<td><?php  echo intval($nums[$item['id']]['num'])?></td>
							<td>
								<input type="checkbox" value="<?php  echo $item['status'];?>" name="status[]" data-id="<?php  echo $item['id'];?>" <?php  if($item['status'] == 1) { ?>checked<?php  } ?>>
							</td>
							<td style="text-align:right;">
								<a href="<?php  echo $this->createWebUrl('goods', array('op' => 'list', 'cid' => $item['id']))?>" class="btn btn-default btn-sm" title="查看商品" data-toggle="tooltip" data-placement="top"><i class="fa fa-eye"> </i></a>
								<a href="<?php  echo $this->createWebUrl('goods', array('op' => 'post', 'cid' => $item['id']))?>" class="btn btn-default btn-sm" title="添加商品" data-toggle="tooltip" data-placement="top" ><i class="fa fa-plus"> </i></a>
								<a href="<?php  echo $this->createWebUrl('goods', array('op' => 'update', 'cid' => $item['id']))?>" class="btn btn-default btn-sm" title="编辑" data-toggle="tooltip" data-placement="top" ><i class="fa fa-plus"> </i></a>
								<a href="<?php  echo $this->createWebUrl('category', array('op' => 'del', 'id' => $item['id']))?>" class="btn btn-default btn-sm" title="删除" data-toggle="tooltip" data-placement="top" onclick="if(!confirm('删除后该分类下的商品也会删除，确定删除吗?')) return false;"><i class="fa fa-times"> </i></a>
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
		<?php  echo $pager;?>
	</form>
</div>
<script type="text/javascript">
require(['bootstrap.switch'], function($){
	$('.form-file').submit(function(){
		if(!$(':file[name="file"]').val()) {
			util.message('请先上传要导入的文件', '', 'error');
			return false;
		}
	});

	$(':checkbox[name="status[]"]').bootstrapSwitch();
	$(':checkbox[name="status[]"]').on('switchChange.bootstrapSwitch', function(e, state){
		var status = this.checked ? 1 : 0;
		var id = $(this).data('id');
		$.post("<?php  echo $this->createWebUrl('category', array('op' => 'status'))?>", {status: status, id: id}, function(resp){
			setTimeout(function(){
				location.reload();
			}, 500)
		});
	});
});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>