<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/header1', TEMPLATE_INCLUDEPATH)) : (include template('default/common/header1', TEMPLATE_INCLUDEPATH));?>
<link href="//cdn.bootcss.com/weui/0.4.2/style/weui.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/libs/ionic/css/ionic.css"/>
<link href="<?php echo MODULE_URL;?>public/css/basic.css" rel="stylesheet">
<link href="<?php echo MODULE_URL;?>public/css/layout.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>public/css/divider.css">

<style type="text/css">
    .box ul li{display: inline-block;margin-left: 5px;border-bottom-width: 0.5px;border-bottom-style: solid;border-bottom-color: gray;}
    .search-city-list {position: absolute;top: 3.25rem;left: 0;width: 100%;z-index: 199;padding: 0.5rem;}
    .mainmap{position: absolute;top: 44px;left: 0px;right: 0px;z-index: 999;}
    #r-result {width: 100%;}
    .popcity {z-index: 100;}
    .popcity-mask {z-index: 99;}
    .container{position: absolute;left: 0px;right: 0px;bottom: 0px;top: 0px;}
    .button.button-calm.button-clear {border-color: transparent;background: none;box-shadow: none;color: #8c6b5b;}
</style>
<style>
    .button.button-calm.button-outline {
        border-color: #D68202;
        background: transparent;
        color: #D68202;
    }
    .button {
        border-color: transparent;
        background-color: #f8f8f8;
        color: #444;
        position: relative;
        display: inline-block;
        margin: 0;
        padding: 0 12px;
        min-width: 52px;
        min-height: 17px;
        border-width: 1px;
        border-style: solid;
        border-radius: 4px;
        vertical-align: top;
        text-align: center;
        text-overflow: ellipsis;
        font-size: 16px;
        line-height: 32px;
        cursor: pointer;
    }
    .weui_input{
        text-align:left;
    }
</style>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&key=4MHBZ-JVL35-WLMII-Q3NME-3Z2G2-PKBJJ"></script>
<div class="hd" id="app1">
    <div class="hd" v-show="showMain" style="display:none;">
        <div class="fix-box veh-box border-r5">
            <dl class="veh-col_01">
                <dt><span>{{params.time.title}}</span></dt>
                <dd>
                    <span>
                        <label id="jishibut">
                            <input type="radio" v-on:click="setTimeType(0)" name="time" value="0" checked/>
                            <span >{{params.time.item1.title}}</span>
                        </label>
                    </span>
                    <span>
                        <label id="yuyuebut" >
                            <input type="radio" v-on:click="setTimeType(1)" name="time" value="1"/>
                            <span >{{params.time.item2.title}}</span>
                        </label>
                    </span>
                </dd>
            </dl>
        </div>
        <div class="fix-box veh-box mt10 border-r5" v-show="pl_yuyue">
            <dl class="veh-col_01">
                <dt><span>{{params.datatime.title}}</span></dt>
                <dd v-on:click="setTimeType(1)">
                    <p style="color: #F4A527;">{{ post.datatime.text }}</p>
                </dd>
            </dl>
        </div>
        <div class="weui_cells">
            <div class="weui_cell" v-on:click="changeCity(post)">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>{{params.city.title}}</p>
                </div>
                <div class="weui_cell_ft">
                    <span style="color: #8a8a8a" >{{post.city.title}}</span>
                </div>
            </div>
        </div>
        <div class="weui_cells_title" v-if="params.receiveaddress.title">
            <span >{{params.sendaddress.title}}</span>
            <span style="float:right;color:red;" v-on:click="openMyaddrlist(true)">常用地址</span>
        </div>
        <div class="weui_cells">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary" >
                    <input class="weui_input" style="text-align:left;" type="text" v-model="post.sendaddress.title" placeholder="请选择地址">
                </div>
                <div class="weui_cell_ft active" @click="openSendAddress()">地图选址</div>
            </div>
            <div class="weui_cell" v-if="showSendDetailInput">
                <div class="weui_cell_hd"><label class="weui_label">详细地址</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="text" v-model="post.sendaddress.detail" placeholder="请输入详细地址">
                </div>
            </div>
            <div class="weui_cell" v-if="showSendDetailInput">
                <div class="weui_cell_hd"><label class="weui_label">发货人姓名</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="text" v-model="post.sendaddress.realname" placeholder="请输入发货人姓名">
                </div>
            </div>
            <div class="weui_cell" v-if="showSendDetailInput">
                <div class="weui_cell_hd"><label class="weui_label">发货人电话</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input mobile" type="number" style="width: 60%;display: inline;" v-model="post.sendaddress.mobile" placeholder="请输入发货人电话">
                    <?php  if(!empty($this->sms['post_open'])) { ?><button class="button button-outline button-calm" id="send" @click="sendCode()" style="float:right;">立即发送</button><?php  } ?>
                </div>
            </div>
            <?php  if(!empty($this->sms['post_open'])) { ?>
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">手机验证码</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" v-model="post.code" value="" type="text" placeholder="请输入您的手机验证码">
                </div>
            </div>
            <?php  } ?>
        </div>

        <div class="weui_cells_title" v-if="params.receiveaddress.title">
            <span >{{params.receiveaddress.title}}</span>
            <span style="float:right;color:red;" v-on:click="openMyaddrlist()">常用地址</span>
        </div>

        <div class="weui_cells">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary" >
                    <input class="weui_input" style="text-align:left;" type="text" v-model="post.receiveaddress.title" placeholder="请选择地址">
                </div>
                <div class="weui_cell_ft active" v-on:click="openReciveAddress(post)">地图选址</div>
            </div>
            <div class="weui_cell" v-if="showReciveDetailInput">
                <div class="weui_cell_hd"><label class="weui_label">详细地址</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="text" v-model="post.receiveaddress.detail" placeholder="请输入详细地址">
                </div>
            </div>
            <div class="weui_cell" v-if="showReciveDetailInput">
                <div class="weui_cell_hd"><label class="weui_label">收件人姓名</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="text" v-model="post.receiveaddress.realname" placeholder="请输入收件人姓名">
                </div>
            </div>
            <div class="weui_cell" v-if="showReciveDetailInput">
                <div class="weui_cell_hd"><label class="weui_label">收件人电话</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="text" v-model="post.receiveaddress.mobile" placeholder="请输入收件人电话">
                </div>
            </div>
        </div>
        <span style="margin: 0 auto;display: block;color: red;text-align: center;margin-top: 15px;" v-show="post.result">{{post.result}}</span>
        <div class="weui_cells weui_cells_form">
            <?php  if(!empty($setting['open_goodsname'])) { ?>
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label class="weui_label">{{params.goodstitle.title}}</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="text" v-model="post.goodstitle" placeholder="{{params.goodstitle.placeholder.title}}">
                    </div>
                </div>
            <?php  } ?>
            <?php  if(!empty($setting['open_goodscost'])) { ?>
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label class="weui_label">{{params.goodscost.title}}</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" type="number" v-model="post.goodscost" placeholder="{{params.goodscost.placeholder.title}}}">
                    </div>
                </div>
            <?php  } ?>
            <?php  if(!empty($setting['open_goodsweight'])) { ?>
                <div class="weui_cell">
                    <div class="weui_cell_hd"><label class="weui_label">{{params.goodsweight.title}}</label></div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <input class="weui_input" id="weightNumber" type="number" v-model="post.goodsweight" placeholder="{{params.goodsweight.placeholder.title}}">
                    </div>
                </div>
            <?php  } ?>
            <?php  if(!empty($setting['open_small_money'])) { ?>
                <div class="send-cost-price border-r5">
                    <div id="pricecon"></div>
                    <div class="price-info" id="priceinfo">
                        亲，加价会让自由跑腿人跑的更快哦！
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
                            <div class="weui_cell_bd weui_cell_primary">
                                <span>{{params.thumbs.title}}</span>
                            </div>
                            <div class="weui_cell_ft">
                                <span >{{thumbs_length}}</span>
                            </div>
                        </div>
                        <div class="weui_uploader_bd">
                            <ul class="weui_uploader_files">
                                <li v-for="img in post.thumbs" class="weui_uploader_file" style="">
                                    <img style="height:100%;" :src="img.src">
                                </li>
                            </ul>
                            <div class="weui_uploader_input_wrp">
                                <input class="weui_uploader_input" id="upload_image" type="file" accept="image/*" multiple="">
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
                <div class="weui_cell_bd weui_cell_primary">
                    <textarea class="weui_textarea" v-model="post.message" id="message" placeholder="{{params.message.placeholder.title}}" rows="3"></textarea>
                    <div class="weui_textarea_counter"><span>{{message_num}}</span></div>
                </div>
            </div>
        </div>
        <?php  } ?>
        <input type="hidden" name="range" />
        <p class="veh-check-info" v-on:click="openWarning()">
            查看<a href="javascript:;" >《{{params.help_warning.title}}》</a>
        </p>
        <a href="javascript:;" class="weui_btn weui_btn_primary" v-on:click="postTasks(post)" style="margin-top:15px;" id="cost-calculation">
            <span>{{params.postBtn.title}}</span>
        </a>
        <div class="h44"></div>
        <div class="h44"></div>
        <div class="h44"></div>
    </div>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/footerbar', TEMPLATE_INCLUDEPATH)) : (include template('default/common/footerbar', TEMPLATE_INCLUDEPATH));?>
    <style type="text/css">
        .weui_cell_primary{
            min-width:5em;
        }
        .weui_cell_ft span{
            color:red;
        }
        .button.button-calm {
            border-color: transparent;
            background-color: #04BE02;
            color: #fff;
        }
        .panel{
            z-index: 99;
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
        }
    </style>
    <div class="hd" v-show="showWarning" style="display:none;">
        <div class="bar bar-header" style="position:fixed;top:0px;">
            <h2 class="title">禁止发布的事项信息</h2>
            <button class="button button-calm" v-on:click="closeWarning()">
                同意
            </button>
        </div>
        <div class="col" class="padding " style="background-color: #fff;margin-top:50px;">
            <?php  echo $setting['post_notice']?>
        </div>
    </div>
    <div class="hd" id="confirm_container" style="display:none;">
        <div class="msg">
        <div class="weui_cells" style="text-align: left;">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>任务类型</p>
                </div>
                <div class="weui_cell_ft">
                    <span v-if="confirmdata.detail.time == 0">{{params.time.item1.title}}</span>
                    <span v-if="confirmdata.detail.time == 1">{{params.time.item2.title}}</span>
                </div>
            </div>

            <div class="weui_cell" v-if="confirmdata.detail.sendaddress">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>{{params.sendaddress.title}}</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.detail.sendaddress}}</span>
                </div>
            </div>

            <div class="weui_cell" v-if="confirmdata.detail.goodsname">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>{{params.goodstitle.title}}</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.detail.goodsname}}</span>
                </div>
            </div>
            <div class="weui_cell" v-if="confirmdata.detail.receiveaddress">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>{{params.receiveaddress.title}}</p>
                </div>
                <div class="weui_cell_ft">
                   <span>{{confirmdata.detail.receiveaddress}}</span>
                </div>
            </div>

            <div class="weui_cell" v-if="confirmdata.detail.distance">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>总路程</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.detail.distance}}</span>km
                </div>
            </div>
                       
            <div class="weui_cell" v-if="confirmdata.detail.goodscost">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>{{params.goodscost.title}}</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.detail.goodscost}}</span>元
                </div>
            </div>
            <div class="weui_cell" v-if="confirmdata.detail.goodsweight">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>{{params.goodsweight.title}}</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.detail.goodsweight}}</span>公斤
                </div>
            </div>

            <div class="weui_cell" v-if="confirmdata.detail.small_money">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>{{params.small_money.title}}</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.detail.small_money}}</span>元
                </div>
            </div>

            <div class="weui_cell" v-if="confirmdata.message">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>统计信息</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.message}}</span>
                </div>
            </div>
        </div>
        <div class="weui_cells" style="text-align: left;">
            <div class="weui_cell" v-if="confirmdata.paylog.tid">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>订单编号</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.paylog.tid}}</span>
                 </div>
            </div>
            <div class="weui_cell" v-if="confirmdata.detail.base_fee">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>起步价</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.detail.base_fee}}</span>元
                </div>
            </div>
            <div class="weui_cell" v-if="confirmdata.detail.small_money">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>{{params.small_money.title}}</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.detail.small_money}}</span>元
                </div>
            </div>
            <div class="weui_cell" v-if="confirmdata.detail.fee">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>超出价</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.detail.fee}}</span>元
                </div>
            </div>
            <div class="weui_cell" v-if="confirmdata.paylog.fee">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>总费用</p>
                </div>
                <div class="weui_cell_ft">
                    <span>{{confirmdata.paylog.fee}}</span>元
                </div>
            </div>
        </div>
        <div class="weui_opr_area">
            <p class="weui_btn_area">
                <a href="javascript:;" class="weui_btn weui_btn_primary" v-on:click="payOrder(confirmdata.tid)">立即支付</a>
                <a href="javascript:;" class="weui_btn weui_btn_default" v-on:click="cancelOrder(confirmdata.tid)">取消订单</a>
                </p>
            </div>
        </div>
        <div class="h44"></div>
        <div style="height:44px;"></div>
    </div>

    <iframe id="mapPage" width="100%" height="100%" v-if="showMap" style="display:none;position:absolute;display:block;" frameborder='0' src="http://apis.map.qq.com/tools/locpicker?search=1&type=1&key=4MHBZ-JVL35-WLMII-Q3NME-3Z2G2-PKBJJ&referer=myapp"></iframe>

    <div class="panel"  v-show="showMyaddrlist" style="display:none;z-index:99;">
        <div class="navbar">
            <div class="bd" style="height: 100%;">
                <div class="weui_tab">
                    <div class="weui_navbar">
                        <div class="weui_navbar_item" style="color:red;" v-on:click="colseMyaddrlist()">
                            返回关闭
                        </div>
                        <div class="weui_navbar_item weui_bar_item_on" @click="myaddr_list()">
                            我的常用地址
                        </div>
                        <div class="weui_navbar_item"  @click="myaddr_used()">
                            历史地址
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="weui_panel weui_panel_access">
            <div class="weui_panel_hd">我的常用地址</div>
            <div class="weui_panel_bd">
                <div class="weui_media_box weui_media_text" v-on:click="choseThisAddr(li)" v-for="li in myadds">
                    <h4 class="weui_media_title">{{li.poiaddress}}</h4>
                    <p class="weui_media_desc">{{li.detail}}-{{li.realname}}【{{li.mobile}}】</p>
                </div>
            </div>
        </div>
    </div>
    <div v-show="showPopCity" style="display:none;">
        <div class="popcity">
            <div class="city">
                <h2 style="background: #137112 !important;">请选择城市</h2>
                <div class="box" id="chooseCity">
                    <ul>
                        <li v-on:click="choseCity(city)" v-for="city in citys">{{city.title}}</li>
                    </ul>
                </div>
                <a href="javascript:;" style="line-height: 2em;margin-right: 0.5em;color: #fff;" v-on:click="closeCity()">关闭</a>
            </div>
        </div>
        <div class="popcity-mask"></div>
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
<script type="text/javascript">
require(['vue','jquery','weixin','core','js/tool','js/template','js/index','js/convertor','base64upload','js/xiaofei','js/ion.rangeSlider'],
        function(Vue,$,wx,core,R){

    $('#app1').show();

    var params = <?php  echo json_encode($params)?>;
    var citys = JSON.parse('<?php  echo json_encode($citys)?>');
    var defaultcity = JSON.parse('<?php  echo json_encode($defaultcitys)?>');
    var myadds = JSON.parse('<?php  echo json_encode($myadds)?>');
    var yuyueobj = R.appointment.bind($('#yuyuebut'));
    
    var sendaddress =  !core.empty(window.localStorage.sendaddress)?eval('(' + localStorage.sendaddress + ')'): {title:params.sendaddress.placeholder.title,lat:'',lng:'',city:'',detail:'',mobile:''};
            console.log(sendaddress);
            
    var receiveaddress =  !core.empty(window.localStorage.receiveaddress)?eval('(' + localStorage.receiveaddress + ')'):{title:params.receiveaddress.placeholder.title,lat:'',lng:'',city:'',detail:'',mobile:''};
            console.log(receiveaddress);
    wx.config(jssdkconfig);
            
    var vm = new Vue({
        el:'#app1',
        data: {
            params:params,
            citys:citys,
            defaultcity:defaultcity,
            myadds:myadds,
            message_num: 0,
            thumbs_length: 0,
            pl_yuyue: false,
            showPopCity: false,
            showMap: false,
            showMain: true,
            marker: null,
            isstartAddress:false,
            showMyaddrlist:false,
            showReciveDetailInput:false,
            showSendDetailInput:false,
            showWarning:false,
            confirmdata:{content:{},detail:{},media_id:'',message:'',result:0,tid:'',paylog:{}},
            post:{
                time: 0,
                datatime:{value:'',text:''},
                city: {title:'我的位置',lat:'',lng:''},
                sendaddress:sendaddress,
                receiveaddress:receiveaddress,
                thumbs:[],
                message:'',
                small_money:'',
                code:'',
                codeid:''
            }
        },
        ready:function(){

            window.addEventListener('message', function(event) {
                var loc = event.data;
                if (loc && loc.module == 'locationPicker') {
                    if(vm.isstartAddress){
                        //如果是起始位置
                        vm.$data.post.sendaddress.city = loc.cityname;
                        vm.$data.post.sendaddress.lat = loc.latlng.lat;
                        vm.$data.post.sendaddress.lng = loc.latlng.lng;
                        vm.$data.post.sendaddress.title = loc.poiaddress;
                        vm.$data.post.sendaddress.point = loc.latlng;
                        vm.$data.showSendDetailInput = true;
                        vm.$data.post.city.title = loc.cityname;
                    }else{
                        vm.$data.post.receiveaddress.city = loc.cityname;
                        vm.$data.post.receiveaddress.lat = loc.latlng.lat;
                        vm.$data.post.receiveaddress.lng = loc.latlng.lng;
                        vm.$data.post.receiveaddress.point = loc.latlng;
                        vm.$data.post.receiveaddress.title = loc.poiaddress + loc.poiname;
                        vm.$data.showReciveDetailInput = true;
                    }
                    vm.showMap = false;
                    vm.showMain = true;
                }
            }, false);

            $('#upload_image').localResizeIMG({
                width: 380,
                quality: 0.8,
                success: function (result) {
                    vm.post.thumbs = vm.post.thumbs.concat({src:result.base64});
                    console.log(vm.post.thumbs);
                    status = true;
                }
            });

            R.xiaofeiRange({onFinish:function(data){
                vm.post.small_money = data.from;
            }},function(data){
                vm.post.small_money = data.start;
            });
            setTimeout(function(){
                if(vm.post.sendaddress.title){
                    vm.showSendDetailInput = true;

                }
            },500);
            setTimeout(function(){
                if(vm.post.receiveaddress.title){
                    vm.showReciveDetailInput = true;
                }
            },500);
        },
        methods:{
            sendCode:function(){
                var start = 0;
                var time = 30;

                var mobile = $('.mobile').val();
                var reg = /^1[3|4|5|8|7][0-9]\d{4,8}$/;

                if (!reg.test(mobile)) {
                    core.cancel('手机号码格式有误！请重新输入');
                    return '';
                }
                var _this = $('#send');
                _this.html('剩余'+time+'秒');
                _this.attr('disabled',true);

                timer = setInterval(function(){
                    if(time == 0){
                        _this.attr('disabled',false);
                        _this.html('重新发送');
                        clearInterval(timer);
                    }else{
                        time = time -1;
                        _this.html('剩余'+time+'秒');
                    }
                },1000);

                core.post('sms_code',{mobile:mobile},function(data){
                    if(data.status == 0){
                        core.cancel(data.message);
                    }else{
                        vm.post.codeid = data.codeid;
                    }
                });
            },
            postTasks : function(post){
                if(core.empty(post.sendaddress.lat)){
                    core.cancel(vm.params.sendaddress.placeholder.title,function(){});
                    return '';
                }
                localStorage.sendaddress =  JSON.stringify(post.sendaddress);
                if(core.empty(post.receiveaddress.lat)){
                    core.cancel(vm.params.receiveaddress.placeholder.title,function(){});
                    return '';
                }
                localStorage.receiveaddress = JSON.stringify(post.receiveaddress);
                var drivingService = new qq.maps.DrivingService({location : vm.post.sendaddress.city});
                var start = new qq.maps.LatLng(post.sendaddress.lat, post.sendaddress.lng);
                var end = new qq.maps.LatLng(post.receiveaddress.lat, post.receiveaddress.lng);
                drivingService.search(start,end);
                drivingService.setComplete(function(result) {
                    post.distance = result.detail.distance;
                    post.duration = result.detail.duration;
                    console.log(post);
                    R.showToast('数据提交中。。');
                    $.post("<?php  echo $this->createMobileUrl('check',array('act'=>'post'))?>",{},function(data){
                        if(data.status == 0){
                            $.post("<?php  echo $this->createMobileUrl('new_post')?>",post,function(data){
                                if(data.result == 0){
                                    R.hideToast();
                                    vm.confirmdata = data;
                                    vm.showMain = false
                                    $('#confirm_container').show();
                                }else{
                                    R.hideToast();
                                    core.cancel(data.message,function(){});
                                }

                            },'json');
                        }else{
                            R.hideToast();

                            core.ok(data.message,function(){
                                window.location.href = data.url;
                            },function(){
                                window.location.href = data.url;
                            });
                        }
                    },'json');
                });
            },

            payOrder : function(tid){
                window.location.href = "<?php  echo $this->createMobileUrl('paytask')?>&tid="+tid;
            },

            cancelOrder : function(tid){
                vm.showMain = true;
                vm.showResult = false;
                $('#confirm_container').hide();
            },
            openSendAddress : function(){
                vm.isstartAddress = true;
                this.showMap = true;
                vm.showMain = false;
            },
            openReciveAddress : function(post){
                vm.isstartAddress = false;
                this.showMap = true;
                vm.showMain = false;
                $('#mapPage').show();
            },
            openMyaddrlist : function(isstart){
                if(isstart){
                    this.isstartAddress = true;
                }else{
                    this.isstartAddress = false;
                }
                this.showMyaddrlist = true;
                this.showMain = false;
            },
            colseMyaddrlist : function(){
                vm.showMyaddrlist = false;
                vm.showMain = true;
            },

            choseThisAddr : function(li){
                console.log(li);
                if(vm.isstartAddress){
                    //如果是起始位置
                    vm.post.sendaddress = vm.post.sendaddress || {};
                    vm.post.sendaddress.city = vm.post.sendaddress.city || '';
                    vm.post.sendaddress.city = li.cityname;
                    vm.post.sendaddress.lat = vm.post.sendaddress.lat || '';
                    vm.post.sendaddress.lat = li.lat;
                    vm.post.sendaddress.lng = vm.post.sendaddress.lng || '';
                    vm.post.sendaddress.lng = li.lng;
                    vm.post.sendaddress.title = vm.post.sendaddress.title || '';
                    vm.post.sendaddress.title = li.poiaddress;
                    vm.post.sendaddress.detail = vm.post.sendaddress.detail || '';
                    vm.post.sendaddress.detail = li.detail;
                    vm.post.sendaddress.realname = vm.post.sendaddress.realname || '';
                    vm.post.sendaddress.realname = li.realname;
                    vm.post.sendaddress.mobile = vm.post.sendaddress.mobile || '';
                    vm.post.sendaddress.mobile = li.mobile;

                    vm.showSendDetailInput = true;
                    vm.post.city.title = li.cityname;
                    vm.post.city.lat = li.lat;
                    vm.post.city.lng = li.lng;
                }else{
                    vm.post.receiveaddress = vm.post.receiveaddress || {};
                    vm.post.receiveaddress.city = vm.post.receiveaddress.city || '';
                    vm.post.receiveaddress.city = li.cityname;
                    vm.post.receiveaddress.lat = vm.post.receiveaddress.lat || '';
                    vm.post.receiveaddress.lat = li.lat;
                    vm.post.receiveaddress.lng = vm.post.receiveaddress.lng || '';
                    vm.post.receiveaddress.lng = li.lng;
                    vm.post.receiveaddress.title = vm.post.receiveaddress.title || '';
                    vm.post.receiveaddress.title = li.poiaddress;
                    vm.post.receiveaddress.detail = vm.post.receiveaddress.detail || '';
                    vm.post.receiveaddress.detail = li.detail;
                    vm.post.receiveaddress.realname = vm.post.receiveaddress.realname || '';
                    vm.post.receiveaddress.realname = li.realname;
                    vm.post.receiveaddress.mobile = vm.post.receiveaddress.mobile || '';
                    vm.post.receiveaddress.mobile = li.mobile;
                    vm.showReciveDetailInput = true;
                }
                vm.showMyaddrlist = false;
                vm.showMap = false;
                vm.showMain = true;
            },
            changeCity : function(post){
                vm.showPopCity = true;
            },
            closeCity : function(){
                vm.showPopCity = false;
            },
            openWarning :function(){
                vm.showWarning = true;
                vm.showMain = false;
            },
            closeWarning:function(){
                vm.showWarning = false;
                vm.showMain = true;
            },
            choseCity : function(city){
                vm.post.city = city;
                vm.showPopCity = false;
            },
            setTimeType : function(i){
                vm.post.time = i;
                if(i == 0){
                    yuyueobj.settime();
                    vm.pl_yuyue = false;
                }
                if(i == 1){
                    yuyueobj.settime();
                    yuyueobj.show();
                    vm.pl_yuyue = true;
                }
            },
            change : function(message){
                vm.message_num = message.length();
            }

        }
    });

            var status = true;


            $('#message').on('keyup keydown change',function(){
                vm.message_num = vm.post.message.length;
            });

            yuyueobj.closecal.add(function(obj){
                if(obj.btn == 'cancel'){
                    if(yuyueobj.gettime() == ''){ //说明是取消预约取而不是修改上次预约的时间
                        $('#jishibut').find('[type="radio"]').prop('checked',true);
                    }
                }else if(obj.btn == 'set'){
                    vm.post.time = 1;
                    vm.pl_yuyue = true;
                    vm.post.datatime.value = obj.value;
                    vm.post.datatime.text = obj.text;
                }
                console.log(vm.post.datatime.text);
            });
        
});
    
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/footer', TEMPLATE_INCLUDEPATH)) : (include template('default/common/footer', TEMPLATE_INCLUDEPATH));?>