<?php

$sql =<<<EOF
DROP TABLE IF EXISTS `ims_tiny_wmall1_account`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_activity_coupon`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_activity_coupon_grant_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_activity_coupon_record`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_address`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_assign_board`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_assign_queue`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_black`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_clerk`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_config`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_delivery_cards`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_delivery_cards_order`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_delivery_config`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_deliveryer`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_deliveryer_current_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_deliveryer_getcash_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_fans`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_goods`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_goods_category`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_goods_options`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_goods_options`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_goods_options`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_help`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_members`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_order`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_order_cart`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_order_comment`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_order_current_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_order_discount`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_order_print_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_order_refund_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_order_stat`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_order_status_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_paylog`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_printer`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_printer_label`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_reply`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_report`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_reserve`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_reserve`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_slide`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_sms_send_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_sms_send_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store_account`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store_activity`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store_category`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store_current_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store_delivery_times`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store_deliveryer`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store_favorite`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store_getcash_log`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store_members`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_store_settle_config`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_tables`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_tables_category`;
DROP TABLE IF EXISTS `ims_tiny_wmall1_tables_scan`;
EOF;
pdo_run($sql);