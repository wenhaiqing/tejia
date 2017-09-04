<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'goods';
mload()->model('store');
mload()->model('order');
mload()->model('member');
$title = '提交订单';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'goods';
$sid = intval($_GPC['sid']);
$store = store_fetch($sid, array('title', 'payment', 'invoice_status', 'delivery_type', 'delivery_mode', 'delivery_price', 'delivery_time', 'delivery_free_price', 'pack_price', 'delivery_within_days', 'delivery_reserve_days', 'order_note'));
if(empty($store)) {
	returnjson('门店不存在', '', 'error');
}

if($op == 'goods') {
	$goodsid = explode(',', $_GPC['goodsid']);
	$goodsnum = explode(',',$_GPC['goodsnum']);
	$hotel = explode(',', $_GPC['hotel']);
	$uid = intval($_GPC['uid']);
	$goodscount = count($goodsid);
	$goods = array();
	for ($i=0; $i < $goodscount; $i++) { 
		$goods[$goodsid[$i]]['options'][0] = $goodsnum[$i];
		$goods[$goodsid[$i]]['options'][1] = $hotel[$i]; 
	}
	$cart = order_insert_member_cart_app($sid,$goods,$uid);
	if(is_error($cart)) {
		returnjson('数据错误');
		// header('location:' . $this->createMobileUrl('goods', array('sid' => $sid)));
		// die;
	}
	returnjson('成功',$cart,'1');
	// header('location:' . $this->createMobileUrl('submit', array('sid' => $sid, 'op' => 'index')));
	// die;
}
if($op == 'goods1') {
	$goodsdata['uid'] = $_W['member']['uid'];
	$goodsdata['data'] = serialize($_GPC['goods']);
	$goodsdata['addtime'] = time();
	$goodsdata['sid'] = $_GPC['sid'];
	$zhan = pdo_fetch("SELECT name FROM " . tablename('mc_members') . ' WHERE uniacid = :uniacid AND uid= :uid', array(':uniacid' => $_W['uniacid'],':uid'=>$_W['member']['uid']));
	$goodsdata['uidname'] = $zhan['name'];
	$goodsdata['uniacid'] = $_W['uniacid'];
	$cart = pdo_insert('tiny_wmall_zhan',$goodsdata);
	if(is_error($cart)) {
		message('数据错误','','error');
		// header('location:' . $this->createMobileUrl('goods', array('sid' => $sid)));
		// die;
	}
	message('成功',referer(),'success');
	// header('location:' . $this->createMobileUrl('submit', array('sid' => $sid, 'op' => 'index')));
	// die;
}

if($op == 'index') {
	$uid = $_GPC['uid'];
	$address = member_fetch_available_address_app($sid,$uid);
	$address_id = $address['id'];
	$cart = order_fetch_member_cart_app($sid,$uid);
	if(empty($cart)) {
		returnjson('没选商品');
		// header('location:' . $this->createMobileUrl('goods', array('sid' => $sid)));
		// die;
	}
	$pay_types = order_pay_types();
	//支付方式
	if(empty($store['payment'])) {
		rerurnjson('店铺没有设置有效的支付方式', referer(), 'error');
	}
	//商家配送方式
	$account = store_account($sid);
	$delivery_time = store_delivery_times($sid);
	$time_flag = 0;
	if(!$delivery_time['reserve']) {
		$data = array_order(TIMESTAMP + 60 * $store['delivery_time'], $delivery_time['timestamp']);
		if(!empty($data)) {
			$time_flag = 1;
			$index = array_search($data, $delivery_time['timestamp']);
			$predict_day = $delivery_time['days'][0];
			$predict_time = "{$delivery_time['times'][$index]['start']}~{$delivery_time['times'][$index]['end']}";
			$text_time = "尽快送达";
		} else {
			$predict_day = $delivery_time['days'][1];
			$predict_time = "{$delivery_time['times'][0]['start']}~{$delivery_time['times'][0]['end']}";
			$text_time = "{$predict_day} {$predict_time}";
		}
	} else {
		$predict_day = $delivery_time['days'][0];
		$predict_time = $delivery_time['times'][0];
		$text_time = "{$predict_day} {$predict_time}";
	}

	//代金券
	$coupon_text = '无可用代金券';
	$coupons = order_coupon_available_app($sid, $cart['price'],$uid);
	if(!empty($coupons)) {
		$coupon_text = count($coupons) . '张可用代金券';
	}
	$recordid = intval($_GPC['recordid']);
	$activityed = order_count_activity_app($sid, $cart, $recordid,$uid);
	if(!empty($activityed['list']['token'])) {
		$coupon_text = "{$activityed['list']['token']['value']}元券";
		$conpon = $activityed['list']['token']['coupon'];
	}
	$delivery_activity_price = 0;
	$activity_price = $activityed['total'];
	if(!empty($activityed) && !empty($activityed['list']['delivery'])) {
		$delivery_activity_price = $activityed['list']['delivery']['value'];
	}

	//配送费
	$delivery_price = $store['delivery_price'];
	if(($store['delivery_mode'] == 1 && $store['delivery_free_price'] > 0 && $cart['price'] >= $store['delivery_free_price']) || $store['delivery_type'] == 2) {
		$delivery_price = 0;
	}
	$waitprice = $cart['price'] + $delivery_price + $store['pack_price'] - $activityed['total'];
	$waitprice = ($waitprice > 0) ? $waitprice : 0;
	$credit = mc_credit_fetch($uid);
	$gdata['credit'] = $credit;
	$gdata['waitprice'] = $waitprice;
	$gdata['activityed'] = $activityed;
	$gdata['cart'] = $cart;
	$gdata['address'] = $address;
	$gdata['coupons'] = $coupons;
	$gdata['coupon_text'] = $coupon_text;
	$gdata['delivery_price'] = $delivery_price;
	returnjson('成功',$gdata);
}

if($op == 'submit') {
	$uid = intval($_GPC['uid']);
	$cart = order_fetch_member_cart_app($sid,$uid);
	if(empty($cart)) {
		returnjson('所选商品有误',$cart);
		// header('location:' . $this->createMobileUrl('goods', array('sid' => $sid)));
		// die;
	}
	$ids_str = implode(',', array_keys($cart['data']));
	$goods_info = pdo_fetchall('SELECT id,cid,title,price,total,print_label FROM ' . tablename('tiny_wmall_goods') . " WHERE uniacid = :aid AND sid = :sid AND id IN ({$ids_str})", array(':aid' => $_W['uniacid'], ':sid' => $sid), 'id');
	foreach ($cart['data'] as $k => $v) {
		foreach ($v as $k1 => $v1) {
			pdo_query('UPDATE ' . tablename('tiny_wmall_goods') . " set sailed = sailed + {$v1['num']} WHERE uniacid = :aid AND id = :id", array(':aid' => $_W['uniacid'], ':id' => $k));
			if (!$k1) {
				if ($goods_info[$k]['total'] != -1 && $goods_info[$k]['total'] > 0) {
					pdo_query('UPDATE ' . tablename('tiny_wmall_goods') . " set total = total - {$v1['num']} WHERE uniacid = :aid AND id = :id", array(':aid' => $_W['uniacid'], ':id' => $k));
				}else if($goods_info[$k]['total'] == -1){
					
				}else{
					returnjson($goods_info[$k]['title'].'库存不足，请重新选择商品','');
				}
			} else {
				$option = pdo_get('tiny_wmall_goods_options', array('uniacid' => $_W['uniacid'], 'id' => $k1));
				if (!empty($option) && $option['total'] != -1 && $option['total'] > 0) {
					pdo_query('UPDATE ' . tablename('tiny_wmall_goods') . " set total = total - {$v1['num']} WHERE uniacid = :aid AND id = :id", array(':aid' => $_W['uniacid'], ':id' => $k1));
				}
			}
		}
	}

	if($_GPC['order_type'] == 1) {
		$address = member_fetch_address($_GPC['address_id']);
		if(empty($address)) {
			returnjson('收货地址信息错误', '', 'ajax');
		}
	} elseif($_GPC['order_type'] == 2) {
		$address = array(
			'realname' => trim($_GPC['username']),
			'mobile' => trim($_GPC['mobile'])
		);
	}
	$recordid = intval($_GPC['record_id']);
	$activityed = order_count_activity_app($sid, $cart, $recordid,$uid);

	$order_type = intval($_GPC['order_type']) ? intval($_GPC['order_type']) : 1;
	if($order_type == 2 && !empty($activityed['list']['delivery'])) {
		$activityed['total'] -= $activityed['list']['delivery']['value'];
		$activityed['activity'] = $activityed['total'];
		unset($activityed['list']['delivery']);
	}

	//配送费
	$delivery_price = $store['delivery_price'];
	if(($store['delivery_mode'] == 1 && $store['delivery_free_price'] > 0 && $cart['price'] >= $store['delivery_free_price']) || $store['delivery_type'] == 2 || $order_type == 2) {
		$delivery_price = 0;
	}

	$order = array(
		'uniacid' => $_W['uniacid'],
		'acid' => $_W['acid'],
		'sid' => $sid,
		'uid' => $uid,
		'ordersn' => date('Ymd') . random(6, true),
		'code' => random(4, true),
		'groupid' => $cart['groupid'],
		'order_type' => $order_type,
		'openid' => $uid,
		'mobile' => $address['mobile'],
		'username' => $address['realname'],
		'sex' => $address['sex'],
		'address' => $address['address'] . $address['number'],
		'location_x' => $address['location_x'],
		'location_y' => $address['location_y'],
		'delivery_day' => trim($_GPC['delivery_day']) ? (date('Y') .'-'. trim($_GPC['delivery_day'])) : date('Y-m-d'),
		'delivery_time' => trim($_GPC['delivery_time']) ? trim($_GPC['delivery_time']) : '尽快送出',
		'delivery_fee' => $delivery_price,
		'pack_fee' => $store['pack_price'],
		'pay_type' => trim($_GPC['pay_type']),
		'num' => $cart['num'],
		'price' => $cart['price'],
		'total_fee' => $cart['price'] + $delivery_price + $store['pack_price'],
		'discount_fee' => $activityed['total'],
		'final_fee' => $cart['price'] + $delivery_price + $store['pack_price'] - $activityed['total'],
		'vip_free_delivery_fee' => !empty($activityed['list']['delivery']) ? 1 : 0,
		'status' => 1,
		'is_comment' => 0,
		'invoice' => trim($_GPC['invoice']),
		'addtime' => TIMESTAMP,
		'data' => iserializer($cart['data']),
		'note' => trim($_GPC['note'])
	);
	if($order['final_fee'] < 0) {
		$order['final_fee'] = 0;
	}
	// if ($order['final_fee']<30) {
	// 	returnjson('订单金额不得低于30元','','ajax');
	// }
	pdo_insert('tiny_wmall_order', $order);
	$id = pdo_insertid();
	order_insert_current_log($id, $sid, $order['final_fee'], '', '');
	order_insert_discount($id, $sid, $activityed['list']);
	order_insert_status_log($id, $sid, 'place_order');
	order_update_goods_info_app($id, $sid,'',$uid);
	order_del_member_cart_app($sid,$uid);
	//插入会员下单统计数据
	$_W['member']['realname'] = $address['realname'];
	$_W['member']['mobile'] = $address['mobile'];
	order_stat_member_app($sid,$uid);
	$whq_data['id'] = $id;
	$whq_data['final_fee'] = $order['final_fee'];
	returnjson('下单成功',$whq_data, 'ajax');
}


if($op == 'credit') {
	$uid = intval($_GPC['uid']);
	$final_fee = $_GPC['amount'];
	$credit = mc_credit_fetch($uid);
	if ($credit['credit2']<$final_fee) {
		returnjson('余额不足,请先充值');
	}
	$whq_data['credit2'] = $credit['credit2']-$final_fee;
	$result = pdo_update('mc_members',$whq_data,array('uid'=>$uid));
	$whq_credits = array();
	$whq_credits['uid'] = $uid;
	$whq_credits['uniacid'] = $_W['uniacid'];
	$whq_credits['credittype'] = 'credit2';
	$whq_credits['num'] = $final_fee;
	$whq_credits['createtime'] = time();
	$whq_credits['remark'] = '外卖模块会员余额支付';
	$whq_credits['clerk_type'] = 2;
	pdo_insert('mc_credits_record',$whq_credits);
	if (!empty($result)) {
		returnjson('支付成功','', '1');
	}
	returnjson('支付失败','', '2');
}
if($op == 'whq_credit2') {
	$uid = intval($_GPC['uid']);
	$final_fee = $_GPC['amount'];
	$credit = mc_credit_fetch($uid);
	if ($final_fee>100) {
		$whq_data['credit3'] = $credit['credit3']+$final_fee;
		$whq_data['credit3'] = round($whq_data,2);
	}else{
		$whq_data['credit2'] = $credit['credit2']+$final_fee;
	$whq_data['credit2'] = round($whq_data,2);
	}
	
	$result = pdo_update('mc_members',$whq_data,array('uid'=>$uid));
	$whq_credits = array();
	$whq_credits['uid'] = $uid;
	$whq_credits['uniacid'] = $_W['uniacid'];
	if ($final_fee>100) {
		$whq_credits['credittype'] = 'credit3';
	}else{
		$whq_credits['credittype'] = 'credit2';
	}
	
	$whq_credits['num'] = $final_fee;
	$whq_credits['createtime'] = time();
	$whq_credits['remark'] = '会员充值';
	$whq_credits['clerk_type'] = 2;
	pdo_insert('mc_credits_record',$whq_credits);
	$whq_recharge = array();
	$whq_recharge['uid'] = $uid;
	$whq_recharge['uniacid'] = $uniacid;
	$whq_recharge['type'] = 'credit';
	$whq_recharge['status'] = 1;
	$whq_recharge['createtime'] = time();
	$whq_recharge['backtype'] = 2;
	$whq_recharge['fee'] = $final_fee;
	pdo_insert('mc_credits_recharge',$whq_recharge);
	if (!empty($result)) {
		returnjson('充值成功','', '1');
	}
	returnjson('充值失败','', '2');
}


include $this->template('submit');
