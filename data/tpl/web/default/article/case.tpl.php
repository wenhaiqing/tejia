<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/header-gw', TEMPLATE_INCLUDEPATH));?>
<ol class="breadcrumb">
	<li><a href="./?refresh"><i class="fa fa-home"></i></a></li>
	<li><a href="<?php  echo url('system/welcome');?>">系统</a></li>
	<li class="active">案例列表</li>
</ol>
<ul class="nav nav-tabs">
	<li <?php  if($do == 'catecase' || $do == 'catecase_post') { ?>class="active"<?php  } ?>><a href="<?php  echo url('article/case/catecase');?>">案例分类</a></li>
	<li <?php  if($do == 'list') { ?>class="active"<?php  } ?>><a href="<?php  echo url('article/case/list');?>">案例列表</a></li>
	<li <?php  if($do == 'post' && !$id) { ?>class="active"<?php  } ?>><a href="<?php  echo url('article/case/post');?>">添加案例</a></li>
	<?php  if($do == 'post' && $id) { ?><li class="active"><a href="<?php  echo url('article/case/post');?>">编辑案例</a></li><?php  } ?>
</ul>
<?php  if($do == 'list') { ?>
<div class="clearfix">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="" method="get" class="form-horizontal" role="form">
				<input type="hidden" name="c" value="article">
				<input type="hidden" name="a" value="case">
				<input type="hidden" name="do" value="list">
				<input type="hidden" name="cateid" value="<?php  echo $_GPC['cateid'];?>">
				<input type="hidden" name="createtime" value="<?php  echo $_GPC['createtime'];?>">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">案例分类</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<div class="btn-group">
							<a href="<?php  echo filter_url('cateid:0');?>" class="btn <?php  if($_GPC['cateid'] == 0) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
							<?php  if(is_array($catecases)) { foreach($catecases as $catecase) { ?>
							<a href="<?php  echo filter_url('cateid:' . $catecase['id']);?>" class="btn <?php  if($_GPC['cateid'] == $catecase['id']) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>"><?php  echo $catecase['title'];?></a>
							<?php  } } ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">添加时间</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<div class="btn-group">
							<a href="<?php  echo filter_url('createtime:0');?>" class="btn <?php  if($_GPC['createtime'] == 0) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">不限</a>
							<a href="<?php  echo filter_url('createtime:3');?>" class="btn <?php  if($_GPC['createtime'] == 3) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">三天内</a>
							<a href="<?php  echo filter_url('createtime:7');?>" class="btn <?php  if($_GPC['createtime'] == 7) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">一周内</a>
							<a href="<?php  echo filter_url('createtime:30');?>" class="btn <?php  if($_GPC['createtime'] == 30) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">一月内</a>
							<a href="<?php  echo filter_url('createtime:90');?>" class="btn <?php  if($_GPC['createtime'] == 90) { ?>btn-primary<?php  } else { ?>btn-default<?php  } ?>">三月内</a>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">标题</label>
					<div class="col-sm-8 col-lg-3 col-xs-12">
						<input class="form-control" name="title" id="" type="text" value="<?php  echo $_GPC['title'];?>">
					</div>
					<div class="pull-left col-xs-12 col-sm-2 col-lg-2">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<form action="<?php  echo url('article/case/batch_post');?>" method="post" class="form-horizontal" role="form">
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th width="80">排序</th>
							<th width="100">阅读次数</th>
							<th width="300">标题</th>
							<th>所属分类</th>
							<th>在首页显示</th>
							<th>是否显示</th>
							<th>添加时间</th>
							<th class="text-right">操作</th>
						</tr>
					</thead>
					<tbody>
					<?php  if(is_array($case)) { foreach($case as $case) { ?>
						<input type="hidden" name="ids[]" value="<?php  echo $case['id'];?>" />
						<tr>
							<td>
								<input type="text" class="form-control" name="displayorder[]" value="<?php  echo $case['displayorder'];?>"/>
							</td>
							<td>
								<input type="text" class="form-control" name="click[]" value="<?php  echo $case['click'];?>"/>
							</td>
							<td>
								<input type="text" class="form-control" name="title[]" value="<?php  echo $case['title'];?>"/>
							</td>
							<td><?php  echo $catecases[$case['cateid']]['title'];?></td>
							<td>
								<?php  if($case['is_show_home'] == 1) { ?>
								<span class="label label-success">是</span>
								<?php  } else { ?>
								<span class="label label-danger">否</span>
								<?php  } ?>
							</td>
							<td>
								<?php  if($case['is_display'] == 1) { ?>
									<span class="label label-success">显示中</span>
								<?php  } else { ?>
									<span class="label label-danger">已隐藏</span>
								<?php  } ?>
							</td>
							<td><?php  echo date('Y-m-d H:i', $case['createtime']);?></td>
							<td class="text-right">
								<a href="<?php  echo url('article/case/post', array('id' => $case['id']));?>" class="btn btn-default">编辑</a>
								<a href="<?php  echo url('article/case/del', array('id' => $case['id']));?>" onclick="if(!confirm('确定删除吗')) return false;" class="btn btn-default">删除</a>
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
		<?php  echo $pager;?>
	</form>
</div>
<?php  } else if($do == 'post') { ?>
<div class="clearfix">
	<form action="<?php  echo url('article/case/post');?>" method="post" class="form-horizontal" role="form" id="form1">
		<input type="hidden" name="id" value="<?php  echo $case['id'];?>"/>
		<div class="panel panel-default">
			<div class="panel-heading">编辑案例</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">案例标题</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control" name="title" value="<?php  echo $case['title'];?>" placeholder="案例标题"/>
						<div class="help-block">请填写案例标题</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">微信号</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control" name="weixinh" value="<?php  echo $case['weixinh'];?>" placeholder="微信号"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">微信标签</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control" name="weixintag" value="<?php  echo $case['weixintag'];?>" placeholder="微信标签"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">案例分类</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<select name="cateid" id="cateid" class="form-control">
							<option value="">==请选择案例分类==</option>
							<?php  if(is_array($catecases)) { foreach($catecases as $catecase) { ?>
							<option value="<?php  echo $catecase['id'];?>" <?php  if($case['cateid'] == $catecase['id']) { ?>selected<?php  } ?>><?php  echo $catecase['title'];?></option>
							<?php  } } ?>
						</select>
						<div class="help-block">还没有分类，点我 <a href="<?php  echo url('article/case/catecase_post');?>" target="_blank"><i class="fa fa-plus-circle"></i> 添加分类</a></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">微信公众号二维码</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<?php  echo tpl_form_field_image('thumb', $case['thumb'], '', array('dest_dir' => 'articles'));?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
					<div class="col-sm-8">
						<div class="help-block"><label class="checkbox-inline"><input type="checkbox" name="autolitpic" value="1"<?php  if(empty($item['thumb'])) { ?> checked="true"<?php  } ?>>提取内容的第一个图片为缩略图</label></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">微信公众号描述</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<?php  echo tpl_ueditor('content', $case['content']);?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">案例来源</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control" name="source" value="<?php  echo $case['source'];?>" placeholder="案例来源"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">案例作者</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control" name="author" value="<?php  echo $case['author'];?>" placeholder="案例作者"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">阅读次数</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control" name="click" value="<?php  echo $case['click'];?>" placeholder="阅读次数"/>
						<div class="help-block">默认为0。您可以设置一个初始值,阅读次数会在该初始值上增加。</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">排序</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input type="text" class="form-control" name="displayorder" value="<?php  echo $case['displayorder'];?>" placeholder="阅读次数"/>
						<div class="help-block">数字越大，越靠前。</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">是否显示</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<label class="radio-inline"><input type="radio" name="is_display" value="1" <?php  if($case['is_display'] == 1) { ?> checked<?php  } ?>> 显示</label>
						<label class="radio-inline"><input type="radio" name="is_display" value="0" <?php  if($case['is_display'] == 0) { ?> checked<?php  } ?>> 不显示</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">显示在首页</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<label class="radio-inline"><input type="radio" name="is_show_home" value="1" <?php  if($case['is_show_home'] == 1) { ?> checked<?php  } ?>> 是</label>
						<label class="radio-inline"><input type="radio" name="is_show_home" value="0" <?php  if($case['is_show_home'] == 0) { ?> checked<?php  } ?>> 否</label>
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
		$('#form1').submit(function(){
			if(!$.trim($(':text[name="title"]').val())) {
				util.message('请填写案例标题', '', 'error');
				return false;
			}
			if(!$.trim($('#cateid').val())) {
				util.message('请选择案例分类', '', 'error');
				return false;
			}
			if(!$.trim($('textarea[name="content"]').val())) {
				util.message('请填写案例内容', '', 'error');
				return false;
			}
			return true;
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-gw', TEMPLATE_INCLUDEPATH));?>
