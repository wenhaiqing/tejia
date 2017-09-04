<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<div class="page help" id="page-app-help">
	<header class="bar bar-nav">
		<a class="pull-left back" href="javascript:;"><i class="fa fa-arrow-left"></i></a>
		<h1 class="title">常见问题</h1>
	</header>
	<div class="content">
		<div class="list-block">
			<ul>
				<?php  if(is_array($helps)) { foreach($helps as $help) { ?>
					<li class="item-content item-help-title border-1px-b">
						<div class="item-inner">
							<div class="item-title"><?php  echo $help['title'];?></div>
							<div class="item-after"><i class="fa fa-arrow-down"></i></div>
						</div>
					</li>
					<li class="item-help-content border-1px-b hide">
							<?php  echo $help['content'];?>
					</li>
				<?php  } } ?>
			</ul>
		</div>
	</div>
</div>
<script>
$(function(){
	$(document).on('click', '.item-help-title', function(){
		var $this = $(this);
		if($this.next().hasClass('hide')) {
			$('.item-help-content').addClass('hide');
			$('.item-help-title').find('.fa').removeClass('fa-arrow-up').addClass("fa-arrow-down");
			$this.next().removeClass('hide');
			$this.find('.fa').removeClass('fa-arrow-down').addClass("fa-arrow-up");
		} else {
			$this.next().addClass('hide');
			$this.find('.fa').removeClass('fa-arrow-up').addClass("fa-arrow-down");
		}
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>