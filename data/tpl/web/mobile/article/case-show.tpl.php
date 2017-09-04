<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/header-cms', TEMPLATE_INCLUDEPATH));?>
<link href="./resource/mobile/css/cms.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.caselist ul li img{width: 95%; height: 95%;}
.newsRow{margin-top: .1rem;}
</style>
<?php  if($do == 'list') { ?>
<section class="tabThis newsTab">
<section class="bd">
<div class="row newsRow">
   <div class="col-md-3"> 
    <div class="tab-v2 margin-bottom-40"> 
	<ul id="myTab1" class="tabHover nav-tabs cl"> 
            <li class="active"><a href="javascript:void(0);">相关分类</a></li>
     </ul>
     <div class="tab-content" id="myTab1_con">       
      <div class="tab-pane J-tab active" style="display: block;"> 
       <div class="row"> 
        <ul class="list-unstyled xiaoyu_tab_other cl">
<?php  if(is_array($catecases)) { foreach($catecases as $catecase) { ?>		
         <li><a href="<?php  echo url('article/case-show/list', array('cateid' => $catecase['id']));?>"><?php  echo $catecase['title'];?></a></li>           
<?php  } } ?>    
        </ul> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
 </div>
<div class="row newsRow">
    <div class="caselist">
		<ul class="m_Grid0">  
	<?php  if(is_array($data)) { foreach($data as $da) { ?>		
            <li class="box1">                   
                 <a href="<?php  echo url('article/case-show/detail', array('id' => $da['id']));?>" target="_blank"><img src="<?php  echo tomedia($da['thumb']);?>"></a>
                 <p class="p1"><a href="<?php  echo url('article/case-show/detail', array('id' => $da['id']));?>" target="_blank"><?php  echo $da['title'];?></a>
                 </p>                
            </li>
	<?php  } } ?>
		</ul>
    </div>
		<?php  echo $pager;?>
    </section>
</section>
	<?php  } ?>
	<?php  if($do == 'detail') { ?>
<section class="tabThis newsTab">
<section class="bd">
<div class="row newsRow"> 
	<div class="ghinfo clearfix">
            <div class="ghavatar">
                <img src="<?php  echo tomedia($case['thumb']);?>"style=" width: 120px; height: 120px;">
                <span>浏览量：<font color="red"><?php  echo $case['click'];?></font></span>
            </div>
            <div class="wxinfo">
                <h2>
                    <a href="<?php  echo url('article/case-show/list');?>"><?php  echo $case['title'];?></a><br>
                </h2>
                <div class="wxrow">
                    <label>微信号：</label>
                    <span><?php  echo $case['weixinh'];?></span>
                </div>
                <div class="wxrow">
                    <label>微信标签：</label>
                    <span class="taglis">
                        <em class="tag-0"><?php  echo $case['weixintag'];?></em> </span>
                </div>
                <div class="wxrow">
                    <label>收录时间：</label>
                    <span><?php  echo date('Y-m-d H:i', $case['createtime']);?></span>
                </div>
            </div>
        </div>
		<div class="case-box">
            <h3>微信公众号描述：</h3>
            <p><?php  echo $case['content'];?></p>
		</div>
</div>
    </section>
</section>
	<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-cms', TEMPLATE_INCLUDEPATH));?>
