<?php defined('IN_IA') or exit('Access Denied');?><style>
.h44{
	height:44px;
}
.weui_mask_transition {
    display: none;
    position: fixed;
    z-index: 1;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.54);
    -webkit-transition: background .3s;
    transition: background .3s;
    bottom: 0px;
    z-index: 10;
}
.weui_actionsheet_toggle {
    -webkit-transform: translate(0, 0);
    transform: translate(0, 0);
    z-index: 11;
}
</style>
<div class="page">
	<div class="hd">
		<div class="tabs tabs-striped tabs-top" style="top:0px;position:fixed;">
			<a class="tab-item <?php  if(!isset($status)) { ?>active<?php  } ?>" data-pjax href="<?php  echo $this->createMobileUrl('home_order')?>">全部</a>
			<a class="tab-item <?php  if($status == 1) { ?>active<?php  } ?>" data-pjax href="<?php  echo $this->createMobileUrl('home_order',array('status'=>1))?>">等待中</a>
			<a class="tab-item <?php  if($status == 2) { ?>active<?php  } ?>" data-pjax href="<?php  echo $this->createMobileUrl('home_order',array('status'=>2))?>">已被抢</a>
			<a class="tab-item <?php  if($status == 3) { ?>active<?php  } ?>" data-pjax href="<?php  echo $this->createMobileUrl('home_order',array('status'=>3))?>">已完成</a>
			<a class="tab-item <?php  if($status == 4) { ?>active<?php  } ?>" data-pjax href="<?php  echo $this->createMobileUrl('home_order',array('status'=>4))?>">已打款</a>
		</div>
		<div class="h44"></div>
		<div class="list">
			<?php  if(is_array($orders)) { foreach($orders as $order) { ?>
			<div class="item item-avatar" data-id="<?php  echo $order['id']?>">
				<img src="<?php  echo tomedia($order['user']['avatar'])?>" alt="<?php  echo $order['user']['nickname'];?>" />
				<h2 class="title"><?php  echo $order['user']['nickname'];?></h2>
				<p style="white-space: normal;color:gray;"><?php  echo $order['desc'];?></p>
				<span><?php  echo $order['create_time'];?></span>
				<?php  if($order['status'] == 1) { ?>
					<i class="badge badge-assertive" style="margin-top: -10px;">等待中</i>
				<?php  } else if($order['status'] == 2) { ?>
					<i class="badge badge-royal" style="margin-top: -10px;">已被抢</i>
				<?php  } else if($order['status'] == 3) { ?>
					<i class="badge badge-positive" style="margin-top: -10px;">已完成</i>
				<?php  } else if($order['status'] == 4) { ?>
					<i class="badge badge-dark" style="margin-top: -10px;">已打款</i>
				<?php  } else { ?>
					<i class="badge badge-stable" style="margin-top: -10px;">支付失败</i>
				<?php  } ?>
			</div>
			<?php  } } ?>
		</div>
		<div style="height:44px;"></div>
	</div>
</div>
<script>
require(['jquery','core'],function($,core){
	$('#footer').hide();
	//data-pjax href="<?php  if($order['status'] == 0) { ?><?php  } else if($order['status'] == 1) { ?><?php  echo $this->createMobileUrl('manage',array('id'=>$order['id']))?><?php  } else { ?><?php  echo $this->createMobileUrl('home_detail',array('id'=>$order['id']))?><?php  } ?>"
	$('.list .item').click(function(){
		var id = $(this).data('id');
		var _this = $(this);
		core.actionSheet([{
            label: '管理任务',
            onClick: function () {
            	window.location.href = "<?php  echo $this->createMobileUrl('detail')?>&id="+id+'#mp.weixin.qq.com';
            }
        },{
			label: '确认完成',
			onClick: function () {
				core.ok("您确认此订单已完成了么！",function(){
					core.post('home_finish',{id:id},function(data){
						if(data.result == 1){
							core.cancel(data.message,function(){
								window.location.href = "<?php  echo $this->createMobileUrl('home_order')?>&status="+"<?php  echo $_GPC['status']?>";
							});
						}else{
							core.cancel(data.message,function(){});
						}
					});
				});
			}
		}, {
            label: '删除任务',
            onClick: function () {
            	core.ok("您确定要删除此任务么？删除任务将清空一切活动相关数据！",function(){
            		core.post('home_delete',{id:id},function(data){
                		if(data.result == 0){
                			core.cancel(data.message,function(){
                				window.location.href = "<?php  echo $this->createMobileUrl('home_order')?>&status="+"<?php  echo $_GPC['status']?>";
                			});
                		}else{
                			core.cancel(data.message,function(){});
                		}
                	});
            	});
            }
        }]);
	});
	
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/footerbar', TEMPLATE_INCLUDEPATH)) : (include template('default/common/footerbar', TEMPLATE_INCLUDEPATH));?>