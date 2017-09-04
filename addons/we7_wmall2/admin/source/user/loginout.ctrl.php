<?php
defined('IN_IA') or exit('Access Denied');
isetcookie('__we7_wmall2_session', 0, -10000);

@header('Location: '.wurl('user/login'));
die;