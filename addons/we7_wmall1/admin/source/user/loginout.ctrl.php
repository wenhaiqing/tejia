<?php
defined('IN_IA') or exit('Access Denied');
isetcookie('__we7_wmall1_session', 0, -10000);

@header('Location: '.wurl('user/login'));
die;