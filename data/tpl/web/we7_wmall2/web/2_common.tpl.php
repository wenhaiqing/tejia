<?php defined('IN_IA') or exit('Access Denied');?><audio id="musicClick" src="<?php  echo $_W['siteroot'];?>addons/we7_wmall2/resource/web/click.mp3" preload="auto"></audio>
<script type="text/javascript">
require(['filestyle'], function(){
	$(".form-group").find(':file').filestyle({buttonText: '上传'});
});
function order_notice() {
	$.post("<?php  echo $this->createWebUrl('cron', array('op' => 'order_notice'));?>", function(data){
		if(data == 'success') {
			$("#musicClick")[0].play();
		}
		setTimeout(order_notice, 30000);
	});
}

$(function(){
	$('.btn').hover(function(){
		$(this).tooltip('show');
	},function(){
		$(this).tooltip('hide');
	});

	$('[data-toggle="popover"]').hover(function(){
		$(this).popover('show');
	},function(){
		$(this).popover('hide');
	});

	$('.clip p a').each(function(){
		util.clip(this, $(this).text());
	});

	order_notice();


});
</script>