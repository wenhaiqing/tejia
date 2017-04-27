<?php defined('IN_IA') or exit('Access Denied');?><link rel="stylesheet" href="./resource/css/font-awesome.min.css"/>
<style>
    .tab-item {
        padding-top: 6px;
        color: #5d2f18 !important;
    }
    .active{
        color:#04BE02 !important;
    }
    .tab-item .icon {
        height: auto;
        margin-bottom: 3px;
    }
</style>
<?php  $footers = M('navs')->getall('runner')?>
<div class="tabs tabs-icon-top" style="position: fixed;bottom: 0px;right:0px;left:0px;margin:0px;padding:0px;border:none;">
    <?php  if(is_array($footers)) { foreach($footers as $footer) { ?>
    <a class="tab-item <?php  if($_GPC['do'] == $footer['ido']) { ?>active<?php  } ?>" style="height:auto;" href="<?php  echo $footer['link']?>">
        <i style="font-size: 2em;" class="icon <?php  echo $footer['icon']?>"></i>
        <span><?php  echo $footer['title'];?></span>
    </a>
    <?php  } } ?>
</div>
<!--底部菜单-->
