<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/vux/header', TEMPLATE_INCLUDEPATH)) : (include template('default/vux/header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/css/common.css"/>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/css/iconfont.css"/>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/footerbar', TEMPLATE_INCLUDEPATH)) : (include template('default/common/footerbar', TEMPLATE_INCLUDEPATH));?>
<style>
    #advSwiper{height:150px;}
    #advSwiper img{width:100%;}
    .meepo_tabs .meepo_tab-item{width: 50%;float: right;margin-top: 15px;}
</style>
<?php  $advs = M('advs')->getList(1," AND position = 'adv'");?>
<?php  if(!empty($advs['list'])) { ?>
<div class="swiper-container" id="advSwiper">
    <div class="swiper-wrapper">
        <?php  if(is_array($advs['list'])) { foreach($advs['list'] as $adv) { ?>
        <a href="<?php  echo $adv['link']?>" class="swiper-slide">
            <img src="<?php  echo tomedia($adv['image'])?>" />
        </a>
        <?php  } } ?>
    </div>
</div>
<?php  } ?>
<!--轮播-->
<?php  $announcements = M('announcement')->getall();?>
<?php  if(!empty($announcements)) { ?>
<div class="x_new_publish">
    <div class="left-icon">
        <i class="icon iconfont">&#xe614;</i>
    </div>
    <ul class="x_newest_publish" id="publishData">
        <?php  if(is_array($announcements)) { foreach($announcements as $announcement) { ?>
        <li><span><a href="<?php  echo $announcement['link']?>"><?php  echo $announcement['title'];?></a></span></li>
        <?php  } } ?>
    </ul>
</div>
<!--轮播-->
<style>
    .x_new_publish{width:100%;height:40px;position:relative;overflow:hidden;background:#fff no-repeat 5% center;background-size:20px}
    .x_new_publish:before {content: " ";position: absolute;left: 0;top: 0;width: 100%;height: 1px;border-top: 1px solid #e1e1e1;color: #C7C7C7;-webkit-transform-origin: 0 0;transform-origin: 0 0;-webkit-transform: scaleY(0.5);transform: scaleY(0.5);}
    .x_new_publish:after {content: " ";position: absolute;left: 0;bottom: 0;width: 100%;height: 1px;border-bottom: 1px solid #e1e1e1;color: #C7C7C7;-webkit-transform-origin: 0 100%;transform-origin: 0 100%;-webkit-transform: scaleY(0.5);transform: scaleY(0.5);}
    .x_new_publish .left-icon{position: absolute;padding-left: 15px;line-height: 40px;}
    .x_new_publish .left-icon .iconfont{font-size: 24px;color: #d93a55;}
    .x_newest_publish{width:100%;line-height:40px;position: absolute;padding-left: 15px;float: left;padding-left: 50px;}
    .x_newest_publish li{width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .c0 {padding-bottom: 0;border-top: 1px dashed #eee;margin-top: 3px;padding-top: 0px;padding-bottom: 12px;}
    .list{background-color:#f4f4f4;}
</style>
<script type="text/javascript">
    require(['jquery'],function($){
        function newnotice(){var a=0;$($(".x_newest_publish li")[0]).clone(!0).insertAfter($($(".x_newest_publish li")[$(".x_newest_publish li").length-1]));setInterval(function(){a-=40;a>=40*-($(".x_newest_publish li").length-2)?$(".x_newest_publish").animate({marginTop:a},2E3):$(".x_newest_publish").animate({marginTop:a},2E3,function(){a=0;$(".x_newest_publish").css({marginTop:0})})},4E3)};
        $(function () {
            newnotice();
        });
    });
</script>
<?php  } ?>
<div id="loadingToast" style="display:block;" class="weui_loading_toast">
    <div class="weui_mask_transparent"></div>
    <div class="weui_toast">
        <div class="weui_loading">
            <div class="weui_loading_leaf weui_loading_leaf_0"></div>
            <div class="weui_loading_leaf weui_loading_leaf_1"></div>
            <div class="weui_loading_leaf weui_loading_leaf_2"></div>
            <div class="weui_loading_leaf weui_loading_leaf_3"></div>
            <div class="weui_loading_leaf weui_loading_leaf_4"></div>
            <div class="weui_loading_leaf weui_loading_leaf_5"></div>
            <div class="weui_loading_leaf weui_loading_leaf_6"></div>
            <div class="weui_loading_leaf weui_loading_leaf_7"></div>
            <div class="weui_loading_leaf weui_loading_leaf_8"></div>
            <div class="weui_loading_leaf weui_loading_leaf_9"></div>
            <div class="weui_loading_leaf weui_loading_leaf_10"></div>
            <div class="weui_loading_leaf weui_loading_leaf_11"></div>
        </div>
        <p class="weui_toast_content">加载中,请稍后!</p>
    </div>
</div>
<style>
    #app{
        width: 95%;
        overflow: hidden;
        margin: 10px auto;
    }
</style>
<div id="app" style="display:none;">
    <div class="hd">
        <style>
            .row h2,.row span{display: block;margin: 0 auto;color: #fff;text-align: center;}
            .row img{margin: 0 auto;display: block;margin-top: 30px;}
            .row{border-radius: 0.1em;}
            .col{border-radius: 0.1em;}
        </style>
        <div class="row" style="margin: 0px;padding: 0px;">
            <div class="col" onclick="window.location.href='<?php  echo $this->createMobileUrl('post_index')?>'" style="background-size: cover;background-image:url('<?php echo MODULE_URL;?>public/images/song_bg.png')">
                <img style="margin-top: 65%;width: 4em;" src="<?php echo MODULE_URL;?>public/images/song_icon.png" alt=""/>
                <h2 style="margin-top:15px;">帮我送</h2>
                <span >着急送 准时达</span>
            </div>
            <div class="col" style="padding-top:0px;padding-bottom:0px;">
                <div class="row" onclick="window.location.href='<?php  echo $this->createMobileUrl('buy')?>'" style="background-size: cover;background-image:url('<?php echo MODULE_URL;?>public/images/mai_bg.png')">
                    <div class="col">
                        <img src="<?php echo MODULE_URL;?>public/images/mai_icon.png" alt=""/>
                        <h2 style="margin-top:5px;">帮我买</h2>
                        <span style="margin-bottom:30px;">懒得动 随意购</span>
                    </div>
                </div>
                <div class="row" onclick="window.location.href='<?php  echo $this->createMobileUrl('help')?>'" style="margin-top:10px;background-size: cover;background-image:url('<?php echo MODULE_URL;?>public/images/help_bg.png')">
                    <div class="col">
                        <img src="<?php echo MODULE_URL;?>public/images/help_icon.png" alt=""/>
                        <h2 style="margin-top:5px;">帮忙</h2>
                        <span style="margin-bottom:30px;">帮排队 帮表白</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="hd">
        <?php  $advs = M('advs')->getList(1," AND position = 'footer'");?>
        <?php  if(!empty($advs['list'])) { ?>
        <style>
            #advSwiper2{height:150px;}
            #advSwiper2 img{width:100%;}
            .h44{height:44px;}
        </style>
        <div class="swiper-container" id="advSwiper2">
            <div class="swiper-wrapper">
                <?php  if(is_array($advs['list'])) { foreach($advs['list'] as $adv) { ?>
                <a href="<?php  echo $adv['link']?>" class="swiper-slide">
                    <img src="<?php  echo tomedia($adv['image'])?>" />
                </a>
                <?php  } } ?>
            </div>
        </div>
        <?php  } ?>
    </div>
    <div class="h44"></div>
    <div style="height:44px;"></div>
</div>


<script>
    require([
        'vue',
        'jquery',
        'libs/underscore-min',
        'swiper',
        'libs/vux/components/x-button/index',
        'libs/vux/components/divider/index',
        'libs/vux/components/tab/index',
        'libs/vux/components/tab-item/index',
        'libs/vux/components/masker/index',
        'libs/vux/components/clocker/index',
        'libs/vux/components/countup/index',
    ],function(Vue,$,_,Swiper,xButton,divider,tab,tab_item,masker,clocker,countup){

        var mySwiper = new Swiper('#advSwiper', {
            autoplay: 3000,
            loop : true,
            effect : 'fade',
        });
        Vue.component('x-button', xButton);
        Vue.component('divider', divider);
        Vue.component('tab', tab);
        Vue.component('tab-item', tab_item);
        Vue.component('masker', masker);
        Vue.component('clocker', clocker);
        Vue.component('countup', countup);

        var item = 'song';
        var page = 1;

        var vm = new Vue({
            el:'#app',
            data:{

            },
            ready:function(){
                $('#app').show();
                $('#loadingToast').hide();
            },
            methods:{

            }
        });
    });
</script>
</body>
</html>