<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<body ng-app="app" >
<div  class="container container-fill">

<link href="//cdn.bootcss.com/weui/0.4.2/style/weui.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/libs/ionic/css/ionic.css?t=<?php  echo time()?>"/>
<link href="<?php echo MODULE_URL;?>public/css/basic.css" rel="stylesheet">
<link href="<?php echo MODULE_URL;?>public/css/layout.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>public/css/divider.css">
<div class="wrapper" ng-controller="appCtrl" ng-cloak>
    <div class="main" id="main" style="">
        <div class="fix-box veh-box border-r5">
            <dl class="veh-col_01">
                <dt ng-click="text(params.time)">
                    <span ng-bind="params.time.title"></span>
                </dt>
                <dd>
                    <span>
                        <label ng-click="text(params.time.item1)">
                            <input type="radio" ng-model="post.time" value="0" checked/>
                            <span ng-bind="params.time.item1.title"></span>
                        </label>
                    </span>
                    <span>
                        <label ng-click="text(params.time.item2)">
                            <input type="radio" ng-model="post.time" value="1"/>
                            <span ng-bind="params.time.item2.title"></span>
                        </label>
                    </span>
                </dd>
            </dl>
        </div>
        <div class="fix-box veh-box mt10 border-r5" style="display:none;">
            <dl class="veh-col_01">
                <dt ng-click="text(params.datatime)">
                    <span ng-bind="params.datatime.title"></span>
                </dt>
                <dd>
                    <p ng-model="post.dataTime" style="color: #F4A527;" id="yuyuetxt"></p>
                </dd>
            </dl>
        </div>
        <div class="fix-box veh-box mt10 border-r5">
            <dl class="veh-col_02 border-bm" style="padding-bottom: 0.6rem;">
                <dt ng-click="text(params.city)">
                    <span ng-bind="params.city.title"></span>
                </dt>
                <dd>
                    <p ng-model="post.city" style="color: #8a8a8a"></p>
                </dd>
            </dl>
            <dl class="veh-col_02 ptb15 border-bm">
                <dt ng-click="text(params.sendaddress)">
                    <span ng-bind="params.sendaddress.title"></span>
                </dt>
                <dd>
                    <p name="sendaddress" ng-click="text(params.sendaddress.placeholder)" ng-bind="params.sendaddress.placeholder.title"></p>
                </dd>
            </dl>
            <dl class="veh-col_02" style="padding-top: 12px;">
                <dt ng-click="text(params.receiveaddress)">
                    <span ng-bind="params.receiveaddress.title"></span></dt>
                <dd>
                    <p name="receiveaddress" ng-click="text(params.receiveaddress.placeholder)" ng-bind="params.receiveaddress.placeholder.title"></p>
                </dd>
            </dl>
        </div>
        <div class="weui_cells weui_cells_form">
            <?php  if(!empty($setting['open_goodsname'])) { ?>
                <div class="weui_cell">
                    <div class="weui_cell_hd" ng-click="text(params.goodstitle)"><label class="weui_label" ng-bind="params.goodstitle.title"></label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="text" ng-click="text(params.goodstitle.placeholder)" ng-model="post.goodstitle" placeholder="{{params.goodstitle.placeholder.title}}">
                    </div>
                </div>
            <?php  } ?>
            <?php  if(!empty($setting['open_goodscost'])) { ?>
                <div class="weui_cell">
                    <div class="weui_cell_hd" ng-click="text(params.goodscost)"><label class="weui_label" ng-bind="params.goodscost.title"></label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" ng-click="text(params.goodscost.placeholder)" type="number" ng-model="post.goodscost" placeholder="{{params.goodscost.placeholder.title}}">
                    </div>
                </div>
            <?php  } ?>
            <?php  if(!empty($setting['open_goodsweight'])) { ?>
                <div class="weui_cell">
                    <div class="weui_cell_hd" ng-click="text(params.goodsweight)"><label class="weui_label" ng-bind="params.goodsweight.title"></label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" ng-click="text(params.goodsweight.placeholder)" id="weightNumber" type="number" ng-model="post.goodsweight" placeholder="{{params.goodsweight.placeholder.title}}">
                    </div>
                </div>
            <?php  } ?>
            <?php  if(!empty($setting['open_small_money'])) { ?>
                <div class="weui_cell">
                    <div class="weui_cell_hd"  ng-click="text(params.small_money)"><label class="weui_label" ng-bind="params.small_money.title"></label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" ng-click="text(params.small_money.placeholder)" type="text" ng-model="post.small_money" placeholder="{{params.small_money.placeholder.title}}">
                    </div>
                </div>
            <?php  } ?>
        </div>
        <?php  if(!empty($setting['open_images'])) { ?>
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <div class="weui_uploader">
                        <div class="weui_uploader_hd weui_cell">
                            <div class="weui_cell_bd weui_cell_primary"  ng-click="text(params.thumbs)">
                                <span ng-bind="params.thumbs.title"></span>
                            </div>
                            <div class="weui_cell_ft">
                                <span ng-bind="thumbs_length"></span>
                            </div>
                        </div>
                        <div class="weui_uploader_bd">
                            <ul class="weui_uploader_files">
                                <li></li>
                            </ul>
                            <div class="weui_uploader_input_wrp">
                                <input class="weui_uploader_input" type="file" accept="image/jpg,image/jpeg,image/png,image/gif" multiple="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php  } ?>
        <?php  if(!empty($setting['open_message'])) { ?>
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary" ng-click="text(params.message.placeholder)">
                    <textarea class="weui_textarea" ng-model="post.message" id="message" placeholder="{{params.message.placeholder.title}}" rows="3"></textarea>
                    <div class="weui_textarea_counter"><span ng-bind="message_num"></span></div>
                </div>
            </div>
        </div>
        <?php  } ?>
        <input type="hidden" name="range" />
        <p class="veh-check-info">
            查看
            <a href="javascript:;" data-check="true" ng-click="text(params.help_warning)">
            《{{params.help_warning.title}}》
            </a>
        </p>
        <a href="javascript:;" ng-click="text(params.postBtn)" class="weui_btn weui_btn_primary" style="margin-top:15px;" id="cost-calculation">
            <span ng-bind="params.postBtn.title"></span>
        </a>
        <div class="h44"></div>
    </div>

    <div class="weui_dialog_confirm" id="text_tpl" ng-cloak ng-show="open_text_tpl">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">修改标题</strong></div>
            <div class="weui_dialog_bd">
                <input class="weui_input" type="text" ng-model="title" placeholder="请输入标题">
            </div>
            <div class="weui_dialog_ft">
                <a href="javascript:;" class="weui_btn_dialog default" ng-click="closeDialog()">取消</a>
                <a href="javascript:;" class="weui_btn_dialog primary" id="sureText">确定</a>
            </div>
        </div>
    </div>
    <div class="tabs tabs-dark" style="border:none;display:none;z-index: 99;position: fixed;xbottom: 0px;left: 0px;right: 0px;" id="footer">
        <a class="tab-itemactive" ng-click="postSave(params)">
            <span class="light">保存数据</span>
        </a>
    </div>
</div>
<style type="text/css">
.active{
    color:#04BE02 !important;
}
.tabs-striped .tab-item.tab-item-active, .tabs-striped .tab-item.active, .tabs-striped .tab-item.activated {
    margin-top: -2px;
    border-style: solid;
    border-width: 2px 0 0 0;
    border-color: #04BE02;
}
</style>

<script src="//cdn.bootcss.com/angular.js/1.5.5/angular.min.js"></script>
<script type="text/javascript">
    $('#footer').show();
    var app = angular.module('app',[]);
    app.config(['$sceProvider',function($sceProvider){
                $sceProvider.enabled(false);
            }]);
    app.controller('appCtrl',function($scope,$http,$sce){

        $scope.params = <?php  echo json_encode($params)?>;

        $scope.params.help_warning = $scope.params.help_warning ||{
                    title:'禁止发布的事项信息'
                }

        $scope.params = $scope.params.install?$scope.params:{
            install:true,
            time:{
                title:'取货时间:',
                item1:{
                    title:'及时取'
                },
                item2:{
                    title:'预约取'
                }
            },
            datatime:{
                title:'预约时间:'
            },
            city:{
                title:'当前城市:'
            },
            help_warning:{
                title:'禁止发布的事项信息'
            },
            sendaddress:{
                title:'发货地:',
                placeholder:{
                    title:'请输入发货地'
                }
            },
            receiveaddress:{
                title:'收货地:',
                placeholder:{
                    title:'请输入收货地'
                }
            },
            goodstitle:{
                title:'物品名称:',
                placeholder:{
                    title:'请填写物品名称'
                }
            },
            goodscost:{
                title:'价值:',
                placeholder:{
                    title:'请输入货物价值'
                }
            },
            goodsweight:{
                title:'重量:',
                placeholder:{
                    title:'请输入货物重量'
                }
            },
            small_money:{
                title:'小费:',
                placeholder:{
                    title:'加价不加量'
                }
            },
            thumbs:{
                title:'附件',
            },
            message:{
                placeholder:{
                    title:'请输入备注'
                }
            },
            postBtn:{
                title:'算算费用'
            }
        };

        $scope.message_num = 0;
        $scope.thumbs_length = 0;
        $scope.open_text_tpl = false;


        $scope.change = function(message){
            $scope.message_num = message.length();
        }

        $scope.safeApply = function(fn) {
            var phase = this.$root.$$phase;
            if (phase == '$apply' || phase == '$digest') {
                if (fn && (typeof(fn) === 'function')) {
                    fn();
                }
            } else {
                this.$apply(fn);
            }
        };
        /**
         * 导航修改
         * */
        $scope.text = function(name){
            $scope.editItem = name;
            $scope.title = name.title;
            $('#text_tpl #sureText').click(function(){
                $scope.safeApply(function(){
                    $scope.editItem.title = $scope.title;
                    name = $scope.editItem;
                    $scope.open_text_tpl = false;
                });
            });
            $scope.open_text_tpl = true;
        }

        $scope.closeDialog = function(){
            $scope.open_text_tpl = false;
        }

        $scope.postSave = function(params){
            $http.post("<?php  echo $this->createWebUrl('plugin',array('mp'=>'template','mdo'=>'divider_template'))?>",params).success(function(data){
                if(data.message == '保存成功'){
                    require(['util'],function(util){
                        util.message(data.message,data.redirect,'info');
                    });
                }else{
                    require(['util'],function(util){
                        util.message(data.message,'','info');
                    });
                }
            });
        }

        //字数统计
        $('#message').on('keyup keydown change',function(){
            $scope.message_num = $scope.post.message.length;
        });
    });

    angular.bootstrap($('#app'),['app']);
    
</script>
</body>
</html>