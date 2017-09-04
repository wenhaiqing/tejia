<?php defined('IN_IA') or exit('Access Denied');?><?php  if($_W['role'] != 'operator') { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php  } else { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header-base1', TEMPLATE_INCLUDEPATH)) : (include template('public/header-base1', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('store/nav', TEMPLATE_INCLUDEPATH)) : (include template('store/nav', TEMPLATE_INCLUDEPATH));?>
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times" style="font-size: 26px"></i></button>
	<h3>温馨提示: 配货中心仅统计订单状态为"已确认,处理中"的订单.</h3>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-pills">
			<li <?php  if($op == 'goods') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('dispatch', array('op' => 'goods'));?>">按商品统计</a></li>
			<!-- <li <?php  if($op == 'category') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('dispatch', array('op' => 'category'));?>">按分类统计</a></li> -->
			<li><a href="javascript:;" onclick="location.reload();">刷新</a></li>
		</ul>
	</div>
</div>
<div class="clearfix">
	<?php  if(empty($orders)) { ?>
	<div class="panel panel-default panel-dispatch">
		<h3 class="text-center"><i class="fa fa-info-circle"></i> 暂无要配送的商品</h3>
	</div>
	<?php  } else { ?>
	<div class="panel panel-default panel-dispatch">
		<div class="panel-body">
			<div class="col-lg-3">
				<ul class="list-group">
					<?php  if(is_array($stat)) { foreach($stat as $row) { ?>
						<li class="list-group-item" id="storecategorystores<?php  echo $row['goods_id'];?>">
							<span class="badge"><?php  echo $row['num'];?> <select name="stores1"  class="badge">
								<?php  if(!empty($stores)) { ?>
								<option value="0">请选择</option>
								<?php  if(is_array($stores)) { foreach($stores as $s) { ?>
								<option value="<?php  echo $s['id'];?>" data-id="stores<?php  echo $row['goods_id'];?>"><font color="black"><?php  echo $s['title'];?></font></option>
								<?php  } } ?>
								<?php  } ?>
							</select></span>
							<?php  echo $row['goods_title'];?>
						</li>
						<?php  if(!empty($goods[$row['goods_id']])) { ?>
							<li class="list-group-item list-group-item-span">
							<?php  if(is_array($goods[$row['goods_id']])) { foreach($goods[$row['goods_id']] as $da) { ?>
								<?php  if($da['goods_num'] > 1) { ?>
									<span class="label label-warning toggle-goods-status" data-id="<?php  echo $da['id'];?>" data-status="<?php echo $da['status'] == 1 ? 0 : 1?>"><?php  echo $da['username'];?>(<?php  echo $da['goods_num'];?>份)</span>
								<?php  } else { ?>
									<span class="label label-success toggle-goods-status" data-id="<?php  echo $da['id'];?>" data-status="<?php echo $da['status'] == 1 ? 0 : 1?>"><?php  echo $da['username'];?></span>
								<?php  } ?>
							<?php  } } ?>
								<a href="javascript:;"></a><span onclick="supplier(<?php  echo $row['goods_id'];?>)" id="supplier" data-id="<?php  echo $row['goods_id'];?>" data-status="<?php echo $da['status'] == 1 ? 0 : 1?>">给供应商下单</span></a>

							</li>
						<?php  } ?>
					<?php  } } ?>
				</ul>
			</div>
			<div class="col-lg-9" id="order-container" style="position: relative">
				<?php  if(is_array($orders)) { foreach($orders as $order) { ?>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-5 water">
					<div class="panel panel-default panel-dispatch table-responsive">
						<div class="panel-heading">
							<span style="font-size: 18px"><strong class="text-primary">#<?php  echo $order['id'];?></strong> ~ <?php  echo $order['username'];?> ~ <?php  echo $order['mobile'];?></span>
						</div>
						<div class="panel-body">
							<table class="table table-hover table-bordered table-text-center">
								<thead>
								<tr>
									<th>商品</th>
									<th>数量</th>
									<th style="text-align: right">状态</th>
								</tr>
								</thead>
								<?php  if(is_array($order_goods[$order['id']])) { foreach($order_goods[$order['id']] as $order_good) { ?>
								<tr>
									<td><?php  echo $order_good['goods_title'];?></td>
									<td><?php  echo $order_good['goods_num'];?></td>
									<td style="text-align: right">
										<?php  if($order_good['status'] == 1) { ?>
										<a href="javascript:;" class="btn btn-success btn-sm toggle-goods-status" data-id="<?php  echo $order_good['id'];?>" data-status="0">已配好</a>
										<?php  } else { ?>
										<a href="javascript:;" class="btn btn-danger btn-sm toggle-goods-status" data-id="<?php  echo $order_good['id'];?>" data-status="1">配货中</a>
										<?php  } ?>
									</td>
								</tr>
								<?php  } } ?>
								<tr>
									<td colspan="3" style="text-align: right">
										<a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $order['id']));?>" target="_blank" class="btn btn-success btn-sm">订单详情</a>
										<a href="javascript:;" class="btn btn-default btn-sm toggle-order-goods-status" data-oid="<?php  echo $order['id'];?>">全部配好</a>
									</td>
								</tr>
							</table>
						</div>
						<div class="panel-footer">
							下单时间:<?php  echo date('Y-m-d H:i', $order['addtime']);?> <strong class="text-danger">(已下单:<?php  echo sub_day($order['addtime']);?>)</strong>
						</div>
					</div>
				</div>
				<?php  } } ?>
			</div>
		</div>
	</div>
	<?php  } ?>
</div>
<script>

$(document).ready(function(){
		$('select').change(function(){
			var p1=$(this).children('option:selected').val();//这就是selected的值
			var dataid = $(this).children('option:selected').attr('data-id');
			$(".stores").hide();
			$.ajax({
				url:"<?php  echo $this->createWebUrl('dispatch', array('op' => 'stores'));?>",
				type:'POST', //GET
				async:true,    //或false,是否异步
				data:{
					id: p1
				},
				dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
				success:function(data){
					if (data.length>0){
						var html = '';
						html+='<span class="badge stores">';
						html+='<select name="stores" id="'+dataid+'"  class="badge">';
						html+='<option value="0">请选择</option>';
						for(var i=0;i<data.length;i++){
							html+='<option value="'+data[i].id+'"><font color="black">'+data[i].title+'</font></option>';
						}
						html+='</select></span>';
						var sid = "#storecategory"+dataid;

						$(sid).after(html);
					}

				}
			})
		});
	});
	function supplier(id){
		var sid = $("#stores"+id).val();
		//console.log(sid);
			if(!id) {
				return false;
			}
			if(!sid){
				return false;
			}
				$.post("<?php  echo $this->createWebUrl('dispatch', array('op' => 'supplier'));?>", {id: id,sid:sid}, function(data) {
					var result = $.parseJSON(data);
					if (result.message.errno != 0) {
						util.message(result.message.message, '', 'error');
						return;
					}
					location.reload();
				})
	}
require(['jquery.wookmark'], function(){
	$('#order-container .water').wookmark({
		align: 'center',
		autoResize: false,
		container: $('#order-container'),
		autoResize :true
	});

	$('.toggle-order-goods-status').click(function(){
		var id = $(this).data('oid');
		if(!id) {
			return false;
		}
		tiny.confirm($(this), '确定该订单的商品都配好了?', function(){
			$.post("<?php  echo $this->createWebUrl('dispatch', array('op' => 'order_status'));?>", {id: id}, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno != 0) {
					util.message(result.message.message, '', 'error');
					return;
				}
				location.reload();
			});
		});
	});



	$('.toggle-goods-status').click(function(){
		var id = $(this).data('id');
		var status = $(this).data('status');
		if(!id) {
			return false;
		}
		tiny.confirm($(this), '确定商品配好了?', function(){
			$.post("<?php  echo $this->createWebUrl('dispatch', array('op' => 'goods_status'));?>", {id: id, status: status}, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno != 0) {
					util.message(result.message.message, '', 'error');
					return;
				}
				location.reload();
			});
		});
	});

//	setInterval(function(){
//		location.reload();
//		return false;
//	}, 15000);
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>