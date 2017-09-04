<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'goods';
mload()->model('store');
mload()->model('goods');
//$this->checkAuth();
$sid = intval($_GPC['sid']);
$store = store_fetch($sid);
if(empty($store)) {
	message('门店不存在或已经删除', referer(), 'error');
}

$_share = array(
	'title' => $store['title'],
	'desc' => $store['content'],
	'imgUrl' => tomedia($store['logo'])
);
$op = trim($_GPC['op']) ? trim($_GPC['op']) : $store['template'];

if($_GPC['from'] == 'search') {
	pdo_query("update " . tablename('tiny_wmall_store') . " set click = click + 1 where uniacid = :uniacid and id = :id",  array(':uniacid' => $_W['uniacid'], ':id' => $sid));
}

if($op == 'index') {
	$title = "{$store['title']}-商品列表";
	//$activity = store_fetch_activity($sid);
	$categorys = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_category')  . ' WHERE status=1 AND sid=:sid AND pid=0 order by displayorder desc limit 8', array(':sid'=>$sid));
	for ($i=0; $i <count($categorys) ; $i++) { 
			$categorys[$i]['thumb'] ='http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$categorys[$i]['thumb']; 
		}
	$w_category['categorys'] = $categorys;
	returnjson('商品分类',$w_category);

}

if($op == 'titlecategory') {
	$title = $_GPC['title'];
	//$activity = store_fetch_activity($sid);
	$categorys = pdo_fetch('select * from ' . tablename('tiny_wmall_goods_category')  . ' WHERE status=1 AND sid=:sid AND title LIKE :title', array(':sid'=>$sid,':title'=>'%'.$title.'%'));	
	if ($categorys) {
		
		returnjson('商品分类',$categorys,1);
	}else{
		$dish = pdo_get('tiny_wmall_goods',array('title'=>$title,'uniacid'=>$_W['uniacid'],'status'=>1,'sid'=>$sid));
		returnjson('商品',$dish,2);
	}
	

}
if($op == 'zhancategory') {
			
	$categorys = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_category')  . ' WHERE status=1 AND sid=:sid AND district=1 order by displayorder desc', array(':sid'=>$sid));

	returnjson('商品分类',$categorys);
	

}
if($op == 'zhancategory1') {
	$category = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_category')  . ' WHERE status=1 AND sid=:sid AND city=1 order by displayorder desc', array(':sid'=>$sid));
	for ($i=0; $i <count($category) ; $i++) { 
			$categorys = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_category')  . ' WHERE status=1 AND sid=:sid AND district=1 AND pid=:pid order by displayorder desc', array(':sid'=>$sid,':pid'=>$category[$i]['id']));
			$category[$i]['categorys'] = $categorys;
		}	
	

	returnjson('商品分类',$category);
	

}

if($op == 'baimenucategory') {
	$title = $_GPC['title'];
	$cgoods = pdo_get('tiny_wmall_goods_category',array('title'=>$title),array('id'));
			
	$categorys = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_category')  . ' WHERE status=1 AND sid=:sid AND pid=:pid order by displayorder desc', array(':sid'=>$sid,':pid'=>$cgoods['id']));
	for ($j=0; $j <count($categorys) ; $j++) { 
		$categorys[$j]['thumb'] = 'http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$categorys[$j]['thumb'];
	}
	returnjson('商品分类',$categorys);
	

}
if ($op == 'comment') {
	$w_comment['uid'] = $_GPC['uid'];
	$w_comment['comment'] = $_GPC['comment'];
	$w_comment['addtime'] = time();
	$w_comment['sid'] = $_GPC['sid'];
	$w_comment['uniacid'] = $_W['uniacid'];
	pdo_insert('tiny_wmall_comment',$w_comment);
	$commentid = pdo_insertid();
	$wdata['id'] = $commentid;
	if ($commentid) {
		returnjson('提交成功',$wdata,1);
	}else{
		returnjson('提交失败',$wdata,0);
	}
}
if ($op == 'extension') {
	// $uid = $_GPC['uid'];
	// $res = pdo_get('mc_members',array('uid'=>$uid));
	// $tuimobile = $res['mobile'];
	$mobile = $_GPC['mobile'];
	$arr = pdo_get('mc_members',array('mobile'=>$mobile));
	if ($arr) {
		returnjson('该手机号已经注册过了，只有新用户才能绑定','',2);
	}
	// $beiuid = $arr['uid'];
	
	// $result = pdo_get('tiny_wmall_extension',array('mobile'=>$tuimobile,'uid'=>$beiuid));
	// if ($result) {
	// 	returnjson('该用户已是您的下级分销商','',2);
	// }

	$w_extension['uid'] = $_GPC['uid'];
	$w_extension['mobile'] = $_GPC['mobile'];
	$w_extension['uniacid'] = $_W['uniacid'];
	$w_extension['addtime'] = time();
	$sql = pdo_get('tiny_wmall_extension',array('mobile'=>$_GPC['mobile']));
	if ($sql) {
		returnjson('该手机号已经绑定过了，请勿重复绑定','',2);
	}
	pdo_insert('tiny_wmall_extension',$w_extension);
	$w_id = pdo_insertid();
	if ($w_id) {
		returnjson('绑定成功','',1);
	}else{
		returnjson('绑定失败','',0);
	}
}

if($op == 'indexcategory') {
	$title = "{$store['title']}-商品列表";
	$pid = $_GPC['pid'];
	if (!$_GPC['type']) {
		$categorys = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_category')  . ' WHERE status=1 AND sid=:sid AND pid=:pid order by displayorder desc', array(':sid'=>$sid,':pid'=>$pid));
	}else{
		if ($_GPC['type'] == 'more') {
			$categorys = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_category')  . ' WHERE status=1 AND pid=141  AND sid=:sid order by displayorder desc', array(':sid'=>$sid));
		}else{
			$categorys = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_category')  . ' WHERE status=1 AND sid=:sid AND id=:id order by displayorder desc', array(':sid'=>$sid,':id'=>$pid));
		}
		
	}
	
	// for ($i=0; $i <count($categorys) ; $i++) { 
	// 		$categorys[$i]['thumb'] ='http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$categorys[$i]['thumb']; 
	// 	}	
	returnjson('商品分类',$categorys);

}

if($op == 'storename'){
	$A = array();
	$A1 = array();
	$cityname = trim($_GPC['cityname']);
	$cityname = mb_substr($cityname, 0,-1);
	$stores = pdo_getall('tiny_wmall_store',array('status'=>1));
	for ($i=0; $i < count($stores); $i++) { 
		if (strpos($stores[$i]['title'], $cityname) !== false) {
			$A['id'] = $stores[$i]['id'];
			$A['slides'] = unserialize($stores[$i]['slides']);
		}
		if (strpos($stores[$i]['title'], '太原') !== false) {
			$A1['id'] = $stores[$i]['id'];
			$A1['slides'] = unserialize($stores[$i]['slides']);
		}
	}
	for ($j=0; $j <count($A['slides']) ; $j++) { 
		$A['slides'][$j] = 'http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$A['slides'][$j];
	}
	for ($j=0; $j <count($A1['slides']) ; $j++) { 
		$A1['slides'][$j] = 'http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$A1['slides'][$j];
	}
	if ($A) {
		returnjson('店铺ID',$A,'1');
	}else{
		returnjson('该城市暂没有分店,为您展示太原店商品',$A1,'2');
	}
	

}
if($op == 'indexgoods') {
	$title = "{$store['title']}-商品列表";
	$cid = $_GPC['cid'];
	$skip = $_GPC['skip'];
	$limit = $_GPC['limit'];
	if ($_GPC['uid']) {
		$uid = intval($_GPC['uid']);
	}else{
		$uid = 0;
	}
	
	$activity = store_fetch_activity($sid);
	$is_favorite = pdo_get('tiny_wmall_store_favorite', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'sid' => $sid));
	//$categorys = store_fetchall_goods_categoryapp($sid, 1);
	$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 AND cid = :cid ORDER BY displayorder DESC, id ASC limit '.$skip.','.$limit, array(':aid' => $_W['uniacid'], ':sid' => $sid,':cid'=>$cid));
	$cate_dish = array();
	foreach($dish as &$di) {
		$di['unitname_cn'] = !empty($di['unitname']) ? "/{$di['unitname']}" : '';
		if($di['is_options']) {
			$di['options'] = pdo_getall('tiny_wmall_goods_options', array('uniacid' => $_W['uniacid'], 'goods_id' => $di['id']));
		}
		$di['thumb'] = 'http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$di['thumb'];
		$cate_dish[$di['cid']][] = $di;
	}
	//获取优惠券
	mload()->model('coupon');
	$tokens = coupon_fetchall_user_available_app($sid, $uid);
	if(!empty($tokens)) {
		$token_nums = count($tokens);
		$token = $tokens[0];
	}

	$gdata['dish'] = $dish;
	$gdata['tokens'] = $tokens;
	returnjson('商品',$gdata);
	// if(!$_GPC['f']) {
	// 	//再来一单的处理逻辑
	// 	$cart = order_fetch_member_cart($sid);
	// } else {
	// 	$cart = order_place_again($sid, $_GPC['id']);
	// 	if(empty($cart)) {
	// 		$cart = order_fetch_member_cart($sid);
	// 	}
	// }
	// include $this->template('goods');
}

if($op == 'titlegoods') {
	$title = $_GPC['title'];
	$sid = $_GPC['sid'];
	if ($_GPC['uid']) {
		$uid = intval($_GPC['uid']);
	}else{
		$uid = 0;
	}
	//$categorys = store_fetchall_goods_categoryapp($sid, 1);
	$dish = pdo_get('tiny_wmall_goods',array('title'=>$title,'uniacid'=>$_W['uniacid'],'status'=>1));
	$gdata['dish'] = $dish;
	returnjson('商品',$gdata);
}
if($op == 'homegoods') {
	$title = "{$store['title']}-商品列表";
	$skip = $_GPC['skip'];
	$limit = $_GPC['limit'];
	if ($_GPC['uid']) {
		$uid = intval($_GPC['uid']);
	}else{
		$uid = 0;
	}
	
	$activity = store_fetch_activity($sid);
	$is_favorite = pdo_get('tiny_wmall_store_favorite', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'sid' => $sid));
	//$categorys = store_fetchall_goods_categoryapp($sid, 1);
	$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 AND is_hot = 1 ORDER BY displayorder DESC, id ASC limit '.$skip.','.$limit, array(':aid' => $_W['uniacid'], ':sid' => $sid));
	$cate_dish = array();
	foreach($dish as &$di) {
		$di['unitname_cn'] = !empty($di['unitname']) ? "/{$di['unitname']}" : '';
		if($di['is_options']) {
			$di['options'] = pdo_getall('tiny_wmall_goods_options', array('uniacid' => $_W['uniacid'], 'goods_id' => $di['id']));
		}
		$di['thumb'] = 'http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$di['thumb'];
		$cate_dish[$di['cid']][] = $di;
	}
	//获取优惠券
	mload()->model('coupon');
	$tokens = coupon_fetchall_user_available_app($sid, $uid);
	if(!empty($tokens)) {
		$token_nums = count($tokens);
		$token = $tokens[0];
	}

	$gdata['dish'] = $dish;
	$gdata['tokens'] = $tokens;
	returnjson('商品',$gdata);

}
if($op == 'categoods') {
	$title = "{$store['title']}-商品列表";
	$cateid = $_GPC['cid'];
	$ctype = $_GPC['type'];
	$skip = $_GPC['skip'];
	$limit = $_GPC['limit'];
	if ($_GPC['uid']) {
		$uid = intval($_GPC['uid']);
	}else{
		$uid = 0;
	}
	if ($ctype == 1) {
		if ($cateid == 1) {
			$cid = 70;
		}elseif ($cateid == 2) {
			$cids = pdo_getall('tiny_wmall_goods_category',array('pid'=>71),array('id'));
			if ($cids) {
				for ($l=0; $l <count($cids) ; $l++) { 
					$w_cids[] = $cids[$l]['id'];
				}
				$w_cids = implode(',', $w_cids);
			}
		}elseif ($cateid ==3) {
			$cid = 64;
		}else{
			$cid = 65;
		}
	}
	
	
	$activity = store_fetch_activity($sid);
	$is_favorite = pdo_get('tiny_wmall_store_favorite', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'sid' => $sid));
	//$categorys = store_fetchall_goods_categoryapp($sid, 1);
	if ($ctype == 1) {
		if ($cateid == 1) {
			$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 AND cid=:cid ORDER BY displayorder DESC, id ASC limit '.$skip.','.$limit, array(':aid' => $_W['uniacid'], ':sid' => $sid,':cid'=>$cid));
		}elseif ($cateid == 2) {
			$dish = pdo_fetchall("SELECT * FROM " . tablename('tiny_wmall_goods') . " WHERE uniacid = :aid AND sid = :sid AND status = 1  AND cid in ({$w_cids}) ORDER BY displayorder DESC, id ASC limit ".$skip.",".$limit, array(':aid' => $_W['uniacid'], ':sid' => $sid));	
		}else{
			$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 AND cid='.$cid.' ORDER BY displayorder DESC, id ASC limit '.$skip.','.$limit, array(':aid' => $_W['uniacid'], ':sid' => $sid));
		}
	}elseif ($ctype == 2) {
		if ($cateid == 1) {
			$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 AND is_shopowner = 1 ORDER BY displayorder DESC, id ASC limit '.$skip.','.$limit, array(':aid' => $_W['uniacid'], ':sid' => $sid));
		}else{
			$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 AND cid=:cid ORDER BY displayorder DESC, id ASC limit '.$skip.','.$limit, array(':aid' => $_W['uniacid'], ':sid' => $sid,':cid'=>$cateid));
		}
	}else{
		if ($cateid == 1) {
			$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 AND is_today = 1 ORDER BY displayorder DESC, id ASC limit '.$skip.','.$limit, array(':aid' => $_W['uniacid'], ':sid' => $sid));
		}else{
			$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 AND is_hot=1 ORDER BY displayorder DESC, id ASC limit '.$skip.','.$limit, array(':aid' => $_W['uniacid'], ':sid' => $sid));
		}
	}
	
	$cate_dish = array();
	foreach($dish as &$di) {
		$di['unitname_cn'] = !empty($di['unitname']) ? "/{$di['unitname']}" : '';
		if($di['is_options']) {
			$di['options'] = pdo_getall('tiny_wmall_goods_options', array('uniacid' => $_W['uniacid'], 'goods_id' => $di['id']));
		}
		$di['thumb'] = 'http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$di['thumb'];
		$cate_dish[$di['cid']][] = $di;
	}
	//获取优惠券
	mload()->model('coupon');
	$tokens = coupon_fetchall_user_available_app($sid, $uid);
	if(!empty($tokens)) {
		$token_nums = count($tokens);
		$token = $tokens[0];
	}

	$gdata['dish'] = $dish;
	$gdata['tokens'] = $tokens;
	returnjson('商品',$gdata);

}
if($op == 'districtgoods') {
	$title = "{$store['title']}-商品列表";
	$skip = $_GPC['skip'];
	$limit = $_GPC['limit'];
	if ($_GPC['uid']) {
		$uid = intval($_GPC['uid']);
	}else{
		$uid = 0;
	}
	
	$cids = pdo_fetchall('SELECT id,title FROM ' . tablename('tiny_wmall_goods_category') . ' WHERE district=1 AND status=1 ORDER BY displayorder DESC,id ASC limit '.$skip.','.$limit);
	if ($cids) {
		for ($l=0; $l <count($cids) ; $l++) {				
				$dish = pdo_fetchall('SELECT id,title,thumb,price,member_price,buzz,sailed,unitname FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 AND cid= :cid ORDER BY displayorder DESC, id ASC limit 3', array(':aid' => $_W['uniacid'], ':sid' => $sid,':cid'=>$cids[$l]['id']));
				if ($dish) {
					$cate_dish = array();
					foreach($dish as &$di) {
						$di['unitname_cn'] = !empty($di['unitname']) ? "/{$di['unitname']}" : '';
						$di['thumb'] = 'http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$di['thumb'];
						$cate_dish[$di['cid']][] = $di;
					}
				}
			
			$cids[$l]['goods'] = $dish;
		}
	}
	
	//$categorys = store_fetchall_goods_categoryapp($sid, 1);
	
	
	

	$gdata['dish'] = $dish;
	returnjson('商品',$cids);

}

if($op == 'hotelgoods') {
	returnjson('商品');
	$title = "{$store['title']}-商品列表";
	$skip = $_GPC['skip'];
	$limit = $_GPC['limit'];
	if ($_GPC['uid']) {
		$uid = intval($_GPC['uid']);
	}else{
		$uid = 0;
	}
	
	$cids = pdo_fetchall('SELECT id,title FROM ' . tablename('tiny_wmall_goods_category') . ' WHERE status=1 AND pid!=97 AND pid!=103 ORDER BY displayorder DESC,id ASC limit '.$skip.','.$limit);
	if ($cids) {
		for ($l=0; $l <count($cids) ; $l++) {				
				$dish = pdo_fetchall('SELECT id,title,thumb,price,member_price,buzz,sailed,unitname,hotel_price,hotel_unitname FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 AND cid= :cid ORDER BY displayorder DESC, id ASC', array(':aid' => $_W['uniacid'], ':sid' => $sid,':cid'=>$cids[$l]['id']));
				if ($dish) {
					$cate_dish = array();
					foreach($dish as &$di) {
						$di['unitname_cn'] = !empty($di['unitname']) ? "/{$di['unitname']}" : '';
						$di['thumb'] = 'http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$di['thumb'];
						$cate_dish[$di['cid']][] = $di;
					}
				}
			
			$cids[$l]['goods'] = $dish;
		}
	}
	
	$gdata['dish'] = $dish;
	returnjson('商品',$cids);

}

if($op == 'cartgoods') {
	$title = "{$store['title']}-商品列表";
	$id = $_GPC['id'];
	$id = explode(',', $id);
	//$categorys = store_fetchall_goods_categoryapp($sid, 1);
	//$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = '.$_W['uniacid'].' AND status = 1 AND id in '.$id.' ORDER BY displayorder DESC, id ASC');
	$dish = pdo_getall('tiny_wmall_goods',array('uniacid'=>$_W['uniacid'],'id'=>$id));
	$cate_dish = array();
	foreach($dish as &$di) {
		$di['unitname_cn'] = !empty($di['unitname']) ? "/{$di['unitname']}" : '';
		if($di['is_options']) {
			$di['options'] = pdo_getall('tiny_wmall_goods_options', array('uniacid' => $_W['uniacid'], 'goods_id' => $di['id']));
		}
		$di['thumb'] = 'http://'.$_SERVER['HTTP_HOST'].'/attachment/'.$di['thumb'];
		$cate_dish[$di['cid']][] = $di;
	}
	//获取优惠券
	// mload()->model('coupon');
	// $tokens = coupon_fetchall_user_available($sid, $_W['member']['uid']);
	// if(!empty($tokens)) {
	// 	$token_nums = count($tokens);
	// 	$token = $tokens[0];
	// }
returnjson('商品',$dish);
	if(!$_GPC['f']) {
		//再来一单的处理逻辑
		$cart = order_fetch_member_cart($sid);
	} else {
		$cart = order_place_again($sid, $_GPC['id']);
		if(empty($cart)) {
			$cart = order_fetch_member_cart($sid);
		}
	}
	include $this->template('goods');
}

if($op == 'market') {
	$title = '商品列表';
	$activity = store_fetch_activity($sid);
	$is_favorite = pdo_get('tiny_wmall_store_favorite', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'sid' => $sid));

	$categorys_temp = $categorys = store_fetchall_goods_category($sid, 1);

	$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 ORDER BY displayorder DESC, id desc', array(':aid' => $_W['uniacid'], ':sid' => $sid), 'id');
	$min = 0;
	foreach($dish as $k => &$di) {
		if(!in_array($di['cid'], array_keys($categorys))) {
			unset($dish[$k]);
			continue;
		}
		$di['unitname_cn'] = !empty($di['unitname']) ? "/{$di['unitname']}" : '';
		if($di['is_options']) {
			$di['options'] = pdo_getall('tiny_wmall_goods_options', array('uniacid' => $_W['uniacid'], 'goods_id' => $di['id']));
		}
	}
	$min = min(array_keys($dish));
	//获取优惠券
	mload()->model('coupon');
	$tokens = coupon_fetchall_user_available($sid, $_W['member']['uid']);
	if(!empty($tokens)) {
		$token_nums = count($tokens);
		$token = $tokens[0];
	}

	if(!$_GPC['f']) {
		//再来一单的处理逻辑
		$cart = order_fetch_member_cart($sid);
	} else {
		$cart = order_place_again($sid, $_GPC['id']);
		if(empty($cart)) {
			$cart = order_fetch_member_cart($sid);
		}
	}
	$cart['data'] = (array)$cart['data'];
	include $this->template('goods-market');
}

if($op == 'more') {
	$id = intval($_GPC['id']);
	$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 and id < :id order by displayorder DESC, id desc limit 12', array(':aid' => $_W['uniacid'], ':sid' => $sid, ':id' => $id), 'id');
	$min = 0;
	if(!empty($dish)) {
		foreach($dish as $k => &$di) {
			if(!in_array($di['cid'], array_keys($categorys))) {
				unset($dish[$k]);
				continue;
			}
			$di['thumb_cn'] = tomedia($di['thumb']);
			$di['is_in_business_hours'] = $store['is_in_business_hours'];
			if($di['is_options']) {
				$di['options'] = pdo_getall('tiny_wmall_goods_options', array('uniacid' => $_W['uniacid'], 'goods_id' => $di['id']));
			}
		}
		$min = min(array_keys($dish));
	}
	$dish = array_values($dish);
	$respon = array('error' => 0, 'message' => $dish, 'min' => $min);
	message($respon, '', 'ajax');
}

if($op == 'cate') {
	$cart = order_insert_member_cart($sid);
	$cid = intval($_GPC['cid']);
	$categorys = store_fetchall_goods_category($sid, 1);
	$dish = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :aid AND sid = :sid AND status = 1 ORDER BY displayorder DESC, id desc', array(':aid' => $_W['uniacid'], ':sid' => $sid), 'id');
	$total = 0;
	foreach($dish as $k => &$di) {
		if(!in_array($di['cid'], array_keys($categorys))) {
			unset($dish[$k]);
			continue;
		}
		if($di['cid'] == $cid) {
			$total++;
			$di['show'] = 1;
		} else {
			$di['show'] = 0;
		}
		if($di['is_options']) {
			$di['options'] = pdo_getall('tiny_wmall_goods_options', array('uniacid' => $_W['uniacid'], 'goods_id' => $di['id']));
		}
	}
	include $this->template('goods-market-cate');
}

if($op == 'detail') {
	if(!$_W['isajax']) {
		message(error(-1, '非法访问'), '', 'ajax');
	}
	$id = intval($_GPC['id']);
	$goods = goods_fetch($id);
	if(is_error($goods)) {
		message(error(-1, '商品不存在或已删除'), '', 'ajax');
	}
	if(!$goods['comment_total']) {
		$goods['comment_good_percent'] = '0%';
	} else {
		$goods['comment_good_percent'] = round($goods['comment_good'] / $goods['comment_total'] * 100, 2) . '%';
	}
	message(error(0, $goods), '', 'ajax');
}

if($op == 'detailgoods') {
	
	$id = intval($_GPC['id']);
	$goods = goods_fetch($id);
	if(is_error($goods)) {
		returnjson('商品不存在或已删除', '');
	}
	if(!$goods['comment_total']) {
		$goods['comment_good_percent'] = '0%';
	} else {
		$goods['comment_good_percent'] = round($goods['comment_good'] / $goods['comment_total'] * 100, 2) . '%';
	}
	returnjson('商品详情',$goods);
}

if($op == 'cart_truncate') {
	if(!$_W['isajax']) {
		message(error(-1, '非法访问'), '', 'ajax');
	}
	pdo_delete('tiny_wmall_order_cart', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'uid' => $_W['member']['uid']));
	message(error(0, ''), '', 'ajax');
}

if($op == 'search') {
	if(!$_W['isajax']) {
		message(error(-1, '非法访问'), '', 'ajax');
	}
	$key = trim($_GPC['key']);
	if(empty($key)) {
		message(error(-1, '关键词不能为空'), '', 'ajax');
	}

	$goods = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods') . ' where uniacid = :uniacid and sid = :sid and status = 1 and title like :title', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':title' => "%{$key}%"));
	if(!empty($goods)) {
		foreach($goods as &$good) {
			$good['thumb_cn'] = tomedia($good['thumb']);
			$good['is_in_business_hours'] = $store['is_in_business_hours'];
			if($good['is_options']) {
				$good['options'] = pdo_getall('tiny_wmall_goods_options', array('uniacid' => $_W['uniacid'], 'goods_id' => $good['id']));
			}
		}
	}
	message(error(0, $goods), '', 'ajax');
}
