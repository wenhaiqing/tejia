<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/template/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/template/navs', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('navs', TEMPLATE_INCLUDEPATH)) : (include template('navs', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading">
		系统设置
	</div>
	
	<div class="panel-body">
		<form action="" class="form-horizontal" method="post">
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">是否开启地图</label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<input type="radio" name="plugin_map_open" value="1" <?php  if($plugin['plugin_map_open']==1) { ?>checked="checked"<?php  } ?> class=""/>开启
					<input type="radio" name="plugin_map_open" class="" value="0" <?php  if($plugin['plugin_map_open']==0) { ?>checked="checked"<?php  } ?>/>关闭
					<span class="help-block">是否开启地图</span>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">城市开关</label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<input type="radio" name="plugin_address_open" value="1" <?php  if($plugin['plugin_address_open']==1) { ?>checked="checked"<?php  } ?> class=""/>开启
					<input type="radio" name="plugin_address_open" class="" value="0" <?php  if($plugin['plugin_address_open']==0) { ?>checked="checked"<?php  } ?>/>关闭
					<span class="help-block">是否开启城市列表</span>
				</div>
			</div>
			
			<div class="form-group">
			    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">任务默认时效</label>
			    <div class="col-sm-8 col-lg-9 col-xs-12">
			        <input type="text" name="limit_time" value="<?php  echo $plugin['limit_time'];?>" class="form-control"/>
			        <span class="help-block">
						单位为小时，超过时间未接单则自动时效
					</span>
			    </div>
			</div>
			
			<div class="form-group">
			    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">自动退款</label>
			    <div class="col-sm-8 col-lg-9 col-xs-12">
					<div class="input-group">
					    <span class="input-group-addon">过期时间超过</span>
					    <input type="text" class="form-control" name="delete_time" value="<?php  echo $plugin['delete_time']?>">
					    <span class="input-group-addon">小时，自动退款</span>
					</div>
			        <span class="help-block"></span>
			    </div>
			</div>
			
			<div class="form-group">
			    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">后台自动清理</label>
			    <div class="col-sm-8 col-lg-9 col-xs-12">
					<div class="input-group">
					    <span class="input-group-addon">清理</span>
					    <input type="text" class="form-control" name="web_delete_time" value="<?php  echo $plugin['web_delete_time']?>">
					    <span class="input-group-addon">小时之前的未支付任务</span>
					</div>
			        <span class="help-block">
						建议大于1个小时
					</span>
			    </div>
			</div>
			
			<div class="form-group">
			    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">默认佣金系数</label>
			    <div class="col-sm-8 col-lg-9 col-xs-12">
			        <input type="text" name="platform_money" value="<?php  echo $plugin['platform_money'];?>" class="form-control"/>
			        <span class="help-block">
						默认佣金系数，任务完成后，跑腿服务人员获取的佣金为（总金额*佣金系数）,请填写小于100的整数，如80则总金额的0.8
					</span>
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