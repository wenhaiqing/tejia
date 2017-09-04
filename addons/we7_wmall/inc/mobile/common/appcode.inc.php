<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
mload()->model('sms');
global $_W, $_GPC;
$do = 'code';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'index';

$sid = intval($_GPC['sid']);
$mobile = trim($_GPC['mobile']);
if($mobile == ''){
	returnjson('请输入手机号','','error');
}

if(!preg_match(REGULAR_MOBILE, $mobile)) {
	returnjson('手机号格式错误','','error');
}
$type = trim($_GPC['type']);
if ($type == 'registercode') {
	$tpid = 'SMS_8926558';//模板ID例如'SMS_12995334';
}

$sql = 'DELETE FROM ' . tablename('uni_verifycode') . ' WHERE `createtime`<' . (TIMESTAMP - 1800);
pdo_query($sql);

$sql = 'SELECT * FROM ' . tablename('uni_verifycode') . ' WHERE `receiver`=:receiver AND `uniacid`=:uniacid';
$pars = array();
$pars[':receiver'] = $mobile;
$pars[':uniacid'] = $_W['uniacid'];
$row = pdo_fetch($sql, $pars);
$record = array();
if(!empty($row)) {
	// if($row['total'] >= 5) {
	// 	returnjson('您的操作过于频繁,请稍后再试','','error');
	// }
	$code = $row['verifycode'];
	$record['total'] = $row['total'] + 1;
} else {
	$code = random(6, true);
	$record['uniacid'] = $_W['uniacid'];
	$record['receiver'] = $mobile;
	$record['verifycode'] = $code;
	$record['total'] = 1;
	$record['createtime'] = TIMESTAMP;
}
if(!empty($row)) {
	pdo_update('uni_verifycode', $record, array('id' => $row['id']));
} else {
	pdo_insert('uni_verifycode', $record);
}
//所传的参数
$content = array(
	'name'=>trim($_GPC['name']),
	'code' => $code,
	'product' => trim($_GPC['product'])
);

$result = sms_send_app($tpid, $mobile, $content, $sid);
if(is_error($result)) {
	returnjson($result['message'],'','error');
}
returnjson('success','','1');