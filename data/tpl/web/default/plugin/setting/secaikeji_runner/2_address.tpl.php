<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/template/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/template/navs', TEMPLATE_INCLUDEPATH));?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('navs', TEMPLATE_INCLUDEPATH)) : (include template('navs', TEMPLATE_INCLUDEPATH));?>
<div ng-controller="rootCtrl" id="app">
	<div class="panel panel-default">
		<div class="panel-heading">
			城市管理
		</div>
		<div class="panel-body table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>区域名称</th>
						<th>区域经度</th>
						<th>区域纬度</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat ='it in items'>
						<td>{{it.title}}</td>
						<td>{{it.lng}}</td>
						<td>{{it.lat}}</td>
						<td>
							<a class="btn btn-default" ng-click="delete(it)">删除</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
			<button class="btn btn-default" ng-click="showModal()">+添加城市</button>
		</div>
	</div>

	<div class="modal" id="addItem" style="display:none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					添加城市
					<button type="button" class="close" ng-click="close()">×</button>
				</div>
				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">区域名称</label>
							<div class="col-sm-8 col-lg-8 col-xs-12">
								<input type="text" class="form-control" ng-model="item.title"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">默认经纬度</label>
							<div class="col-sm-8 col-lg-8 col-xs-12">
								<div class="row row-fix">
									<div class="col-xs-4 col-sm-4">
										<input type="text" ng-model="item.lng" value="" placeholder="地理经度" class="form-control">
									</div>
									<div class="col-xs-4 col-sm-4">
										<input type="text" ng-model="item.lat" value="" placeholder="地理纬度" class="form-control">
									</div>
									<div class="col-xs-4 col-sm-4">
										<button ng-click="showCoordinate(item);" class="btn btn-default" type="button">选择坐标</button>
									</div>
								</div>							
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-info" ng-click="addItem(item)">提交</button>
				</div>
			</div>
			
		</div>
	</div>

</div>
<script type="text/javascript">
	
	require(['angular'],function(angular){
		var app = angular.module('app',[]);
		app.controller('rootCtrl',function($scope,$http){
			$scope.items = <?php  echo json_encode($list)?>;
			$scope.item = {};

			var addUrl = "<?php  echo $this->createWebUrl('plugin',array('mp'=>'setting','mdo'=>'address','act'=>'add'))?>";
			var delUrl = "<?php  echo $this->createWebUrl('plugin',array('mp'=>'setting','mdo'=>'address','act'=>'delete'))?>";

			$scope.close = function(){
				$('#addItem').hide();
			}
			$scope.showModal = function(){
				$('#addItem').show();
			}

			$scope.addItem = function(item){
				$http.post(addUrl,item).success(function(data){
					$scope.items =$scope.items.concat(data);
				});
				$scope.close();
			}

			$scope.delete = function(it){
				$http.post(delUrl,it).success(function(){
					angular.forEach($scope.items,function(item,index,items){
						$scope.items.splice(index,1);
					});
				});
			}

			$scope.showCoordinate = function(item){
				require(["util"], function(util){
					var val = {};
					val.lng = item.lng;
					val.lat = item.lat;
					util.map(val, function(r){
						$scope.$apply(function(){
							item.lng = r.lng;
							item.lat = r.lat;
						});
					});
				});
			}
		});
		angular.bootstrap($('#app'),['app']);
	});
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>