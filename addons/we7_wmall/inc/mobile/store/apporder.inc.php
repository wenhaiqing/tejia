<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'order';
mload()->model('store');
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';
$uid = intval($_GPC['uid']);
if($op == 'list') {
	$skip = $_GPC['skip'];
	$limit = $_GPC['limit']; 
	$status = $_GPC['status'];
	if ($status ==1) {
		$status = 'and (a.status = 1 or a.status =6)';
	}
	if ($status ==2) {
		$status = 'and (a.status =2 or a.status = 3 or a.status = 4)';
	}
	if ($status ==5) {
		$status = 'and a.status = 5';
	}
	if ($status == 7) {
		$status = 'and a.is_refund = 1';
	}
	$title = "{$_W['we7_wmall']['config']['title']}-订单列表";
	$orders = pdo_fetchall('select a.id as aid, a.*, b.title, b.logo, b.delivery_mode, b.pay_time_limit from ' . tablename('tiny_wmall_order') . ' as a left join ' . tablename('tiny_wmall_store') . ' as b on a.sid = b.id where a.uniacid = :uniacid and a.uid = :uid '.$status.' order by a.id desc limit '.$skip.','.$limit, array(':uniacid' => $_W['uniacid'], ':uid' => $uid));
	$min = 0;
	if(!empty($orders)) {
		$order_status = order_status();
		foreach($orders as &$da) {
			$da['goods'] = pdo_get('tiny_wmall_order_stat', array('oid' => $da['id']));
			$da['logo'] = 'http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$da['logo'];
			$da['status_cn'] = $order_status[$da['status']]['text'];
			$da['addtime'] = date('Y-m-d H:i', $da['addtime']);
		}
		$min = min(array_keys($orders));
	}
	returnjson('订单列表',$orders);
}
if ($op == 'recommend') {
	$status = $_GPC['status'];
	$uid = $_GPC['uid'];
	$first_uids = array();
	$w_config = pdo_get('tiny_wmall_config',array('uniacid'=>$_W['uniacid']));
	$first = pdo_getall('tiny_wmall_extension',array('uid'=>$uid));
	if (!$first) {
		returnjson('无数据');
	}
	for ($i=0; $i < count($first); $i++) { 
			$first_uid = pdo_get('mc_members',array('mobile'=>$first[$i]['mobile']),array('uid'));
			if ($first_uid) {
				$first_uids[] = $first_uid['uid'];
			}
		};
		if (!$first_uids) {
			returnjson('无数据');
		}	
	if ($status == 0) {
					
		$first_uids1 = implode(',',$first_uids);
		$first_order = pdo_fetchall("select username,final_fee from " . tablename('tiny_wmall_order') . " where uniacid = :uniacid and status = 5 and uid in ({$first_uids1}) order by id desc", array(':uniacid' => $_W['uniacid']));
		if ($first_order) {
			for ($l=0; $l <count($first_order) ; $l++) { 
				$first_order[$l]['final_fee'] = $first_order[$l]['final_fee']*($w_config['w_first']/100);
			}
		}

		returnjson('第一级推荐',$first_order,'1');
	}else{
		$second_uids = array();
		$third_uids = array();
		for ($j=0; $j <count($first_uids) ; $j++) { 
			$second_uid = pdo_getall('tiny_wmall_extension',array('uid'=>$first_uids[$j]));
			if ($second_uid) {
				for ($g=0; $g < count($second_uid); $g++) { 
					$second_uids[] = $second_uid[$g]['mobile'];
				}
				
			}
		}
		if (!$second_uids) {
			returnjson('无数据');
		}
		for ($k=0; $k < count($second_uids); $k++) { 
			$third_uid = pdo_get('mc_members',array('mobile'=>$second_uids[$k]),array('uid'));
			if ($third_uid) {
				$third_uids[] = $third_uid['uid'];
			}
		};
		if (!$third_uids) {
			returnjson('无数据');
		}
		$third_uids1 = implode(',', $third_uids);
		$third_order = pdo_fetchall("select username,final_fee from " . tablename('tiny_wmall_order') . " where uniacid = :uniacid and status = 5 and uid in ({$third_uids1}) order by id desc", array(':uniacid' => $_W['uniacid']));
		if ($third_order) {
			for ($h=0; $h <count($third_order) ; $h++) { 
				$third_order[$h]['final_fee'] = $third_order[$h]['final_fee']*($w_config['w_second']/100);
			}
		}
		returnjson('第二级推荐',$third_order,'2');
	}
}

if ($op == 'extensionperson') {
	$uid = $_GPC['uid'];
	$first_uids = array();
	$first = pdo_getall('tiny_wmall_extension',array('uid'=>$uid));
	if (!$first) {
		returnjson('无数据');
	}
	for ($i=0; $i < count($first); $i++) { 
			$first_uid = pdo_get('mc_members',array('mobile'=>$first[$i]['mobile']),array('uid'));
			if ($first_uid) {
				$first_uids[] = $first_uid['uid'];
			}
		};
		if (!$first_uids) {
			returnjson('无数据');
		}
		$r_data['first'] = count($first_uids);	
		$second_uids = array();
		$third_uids = array();
		for ($j=0; $j <count($first_uids) ; $j++) { 
			$second_uid = pdo_getall('tiny_wmall_extension',array('uid'=>$first_uids[$j]));
			if ($second_uid) {
				for ($g=0; $g < count($second_uid); $g++) { 
					$second_uids[] = $second_uid[$g]['mobile'];
				}
				
			}
		}
		if (!$second_uids) {
			returnjson('获取数据成功',$r_data,'1');
		}
		$r_data['second'] = count($second_uids);
		
		returnjson('获取数据成功',$r_data,'1');
}

if($op == 'more') {
	$id = intval($_GPC['id']);
	$orders = pdo_fetchall('select a.id as aid, a.*, b.title, b.logo, b,delivery_mode, b.pay_time_limit from ' . tablename('tiny_wmall_order') . ' as a left join ' . tablename('tiny_wmall_store') . ' as b on a.sid = b.id where a.uniacid = :uniacid and a.uid = :uid and a.id < :id order by a.id desc limit 15', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'], ':id' => $id), 'aid');
	$min = 0;
	if(!empty($orders)) {
		$order_status = order_status();
		foreach($orders as &$order) {
			$order['goods'] = pdo_get('tiny_wmall_order_stat', array('oid' => $order['aid']), array('goods_title'));
			$order['addtime_cn'] = date('Y-m-d H:i:s', $order['addtime']);
			$order['time_cn'] = date('H:i', $order['addtime']);
			$order['status_cn'] = $order_status[$order['status']]['text'];
			$order['logo_cn'] = tomedia($order['logo']);
		}
		$min = min(array_keys($orders));
	}
	$orders = array_values($orders);
	$respon = array('error' => 0, 'message' => $orders, 'min' => $min);
	message($respon, '', 'ajax');
}

if($op == 'cancle') {
	$id = intval($_GPC['id']);
	$order = order_fetch($id);
	if(empty($order)) {
		returnjson('订单不存在或已删除', '', '2');
	}
	if($order['status'] != 1) {
		returnjson('商户已接单,如需取消订单请联系商户处理', '', '2');
	}
	if(!$order['is_pay']) {
		pdo_update('tiny_wmall_order', array('status' => '6'), array('uniacid' => $_W['uniacid'], 'id' => $id));
		order_insert_status_log($id, $order['sid'], 'cancel', '您取消了订单');
	} else {
		returnjson('该订单已支付,如需取消订单请联系商户处理', '', '2');
	}
	returnjson('订单取消成功', '', '1');
}

if ($op == 'help') {
	$help = pdo_get('tiny_wmall_help',array('title'=>'会员帮助','uniacid'=>$_W['uniacid']));
	returnjson('获取数据成功',$help,1);
}
if ($op == 'bai') {
	$help = pdo_get('tiny_wmall_help',array('title'=>'百家厨','uniacid'=>$_W['uniacid']));
	returnjson('获取数据成功',$help,1);
}

if ($op == 'about') {
	$help = pdo_get('tiny_wmall_help',array('title'=>'关于我们','uniacid'=>$_W['uniacid']));
	returnjson('获取数据成功',$help,1);
}
if ($op == 'notice') {
	$help1 = pdo_get('tiny_wmall_help',array('title'=>'APP首页广播通知1','uniacid'=>$_W['uniacid']));
	$help2 = pdo_get('tiny_wmall_help',array('title'=>'APP首页广播通知2','uniacid'=>$_W['uniacid']));
	$helps[] = $help1;
	$helps[] = $help2;
	returnjson('获取数据成功',$helps,1);
}

if($op == 'end') {
	$id = intval($_GPC['id']);
	$order = order_fetch($id);
	if(empty($order)) {
		returnjson('订单不存在或已删除');
	}
	pdo_update('tiny_wmall_order', array('status' => 5, 'delivery_status' => 5, 'deliveryedtime' => TIMESTAMP), array('uniacid' => $_W['uniacid'], 'id' => $id));
	order_update_current_log($id, 5);
	order_insert_status_log($id, $order['sid'], 'end');
	order_status_notice($order['sid'], $order['id'], 'end');
	order_update_extension_logs($id,$order['uid'],$order['final_fee']);
	returnjson('订单更新成功', '', '1');
}

if($op == 'detail') {
	$title = "{$_W['we7_wmall']['config']['title']}-订单详情";
	$id = intval($_GPC['id']);
	$order = order_fetch($id);
	if(empty($order)) {
		returnjson('订单不存在或已删除');
	}
	$store = store_fetch($order['sid'], array('title', 'telephone', 'pack_price', 'logo', 'delivery_price', 'address', 'location_x', 'location_y'));
	$goods = order_fetch_goods($order['id']);
	$log = pdo_fetch('select * from ' . tablename('tiny_wmall_order_status_log') . ' where uniacid = :uniacid and oid = :oid order by id desc', array(':uniacid' => $_W['uniacid'], ':oid' => $id));
	$log['addtime'] = date('Y-m-d h:i',$log['addtime']);
	if($order['discount_fee'] > 0) {
		$activityed = order_fetch_discount($id);
	}
	$logs = order_fetch_status_log_app($id);
	if(!empty($logs)) {
		$maxid = max(array_keys($logs));
	}
	foreach ($logs as &$value) {
		$value['addtime'] = date('Y-m-d h:i',$value['addtime']);
	}
	if($order['is_refund']) {
		$refund = order_current_fetch($id);
		$refund_logs = order_fetch_refund_status_log($id);
		if(!empty($refund_logs)) {
			$refundmaxid = max(array_keys($refund_logs));
		}
	}

	$order_types = order_types();
	$pay_types = order_pay_types();
	$order_status = order_status();
	$orderdetail = array();
	$orderdetail['order'] = $order;
	$orderdetail['store'] = $store;
	$orderdetail['goods'] = $goods;
	$orderdetail['log'] = $log;
	$orderdetail['logs'] = $logs;
	returnjson('获取成功',$orderdetail);
}

if($op == 'del') {
	$id = intval($_GPC['id']);
	$sid = intval($_GPC['sid']);
	$order = order_fetch($id);
	if(empty($order)) {
		returnjson('订单不存在或已删除', '', 'error');
	}
	if($order['status'] != 6) {
		returnjson('该订单正在进行中或已完成,不能删除', '', 'error');
	}
	pdo_delete('tiny_wmall_order', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'id' => $id));
	pdo_delete('tiny_wmall_order_stat', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'oid' => $id));
	pdo_delete('tiny_wmall_order_comment', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'oid' => $id));
	pdo_delete('tiny_wmall_order_status_log', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'oid' => $id));
	pdo_delete('tiny_wmall_order_refund_log', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'oid' => $id));
	returnjson('删除订单成功', '', 'success');
}

if($op == 'remind') {
	$id = intval($_GPC['id']);
	$order = order_fetch($id);
	if(empty($order)) {
		message(error(-1, '订单不存在或已删除'), '', 'ajax');
	}
	$log = pdo_fetch('select * from ' . tablename('tiny_wmall_order_status_log') . ' where uniacid = :uniacid and oid = :oid and status = 8 order by id desc',  array(':uniacid' => $_W['uniacid'], ':oid' => $id));
	$store = store_fetch($order['sid'], array('remind_time_limit'));
	$remind_time_limit = intval($store['remind_time_limit']) ? intval($store['remind_time_limit']) : 10;
	if($log['addtime'] >= (time() - $remind_time_limit * 60)) {
		message(error(-1, "距离上次催单不超过{$remind_time_limit}分钟,不能催单"), '', 'ajax');
	}
	order_insert_status_log($id, $order['sid'], 'remind');
	order_clerk_notice($order['sid'], $id, 'remind');
	pdo_update('tiny_wmall_order', array('is_remind' => '1'), array('uniacid' => $_W['uniacid'], 'id' => $id));
	message(error(0, ''), '', 'ajax');
}

if($op == 'comment') {
	mload()->func('tpl.app');
	$title = '商品评价';
	$id = intval($_GPC['id']);
	$order = order_fetch($id);
	if(!$_W['ispost']) {
		if(empty($order)) {
			returnjson('订单不存在或已删除', '', 'error');
		}
		$goods = order_fetch_goods($order['id']);
	} else {
		if(empty($order)) {
			returnjson('订单不存在或已删除', '', 'error');
		}
		if($order['is_comment'] == 1) {
			returnjson('订单已评价', '', 'error');
		}

		$store = store_fetch($order['sid'], array('comment_status'));
		$insert = array(
			'uniacid' => $_W['uniacid'],
			'uid' => $_W['member']['uid'],
			'username' => $order['username'],
			'avatar' => $_W['fans']['avatar'],
			'mobile' => $order['mobile'],
			'oid' => $id,
			'sid' => $order['sid'],
			'goods_quality' => intval($_GPC['goods_quality']) ? intval($_GPC['goods_quality']) : 5,
			'delivery_service' => intval($_GPC['delivery_service']) ? intval($_GPC['delivery_service']) : 5,
			'note' => trim($_GPC['note']),
			'status' => $store['comment_status'],
			'data' => '',
			'addtime' => TIMESTAMP,
		);
		// if(!empty($_GPC['thumbs'])) {
		// 	$thumbs = array();
		// 	var_dump($thumbs);
		// 	foreach($_GPC['thumbs'] as $thumb) {
		// 		if(empty($thumb)) continue;
		// 		$thumbs[] = $thumb;
		// 	}
		// 	$insert['thumbs'] = iserializer($thumbs);
		// }
		$thumbs = array();
		$res = pdo_getall('tiny_wmall_order_comment_picture',array('orderid'=>$id),array('path'));
		if ($res) {
			for ($i=0; $i <count($res) ; $i++) { 
				$thumbs[] = $res[$i]['path'];
			}
		}
		$insert['thumbs'] = iserializer($thumbs);
		$goods = order_fetch_goods($order['id']);
		foreach($goods as $good) {
			$value = intval($_GPC['goods'][$good['id']]);
			if(!$value) {
				continue;
			}
			$update = ' set comment_total = comment_total + 1';
			if($value == 1) {
				$update .= ' , comment_good = comment_good + 1';
				$insert['data']['good'][] = $good['goods_title'];
			} else {
				$insert['data']['bad'][] = $good['goods_title'];
			}
			pdo_query('update ' . tablename('tiny_wmall_goods') . $update . ' where id = :id', array(':id' => $good['goods_id']));
		}
		$insert['score'] = $insert['goods_quality'] + $insert['delivery_service'];
		$insert['data'] = iserializer($insert['data']);
		pdo_insert('tiny_wmall_order_comment', $insert);
		pdo_update('tiny_wmall_order', array('is_comment' => 1), array('id' => $id));
		if($store['comment_status'] == 1) {
			store_comment_stat($order['sid']);
		}
		returnjson('评论成功', $insert, '1');
	}
	include $this->template('order-detail');
}

