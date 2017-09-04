<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '订单统计-' . $_W['we7_wmall']['config']['title'];
mload()->model('store');

$store = store_check();
$sid = $store['id'];
$do = 'stat';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';

if($op == 'list') {
	$condition = " WHERE uniacid = :aid AND sid = :sid AND is_pay = 1 and status > 1 and status !=6";
	$params[':aid'] = $_W['uniacid'];
	$params[':sid'] = $sid;
	if(!empty($_GPC['addtime'])) {
		$starttime = strtotime($_GPC['addtime']['start'])-7200;
		$endtime = strtotime($_GPC['addtime']['end']) + 86399-7200;
	} else {
		$starttime = strtotime(date('Y-m'))-7200;
		$endtime = TIMESTAMP;
	}
	$condition .= " AND addtime > :start AND addtime < :end";
	$params[':start'] = $starttime;
	$params[':end'] = $endtime;
	
	$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_order') .  $condition, $params);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_order') . $condition, $params);
	$total = array();
	if(!empty($data)) {
		foreach($data as &$da) {
			$total_price = $da['final_fee'];
			$key = date('Y-m-d', $da['addtime']);
			$return[$key]['price'] += $total_price;
			$return[$key]['count'] += 1;
			$total['total_price'] += $total_price;
			$total['total_count'] += 1;
			if($da['pay_type'] == 'alipay') {
				$return[$key]['alipay'] += $total_price;
				$total['total_alipay'] += $total_price;
			} elseif($da['pay_type'] == 'wechat') {
				$return[$key]['wechat'] += $total_price;
				$total['total_wechat'] += $total_price;
			} elseif($da['pay_type'] == 'credit') {
				$return[$key]['credit'] += $total_price;
				$total['total_credit'] += $total_price;
			} elseif($da['pay_type'] == 'delivery') {
				$return[$key]['delivery'] += $total_price;
				$total['total_delivery'] += $total_price;
			} else {
				$return[$key]['cash'] += $total_price;
				$total['total_cash'] += $total_price;
			}
		}
	}
	//订单统计
	$stat = order_amount_stat($sid);
	include $this->template('store/stat');
}

if($op == 'order_num') {
	$start = $_GPC['start'] ? strtotime($_GPC['start'])-7200 : (strtotime(date('Y-m'))-7200);
	$end= $_GPC['end'] ? strtotime($_GPC['end']) + 86399-7200 : (strtotime(date('Y-m-d')) + 86399-7200);
	$day_num = ($end - $start) / 86400;
	if($_W['isajax'] && $_W['ispost']) {
		$days = array();
		$datasets = array(
			'flow1' => array(),
		);
		for($i = 0; $i < $day_num; $i++){
			$key = date('m-d', $start + 86400 * $i);
			$days[$key] = 0;
			$datasets['flow1'][$key] = 0;
		}
		$data = pdo_fetchall("SELECT * FROM " . tablename('tiny_wmall_order') . 'WHERE uniacid = :uniacid AND sid = :sid and status > 1 and status!=6 and is_pay = 1 and addtime >= :starttime and addtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':starttime' => $start, 'endtime' => $end));
		foreach($data as $da) {
			$key = date('m-d', $da['addtime']);
			if(in_array($key, array_keys($days))) {
				$datasets['flow1'][$key]++;
			}
		}
		$shuju['label'] = array_keys($days);
		$shuju['datasets'] = $datasets;
		exit(json_encode($shuju));
	}
}

if($op == 'order_price') {
	$start = $_GPC['start'] ? strtotime($_GPC['start'])-7200 : (strtotime(date('Y-m'))-7200);
	$end= $_GPC['end'] ? strtotime($_GPC['end']) + 86399-7200 : (strtotime(date('Y-m-d')) + 86399-7200);
	$day_num = ($end - $start) / 86400;

	if($_W['isajax'] && $_W['ispost']) {
		$days = array();
		$datasets = array(
			'flow1' => array(),
		);
		for($i = 0; $i < $day_num; $i++){
			$key = date('m-d', $start + 86400 * $i);
			$days[$key] = 0;
			$datasets['flow1'][$key] = 0;
		}
		$data = pdo_fetchall("SELECT * FROM " . tablename('tiny_wmall_order') . 'WHERE uniacid = :uniacid AND sid = :sid and status > 1 and status!=6 and is_pay = 1 and addtime >= :starttime and addtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':starttime' => $start, 'endtime' => $end));
		foreach($data as $da) {
			$key = date('m-d', $da['addtime']);
			if(in_array($key, array_keys($days))) {
				$datasets['flow1'][$key] += $da['final_fee'];
			}
		}
		$shuju['label'] = array_keys($days);
		$shuju['datasets'] = $datasets;
		exit(json_encode($shuju));
	}
}

if($op == 'day') {
	$orderby = trim($_GPC['orderby']) ? trim($_GPC['orderby']) : 'num';
	if($orderby == 'num') {
		$order_by = ' ORDER BY num DESC';
	} else {
		$order_by = ' ORDER BY price DESC';
	}

	$starttime = strtotime($_GPC['addtime']['start'])-7200;
	if(empty($_GPC['addtime']['end'])) {
		$endtime = $starttime + 86399-7200;
	} else {
		$endtime = strtotime($_GPC['addtime']['end']) + 86399-7200;
	}
	$data = array();
	$orders = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_order') . " WHERE uniacid = :aid AND sid = :sid AND is_pay = 1 and status > 1 and status!=6 and addtime >= :start AND addtime < :end", array(':sid' => $sid, ':aid' => $_W['uniacid'], ':start' => $starttime, ':end' => $endtime), 'id');
	$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_order') . " WHERE uniacid = :aid AND sid = :sid AND is_pay = 1 and status > 1 and status!=6 and addtime >= :start AND addtime < :end", array(':sid' => $sid, ':aid' => $_W['uniacid'], ':start' => $starttime, ':end' => $endtime));
	if(!empty($orders)) {
		$str = implode(',', array_keys($orders));
		$data = pdo_fetchall('SELECT *,SUM(goods_num) AS num, SUM(goods_price) AS price FROM ' . tablename('tiny_wmall_order_stat') . " WHERE uniacid = :aid AND sid = :sid AND oid IN ({$str}) GROUP BY goods_id" . $order_by, array(':aid' => $_W['uniacid'], ':sid' => $sid), 'goods_id');
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_order_stat') . " WHERE uniacid = :aid AND sid = :sid AND oid IN ({$str})", array(':aid' => $_W['uniacid'], ':sid' => $sid));
		$price = pdo_fetchcolumn('SELECT SUM(final_fee) FROM ' . tablename('tiny_wmall_order') . " WHERE uniacid = :aid AND sid = :sid AND id IN ({$str})", array(':aid' => $_W['uniacid'], ':sid' => $sid));
	}
	if(!empty($orders)) {
		foreach($orders as &$da) {
			$total_price = $da['final_fee'];
			if($da['pay_type'] == 'alipay') {
				$return['alipay']['price'] += $total_price;
				$return['alipay']['num'] += 1;
			} elseif($da['pay_type'] == 'wechat') {
				$return['wechat']['price'] += $total_price;
				$return['wechat']['num'] += 1;
			} elseif($da['pay_type'] == 'credit') {
				$return['credit']['price'] += $total_price;
				$return['credit']['num'] += 1;
			} elseif($da['pay_type'] == 'delivery') {
				$return['delivery']['price'] += $total_price;
				$return['delivery']['num'] += 1;
			} else {
				$return['cash']['price'] += $total_price;
				$return['cash']['num'] += 1;
			}
		}
	}
	include $this->template('store/stat-day');
}

if($op == 'day_order_price') {
	$start = $_GPC['start'] ? strtotime($_GPC['start'])-7200 : (strtotime(date('Y-m'))-7200);
	$end= $_GPC['end'] ? strtotime($_GPC['end']) + 86399-7200 : (strtotime(date('Y-m-d')) + 86399-7200);
	if($_W['isajax'] && $_W['ispost']) {
		$datasets = array(
			'wechat' => array('name' => '微信支付', 'value' => 0),
			'alipay' => array('name' => '支付宝支付', 'value' => 0),
			'credit' => array('name' => '余额支付', 'value' => 0),
			'cash' => array('name' => '现金支付', 'value' => 0),
			'delivery' => array('name' => '货到付款', 'value' => 0)
		);
		$data = pdo_fetchall("SELECT * FROM " . tablename('tiny_wmall_order') . 'WHERE uniacid = :uniacid AND sid = :sid and status > 1 and status!=6 and is_pay = 1 and addtime >= :starttime and addtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':starttime' => $start, 'endtime' => $end));
		foreach($data as $da) {
			if(in_array($da['pay_type'], array_keys($datasets))) {
				$datasets[$da['pay_type']]['value'] += $da['final_fee'];
			}
		}
		$datasets = array_values($datasets);
		message(error(0, $datasets), '', 'ajax');
	}
}

if($op == 'day_order_num') {
	$start = $_GPC['start'] ? strtotime($_GPC['start'])-7200 : (strtotime(date('Y-m'))-7200);
	$end= $_GPC['end'] ? strtotime($_GPC['end']) + 86399-7200 : (strtotime(date('Y-m-d')) + 86399-7200);
	if($_W['isajax'] && $_W['ispost']) {
		$datasets = array(
			'wechat' => array('name' => '微信支付', 'value' => 0),
			'alipay' => array('name' => '支付宝支付', 'value' => 0),
			'credit' => array('name' => '余额支付', 'value' => 0),
			'cash' => array('name' => '现金支付', 'value' => 0),
			'delivery' => array('name' => '货到付款', 'value' => 0)
		);
		$data = pdo_fetchall("SELECT * FROM " . tablename('tiny_wmall_order') . 'WHERE uniacid = :uniacid AND sid = :sid and status >1 and status!=6 and is_pay = 1 and addtime >= :starttime and addtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':starttime' => $start, 'endtime' => $end));
		foreach($data as $da) {
			if(in_array($da['pay_type'], array_keys($datasets))) {
				$datasets[$da['pay_type']]['value'] += 1;
			}
		}
		$datasets = array_values($datasets);
		message(error(0, $datasets), '', 'ajax');
	}
}

if($op == 'excel') {
	load()->model('mc');
	mload()->model('deliveryer');

	$orderby = trim($_GPC['orderby']) ? trim($_GPC['orderby']) : 'num';
	if($orderby == 'num') {
		$order_by = ' ORDER BY num DESC';
	} else {
		$order_by = ' ORDER BY price DESC';
	}

	$starttime = strtotime($_GPC['addtime']['start']);
	if(empty($_GPC['addtime']['end'])) {
		$endtime1 = $_GPC['addtime']['start'];
		$endtime = $starttime + 86399-7200;
	} else {
		$endtime = strtotime($_GPC['addtime']['end']) + 86399-7200;
		$endtime1 = $_GPC['addtime']['end'];
	}

	$list = array();
	$orders = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_order') . " WHERE uniacid = :aid AND sid = :sid AND is_pay = 1 and addtime >= :start AND addtime < :end", array(':sid' => $sid, ':aid' => $_W['uniacid'], ':start' => $starttime, ':end' => $endtime), 'id');
	$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_order') . " WHERE uniacid = :aid AND sid = :sid AND is_pay = 1  and addtime >= :start AND addtime < :end", array(':sid' => $sid, ':aid' => $_W['uniacid'], ':start' => $starttime, ':end' => $endtime));
	if(!empty($orders)) {
		$str = implode(',', array_keys($orders));
		$list = pdo_fetchall('SELECT *,SUM(goods_num) AS num, SUM(goods_price) AS price FROM ' . tablename('tiny_wmall_order_stat') . " WHERE uniacid = :aid AND sid = :sid AND oid IN ({$str}) GROUP BY goods_id" . $order_by, array(':aid' => $_W['uniacid'], ':sid' => $sid));
	
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_order_stat') . " WHERE uniacid = :aid AND sid = :sid AND oid IN ({$str})", array(':aid' => $_W['uniacid'], ':sid' => $sid));
		$price = pdo_fetchcolumn('SELECT SUM(final_fee) FROM ' . tablename('tiny_wmall_order') . " WHERE uniacid = :aid AND sid = :sid AND id IN ({$str})", array(':aid' => $_W['uniacid'], ':sid' => $sid));
	}

	$order_fields = array(
		'time' => array(
			'field' => 'time',
			'title' => '时间',
			'width' => '30',
		),
		'title' => array(
			'field' => 'title',
			'title' => '商品名称',
			'width' => '30',
		),
		'sale' => array(
			'field' => 'sale',
			'title' => '今日销量',
			'width' => '10',
		),
		'price' => array(
			'field' => 'price',
			'title' => '今日收入',
			'width' => '40',
		),
		
	);

	
	$ABC = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
	$i = 0;
	foreach($order_fields as $key => $val) {
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
			$row1['time'] = $_GPC['addtime']['start'].'～'.$endtime1;
			$row1['title'] = " {$row['goods_title']}";
			$row1['sale'] = "{$row['num']}";
			$row1['price'] = "{$row['price']}";
			foreach ($all_fields as $key => $li){
				$field = $li['field'];
				$objPHPExcel->getActiveSheet(0)->setCellValue($key . ($i + 2), $row1[$field]);
			}
		}

	}
	$objPHPExcel->getActiveSheet()->setTitle('订单数据');
	$objPHPExcel->setActiveSheetIndex(0);

	// 输出
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
	header('Content-Disposition: attachment;filename="订单数据.xls"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit();
}


