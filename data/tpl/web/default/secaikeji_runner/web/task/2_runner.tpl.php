<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<?php  load()->func('tpl')?>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/libs/weui/weui.css?t=<?php  echo time()?>"/>
<style>
.map{
	position:absolute;
	top:0;
	bottom:0;
	left:0;
	right:0;
}

.BMapLabel{
	border:none !important;
	background-color: rgba(255, 255, 255, 0) !important;
}

.BMapLabel .avatar{
	width:30px;
	height:30px;
	border-radius:25px;
}
.pullleft{
	z-index: 99999;
	position: absolute;
	width: 200px;
	bottom: 0px;
	top:44px;
	left:0px;
}
.pullright{
	z-index: 99999;
	position: absolute;
	width: 200px;
	bottom: 0px;
	top: 44px;
	right:0px;
}
</style>
<div class="map" id="map"></div>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/libs/weui/weui.css"/>
<div class="pullright">
	<div class="panel panel-default">
		<div class="panel-heading">
			所有跑腿
		</div>
		<div class="panel-body">
			<div class="weui_cells" id="run_list">
				<?php  $runners = M('member')->getList(1," AND isrunner = 1 AND status = 1",array())?>
				<?php  if(is_array($runners['list'])) { foreach($runners['list'] as $run) { ?>
				<div class="weui_cell" data-lat="<?php  echo $run['lat'];?>" data-lng="<?php  echo $run['lng'];?>">
					<div class="weui_cell_hd"><img src="<?php  echo tomedia($run['avatar'])?>" alt="" style="width:20px;margin-right:5px;display:block"></div>
					<div class="weui_cell_bd weui_cell_primary">
						<p><?php  echo $run['nickname'];?></p>
					</div>
				</div>
				<?php  } } ?>
			</div>
		</div>
	</div>
</div>

<div id="task_content">
	<div class="panel panel-default">
		<div class="panel-heading">
			任务列表
		</div>

		<div class="panel-body">
			<table st-table="items" class="table table-striped table-condensed" style="display:auto;">
				<thead>
				<tr>
					<th style="width:6em;">头像</th>
					<th style="width:12em;">截止时间</th>
					<th style="width:20em;">信息</th>
				</tr>
				</thead>
				<tbody>
				<?php  $list = M('tasks')->getall(array('status'=>1))?>
				<?php  if(is_array($list)) { foreach($list as $li) { ?>
				<tr>
					<?php  $member=M('member')->getInfo($li['openid'])?>
					<td>
					    <img src="<?php  echo tomedia($member['avatar'])?>" style="width:4em;height:4em;" class="img-rounded"/>
					</td>
					<td>
					    <label class="label label-success"><?php  echo date('Y-m-d H:i',$li['limit_time'])?></label>
					</td>
					<td>
						<?php  $info = M('tasks')->getInfo($li['id'])?>
						<?php  if(!empty($info['detail']['sendaddress'])) { ?>
						<label class="label label-info">起始地：<?php  echo $info['detail']['sendaddress'];?></label>
						<br/>
						<?php  } ?>
						<?php  if(!empty($info['detail']['sendrealname'])) { ?>
						<label class="label label-info">发货人：<?php  echo $info['detail']['sendrealname'];?></label>
						<br/>
						<?php  } ?>
						<?php  if(!empty($info['detail']['sendmobile'])) { ?>
						<label class="label label-info">发货人电话：<?php  echo $info['detail']['sendmobile'];?></label>
						<br/>
						<?php  } ?>

						<?php  if(!empty($info['detail']['receiveaddress'])) { ?>
						<label class="label label-info">收货地：<?php  echo $info['detail']['receiveaddress'];?></label>
						<br/>
						<?php  } ?>
						<?php  if(!empty($info['detail']['receiverealname'])) { ?>
						<label class="label label-info">收货人：<?php  echo $info['detail']['receiverealname'];?></label>
						<br/>
						<?php  } ?>
						<?php  if(!empty($info['detail']['receivemobile'])) { ?>
						<label class="label label-info">收货人电话：<?php  echo $info['detail']['receivemobile'];?></label>
						<br/>
						<?php  } ?>
						<label class="label label-danger">任务金额：<?php  echo $li['total'];?></label>
						<br/><br/>
						<a href="javascript:;" class="btn btn-default select" data-taskid="<?php  echo $li['id']?>">点击指派</a>
					</td>
				</tr>
				<?php  } } ?>
				</tbody>
			</table>
			<?php  echo $list['pager']?>
		</div>
	</div>
</div>

<input type="hidden" name="province"/>
<input type="hidden" name="city"/>

<script>
	var user_id = '';
	function label_click(id){
		user_id = id;
	}
require(['jquery','map','district','util'],function($,BMap,district,util){

	var map;
	var set_runner_url = "<?php  echo $this->createWebUrl('task',array('act'=>'set_this_search'))?>";
	function location() {
        $.ajax({
            url: 'http://api.map.baidu.com/location/ip?ak=F51571495f717ff1194de02366bb8da9',
            dataType: "jsonp",
            jsonp: "callback",
            timeout: 5000,
            success: function(data) {
            	$('input[name="province"]').val(data.content.address_detail.province);
                $('input[name="city"]').val(data.content.address_detail.city);


                var province = data.content.address_detail.province;
                var city = data.content.address_detail.city;
                
            	map = util.map.instance = new BMap.Map('map');
            	var point = new BMap.Point(116.331398,39.897445);
            	map.centerAndZoom(point, 12);
            	map.setCenter(city);
            	
            	map.enableScrollWheelZoom();
            	map.enableDragging();
            	map.enableContinuousZoom();
            	map.addControl(new BMap.NavigationControl());
            	
            	addRunner();
            }
        });
    }
	location();
	var runners = <?php  echo json_encode($runner)?>;
	var geoc = new BMap.Geocoder();

	$('#run_list .weui_cell').click(function(){
		var lat = $(this).data('lat');
		var lng = $(this).data('lng');
		if(!lat || !lng){
			window.alert('地理位置未获取成功');
			return '';
		}
		var point = new BMap.Point(lng,lat)
		map.panTo(point);
	});
	var title = '指派任务';
	var content = $('#task_content').html();
	var footer = '<button class="btn btn-danger close2">关闭</button>';
	var options = {containerName:'task'};

	task_modal = util.dialog(title, content, footer,options);

	task_modal.find('.close').click(function(){
		task_modal.addClass('fade');
		task_modal.hide();
	});

	task_modal.find('.close2').click(function(){
		task_modal.addClass('fade');
		task_modal.hide();
	});

	task_modal.find('.post').click(function(){
		$.post("",{},function(data){
			util.message(data.message,'',function(){
				task_modal.addClass('fade');
				task_modal.hide();
			});
		},'json');
	});

	task_modal.find('.select').click(function(){
		var taskid = $(this).data('taskid');
		console.log(taskid);
		$.post(set_runner_url,{user_id:user_id,taskid:taskid},function(data){
			if(data.status == 1){
				util.message(data.message,"<?php  echo $_W['siteurl']?>",'error');
			}else{
				util.message(data.message,"<?php  echo $_W['siteurl']?>",'success');
			}
		},'json');
	})
	
	function addRunner(){
		var i = 0;
		for(i;i<runners.length;i++){
			console.log();
			var pt = new BMap.Point(parseFloat(runners[i].lng), parseFloat(runners[i].lat));
			var run = runners[i];
			var opts = {position : pt}
			var str = '<div class="weui_cell">'+
			                '<div class="weui_cell_hd"><img data-id="'+run.id+'" src="'+run.avatar+'" alt="" style="width:40px;border-radius:20px;"></div>'+
			           '</div>';
			var label = new BMap.Label(str,opts);

			label.addEventListener('click',function(){
				$('.weui_cell img').click(function(){
					user_id = $(this).data('id');
					console.log(user_id);
					task_modal.show();
					task_modal.removeClass('fade');
				});
			});
			map.addOverlay(label);
		}
	}
});
</script>