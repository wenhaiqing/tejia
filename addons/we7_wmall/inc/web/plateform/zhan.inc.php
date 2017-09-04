<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '订单列表-' . $_W['we7_wmall']['config']['title'];
mload()->model('store');
mload()->model('order');
mload()->model('deliveryer');
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';

if($op == 'list') {
	$data = pdo_fetchall("SELECT * FROM " . tablename('tiny_wmall_zhan') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']), 'id');

	
	$stores = store_fetchall(array('id', 'title'));
}

if($op == 'detail') {
	$id = intval($_GPC['id']);
	$order = pdo_fetch("SELECT * FROM " . tablename('tiny_wmall_zhan') . ' WHERE uniacid = :uniacid AND id=:id', array(':uniacid' => $_W['uniacid'],':id'=>$id));
	$order['data'] = unserialize($order['data']);
	
}

if($op == 'export') {
	load()->model('mc');
	$stores = store_fetchall(array('id', 'title'));
	$pay_types = order_pay_types();

	$condition = ' WHERE uniacid = :uniacid and status = 5 and order_type < 3';
	$params[':uniacid'] = $_W['uniacid'];

	$sid = intval($_GPC['sid']);
	if($sid > 0) {
		$condition .= ' AND sid = :sid';
		$params[':sid'] = $sid;
	}
	$ordersn = trim($_GPC['ordersn']);
	if(!empty($ordersn)) {
		$condition .= " AND (ordersn LIKE '%{$ordersn}%'";
	}
	if(!empty($_GPC['addtime'])) {
		$starttime = strtotime($_GPC['addtime']['start']);
		$endtime = strtotime($_GPC['addtime']['end']) + 86399;
	} else {
		$starttime = strtotime('-15 day');
		$endtime = TIMESTAMP;
	}
	$condition .= " AND addtime > :start AND addtime < :end";
	$params[':start'] = $starttime;
	$params[':end'] = $endtime;

	$list = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_order') . $condition . ' ORDER BY id DESC', $params);
	$order_fields = array(
		'id' => array(
			'field' => 'id',
			'title' => '订单ID',
			'width' => '10',
		),
		'ordersn' => array(
			'field' => 'ordersn',
			'title' => '订单编号',
			'width' => '30',
		),
		'uid' => array(
			'field' => 'uid',
			'title' => '下单人UID',
			'width' => '10',
		),
		'openid' => array(
			'field' => 'openid',
			'title' => '粉丝openid',
			'width' => '40',
		),
		'sid' => array(
			'field' => 'sid',
			'title' => '下单门店',
			'width' => '15',
		),
		'username' => array(
			'field' => 'username',
			'title' => '收货人',
			'width' => '15',
		),
		'mobile' => array(
			'field' => 'mobile',
			'title' => '手机号',
			'width' => '20',
		),
		'address' => array(
			'field' => 'address',
			'title' => '收货地址',
			'width' => '40',
		),
		'pay_type' => array(
			'field' => 'pay_type',
			'title' => '支付方式',
			'width' => '15',
		),
		'num' => array(
			'field' => 'num',
			'title' => '份数',
			'width' => '10',
		),
		'total_fee' => array(
			'field' => 'total_fee',
			'title' => '总价',
			'width' => '15',
		),
		'discount_fee' => array(
			'field' => 'discount_fee',
			'title' => '优惠金额',
			'width' => '15',
		),
		'final_fee' => array(
			'field' => 'final_fee',
			'title' => '优惠后价格',
			'width' => '15',
		),
		'addtime' => array(
			'field' => 'addtime',
			'title' => '下单时间',
			'width' => '25',
		),
	);

	if(!empty($_GPC['fields'])) {
		$groups = mc_groups();
		$fields = mc_acccount_fields();
		$user_fields = array();
		foreach($_GPC['fields'] as $field) {
			if(in_array($field, array_keys($fields))) {
				$user_fields[$field] = array(
					'field' => $field,
					'title' => $fields[$field],
					'width' => '25',
				);
			}
		}
		if(!empty($user_fields)) {
			$uids = array();
			foreach($list as $li) {
				if(!in_array($li['uid'], $uids)) {
					$uids[] = $li['uid'];
				}
			}
			$uids = array_unique($uids);
			$uids_str = implode(',', $uids);
			$users = pdo_fetchall('select * from ' . tablename('mc_members') . " where uniacid = :uniacid and uid in ({$uids_str})", array(':uniacid' => $_W['uniacid']), 'uid');
		}
		$header = array_merge($order_fields, $user_fields);
	}
	$ABC = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
	$i = 0;
	foreach($header as $key => $val) {
		$all_fields[$ABC[$i]] = $val;
		$i++;
	}

	include_once(IA_ROOT . '/framework/library/phpexcel/PHPExcel.php');
	$objPHPExcel = new PHPExcel();

	foreach($all_fields as $key => $li) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($key)->setWidth($li['width']);
		$objPHPExcel->getActiveSheet()->getStyle($key)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($key . '1', $li['title']);
	}
	if(!empty($list)) {
		for($i = 0, $length = count($list); $i < $length; $i++) {
			$row = $list[$i];
			$row['addtime'] = date('Y/m/d H:i', $row['addtime']);
			$row['ordersn'] = " {$row['ordersn']}";
			foreach($all_fields as $key => $li) {
				$field = $li['field'];
				if(in_array($field, array_keys($order_fields))) {
					if($field == 'sid') {
						$row[$field] = $stores[$row[$field]]['title'];
					} elseif($field == 'pay_type') {
						$row[$field] = $pay_types[$row[$field]]['text'];
					}
				} else {
					$row[$field] = $users[$row['uid']][$field];
					if($field == 'groupid') {
						$row[$field] = $groups[$row['groupid']]['title'];
					}
				}
				$objPHPExcel->getActiveSheet(0)->setCellValue($key . ($i + 2), $row[$field]);
			}
		}
	}
	$objPHPExcel->getActiveSheet()->setTitle('订单数据');
	$objPHPExcel->setActiveSheetIndex(0);

	// 输出
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="订单数据.xls"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit();
}

include $this->template('plateform/zhan-takeout');