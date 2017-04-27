<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/template/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/template/navs', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading">
		帮我送-默认配送价格设置
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal" role="form" id="form1" >
			<div class="panel panel-default">
				<div class="panel-heading">总开关</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 control-label">开启小费功能</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="radio" name="open_small_money" value="1" <?php  if($item['open_small_money']==1) { ?>checked="checked"<?php  } ?> class=""/>开启
							<input type="radio" name="open_small_money" class="" value="0" <?php  if($item['open_small_money']==0) { ?>checked="checked"<?php  } ?>/>关闭
							&nbsp;【开启小费模式，前台将出现小费功能】
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 control-label">物品价值</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="radio" name="open_goodscost" value="1" <?php  if($item['open_goodscost']==1) { ?>checked="checked"<?php  } ?> class=""/>开启
							<input type="radio" name="open_goodscost" class="" value="0" <?php  if($item['open_goodscost']==0) { ?>checked="checked"<?php  } ?>/>关闭
							&nbsp;【物品价值是否需要显示】
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 control-label">备注</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="radio" name="open_message" value="1" <?php  if($item['open_message']==1) { ?>checked="checked"<?php  } ?> class=""/>开启
							<input type="radio" name="open_message" class="" value="0" <?php  if($item['open_message']==0) { ?>checked="checked"<?php  } ?>/>关闭
							&nbsp;【备注是否需要显示】
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 control-label">图片附件</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="radio" name="open_images" value="1" <?php  if($item['open_images']==1) { ?>checked="checked"<?php  } ?> class=""/>开启
							<input type="radio" name="open_images" class="" value="0" <?php  if($item['open_images']==0) { ?>checked="checked"<?php  } ?>/>关闭
							&nbsp;【备注是否需要显示】
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 control-label">物品名称</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="radio" name="open_goodsname" value="1" <?php  if($item['open_goodsname']==1) { ?>checked="checked"<?php  } ?> class=""/>开启
							<input type="radio" name="open_goodsname" class="" value="0" <?php  if($item['open_goodsname']==0) { ?>checked="checked"<?php  } ?>/>关闭
							&nbsp;【物品名称是否需要显示】
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 control-label">物品重量</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="radio" name="open_goodsweight" value="1" <?php  if($item['open_goodsweight']==1) { ?>checked="checked"<?php  } ?> class=""/>开启
							<input type="radio" name="open_goodsweight" class="" value="0" <?php  if($item['open_goodsweight']==0) { ?>checked="checked"<?php  } ?>/>关闭
							&nbsp;【物品重量是否需要显示】
						</div>
					</div>
					
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					小费设置
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<div class="input-group">
								<div class="input-group-addon">最小</div>
								<input type="text" class="form-control" name="buy_min_num" value="<?php  echo $item['buy_min_num'];?>"/>
								<div class="input-group-addon">元，最大</div>

								<input type="text" class="form-control" name="buy_max_num" value="<?php  echo $item['buy_max_num'];?>"/>
								<div class="input-group-addon">元，默认</div>
								<input type="text" class="form-control" name="buy_default_num" value="<?php  echo $item['buy_default_num'];?>"/>
								<div class="input-group-addon">元</div>
							</div>

						</div>
					</div>
				</div>、
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
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<div class="input-group">
						<div class="input-group-addon">起步价</div>
						<input type="text" class="form-control" name ="start_fee" value="<?php  echo $item['start_fee'];?>"/>
						<div class="input-group-addon">元含</div>
						<input type="text" class="form-control" name ="start_km" value="<?php  echo $item['start_km'];?>" >
						<div class="input-group-addon">公里以内</div>
						<!-- <input type="text" class="form-control" name ="start_kg" value="<?php  echo $item['start_kg'];?>">
						<div class="input-group-addon">公斤以内</div> -->
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<div class="input-group">
						<div class="input-group-addon">正常服务时间，从</div>
						<input type="text" class="form-control" name ="start_time" value="<?php  echo $item['start_time'];?>"/>
						<div class="input-group-addon">点</div>
						<input type="text" class="form-control" name ="end_time" value="<?php  echo $item['end_time'];?>" >
						<div class="input-group-addon">点,超出每单加</div>
						<input type="text" class="form-control" name ="time_fee" value="<?php  echo $item['time_fee'];?>">
						<div class="input-group-addon">%</div>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<div class="input-group">
						<div class="input-group-addon">每</div>
						<input type="text" class="form-control" name="limit_km_km" value="<?php  echo $item['limit_km_km'];?>"/>
						<div class="input-group-addon">公里增加</div>
						<input type="text" class="form-control" name="limit_km_fee" value="<?php  echo $item['limit_km_fee'];?>"/>
						<div class="input-group-addon">元</div>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<div class="input-group">
						<div class="input-group-addon">每</div>
						<input type="text" class="form-control" name="limit_kg_kg" value="<?php  echo $item['limit_kg_kg'];?>"/>
						<div class="input-group-addon">公斤增加</div>
						<input type="text" class="form-control" name="limit_kg_fee" value="<?php  echo $item['limit_kg_fee'];?>"/>
						<div class="input-group-addon">元</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					《禁止发布的事项信息》
				</div>
				<div class="panel-body">
					<?php  echo tpl_ueditor('post_notice',$item['post_notice'])?>
				</div>
				<div class="panel-footer">
					<a href="<?php  echo $this->createWebUrl('plugin',array('mp'=>'template','mdo'=>'divider_template'))?>" class="btn btn-danger">帮我送页面DIY</a>
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
	<div class="panel-footer">
	
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>