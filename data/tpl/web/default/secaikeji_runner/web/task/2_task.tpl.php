<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/task/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/task/navs', TEMPLATE_INCLUDEPATH));?>
<style>
.editable-click, a.editable-click {color: #000 !important;border-bottom:none !important;text-decoration: none;}
.editable-input.editable-has-buttons {width: auto;max-width: 100px;}
.st-sort-ascent:before {content: '\25B2';}
</style>
<style>
	.table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {overflow: visible !important;}
	.dropdown-menu{min-width:4em;}
	.table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {white-space: normal !important;overflow: visible !important;}
	.dropdown{display:inline-block !important;}
	.account-stat-num > div {width: 25%;float: left;font-size: 16px;text-align: center;}
	.account-stat-num > div span {display: block;font-size: 30px;font-weight: bold;}
</style>
<div class="panel panel-default" style="padding:1em">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="z-index:1;margin: -1em -1em 1em -1em;">
		<div class="navbar-header">
			<a class="navbar-brand" href="javascript:;">数据统计</a>
		</div>
	</nav>
	<div class="panel-body">
		<div class="account-stat-num row">
			<?php  $m = M('tasks')->totalstatus();?>
			<div>总数<span><?php  echo $m['all']['fee'];?></span></div>
			<div>本日总数<span><?php  echo $m['day']['fee'];?></span></div>
			<div>本周总数<span><?php  echo $m['week']['fee'];?></span></div>
			<div>本月总数<span><?php  echo $m['month']['fee'];?></span></div>
		</div>
	</div>
</div>
<!-- 项目管理 -->
<div class="panel panel-default" ng-app="app" ng-controller="rootCtrl">
	<div class="panel-heading">
		<button class="btn btn-default" onclick="window.location.href='<?php  echo $this->createWebUrl('task')?>'">全部</button>
		<button class="btn btn-default" onclick="window.location.href='<?php  echo $this->createWebUrl('task',array('status'=>'1'))?>'">等待接单</button>
		<button class="btn btn-default" onclick="window.location.href='<?php  echo $this->createWebUrl('task',array('status'=>'2'))?>'">已接单</button>
		<button class="btn btn-default" onclick="window.location.href='<?php  echo $this->createWebUrl('task',array('status'=>'3'))?>'">已完成</button>
		<button class="btn btn-default" onclick="window.location.href='<?php  echo $this->createWebUrl('task',array('status'=>'4'))?>'">已结款</button>
		<audio src="{{src}}" ng-model="audio"></audio>
	</div>
	<div class="panel-body table-responsive">
		<table st-table="items" class="table table-striped table-condensed" style="display:auto;">
			<thead>
				<tr>
					<th style="width:50px;" st-sort="id">任务编号</th>
					<th style="width:120px;">发起人</th>
					<th style="width:80px;" st-sort="icon">头像</th>
					<th style="width:90px;" st-sort="type">任务类型</th>
					<th style="width:220px;" st-sort="desc">简介</th>
					<th style="width:5em;" st-sort="in_num">听单人数</th>
					<th style="width:5em;" st-sort="status">状态</th>
					<th style="width:10em;">截止时间</th>
					<th style="width:320px;" >操作</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in items">
					<td>
						{{item.id}}
					</td>
					<td>
						<span style="cursor:pointer;" ng-click="showUser(item.user)">{{ item.user.nickname || "empty" }}</span>
					</td>
					<td>
						<img ng-src="{{item.user.avatar || '../addons/meepo_voteplatform/icon.jpg'}}" style="width:50px;height:50px;"/>
					</td>
					<td><label class="label {{item.type_label}}">{{item.typetitle}}</label></td>
					
					<td>{{item.desc}}</td>
					<td><label class="label label-default" >{{item.in_num || 0}}</label></td>
					<td><label class="label {{item.status_label}}">{{item.statustitle}}</label></td>
					<td>
					    <label class="label label-success">{{item.limit_time}}</label>
					</td>
					<td>
						<a class="btn btn-default" href="<?php  echo $this->createWebUrl('tasks_paylog')?>&tasks_id={{item.id}}" >支付记录
						</a>
						<a class="btn btn-default" href="<?php  echo $this->createWebUrl('task',array('act'=>'edit'))?>&id={{item.id}}" >任务简述
						</a>
						<a class="btn btn-default" href="<?php  echo $this->createWebUrl('task',array('act'=>'edit_item'))?>&id={{item.id}}" >任务详情
						</a>
						<a class="btn btn-default" href="javascript:;" ng-click="forcusRunner(item.id,$index)">指派跑腿
						</a>
						<a class="btn btn-success" 	href="<?php  echo $this->createWebUrl('tasks_log')?>&taskid={{item.id}}">
							任务进度</a>
						<a class="btn btn-info" href="<?php  echo $this->createWebUrl('star')?>&taskid={{item.id}}" >
							任务评价</a>
						<a class="btn btn-danger" ng-click="refuzed(item.id)" >
							撤销任务</a>
						<a class="btn btn-danger" ng-click="finish(item.id)" >
							完成任务</a>
						<a class="btn btn-danger" title="删除项目" href="javascript:;" ng-click="delete(item.id,$index)">
							<i class="fa fa-times"></i>删除项目
						</a>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr class="text-center">
					<td colspan="9">
						<div st-pagination="" st-items-by-page="itemsByPage" st-displayed-pages="7"></div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<div id="user" ng-cloak ng-if="showSearch" class="modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" ng-click="closeRunner()" >×</button>
					<h3>选择跑腿服务人员</h3></div>
				<div class="modal-body">
					<div class="modal-body">
						<div class="row" style="padding:0px 15px;">
							<div class="input-group">
								<input type="text" class="form-control" ng-model="keyword" value="" id="secect-kw" placeholder="请输入跑腿员昵称进行查询筛选">
              					<span class="input-group-btn">
               	 					<button type="button" ng-click="searchByKeyword(keyword)" class="btn btn-default" id="selectgood">搜索</button>
								</span>
							</div>
						</div>
						<div id="module-menus" style="padding-top:5px; overflow: auto;max-height:500px;">
							<div id="module-menus" style="padding-top:5px; overflow: auto;max-height:500px;"><div class="panel panel-default">
								<div class="panel-body">
									<div class="ng-scope" ng-click="setThisSearch(search)" ng-repeat="search in searchs">
										<div class="meepo_data" style="height:177px; width:137px; float: left; padding: 5px; margin: 5px; background: #f4f4f4; margin-top: 5px;" data-uid="9">
											<div style="height: 127px; width: 127px; background: #eee; float: left; position: relative; cursor: pointer;">
												<img ng-src="{{search.avatar}}" width="100%" height="100%">
											</div>
											<div style="height: 40px; width: 127px; font-size: 13px; line-height: 20px; text-align: center; overflow: hidden;">
												{{search.nickname}}【{{search.realname}}-{{search.mobile}}】       
											</div>
										</div>
									</div>
								</div>
								<div class="panel-footer" style="text-align:center;">
									<a href="javascript:;" ng-click="moreSearch()" class="more">加载更多</a>
								</div>
							</div>

							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary add">确定</button></div>
			</div>
		</div>
	</div>
</div>

<style>

.media img{
	width:80px;
	height:80px;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>/public/libs/angular-xeditable/dist/css/xeditable.css"/>
<script src="<?php echo MODULE_URL;?>public/libs/angular.min.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/public/libs/smart-table.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/public/libs/angular-xeditable/dist/js/xeditable.js"></script>
<script src="<?php echo MODULE_URL;?>/public/libs/ui-bootstrap-tpls.min.js"></script>
<script>
	var app = angular.module('app',['xeditable','smart-table',"ui.bootstrap"]);
	app.run(function(editableOptions) {
		editableOptions.theme = 'bs3';
	});
	app.controller('rootCtrl',function($scope,$http){
		$scope.items = <?php  echo json_encode($list)?>;
		var addurl = "<?php  echo $this->createWebUrl('task',array('act'=>'add'))?>";
		var deleteurl = "<?php  echo $this->createWebUrl('task',array('act'=>'delete'))?>";
		
		$scope.showSearch = false;
		$scope.searchs = [];
		
		$scope.this_taskid = 0;
		
		$scope.forcusRunner = function(id,index){
			$('#user').show();
			$scope.this_taskid = id;
			$scope.showSearch = true;
		}
		
		$scope.setThisSearch = function(search){
			$http.post("<?php  echo $this->createWebUrl('task',array('act'=>'set_this_search'))?>",{user_id:search.id,taskid:$scope.this_taskid}).success(function(data){
				$scope.showSearch = false;
				if(data.status == 1){
					require(['util'],function(util){
						util.message(data.message,"<?php  echo $_W['siteurl']?>",'error');
					});
				}else{
					require(['util'],function(util){
						util.message(data.message,"<?php  echo $_W['siteurl']?>",'success');
					});
				}
			});
		}
		$scope.closeRunner = function(){
			$scope.this_taskid = 0;
			$scope.showSearch = false;
			$('#user').show();
		}
		
		$scope.searchByKeyword = function(key){
			console.log(key);
			$http.post("<?php  echo $this->createWebUrl('task',array('act'=>'search_by_keyword'))?>",{keyword:key}).success(function(data){
				if(data.status == 1){
					$scope.searchs = data.list;
				}else{
					$scope.searchs = data.list;
				}
			});
		}
		
		$scope.showUser = function(user){
			require(['jquery','util'],function($,util){
			
				var body = '<div class="media">'+
  								'<div class="pull-left">'+
    								'<a href="#">'+
      									'<img class="media-object" src="'+user.avatar+'" alt="'+user.nickname+'">'+
    								'</a>'+
  								'</div>'+
  								'<div class="media-body">'+
    								'<h4 class="media-heading">'+user.nickname+'('+user.realname+')</h4>'+
    								'<p>电话：<a href="tel:'+user.mobile+'">'+user.mobile+'</a></p>'+
  								'</div>'+
							'</div>';
							
				var footer = '<button class="btn btn-primary sendmessage ">发送消息</button>';
				footer += '<button class="btn btn-default sysinfo">会员日志</button>';
				footer += '<button class="btn btn-default down">关闭</button>';
				
				var modalobj = util.dialog('会员详情',body,footer,{containerName:'user'});
				modalobj.removeClass('fade');
				modalobj.show();
				
				$('#user .sendmessage').click(function(){
					window.location.href = './index.php?c=mc&a=notice&do=tpl&id='+user.fansid;
				});
				
				$('#user .sysinfo').click(function(){
					window.location.href = './index.php?c=mc&a=member&do=credit_stat&uid='+user.uid+'&type=1';
				});
				
				$('#user .close').click(function(){
					modalobj.hide();
				});
				
				$('#user .down').click(function(){
					modalobj.hide();
				});
				
			});
		}
		
		$scope.tooltip = function(){
			$scope.tooltip = function(){
				$('[data-toggle="tooltip"]').tooltip();
			}
		}
		
		$scope.delete = function(id,start){
			var truthBeTold = window.confirm("您确定要删除此项目么，删除后将删除一切相关数据，用户不退款，所接单作废，单击“确定”继续。单击“取消”停止。");
			if(truthBeTold){
				$http.get(deleteurl+'&id='+id).success(function(data){
					$scope.items.splice(start,1);
				});
			}
		}

		$scope.refuzed = function(id){
			var truthBeTold = window.confirm("您确定要撤销任务吗？撤销后，金额将退回到用户余额，接单员佣金为0");
			if(truthBeTold){
				$http.get(deleteurl+'&id='+id).success(function(data){
					$scope.items.splice(start,1);
				});
			}
		}

		$scope.finish = function(id){
			var truthBeTold = window.confirm("您确定要完成此任务吗？完成后佣金将发送到接单员手中！");
			if(truthBeTold){
				$http.get(deleteurl+'&id='+id).success(function(data){
					$scope.items.splice(start,1);
				});
			}
		}
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>