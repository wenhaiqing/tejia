<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 * $sn$
 */
load()->model('user');
load()->func('tpl');
$_W['token'] = token();
$session = json_decode(base64_decode($_GPC['__we7_wmall1_session']), true);
if(is_array($session)) {
	$user = pdo_get('tiny_wmall1_clerk', array('id' => $session['clerk_id']));
	if(is_array($user) && $session['hash'] == $user['password']) {
		$_W['role'] = 'operator';
		$_W['we7_wmall1']['clerk'] = $user;
		$_W['we7_wmall1']['store'] = pdo_get('tiny_wmall1_store', array('id' => $user['sid']), array('title', 'id'));
		$_W['we7_wmall1']['clerk_id'] = $user['id'];
		$_W['we7_wmall1']['sid'] = $user['sid'];
		$_W['uniacid'] = $user['uniacid'];
		$_W['__uniacid'] = $user['uniacid'];
		isetcookie('__sid', $user['sid'], 7*86400);
	} else {
		isetcookie('__we7_wmall1_session', false, -100);
		isetcookie('__sid', 0, -1000);
	}
	unset($user);
}
unset($session);

if(!empty($_W['__uniacid'])) {
	$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
	$_W['acid'] = $_W['account']['acid'];
	$_W['weid'] = $_W['uniacid'];
}
load()->func('compat.biz');
