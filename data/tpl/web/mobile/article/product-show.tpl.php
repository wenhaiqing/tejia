<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/header-cms', TEMPLATE_INCLUDEPATH));?>
<link href="./resource/mobile/css/cms.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.caselist ul li img{width: 95%; height: 95%;}
.content{font-size:12px;padding:0 0.5rem;margin-top: .2rem;}
.title{font-size:13px;color:#585f69;padding:0 0.5rem;text-align:center}
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
		<?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>		
         <li><a href="<?php  echo url('article/product-show/list', array('cateid' => $category['id']));?>"><?php  echo $category['title'];?></a></li>           
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
                 <a href="<?php  echo url('article/product-show/detail', array('id' => $da['id']));?>" target="_blank"><img src="<?php  echo tomedia($da['thumb']);?>"></a>
                 <p class="p1"><a href="<?php  echo url('article/product-show/detail', array('id' => $da['id']));?>" target="_blank"><?php  echo $da['title'];?></a>
                 </p>                
            </li>
	<?php  } } ?>
		</ul>
    </div>
	<div class="page clearfix mt30 mb30">
	<?php  echo $pager;?>
    </div>
    </section>
</section>
	<?php  } ?>
	<?php  if($do == 'detail') { ?>
<section class="tabThis newsTab">
    <section class="bd">
        <div class="row newsRow">
			<div class="title"><?php  echo $product['title'];?></div>
			<div class="content">
				<?php  echo $product['content'];?>
			</div>
        </div>
    </section>
</section>
	<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-cms', TEMPLATE_INCLUDEPATH));?>
