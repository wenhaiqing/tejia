<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '商品分类-' . $_W['we7_wmall']['config']['title'];
mload()->model('store');

$store = store_check();
$sid = $store['id'];
$do = 'category';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';

if($op == 'post') {
	$category = pdo_getall('tiny_wmall_goods_category',array('status'=>1,'sid'=>$sid,'pid'=>0));
	if(checksubmit('submit')) {
		if(!empty($_GPC['title'])) {
			foreach($_GPC['title'] as $k => $v) {
				$v = trim($v);
				if(empty($v)) continue;
				$data['sid'] = $sid;
				$data['uniacid'] = $_W['uniacid'];
				$data['title'] = $v;
				$data['description'] = $_GPC['description'][$k];
				$data['pid'] = $_GPC['pid'];
				$data['district'] = $_GPC['district'];
				$data['city'] = $_GPC['city'];
				$data['displayorder'] = intval($_GPC['displayorder'][$k]);
				$data['thumb'] = $_GPC['thumb'];
				pdo_insert('tiny_wmall_goods_category', $data);
			}
		}
		message('添加商品分类成功', $this->createWebUrl('category'), 'success');
	}
}

if($op == 'update') {
	if($_W['ispost']) {
				$data['sid'] = $sid;
				$data['uniacid'] = $_W['uniacid'];
				$data['title'] = $_GPC['title'];
				$data['description'] = $_GPC['description'];
				$data['pid'] = $_GPC['pid'];
				$data['district'] = $_GPC['district'];
				$data['city'] = $_GPC['city'];
				$data['displayorder'] = intval($_GPC['displayorder']);
		$data['thumb'] = $_GPC['thumb'];
		pdo_update('tiny_wmall_goods_category', $data, array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']));
		message('更新商品分类成功', $this->createWebUrl('category'), 'success');
	}else{
		$id = $_GPC['cid'];
		$category = pdo_getall('tiny_wmall_goods_category',array('status'=>1,'sid'=>$sid,'pid'=>0));
		$info = pdo_get('tiny_wmall_goods_category',array('id'=>$id));
		include $this->template('store/category1');
		exit;
	}
}

if($op == 'list') {
	$condition = ' uniacid = :aid AND sid = :sid';
	$params[':aid'] = $_W['uniacid'];
	$params[':sid'] = $sid;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;

	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_goods_category') . ' WHERE ' . $condition, $params);
	$lists = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods_category') . ' WHERE ' . $condition . ' ORDER BY displayorder DESC,id ASC LIMIT '.($pindex - 1) * $psize.','.$psize, $params,'id');
	// for ($i=0;$i<count($lists);$i++){
	// 		$pidtitle = pdo_get('tiny_wmall_goods_category',array('id'=>$lists[$i]['pid']),array('title'));
	// 		if ($pidtitle['title'] == '') {
	// 			$pidtitle['title'] = '顶级分类';
	// 		}
	// 	$lists[$i]['pidtitle'] = $pidtitle['title'];		
	// }
	if(!empty($lists)) {
		$ids = implode(',', array_keys($lists));
		$nums = pdo_fetchall('SELECT count(*) AS num,cid FROM ' . tablename('tiny_wmall_goods') . " WHERE uniacid = :aid AND cid IN ({$ids}) GROUP BY cid", array(':aid' => $_W['uniacid']), 'cid');
		$pidtitle = pdo_fetchall("SELECT * FROM " . tablename('tiny_wmall_goods_category') . " WHERE status=:status",array(":status"=>1),'id');
	}
	$pager = pagination($total, $pindex, $psize);
	if(checksubmit('submit')) {
		if(!empty($_GPC['ids'])) {
			foreach($_GPC['ids'] as $k => $v) {
				$data = array(
					'title' => trim($_GPC['title'][$k]),
					'displayorder' => intval($_GPC['displayorder'][$k])
				);
				pdo_update('tiny_wmall_goods_category', $data, array('uniacid' => $_W['uniacid'], 'id' => intval($v)));
			}
			message('编辑成功', $this->createWebUrl('category'), 'success');
		}
	}
}

if($op == 'del') {
	$id = intval($_GPC['id']);
	pdo_delete('tiny_wmall_goods_category', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'id' => $id));
	pdo_delete('tiny_wmall_goods', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'cid' => $id));
	message('删除商品分类成功', $this->createWebUrl('category'), 'success');
}

if($op == 'export') {
	if(checksubmit()) {
		$file = upload_file($_FILES['file'], 'excel');
		if(is_error($file)) {
			message($file['message'], $this->createWebUrl('category'), 'error');
		}
		$data = read_excel($file);
		if(is_error($data)) {
			message($data['message'], $this->createWebUrl('category'), 'error');
		}
		unset($data[0]);
		if(empty($data)) {
			message('没有要导入的数据', $this->createWebUrl('category'), 'error');
		}
		foreach($data as $da) {
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'sid' => $sid,
				'title' => trim($da[0]),
				'displayorder' => intval($da[1]),
				'status' =>  intval($da[2]),
			);
			pdo_insert('tiny_wmall_goods_category', $insert);
		}
		message('导入商品分类成功', $this->createWebUrl('category'), 'success');
	}
}

if($op == 'status') {
	if($_W['isajax']) {
		$id = intval($_GPC['id']);
		$status = intval($_GPC['status']);
		pdo_update('tiny_wmall_goods_category', array('status' => $status), array('uniacid' => $_W['uniacid'], 'sid' => $sid , 'id' => $id));
		message(error(0, ''), '', 'ajax');
	}
}
include $this->template('store/category');