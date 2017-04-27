<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 
 */
defined('IN_IA') or exit('Access Denied');
session_start();
session_destroy();

header('Location:' . url('account/welcome'));
