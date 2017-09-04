<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<script type='text/javascript' src='../addons/we7_wmall/resource/app/js/iscroll-probe.js' charset='utf-8'></script>
<div class="page order-confirm">
	<header class="bar bar-nav">
		<a class="pull-left back" href="javascript:;"><i class="fa fa-arrow-left"></i></a>
		<h1 class="title">提交订单</h1>
	</header>
	<nav class="bar bar-tab no-gutter order-bar">
		<div class="left">
			<span class="pull-left">
				已优惠
				<span class="activity-price">￥<?php  echo $activityed['total'];?></span>
			</span>
			<span class="pull-right">
				还需付
				<span class="sum"><span class="wait-price">￥<?php  echo $waitprice;?></span></span>
			</span>
		</div>
		<div class="right text-center bg-danger" id="order-submit">确认下单</div>
	</nav>
	<?php  if(!empty($activityed['list']['delivery'])) { ?>
		<nav class="bar bar-tab info-bar">
			<img src="<?php echo MODULE_URL;?>resource/app/img/vip_effective.png" alt="">
			尊贵的会员, 已为您节省<?php  echo $activityed['list']['delivery']['value'];?>元
		</nav>
	<?php  } ?>
	<div class="content">
		<form method="post" id="order-form" action="<?php  echo $this->createMobileUrl('order', array('sid' => $sid, 'op' => 'submit'));?>">
			<input type="hidden" name="sid" value="<?php  echo $sid;?>">
			<input type="hidden" name="address_id" id="address_id" value="<?php  echo $address_id;?>">
			<input type="hidden" name="record_id" id="record_id" value="<?php  echo $recordid;?>">
			<input type="hidden" name="note" id="order-note" value="">
			<input type="hidden" name="delivery_time" id="delivery-time" value="<?php  echo $predict_time;?>">
			<input type="hidden" name="delivery_day" id="delivery-day" value="<?php  echo $predict_day;?>">
			<?php  if($store['delivery_type'] == 2) { ?>
				<input type="radio" name="order_type" class="order_type hide" value="2" checked>
				<div class="content-block-title">选择配送方式 <span class="color-danger">（仅支持到店自提）</span></div>
			<?php  } ?>
			<?php  if($store['delivery_type'] == 1) { ?>
				<input type="radio" name="order_type" class="order_type hide" value="1" checked>
			<?php  } ?>
			<?php  if($store['delivery_type'] == 3) { ?>
				<div class="content-block-title">选择配送方式</div>
				<div class="list-block media-list pay-method">
					<ul>
						<li>
							<label class="label-checkbox item-content">
								<div class="item-inner">
									<div class="item-title">商家配送</div>
								</div>
								<input type="radio" name="order_type" class="order_type" value="1" checked id="order-type-1">
								<div class="item-media"><i class="icon icon-form-checkbox"></i></div>
							</label>
						</li>
						<li>
							<label class="label-checkbox item-content">
								<div class="item-inner">
									<div class="item-title">到店自提</div>
								</div>
								<input type="radio" name="order_type" class="order_type" value="2" id="order-type-2">
								<div class="item-media"><i class="icon icon-form-checkbox"></i></div>
							</label>
						</li>
					</ul>
				</div>
			<?php  } ?>
			<?php  if($store['delivery_type'] == 2 || $store['delivery_type'] == 3) { ?>
			<div class="list-block <?php  if($store['delivery_type'] == 3) { ?>hide<?php  } ?>" id="delivery-time-2">
				<ul>
					<li>
						<a href="javascript:;" class="item-link item-content delivery-time">
							<div class="item-inner">
								<div class="item-title">自提时间</div>
								<div class="item-after"><span class="color-black delivery-time-show">下单后直接去自提</span><span class="color-orange hide">(大约12:00到)</span></div>
							</div>
						</a>
					</li>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">下单人</div>
								<div class="item-input">
									<input type="text" name="username" placeholder="您的姓名" value="<?php  echo $_W['member']['realname'];?>">
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title label">手机号</div>
								<div class="item-input">
									<input type="text" name="mobile" placeholder="手机号" value="<?php  echo $_W['member']['mobile'];?>">
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<?php  } ?>
			<?php  if($store['delivery_type'] == 1 || $store['delivery_type'] == 3) { ?>
			<div class="list-block address" id="address-container">
				<ul>
					<li>
						<a class="item-link item-content external" href="<?php  echo $this->createMobileUrl('address', array('sid' => $sid, 'redirect_type' => 'order', 'recordid' => $_GPC['recordid']));?>">
							<div class="item-inner">
								<?php  if(!empty($address)) { ?>
									<div class="item-text">
										<div><span class="name"><?php  echo $address['realname'];?></span><span class="tel"><?php  echo $address['mobile'];?></span></div>
										<div>地址:<?php  echo $address['address'];?></div>
									</div>
								<?php  } else { ?>
									<div class="item-title">请选择送达地址</div>
								<?php  } ?>
							</div>
						</a>
						<div class="top-line"></div>
					</li>
					<li id="delivery-time-1">
						<a href="#" class="item-link item-content delivery-time">
							<div class="item-inner">
								<div class="item-title">请选择送达时间</div>
								<div class="item-after"><span class="color-black delivery-time-show"><?php  echo $text_time;?></span></div>
							</div>
						</a>
					</li>
				</ul>
			</div>
			<?php  } ?>
			<div class="content-block-title">选择支付方式 <span class="color-warning hide">（在线支付立减5元）</span></div>
			<div class="list-block media-list pay-method">
				<ul>
					<?php  if(is_array($store['payment'])) { foreach($store['payment'] as $row) { ?>
						<li>
							<label class="label-checkbox item-content">
								<div class="item-inner">
									<div class="item-title"><?php  echo $pay_types[$row]['text'];?></div>
								</div>
								<input type="radio" name="pay_type" class="pay_type" value="<?php  echo $row;?>" <?php  if($row == 'wechat') { ?>checked<?php  } ?>>
								<div class="item-media"><i class="icon icon-form-checkbox"></i></div>
							</label>
						</li>
					<?php  } } ?>
				</ul>
			</div>
			<div class="list-block coupon-info">
				<ul>
					<li>
						<a href="javascript:;" class="item-link item-content">
							<div class="item-inner">
								<div class="item-title">代金券</div>
								<div class="item-after color-danger <?php  if(!empty($coupons)) { ?>open-popup<?php  } ?>" data-popup=".popup-coupon">
								<?php  echo $coupon_text;?>
								</div>
							</div>
						</a>
					</li>
					<?php  if(!empty($conpon)) { ?>
						<li class="help-block">
							<?php  if($conpon['use_limit'] == 1) { ?>
							<div class="color-danger">本券可与其他优惠叠加使用</div>
							<?php  } else { ?>
							<div class="color-gray">本券不可与其他优惠叠加使用</div>
							<?php  } ?>
						</li>
					<?php  } ?>
				</ul>
			</div>
			<div class="list-block">
				<ul>
					<li>
						<a class="item-link item-content">
							<div class="item-inner">
								<div class="item-title">备注</div>
								<div class="item-after order-note" id="order-note-show">(选填)可填入特殊要求</div>
							</div>
						</a>
					</li>
					<?php  if($store['invoice_status']) { ?>
					<li>
						<div class="item-content invoice">
							<div class="item-inner">
								<div class="item-title">需要发票</div>
								<div class="item-after">
									<label class="label-switch invoice-status">
										<input type="checkbox" value="1">
										<div class="checkbox"></div>
									</label>
								</div>
							</div>
						</div>
					</li>
					<?php  } ?>
					<li class="hide invoice-value">
						<div class="item-content">
							<input type="text" id="invoice" placeholder="输入个人或者公司抬头"/>
						</div>
					</li>
				</ul>
			</div>
			<div class="list-block detail-info">
				<ul>
					<li>
						<div class="item-content">
							<div class="item-inner">
								<div class="item-title"><?php  echo $store['title'];?></div>
								<div class="item-after">本单由 <span class="color-black"><?php  if($account['delivery_type'] == 1) { ?>商家<?php  } else { ?>平台<?php  } ?></span> 配送</div>
							</div>
						</div>
					</li>
					<li class="order-list">
						<div class="inner-con">
							<?php  if(is_array($cart['data'])) { foreach($cart['data'] as $val) { ?>
								<?php  if(is_array($val)) { foreach($val as $val1) { ?>
									<div class="row no-gutter">
										<div class="col-60"><?php  echo $val1['title'];?></div>
										<div class="col-20 text-right color-muted">×<?php  echo $val1['num'];?></div>
										<div class="col-20 text-right color-black">￥<?php  echo $val1['price'];?></div>
									</div>
								<?php  } } ?>
							<?php  } } ?>
						</div>
					</li>
					<li class="order-list">
						<div class="inner-con">
							<div class="row no-gutter">
								<div class="col-80">包装费</div>
								<div class="col-20 text-right color-black">￥<?php  echo $store['pack_price'];?></div>
							</div>
							<div class="row no-gutter">
								<div class="col-80">配送费</div>
								<div class="col-20 text-right color-black">￥<span id="delivery-price"><?php  echo $delivery_price;?></span></div>
							</div>
						</div>
					</li>
					<?php  if(!empty($activityed['list'])) { ?>
						<li class="order-list activity-list">
							<div class="inner-con">
								<?php  if(is_array($activityed['list'])) { foreach($activityed['list'] as $key => $row) { ?>
									<div class="row no-gutter activity-<?php  echo $key;?>">
										<div class="col-50 icon-before"><img src="<?php echo MODULE_URL;?>resource/app/img/<?php  echo $row['icon'];?>"><?php  echo $row['name'];?></div>
										<div class="col-50 text-right color-black"><?php  echo $row['text'];?></div>
									</div>
								<?php  } } ?>
							</div>
						</li>
					<?php  } ?>
					<li class="order-list">
						<div class="inner-con">
							<div class="row no-gutter">
								<div class="col-60 color-muted">订单 <span class="color-black total-price">￥<?php  echo $cart['price'] + $store['pack_price'] + $delivery_price?></span> - 优惠 <span class="color-black activity-price">￥<?php  echo $activityed['total'];?></span></div>
								<div class="col-20 text-right color-muted">总计</div>
								<div class="col-20 text-right color-black"><span class="wait-price">￥<?php  echo $waitprice;?></span></div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</form>
	</div>
</div>
<div class="modal modal-no-buttons delivery-time-modal not-remove">
	<div class="modal-inner">
		<div class="modal-title">
			<div>请选择送达时间</div>
		</div>
		<div class="modal-text">
			<div class="category-container">
				<div class="parent-category" id="delivery-time-parent">
					<ul>
						<?php  if(is_array($delivery_time['days'])) { foreach($delivery_time['days'] as $i => $day) { ?>
							<li <?php  if(!$i) { ?>class="active"<?php  } ?> data-value="<?php  echo $day;?>"><a href="javascript:;"><?php  echo $day;?></a></li>
						<?php  } } ?>
					</ul>
				</div>
				<div class="children-category" id="delivery-time-children">
					<div class="children-category-wrapper">
						<ul id="category1">
							<?php  if($time_flag == 1) { ?>
								<li data-value="尽快送达" class="time-flag"><a href="javascript:;">尽快送达</a></li>
							<?php  } ?>
							<?php  if(is_array($delivery_time['times'])) { foreach($delivery_time['times'] as $i => $time) { ?>
								<li data-value="<?php  echo $time['start'];?> ~ <?php  echo $time['end'];?>" class="<?php  if($time['timestamp'] <= TIMESTAMP && !$delivery_time['reserve']) { ?>hide init-hide<?php  } ?>">
									<a href="javascript:;"><?php  echo $time['start'];?> ~ <?php  echo $time['end'];?></a>
								</li>
							<?php  } } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="popup popup-remark" id="popup-remark">
	<div class="content-block">
		<div class="popup-header row no-gutter">
			<div class="col-25"><a href=""><span class="fa fa-arrow-left"></span></a></div>
			<div class="col-50 text-center">填写备注</div>
			<div class="col-25 text-right"><a href="javascript:;" class="sure close-popup" id="note-submit">确定</a></div>
		</div>
		<div class="popup-body">
			<textarea name="" id="note-textarea" placeholder="给商家留言,可输入对商家的要求"></textarea>
			<?php  if(!empty($store['order_note'])) { ?>
				<div class="specs-select">
					<?php  if(is_array($store['order_note'])) { foreach($store['order_note'] as $order_note) { ?>
						<span class="spec-item"><?php  echo $order_note;?></span>
					<?php  } } ?>
				</div>
			<?php  } ?>
		</div>
	</div>
</div>
<div class="popup popup-coupon" id="popup-coupon">
	<div class="page coupon coupon-select">
		<header class="bar bar-nav common-bar-nav">
			<h1 class="title">选择代金券</h1>
		</header>
		<div class="content">
			<div class="content-padded">
				<a href="<?php  echo $this->createMobileUrl('submit', array('sid' => $sid, 'op' => 'index', 'address_id' => $_GPC['address_id']));?>" class="button button-light button-big">不使用代金券</a>
			</div>
			<div class="coupon-list content-padded">
				<?php  if(is_array($coupons)) { foreach($coupons as $coupon) { ?>
				<div class="coupon-list-item" data-recordid="<?php  echo $coupon['id'];?>">
					<div class="coupon-panel">
						<label class="label-checkbox item-content">
							<input type="radio" name="recordid" value="<?php  echo $coupon['id'];?>" class="coupon-radio">
							<div class="item-media">
								<i class="icon icon-form-checkbox"></i>
							</div>
							<div class="item-inner">
								<div class="row no-gutter">
									<div class="col-40 text-center">
										<div class="price"><span>￥</span><?php  echo $coupon['discount'];?></div>
										<div class="condition">满<?php  echo $coupon['condition'];?>元可用</div>
									</div>
									<div class="col-60">
										<div class="store-title"><?php  echo $coupon['title'];?></div>
										<div class="date">有效期至<?php  echo date('Y-m-d', $coupon['endtime'])?></div>
									</div>
								</div>
							</div>
						</label>
						<span class="scan-rules">代金券使用规则<span class="fa fa-arrow-down"></span></span>
					</div>
					<ol class="coupon-rules hide">
						<li>
							<?php  if($coupon['use_limit'] == 1) { ?>
							可与其他优惠同享
							<?php  } else { ?>
							不与其他优惠同享
							<?php  } ?>
						</li>
						<li>仅在线支付可用</li>
					</ol>
				</div>
				<?php  } } ?>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$(document).on('click', '.scan-rules', function(){
		var $parent = $(this).parents('.coupon-list-item');
		$parent.find('.coupon-rules').toggleClass('hide');
	});

	$(document).on('click', '#popup-coupon .coupon-radio', function(e){
		var recordid = $(this).parents('.coupon-list-item').data('recordid');
		$.closeModal('.popup-coupon');
		$.showIndicator();
		setTimeout(function(){
			location.href = "<?php  echo $this->createMobileUrl('submit', array('sid' => $sid, 'op' => 'index', 'address_id' => $_GPC['address_id']));?>&recordid=" + recordid;
		}, 100);
		return;
	});

	$(document).on('click', '#order-submit', function(){
		var $this = $(this);
		if($(this).hasClass('bg-grey')) {
			return false;
		}
		$(this).removeClass('bg-danger').addClass('bg-grey');
		var order_type = $(':radio[name="order_type"]:checked').val();
		var username = '';
		var mobile = '';
		if(order_type == 1) {
			if(!$('#address_id').val()) {
				$(this).addClass('bg-danger').removeClass('bg-grey');
				$.toast('请选择收货地址');
				return false;
			}
		} else if(order_type == 2) {
			var username = $.trim($(':text[name="username"]').val());
			if(!username) {
				$(this).addClass('bg-danger').removeClass('bg-grey');
				$.toast('请填写下单人');
				return false;
			}
			var mobile = $.trim($(':text[name="mobile"]').val());
			var reg = /^1[34578][0-9]{9}$/;
			if(!reg.test(mobile)) {
				$(this).addClass('bg-danger').removeClass('bg-grey');
				$.toast("手机号格式错误");
				return false;
			}
		}

		if(!$('.pay_type:checked').val()) {
			$(this).addClass('bg-danger').removeClass('bg-grey');
			$.toast('请选择支付方式');
			return false;
		}
		var params = {
			delivery_day: $('#delivery-day').val(),
			delivery_time: $('#delivery-time').val(),
			address_id: $('#address_id').val(),
			record_id: $('#record_id').val(),
			note: $('#order-note').val(),
			pay_type: $('.pay_type:checked').val(),
			invoice: $('#invoice').val(),
			order_type: order_type,
			username: username,
			mobile: mobile
		};
		$.post("<?php  echo $this->createMobileUrl('submit', array('sid' => $sid, 'op' => 'submit'));?>", params, function(data){
			var result = $.parseJSON(data);
			if(result.message.errno != 0) {
				$(this).addClass('bg-danger').removeClass('bg-grey');
				$.toast(result.message.message);
			} else {
				$.toast('下单成功');
				location.href = "<?php  echo $this->createMobileUrl('pay', array('sid' => $sid, 'order_type' => 'order'));?>&id=" + result.message.message;
			}
			return false;
		});
	});

	var delivery_price = "<?php  echo $delivery_price;?>";
	var waitprice = "<?php  echo $waitprice;?>";
	var cartprice = "<?php  echo $cart['price'];?>";
	var totalprice = <?php  echo $cart['price'] + $store['pack_price'] + $delivery_price?>;
	var delivery_activity_price = "<?php  echo $delivery_activity_price;?>";
	var activity_price = "<?php  echo $activity_price;?>";

	//配送方式
	$(document).on('click', '#order-type-1', function(){
		$('#address-container').show();
		$('#delivery-time-2').hide();
		$('#delivery-time-1').show();
		$('#delivery-price').html(delivery_price);
		$('.total-price').html('￥' + totalprice);
		$('.activity-price').html('￥' + activity_price);
		waitprice_temp = totalprice - activity_price;
		$('.wait-price').html('￥' + waitprice_temp);
		$('.activity-delivery').show();
		$('.info-bar').show();
	});

	$(document).on('click', '#order-type-2', function(){
		$('#address-container').hide();
		$('#delivery-time-2').show();
		$('#delivery-time-1').hide();
		$('#delivery-price').html(0);
		$('.activity-delivery').hide();
		$('.info-bar').hide();
		var totalprice_temp = totalprice - 0 - delivery_price;
		$('.total-price').html('￥' + totalprice_temp);
		activityprice_temp = activity_price - delivery_activity_price;
		$('.activity-price').html('￥' + activityprice_temp);
		waitprice_temp = totalprice_temp - activityprice_temp;
		$('.wait-price').html('￥' + waitprice_temp);
	});

	//选择时间
	$(document).on('click', '.delivery-time-show', function(){
		$.iopenModal('.delivery-time-modal', function(){
			var init_show = $('#delivery-time-children li').not('.hide').size();
			if(!init_show) {
				var now_day = $('#delivery-time-parent li.active');
				now_day.next().trigger('click');
				now_day.addClass('hide');
			}
			$('.delivery-time-modal .children-category-wrapper').height(350);
			if($.device.iphone) {
				new IScroll('.delivery-time-modal .children-category-wrapper', {probeType: 3, mouseWheel: true, click: false, tap: true})
			} else {
				new IScroll('.delivery-time-modal .children-category-wrapper', {probeType: 3, mouseWheel: true, click: true})
			}
		});
	});

	$(document).on('click', '#delivery-time-children li', function(){
		var day = $('#delivery-time-parent li.active').data('value');
		var time = $(this).data('value');
		$('#delivery-time').val(time);
		$('#delivery-day').val(day);
		$('.delivery-time-show').html(day + ' ' + time);
		$.icloseModal('.delivery-time-modal', true);
		return false;
	});
	var today_date = "<?php  echo date('m-d')?>";
	var time_flag = "<?php  echo $time_flag;?>";
	$(document).on('click', '#delivery-time-parent li', function(){
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		var date = $(this).data('value');
		if(today_date == date) {
			if(time_flag == 1) {
				$('#delivery-time-children li.time-flag').removeClass('hide');
			}
			$('#delivery-time-children li.init-hide').addClass('hide');
		} else {
			$('#delivery-time-children li.time-flag').addClass('hide');
			$('#delivery-time-children li.init-hide').removeClass('hide');
		}
		return false;
	});

	//备注
	$(document).on('click', '#order-note-show', function(){
		$.popup('.popup-remark');
	});

	$(document).on('click', '#popup-remark .spec-item', function(){
		var note = $('#note-textarea').val();
		$('#note-textarea').val(note + ' ' + $(this).html());
	});

	$(document).on('click', '#note-submit', function(){
		var note = $('#note-textarea').val();
		if(note == '') {
			note = '(选填)可填入特殊要求';
		}
		$('#order-note-show').html(note);
		$('#order-note').val(note);
	});

	//发票
	$(document).on('click', '.invoice-status', function(){
		console.info(($(this).find('input').prop('checked')));
		if($(this).find('input').prop('checked')) {
			$('.invoice-value').removeClass('hide');
		} else {
			$('.invoice-value').addClass('hide');
		}
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>