<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/template/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/template/navs', TEMPLATE_INCLUDEPATH));?>
<form action="" method="post"  class="form-horizontal" role="form" enctype="multipart/form-data" id="form1">
<div class="panel panel-default">
	<div class="panel-heading">
		跑腿认证设置
		<input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
	</div>
	<div class="panel-body">

		<div class="form-group">
			<div class="col-sm-10 col-xs-12">
				<div class="input-group">
				<div class="input-group-addon">认证费用</div>
				<input type="text" name="runner_money" class="form-control" value="<?php  echo $settings['runner_money'];?>" />
				<div class="input-group-addon">元，认证通过赠送</div>
				<input type="text" name="start_num" class="form-control" value="<?php  echo $settings['start_num'];?>" />
				<div class="input-group-addon">信誉，每点信誉</div>
				<input type="text" name="one_money" class="form-control" value="<?php  echo $settings['one_money'];?>" />
				<div class="input-group-addon">元，放弃订单扣除</div>
				<input type="text" name="giveup_num" class="form-control" value="<?php  echo $settings['giveup_num'];?>" />
				<div class="input-group-addon">信誉</div>
				</div>
			</div>
		</div>
		<div class="form-group">
		    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">自动完成时间</label>
		    <div class="col-sm-8 col-lg-9 col-xs-12">
				<input type="text" name="auto_finish_time" placeholder="" value="<?php  echo $item['auto_finish_time'];?>" class="form-control"/>
		        <span class="help-block">接任务后，如超过此时间自动完成任务，单位为小时，不填则不自动完成</span>
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">显示优秀跑腿</label>
		    <div class="col-sm-8 col-lg-9 col-xs-12">
		        <label class="radio-inline">
		            <input type="radio" name="shop_runner_best" value="1" <?php  if($item['shop_runner_best']==1) { ?>checked="checked"<?php  } ?>> 开启
		        </label>
		        <label class="radio-inline">
		            <input type="radio" name="shop_runner_best" value="0" <?php  if($item['shop_runner_best']==0) { ?>checked="checked"<?php  } ?>> 关闭
		        </label>
		        <span class="help-block">控制任务大厅页面有效跑腿是否显示</span>
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">默认6星好评时间</label>
		    <div class="col-sm-8 col-lg-9 col-xs-12">
		        <input type="text" name="star_length" placeholder="" value="<?php  echo $item['star_length'];?>" class="form-control"/>
		        <span class="help-block">默认是完成任务后24小时</span>
		    </div>
		</div>


		<div class="form-group">
		    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">评价奖惩</label>
		    <div class="col-sm-8 col-lg-9 col-xs-12">
		        <div class="input-group">
		            <span class="input-group-addon">小于</span>
		            <input type="text" class="form-control" name="min_star" value="<?php  echo $item['min_star']?>">
		            <span class="input-group-addon">星,每星扣除</span>
					<input type="text" class="form-control" name="min_credit" value="<?php  echo $item['min_credit']?>">
					<span class="input-group-addon">积分</span>
					<input type="text" class="form-control" name="min_xinyu" value="<?php  echo $item['min_xinyu']?>">
					<span class="input-group-addon">信誉，大于</span>
					<input type="text" class="form-control" name="max_star" value="<?php  echo $item['max_star']?>">
					<span class="input-group-addon">星,每星奖励</span>
					<input type="text" class="form-control" name="max_credit" value="<?php  echo $item['max_credit']?>">
					<span class="input-group-addon">积分</span>
					<input type="text" class="form-control" name="max_xinyu" value="<?php  echo $item['max_xinyu']?>">
					<span class="input-group-addon">信誉</span>
		        </div>
		    </div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				连接设置
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 control-label">提现入口</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<?php  echo tpl_form_field_link('tixian_url',$settings['tixian_url'])?>
					</div>
				</div>

				<div class="form-group" style="margin-top:20px;">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 control-label">流程说明入口</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<?php  echo tpl_form_field_link('help_url',$settings['help_url'])?>
					</div>
				</div>

			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">总开关</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">接任务必须认证</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" name="recive_open" value="1" <?php  if($item['recive_open']==1) { ?>checked="checked"<?php  } ?>> 开启
						</label>
						<label class="radio-inline">
							<input type="radio" name="recive_open" value="0" <?php  if($item['recive_open']==0) { ?>checked="checked"<?php  } ?>> 关闭
						</label>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">发布任务前必须完善信息</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" name="post_open" value="1" <?php  if($item['post_open']==1) { ?>checked="checked"<?php  } ?>> 开启
						</label>
						<label class="radio-inline">
							<input type="radio" name="post_open" value="0" <?php  if($item['post_open']==0) { ?>checked="checked"<?php  } ?>> 关闭
						</label>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">跑腿自动审核</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" name="auto_runner" value="1" <?php  if($item['auto_runner']==1) { ?>checked="checked"<?php  } ?>> 开启
						</label>
						<label class="radio-inline">
							<input type="radio" name="auto_runner" value="0" <?php  if($item['auto_runner']==0) { ?>checked="checked"<?php  } ?>> 关闭
						</label>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">非跑腿用户不能浏览跑腿端信息</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<label class="radio-inline">
							<input type="radio" name="limit_runner_look" value="1" <?php  if($item['limit_runner_look']==1) { ?>checked="checked"<?php  } ?>> 开启
						</label>
						<label class="radio-inline">
							<input type="radio" name="limit_runner_look" value="0" <?php  if($item['limit_runner_look']==0) { ?>checked="checked"<?php  } ?>> 关闭
						</label>
						<span class="help-block"></span>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">注册条款</div>
			<div class="panel-body" style="margin:0px;padding:0px;">
			<?php  echo tpl_ueditor('register',$settings['register'])?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
				<input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>

	</div>
</form>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
