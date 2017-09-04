<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/header-cms', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
.content{font-size:12px;padding:0 0.5rem;margin-top: .2rem;}
.title{font-size:24.5px;color:#585f69; padding:0 0.5rem;text-align:center}
</style>
<?php  if($do == 'list') { ?>
<section class="tabThis newsTab">
    <section class="bd">
        <div class="row newsRow">
            <ul>
                  <?php  if(is_array($data)) { foreach($data as $da) { ?>
                <li>
                    <a href="<?php  echo url('article/about-show/detail', array('id' => $da['id']));?>" class="item clearfix">
                        <div class="cnt">
                            <img class="pic" src="<?php  if(!$da['thumb']) { ?><?php  echo $_W['siteroot'];?>/web/resource/images/nopic.jpg<?php  } else { ?><?php  echo tomedia($da['thumb']);?><?php  } ?>">

                            <div class="wrap1">
                                <div class="wrap2">
                                    <div class="content">
                                        <div class="gist">
                                            <h3><?php  echo cutstr_html($da['title'], 8, true);?></h3>
                                            <p><?php  echo cutstr_html($da['content'], 58, 1)?></p>
                                            <small class="fl clearfix time">[<?php  echo date('Y-m-d', $da['createtime']);?>]</small>
                                        </div>

                                        <div class="discount">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
				<?php  } } ?>
                    </ul>
            <div class="page clearfix mt30 mb30">
                <div class="tc">
				<?php  echo $pager;?>
                </div>
            </div>
                </div>
    </section>
</section>
	<?php  } ?>
	<?php  if($do == 'detail') { ?>
<section class="tabThis newsTab">
    <section class="bd">
        <div class="row newsRow">
			<h6 class="title"><?php  echo $about['title'];?></h6>
			<div class="content">
				<?php  echo $about['content'];?>
			</div>
            <div class="page clearfix mt30 mb30">
                <div class="tc">
				<?php  echo $pager;?>
                </div>
            </div>
        </div>
    </section>
</section>
	<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-cms', TEMPLATE_INCLUDEPATH));?>
