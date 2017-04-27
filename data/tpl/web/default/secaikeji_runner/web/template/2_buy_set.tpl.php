<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/template/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/template/navs', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading">
		帮我买-默认配送价格设置
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal" role="form" id="form1" >
			<div class="form-group">
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<div class="input-group">
						<div class="input-group-addon">从</div>
						<input type="text" class="form-control" name="day_start_time" value="<?php  echo $item['day_start_time'];?>"/>
						<div class="input-group-addon">点，到</div>
						<input type="text" class="form-control" name="day_end_time" value="<?php  echo $item['day_end_time'];?>"/>
						<div class="input-group-addon">起步价</div>
						<input type="text" class="form-control" name="day_start" value="<?php  echo $item['day_start'];?>"/>
						<div class="input-group-addon">元，最大</div>
						<input type="text" class="form-control" name="day_max" value="<?php  echo $item['day_max'];?>">
						<div class="input-group-addon">元</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<div class="input-group">
						<div class="input-group-addon">从</div>
						<input type="text" class="form-control" name="night_start_time" value="<?php  echo $item['night_start_time'];?>"/>
						<div class="input-group-addon">点，到</div>
						<input type="text" class="form-control" name="night_end_time" value="<?php  echo $item['night_end_time'];?>"/>
						<div class="input-group-addon">起步价</div>
						<input type="text" class="form-control" name="night_min" value="<?php  echo $item['night_min'];?>">
						<div class="input-group-addon">元，最大</div>
						<input type="text" class="form-control" name="night_max" value="<?php  echo $item['night_max'];?>">
						<div class="input-group-addon">元</div>
					</div>
				</div>
			</div>
			<div class="form-group">
			    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">语音单开关</label>
			    <div class="col-sm-8 col-lg-9 col-xs-12">
			        <label class="radio-inline">
			            <input type="radio" name="open_voice" value="1" <?php  if($item['open_voice']==1) { ?>checked="checked"<?php  } ?>> 开启
			        </label>
			        <label class="radio-inline">
			            <input type="radio" name="open_voice" value="0" <?php  if($item['open_voice']==0) { ?>checked="checked"<?php  } ?>> 关闭
			        </label>
			        <span class="help-block"></span>
			    </div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">总开关</label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<label class="radio-inline">
						<input type="radio" name="open" value="1" <?php  if($item['open']==1) { ?>checked="checked"<?php  } ?>> 开启
					</label>
					<label class="radio-inline">
						<input type="radio" name="open" value="0" <?php  if($item['open']==0) { ?>checked="checked"<?php  } ?>> 关闭
					</label>
					<span class="help-block"></span>
				</div>
			</div>
			
			<div class="form-group">
			    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">商品价值</label>
			    <div class="col-sm-8 col-lg-9 col-xs-12">
			        <label class="radio-inline">
			            <input type="radio" name="open_goodstoast" value="1" <?php  if($item['open_goodstoast']==1) { ?>checked="checked"<?php  } ?>> 显示
			        </label>
			        <label class="radio-inline">
			            <input type="radio" name="open_goodstoast" value="0" <?php  if($item['open_goodstoast']==0) { ?>checked="checked"<?php  } ?>> 不显示
			        </label>
			        <span class="help-block"></span>
			    </div>
			</div>
			
			<div class="form-group">
			    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">垫付</label>
			    <div class="col-sm-8 col-lg-9 col-xs-12">
			        <label class="radio-inline">
			            <input type="radio" name="open_dian" value="1" <?php  if($item['open_dian']==1) { ?>checked="checked"<?php  } ?>> 显示
			        </label>
			        <label class="radio-inline">
			            <input type="radio" name="open_dian" value="0" <?php  if($item['open_dian']==0) { ?>checked="checked"<?php  } ?>> 不显示
			        </label>
			        <span class="help-block"></span>
			    </div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					佣金系数
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<div class="form-group">
								<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">佣金系数</label>
								<div class="col-sm-8 col-lg-9 col-xs-12">
									<input type="text" name="platform_money" placeholder="" value="<?php  echo $item['platform_money'];?>" class="form-control"/>
									<span class="help-block">任务完成后，跑腿服务人员获取的佣金为（总金额*佣金系数）,请填写小于100的整数，如80则总金额的0.8</span>
								</div>
							</div>
						</div>
					</div>
				</div>、
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<input type="submit" class="btn btn-danger" value="提交">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				</div>
			</div>
		</form>
	</div>
	<div class="panel-footer">
	
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>