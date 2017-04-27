<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$accounts = uni_accounts();
if(!empty($accounts)) {
	foreach($accounts as $key => $li) {
		if($li['level'] < 3) {
			unset($accounts[$key]);
		}
	}
}
template('wechat/account');