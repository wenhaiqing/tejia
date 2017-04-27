<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/task/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/task/navs', TEMPLATE_INCLUDEPATH));?>
<style>
.editable-click, a.editable-click {
    color: #000 !important;
    border-bottom:none !important;
    text-decoration: none;
}
.editable-input.editable-has-buttons {
    width: auto;
    max-width: 100px;
}
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
			<?php  $m = M('member')->totalstatus();?>
			<div>总数<span><?php  echo $m['all']['sum'];?></span></div>
			<div>今日新增<span><?php  echo $m['day']['sum'];?></span></div>
			<div>本周新增<span><?php  echo $m['week']['sum'];?></span></div>
			<div>本月新增<span><?php  echo $m['month']['sum'];?></span></div>
		</div>
	</div>
</div>
<div class="panel panel-default" ng-app="app" ng-controller="rootCtrl">
	<div class="panel-heading">
		会员管理
	</div>
	<div class="panel-body">
		<table st-table="items" class="table table-striped">
			<thead>
				<tr>
					<th style="width:50px;" st-sort="uid">会员编号</th>
					<th style="width:140px;" st-sort="nickname">会员昵称</th>
					<th style="width:140px;" st-sort="realname">真实姓名</th>
					<th style="width:140px;" st-sort="mobile">手机号</th>
					<th style="width:100px;">信誉</th>
					<th style="width:80px;" st-sort="avatar">会员头像</th>
					<th style="width:100px;" st-sort="status">状态</th>
					<th style="width:80px;" st-sort="isrunner">是否跑腿</th>
					<th style="width:80px;" st-sort="forbid">拉黑</th>
					<th>操作</th>
				</tr>
				<tr>
					<th  colspan="2">
						<input st-search="nickname" placeholder="昵称" class="input-sm form-control" type="search"/>
					</th>
					<th colspan="1">
						<input st-search="realname" placeholder="真实姓名" class="input-sm form-control" type="search"/>
					</th>
					<th colspan="2">
						<input st-search="mobile" placeholder="手机号" class="input-sm form-control" type="search"/>
					</th>
					<th></th>
					<th colspan="2">
						<select st-search="isrunner" class="form-control">
							<option value="">是否跑腿</option>
							<option value="0">否</option>
							<option value="1">是</option>
						</select>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in items">
					<td>
						{{item.uid}}
					</td>
					<td>
						{{ item.nickname || "未获取" }}
					</td>
					<td>
						{{ item.realname || "未完善" }}
					</td>
					<td>
						{{ item.mobile || "未完善" }}
					</td>
					<td>
						<a href="#" editable-text="item.xinyu" onbeforesave="updatexinyu(item,$data)">{{ item.xinyu || "0.00" }}</a>
					</td>
					<td>
						<img ng-src="{{item.avatar || '../addons/meepo_voteplatform/icon.jpg'}}" style="width:50px;height:50px;"/>
					</td>
					<td><label class="label {{item.status_label}}" ng-click="status(item)">{{item.statustitle}}</label></td>
					<td><label class="label {{item.isrunner_label}}" ng-click="isrunner(item)">{{item.isrunnertitle}}</label></td>
					<td><label class="label {{item.forbid_label}}" ng-click="forbid(item)">{{item.forbidtitle}}</label></td>
					<td>
						<a href="<?php  echo $this->createWebUrl('task',array('act'=>'list'))?>&openid={{item.openid}}" class="btn btn-default">任务记录</a>
						<a href="<?php  echo $this->createWebUrl('paylog')?>&openid={{item.openid}}" class="btn btn-default">支付记录</a>
						<a class="btn btn-default" ng-mouseenter="tooltip()" data-toggle="tooltip" data-placement="top" title="删除项目" href="#" ng-click="delete(item.id,$index)">
							<i class="fa fa-times"></i>
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
	<div class="panel-footer">
	
	</div>
</div>
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
		var addurl = "<?php  echo $this->createWebUrl('member',array('act'=>'add'))?>";
		var deleteurl = "<?php  echo $this->createWebUrl('member',array('act'=>'delete'))?>";
		
		$scope.tooltip = function(){
			$scope.tooltip = function(){
				$('[data-toggle="tooltip"]').tooltip();
			}
		}
		
		$scope.delete = function(id,start){
			var truthBeTold = window.confirm("您确定要删除此会员么，单击“确定”继续。单击“取消”停止。");
			if(truthBeTold){
				$http.get(deleteurl+'&id='+id).success(function(data){
					$scope.items.splice(start,1);
				});
			}
		}
		
		$scope.isrunner = function(e){
			if(e.isrunner == 0){
				e.isrunner = 1;
				e.isrunnertitle = '是';
				e.isrunner_label = 'label-info';
			}else{
				e.isrunner = 0;
				e.isrunnertitle = '否';
				
				e.isrunner_label = 'label-danger';
			}
			$http.post(addurl,e).success(function(data){});
		}
		
		$scope.forbid = function(e){
			if(e.forbid == 0){
				e.forbid = 1;
				e.forbidtitle = '已拉黑';
				e.forbid_label = 'label-danger';
			}else{
				e.forbid = 0;
				e.forbidtitle = '正常';
				
				e.forbid_label = 'label-info';
			}
			$http.post(addurl,e).success(function(data){});
		}
		
		$scope.updatexinyu = function(e,t){
			e.xinyu = t;
			$http.post(addurl,e).success(function(data){});
		}
		
		$scope.status = function(e){
			if(e.status == 0){
				e.status = 1;
				e.statustitle = '审核通过';
				e.status_label = 'label-info';
			}else{
				e.status = 0;
				e.statustitle = '待审核';
				
				e.status_label = 'label-danger';
			}
			$http.post(addurl,e).success(function(data){});
		}
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>