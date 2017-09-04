<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;

$op = trim($_GPC['op']);

if($op == 'deliveryer') {
	// $sid = intval($_GPC['sid']);
	// $data = pdo_getall('tiny_wmall2_store', array('uniacid' => $_W['uniacid'], 'status' => 1));
	// if(empty($data)) {
	// 	message(error(-1, '配送站不存在'), '', 'ajax');
	// }
//	if($account['delivery_type'] == 2) {
//		message(error(-1, '你没有使用店内配送员的权限, 请联系平台管理员'), '', 'ajax');
//	}
	$condition = ' where uniacid = :uniacid and status = :status';
	$params = array(':uniacid' => $_W['uniacid'], ':status' => 1);
	$data = pdo_fetchall('select id,title,telephone from ' . tablename('tiny_wmall2_store') . $condition, $params);
	// if(!empty($data)) {
	// 	foreach($data as &$da) {
	// 		$da['deliveryer'] = $da;
	// 	}
	// }
	message(error(0, $data), '', 'ajax');
}