<?php
/**
 * 微擎外送模块
 *
 * @author 微擎团队&灯火阑珊
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class We7_wmall1Module extends WeModule {
	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		include $this->template('settings');
	}
}
