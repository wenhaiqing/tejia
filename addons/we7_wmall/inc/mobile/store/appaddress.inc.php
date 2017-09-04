<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
mload()->model('member');
load()->func('communication');
$do = 'address';
$title = '我的收货地址';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';
$sid = intval($_GPC['sid']);
$init_hide = 0;
$store['serve_radius'] = 0;
$store['auto_get_address'] = 1;
if($sid > 0) {
	$store = store_fetch($sid);
	if(!$store['not_in_serve_radius'] && !empty($store['location_x']) && !empty($store['location_y']) && $store['serve_radius'] > 0 && $store['auto_get_address'] == 1) {
		$init_hide = 1;
	}
}
$redirect_type = trim($_GPC['redirect_type']);
$redirect_input = trim($_GPC['redirect_input']);
$routes = array(
	'order' => $this->createMobileUrl('submit', array('sid' => $_GPC['sid'], 'r' => 1, 'op' => 'index', 'recordid' => $_GPC['recordid'])) . "&address_id=" ,
	'errander' => $this->createMobileUrl('errander-index', array('op' => 'submit', 'id' => $_GPC['errander_id'])) . "&{$redirect_input}="
);
$redirect_url = $routes[$redirect_type];
if($op == 'list') {
	$uid = $_GPC['uid'];
	$addresses = member_fetchall_address_app($uid);
	if($init_hide == 1) {
		$available = array();
		$dis_available = array();
		foreach($addresses as $li) {
			if(!empty($li['location_x']) && !empty($li['location_y'])) {
				$dist = distanceBetween($li['location_y'], $li['location_x'], $store['location_y'], $store['location_x']);
				if($dist > ($store['serve_radius'] * 1000)) {
					$dis_available[] = $li;
				} else {
					$available[] = $li;
				}
			} else {
				$dis_available[] = $li;
			}
		}
	}
	returnjson('地址列表',$addresses);
}

if($op == 'post') {
	$id = intval($_GPC['id']);
	if($id > 0) {
		$address = member_fetch_address($id);
		if(empty($address)) {
			returnjson('地址不存在或已经删除', referer(), 'error');
		}
	} else {
		$address = array(
			'mobile' => $_W['member']['mobile'],
			'realname' => $_W['member']['realname'],
		);
	}
	if($_GPC['d'] == 1) {
		$address['location_x'] = trim($_GPC['lat']);
		$address['location_y'] = trim($_GPC['lng']);
		$address['address'] = trim($_GPC['address']);
	}
	if($_GPC['app']) {
		if(empty($_GPC['realname']) || empty($_GPC['mobile'])) {
			returnjson('信息有误', '', 'ajax');
		}
		if (strlen($_GPC['mobile'])!=11||$_GPC['mobile'] == 'undefined') {
			returnjson('手机号信息有误,请重新填写','','ajax');
		}
		$alladdress = $_GPC['address'];
		if ($alladdress!='山西太原小店区'&&$alladdress!='山西太原晋源区'&&$alladdress!='山西太原迎泽区'&&$alladdress!='山西太原杏花岭区') {
			returnjson('该地区暂未开放配送，目前只支持小店区,晋源区,迎泽区,杏花岭区','','ajax');
		}
		$data = array(
			'uniacid' => $_W['uniacid'],
			'uid' => $_GPC['uid'],
			'realname' => trim($_GPC['realname']),
			'sex' => trim($_GPC['sex']),
			'mobile' => trim($_GPC['mobile']),
			'address' => trim($_GPC['address']),
			'number' => trim($_GPC['number']),
			'location_x' => trim($_GPC['location_x']),
			'location_y' => trim($_GPC['location_y']),
			'type' => 1,
			'is_default'=>$_GPC['is_default']
		);
		if($redirect_type == 'errander') {
			$config = $_W['we7_wmall']['config']['errander'];
			$distance = distanceBetween($data['location_y'], $data['location_x'], $config['map']['location_y'], $config['map']['location_x']);
			if($distance > ($config['serve_radius'] * 1000)) {
				returnjson('该地址不在配送服务范围内', '', 'ajax');
			}
		}
		if ($_GPC['is_default'] == 1) {
			$w_default['is_default'] = 0;
			pdo_update('tiny_wmall_address',$w_default,array('uid'=>$_GPC['uid']));
		}
		if(!empty($address['id'])) {
			pdo_update('tiny_wmall_address', $data, array('uniacid' => $_W['uniacid'], 'id' => $id));
		} else {
			pdo_insert('tiny_wmall_address', $data);
			$id = pdo_insertid();
		}
		returnjson('成功', $id, 'ajax');
	}
}

if($op == 'del') {
	
	$id = intval($_GPC['id']);
	pdo_delete('tiny_wmall_address', array('uniacid' => $_W['uniacid'], 'id' => $id));
	returnjson('删除成功', '', '1');
}

if($op == 'default') {
	$id = intval($_GPC['id']);
	pdo_update('tiny_wmall_address', array('is_default' => 0), array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'type' => 1));
	pdo_update('tiny_wmall_address', array('is_default' => 1), array('uniacid' => $_W['uniacid'], 'id' => $id));
	exit();
}

if($op == 'serve_address') {
	$data = array(
		'uniacid' => $_W['uniacid'],
		'uid' => $_W['member']['uid'],
		'name' => trim($_GPC['address']),
		'address' => trim($_GPC['name']),
		'location_x' => trim($_GPC['location_x']),
		'location_y' => trim($_GPC['location_y']),
		'number' => trim($_GPC['number']),
		'type' => 2,
	);
	if(empty($data['name']) || empty($data['location_x'])) {
		message(error(-1, '地址信息不完善'), '', 'ajax');
	}
	pdo_insert('tiny_wmall_address', $data);
	$id = pdo_insertid();
	message(error(0, $id), '', 'ajax');
}

if($op == 'update_avatar'){ 
	
	//$upload_img =  "/atachment/images/touxian/". $_POST['user'].".jpg";
	$upload_img = MODULE_ROOT.'/attachment/touxian/'.$_POST['user'].'.jpg';
	
	$aa = move_uploaded_file($_FILES["file"]["tmp_name"],$upload_img);
	if($aa){
		$A['code'] = "1";
		$A['path'] = $upload_img;
	}

	returnjson('上传头像', $A);
}

if($op == 'update_comment'){
	$orderid = $_GPC['orderid'];
	$sid = $_GPC['sid']; 
	
	//$upload_img =  "/atachment/images/touxian/". $_POST['user'].".jpg";
	$upload_img = MODULE_ROOT.'/attachment/comment/'.time().'.jpg';
	
	$aa = move_uploaded_file($_FILES["file"]["tmp_name"],$upload_img);
	$upload_img1 = '/attachment/comment/'.time().'.jpg';
	$upload_img2 = MODULE_URL.'attachment/comment/'.time().'.jpg';
	$w_data['orderid'] = $orderid;
	$w_data['sid'] = $sid;
	$w_data['addtime'] = time();
	$w_data['path'] = $upload_img1;
	$w_data['uniacid'] = $_W['uniacid'];
	pdo_insert('tiny_wmall_order_comment_picture',$w_data);
	if($aa){
		$A['code'] = "1";
		$A['path'] = $upload_img2;
	}

	returnjson('上传评论图片', $A);
}

if($op == 'update_member_avatar'){ 
	
	$uid = $_GPC['memberid'];
	$da['avatar'] = MODULE_URL.'attachment/touxian/'.$uid.'.jpg';
	$id = pdo_update('mc_members',$da,array('uid'=>$uid));
	if ($id) {
		$A['code'] =1;
	}
	$A['path'] = $da['avatar'];
	$A['uid'] = $uid;
	returnjson('更新数据库头像路径',$A);
}

if($op == 'get_member'){ 
	
	$uid = $_GPC['uid'];
	$info = pdo_get('mc_members',array('uid'=>$uid));
	$A['info'] = $info;
	returnjson('更新数据库头像路径',$A);
}


include $this->template('address');


