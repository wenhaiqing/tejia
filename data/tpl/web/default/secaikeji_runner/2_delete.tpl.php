<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/task/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/task/navs', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default" ng-app="app" ng-controller="rootCtrl">
	<div class="panel-heading">
		清理测试数据
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal" role="form" id="form1" >
			<div class="form-group">
			    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">数据表</label>
			    <div class="col-sm-8 col-lg-9 col-xs-12">
					<?php  if(is_array($tables)) { foreach($tables as $key => $task) { ?>
			        <label class="checkbox-inline">
			            <input type="checkbox" name="table[]" value="<?php  echo $task;?>"> <?php  echo $key;?>
			        </label>
					<?php  } } ?>
			        <span class="help-block"></span>
			    </div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">请输入删除密码</label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<input type="text" name="code" value="" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<input type="submit" class="btn btn-default" value="提交">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				</div>
			</div>
			
		</form>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>