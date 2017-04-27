<?php defined('IN_IA') or exit('Access Denied');?><link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/default/home/css/topscreen_v6.css"/>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/default/home/css/index_v10.css"/>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/default/home/css/index/topad.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/default/home/css/index/fifteen.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/default/home/css/topscreen/mod_feature.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/default/home/css/topscreen/mod_game.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/default/home/css/topscreen/mod_life.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/default/home/css/topscreen/mod_zb.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/default/home/css/index/signin.css">
<?php  $member = M('member')->getInfo($_W['openid'])?>
<?php  $uid = mc_openid2uid($_W['openid'])?>
<?php  $user = mc_fetch($uid);?>
<header style="background-image: url(<?php echo MODULE_URL;?>template/mobile/default/home/banner.jpg)" class="header">
    <h2 class="name" style="color: #fff;"><?php  echo $member['nickname']?></h2>
    <div class="info">
        <div class="date">
            <?php  $level = M('runner_level')->getInfo($member['level_id'])?>
            <?php  if(!empty($level['title'])) { ?>
            信誉等级：【<?php  echo $level['title']?>】
            <?php  } else { ?>
            信誉等级：【未认证】
            <?php  } ?>
        </div>
        <span class="info-btn">
            <button type="button" onclick="window.location.href='<?php  echo $this->createMobileUrl('runner_xinyu')?>'" class="btn-renew">升级</button>
        </span>
    </div>
    <div class="level">
        <span>
            <?php  if(!empty($member['realname'])) { ?><?php  echo $member['realname']?><?php  } else { ?>未完善<?php  } ?>
            <?php  if(!empty($member['mobile'])) { ?>【<?php  echo $member['mobile'];?>】<?php  } ?>
        </span>
    </div>
    <ul>
        <li>
            <em><?php  echo $user['credit2'];?></em>
            <span>会员余额</span>
        </li>
        <li class="growth">
            <div class="my-growth">
                <div class="circle vip">
                    <div class="circle-left">
                        <div class="left" style="transition-timing-function: linear; transition-duration: 443.662ms; transform: rotate(180deg);"></div>
                    </div>
                    <div class="circle-right">
                        <div class="right" style="transition-timing-function: linear; transition-duration: 256.338ms; transform: rotate(78deg);"></div>
                    </div>
                    <div class="circle-mask">
                        <span><?php  echo $member['xinyu'];?></span>
                    </div>
                </div>
            </div>
            <span>信誉值</span>
        </li>
        <li>
            <em><?php  echo $user['credit1'];?></em>
            <span>会员积分</span>
        </li>
    </ul>
</header>