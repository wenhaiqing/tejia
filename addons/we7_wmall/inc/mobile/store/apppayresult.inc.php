<?php 
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$type = $_GPC['paytype'];
$params['module'] = 'we7_wmall';
$orderid = $_GPC['id'];
$whq_order = pdo_get('tiny_wmall_order',array('id'=>$orderid));
$params['tid'] = $whq_order['ordersn'];
if(!empty($type)) {
	if($_GPC['plid']){
		$log = pdo_get('core_paylog',array('plid'=>intval($_GPC['plid'])));
	}else{
		$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
		$pars  = array();
		$pars[':uniacid'] = $_W['uniacid'];
		$pars[':module'] = $params['module'];
		$pars[':tid'] = $params['tid']; 
		$log = pdo_fetch($sql, $pars); 
	}
	if(!empty($log) && $log['status'] != '0') {
		returnjson('这个订单已经支付成功, 不需要重复支付.');
	}
	$update_card_log = array(
		'is_usecard' => '0',
		'card_type' => '0',
		'card_id' => '0',
		'card_fee' => $log['fee'],
		'type' => $type,
		'status' => 1
	);
	pdo_update('core_paylog', $update_card_log, array('plid' => $log['plid']));
	$log['is_usecard'] = '0';
	$log['card_type'] = '0';
	$log['card_id'] = '0';
	$log['card_fee'] = $log['fee'];
	
	$moduleid = pdo_fetchcolumn("SELECT mid FROM ".tablename('modules')." WHERE name = :name", array(':name' => $params['module']));
	$moduleid = empty($moduleid) ? '000000' : sprintf("%06d", $moduleid);
	
	$record = array();
	$record['type'] = $type;
	if (empty($log['uniontid'])) {
		$record['uniontid'] = $log['uniontid'] = date('YmdHis').$moduleid.random(8,1);
	}
	$params['type'] = $type;
	$params['uniontid'] = $record['uniontid'];
	$params['uniacid'] = $_W['uniacid'];
	payresult($params);

}

function payresult($params){
	
	mload()->model('order');
	$record = pdo_get('tiny_wmall_paylog', array('uniacid' => $params['uniacid'], 'order_sn' => $params['tid']));
	if (!empty($record)) {
		pdo_update('tiny_wmall_paylog', array('status' => 1, 'paytime' => TIMESTAMP), array('id' => $record['id']));
	}
	$data = array('pay_type' => $params['type'], 'is_pay' => 1, 'paytime' => TIMESTAMP);
	if ($record['order_type'] == 'order') {
		$order = pdo_fetch('SELECT id, sid, order_type, table_id, status, is_pay FROM ' . tablename('tiny_wmall_order') . ' WHERE uniacid = :aid AND id = :id', array(':aid' => $params['uniacid'], ':id' => $record['order_id']));
		if (!$order['is_pay']) {
			$store = pdo_get('tiny_wmall_store', array('uniacid' => $params['uniacid'], 'id' => $order['sid']));
			order_update_current_pay_type($order['id'], $params['type'], $params['uniontid']);
			if ($order['order_type'] <= 2) {
				if ($store['auto_handel_order'] == 1) {
					$data['status'] = 2;
					if ($order['order_type'] == 2) {
						$data['status'] = 4;
					}
					pdo_update('tiny_wmall_order', $data, array('id' => $record['order_id'], 'uniacid' => $params['uniacid']));
					order_insert_status_log($order['id'], $order['sid'], 'pay');
					order_insert_status_log($order['id'], $order['sid'], 'handel');
					order_print($order['id']);
					order_status_notice($order['sid'], $order['id'], 'handel');
					order_clerk_notice($order['sid'], $order['id'], 'place_order');
					if ($store['auto_notice_deliveryer'] == 1) {
						if ($order['order_type'] == 1) {
							$account = store_account($order['sid']);
							pdo_update('tiny_wmall_order', array('delivery_type' => $account['delivery_type'], 'status' => 3, 'delivery_status' => 3), array('uniacid' => $params['uniacid'], 'id' => $order['id']));
							pdo_update('tiny_wmall_order_current_log', array('delivery_type' => $account['delivery_type']), array('uniacid' => $params['uniacid'], 'orderid' => $order['id']));
							order_insert_status_log($order['id'], $order['sid'], 'delivery_wait');
							order_deliveryer_notice($order['sid'], $order['id'], 'delivery_wait');
						}
					}
				} else {
					pdo_update('tiny_wmall_order', $data, array('id' => $order['id'], 'uniacid' => $params['uniacid']));
					order_insert_status_log($order['id'], $order['sid'], 'pay');
					order_print($order['id']);
					order_status_notice($order['sid'], $order['id'], 'pay');
					order_clerk_notice($order['sid'], $order['id'], 'place_order');
				}
			} else {
				if ($order['order_type'] == 3) {
					mload()->model('table');
					$data['status'] = 2;
					pdo_update('tiny_wmall_order', $data, array('id' => $order['id'], 'uniacid' => $params['uniacid']));
					table_order_update($order['table_id'], $order['id'], 4);
					order_insert_status_log($order['id'], $order['sid'], 'pay');
					order_print($order['id']);
					order_status_notice($order['sid'], $order['id'], 'pay');
					order_clerk_notice($order['sid'], $order['id'], 'store_order_pay');
				} elseif ($order['order_type'] == 4) {
					$data['status'] = 2;
					pdo_update('tiny_wmall_order', $data, array('id' => $order['id'], 'uniacid' => $params['uniacid']));
					order_insert_status_log($order['id'], $order['sid'], 'pay');
					order_status_notice($order['sid'], $order['id'], 'reserve_order_pay');
					order_clerk_notice($order['sid'], $order['id'], 'reserve_order_pay');
				}
			}
		}
	}
}
