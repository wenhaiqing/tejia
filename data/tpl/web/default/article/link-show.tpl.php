<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/header-cms', TEMPLATE_INCLUDEPATH));?>
<link href="./resource/weidongli/css/cms.css" rel="stylesheet" type="text/css" />
<style type="text/css">	
/*首页二维码图片列表*/
.m_link .box1{float:left;width:130px;color:#666;position:relative;border:1px #e2e2e2 solid;background:#fff;margin:10px
10px 0 0}
.m_link img{width:120px;height:120px;display:block;padding:5px 5px 0 5px}
.m_link .txt1,.m_link .txt2{float:left;width:130px;height:130px;position:absolute;top:5px;left:5px;padding:5px;color:#fff;line-height:24px;display:none;z-index:999;overflow:hidden;background:url(/images/mbzj_bg1.png) repeat}
.m_link .txt1 p,.m_link .txt2 p{margin-left:115px;text-align:center;line-height:22px;display:block;width:80px;height:22px;background:#44b549;}
.m_link li:hover .txt1,.m_link li:hover .txt2{display:block}
.m_link .p1{height:39px;line-height:39px;padding:0
5px;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap; font-size:14px}
.m_link .p2{height:30px;padding:0 10px;line-height:30px;background:#f1f1f1}
.m_link .p2 label{color:#F60;font-family:Georgia;font-size:17px;font-weight:bold}
.m_link .box1:hover a{color:#419900;text-decoration:underline}
.m_link .box2:hover a{color:#f00;text-decoration:underline}
.m_link .p2 span{float:right}
.m_link .box1:hover{border:1px #18d018 solid}
.m_link .box2:hover{border:1px #f00 solid}
.m_link .box2 .p1 a:hover{color:#f00}
.m_link .txt1 a,.m_link .txt2 a{color:#fff !important;text-decoration:none !important}
.m_link .txt1 a:hover,.m_link .txt2 a:hover{color:#fff !important;text-decoration:underline !important}
</style>
<?php  if($do == 'list') { ?>
<div class="breadcrumbs margin-bottom-40 cl">
<div class="xiaoyu_container cl">
        <h1 class="color-green z"><a href="<?php  echo url('article/link-show/list');?>">友情链接</a></h1>
        <ul class="y breadcrumb">
        <li><a href="./" title="首页">首页</a> <span class="divider">/</span></li>
		<li><a href="<?php  echo url('article/link-show/list');?>">友情链接列表</a><span class="divider">/</span></li>
		<li class="active">所有友情链接</li>
        </ul>
</div>
</div>
<div class="xiaoyu_container cl">
		<div class="m_link">  
	<?php  if(is_array($data)) { foreach($data as $da) { ?>		
            <div class="box1">                   
                 <a href="<?php  echo url('article/link-show/detail', array('id' => $da['id']));?>" target="_blank">
				 <img src="<?php  echo $_W['siteroot'];?>/attachment/<?php  echo $da['thumb'];?>" height="120" width="120"  onerror="this.src='../web/resource/images/nopic-small.jpg'">
				 </a>
                 <p class="p1"><a href="<?php  echo url('article/link-show/detail', array('id' => $da['id']));?>" target="_blank"><?php  echo $da['title'];?></a>
                 </p>                
            </div>
	<?php  } } ?>
		</div>
		<div class="xiaoyu_bottom_border"></div>
</div>
	<?php  } ?>
	<?php  if($do == 'detail') { ?>
<div class="breadcrumbs margin-bottom-40 cl">
<div class="xiaoyu_container cl">
        <h1 class="color-green z"><a href="<?php  echo url('article/link-show/list');?>">友情链接动态</a></h1>
        <ul class="y breadcrumb">
        <li><a href="./" title="首页">首页</a> <span class="divider">/</span></li>
		<li><a href="<?php  echo url('article/link-show/list');?>">友情链接列表</a><span class="divider">/</span></li>
		<li class="active"><?php  echo $link['title'];?></li>
        </ul>
</div>
</div>
<div class="xiaoyu_container cl">
<div class="fishue_unnew_left"> 
	<div class="ghinfo clearfix">
            <div class="ghavatar">
                <img src="<?php  echo $_W['siteroot'];?>/attachment/<?php  echo $link['thumb'];?>"style=" width: 120px; height: 120px;"  onerror="this.src='../web/resource/images/nopic-small.jpg'">
                <span>浏览量：<font color="red"><?php  echo $link['click'];?></font></span>
            </div>
            <div class="wxinfo">
                <h2>
                    <a href="<?php  echo url('article/link-show/list');?>"><?php  echo $link['title'];?></a><br>
                </h2>
                <div class="wxrow">
                    <label>网站网址：</label>
                    <span><?php  echo $link['siteurl'];?></span>
                </div>
                <div class="wxrow">
                    <label>网站标签：</label>
                    <span class="taglis">
                        <em class="tag-0"><?php  echo $link['linktag'];?></em> </span>
                </div>
                <div class="wxrow">
                    <label>收录时间：</label>
                    <span><?php  echo date('Y-m-d H:i', $link['createtime']);?></span>
                </div>
                <div style="margin:0px auto;">
                    <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more">分享到：</a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">人人网</a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a></div>
					<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{"bdSize":16},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                </div>
            </div>
        </div>
</div>
  <div class="y pph xiaoyu_view_sd"> 
   <div class="col-md-3"> 
    <div class="headline headline-md">
     <h2>其他友情链接</h2>
    </div> 
    <div class="tab-v2 margin-bottom-40"> 
     <div class="tab-content" id="myTab1_con">       
      <div class="tab-pane J-tab active"> 
       <div class="row"> 
        <ul class="list-unstyled xiaoyu_tab_other cl">
<?php  if(is_array($links)) { foreach($links as $link) { ?>		
         <li><a href="<?php  echo $link['siteurl'];?>"><?php  echo $link['title'];?></a></li>           
<?php  } } ?>    
        </ul> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div>
</div>
	<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-cms', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-cms', TEMPLATE_INCLUDEPATH));?>
