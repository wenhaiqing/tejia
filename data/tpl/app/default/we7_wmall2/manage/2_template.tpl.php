<?php defined('IN_IA') or exit('Access Denied');?><script id="tpl-order" type="text/html">
	<{# for(var i = 0, len = d.length; i < len; i++){ }>
		<li>
			<a class="order-ls-info" href="<?php  echo $this->createMobileUrl('mgorder', array('op' => 'detail'));?>&id=<{d[i].id}>">
				<div class="order-ls-tl">下单人:<{d[i].username}><span class="<{d[i].status_color}>"><{d[i].status_cn}></span></div>
				<div class="order-ls-date"><{d[i].addtime_cn}><span>编号: <{d[i].id}></span></div>
				<div class="order-ls-dl">
					<{# for(var j = 0, lenj = d[i].goods.length; j < lenj; j++){ }>
					<div class="row">
						<div class="col-60"><{d[i].goods[j].goods_title}></div>
						<div class="col-20 align-right">X <{d[i].goods[j].goods_num}></div>
						<div class="col-20 align-right">¥<{d[i].goods[j].goods_price}></div>
					</div>
					<{# } }>
					<div class="row">
						<div class="col-60">配送费¥<{d[i].delivery_fee}> + 包装费¥<{d[i].pack_fee}></div>
						<div class="col-40 align-right">¥<{d[i].total_fee}>元</div>
					</div>
				</div>
				<div class="order-ls-sum">
					共<{d[i].num}>件，合计：¥<{d[i].final_fee}>
					<span class="color-danger">(已优惠¥<{d[i].discount_fee}>)</span>
					<span class="pull-right color-primary order-ls-dist hide" data-lat="<{d[i].location_x}>" data-lng="<{d[i].location_y}>"></span>
				</div>
			</a>
			<div class="order-ls-btn">
				<{# if(d[i].status < 5){ }>
					<{# if(d[i].status == 1){ }>
						<a href="javascript:;" class="order-status" data-id="<{d[i].id}>" data-status="2" data-type="handel"><i class="fa fa-selected"></i> 确认接单</a>
						<a href="javascript:;" class="order-cancel" data-id="<{d[i].id}>" data-status="6" data-pay="<{d[i].is_pay}>" data-pay-type="<{d[i].pay_type}>"><i class="fa fa-selected"></i> 取消订单</a>
					<{# } else if(d[i].status == 2 || d[i].status == 3) { }>
						<a href="javascript:;" class="order-status" data-id="<{d[i].id}>" data-status="3" data-type="delivery_wait"><i class="fa fa-selected"></i> 通知配送员配送</a>
						<{# if(d[i].delivery_type == 1){ }>
						<a href="javascript:;" class="order-delivery" data-id="<{d[i].id}>" data-status="2" data-type="handel"><i class="fa fa-selected"></i> 指定配送员配送</a>
						<{# } }>
						<a href="javascript:;" class="order-status" data-id="<{d[i].id}>" data-status="4" data-type="delivery_ing"><i class="fa fa-selected"></i> 设为配送中</a>
					<{# } else if(d[i].status == 1){ }>
						<a href="javascript:;" class="order-status" data-id="<{d[i].id}>" data-status="5" data-type="end"><i class="fa fa-selected"></i> 订单完成</a>
					<{# } }>
				<{# } }>
			</div>
		</li>
	<{# } }>
</script>