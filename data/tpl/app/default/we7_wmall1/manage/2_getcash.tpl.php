<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/header', TEMPLATE_INCLUDEPATH)) : (include template('manage/header', TEMPLATE_INCLUDEPATH));?>
<div class="page getcash">
	<header class="bar bar-nav common-bar-nav">
		<a class="icon pull-left fa fa-arrow-left back"></a>
		<h1 class="title">申请提现</h1>
	</header>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/nav', TEMPLATE_INCLUDEPATH)) : (include template('manage/nav', TEMPLATE_INCLUDEPATH));?>
	<div class="content">
		<div class="takeout-title">账户可用余额：<span>¥<?php  echo $account['amount'];?></span></div>
		<ul class="takeout-list">
			<li>
				<div class="takeout-item-left">提现金额</div>
				<div class="takeout-item-right">
					<div class="takeout-item-input">
						<input type="text" placeholder="0" id="fee" value="">
					</div>
					<p class="takeout-rule">最低提现金额为<?php  echo $account['fee_limit'];?>元</p>
					<p class="takeout-rule">提现费率为<?php  echo $account['fee_rate'];?>%,最低收取<?php  echo $account['fee_min'];?>元,最高收取<?php  echo $account['fee_max'];?>元</p>
					<?php  if($account['amount'] < $account['fee_limit']) { ?>
						<a href="#" class="button button-big button-fill button-success disabled">不足<?php  echo $account['fee_limit'];?>元</a>
					<?php  } else { ?>
						<a href="#" class="button button-big button-fill button-danger">提现</a>
					<?php  } ?>
				</div>
			</li>
		</ul>
	</div>
</div>

<script>
$(function(){
	$('.button-danger').click(function(){
		var $this = $(this);
		if($this.hasClass('disabled')) {
			return false;
		}
		var account = <?php  echo json_encode($account);?>;
		var fee = parseFloat($.trim($('#fee').val()));
		if(isNaN(fee)) {
			$.toast('提现金额有误');
			return false;
		}
		if(fee > account.amount) {
			$.toast('提现金额大于账户可用余额');
			return false;
		}
		if(fee < account.fee_limit) {
			$.toast('提现金额不能小于' + account.fee_limit + '元');
			return false;
		}
		var rule_fee = (fee * account.fee_rate/100).toFixed(2);
		rule_fee = Math.max(rule_fee, account.fee_min);
		rule_fee = Math.min(rule_fee, account.fee_max);
		rule_fee = parseFloat(rule_fee);
		var final_fee = (fee - rule_fee).toFixed(2);
		var tips = "提现金额" + fee + "元, 手续费" + rule_fee + "元,实际到账" + final_fee + "元, 确定提现吗";
		$.confirm(tips, function(){
			if(final_fee <= 0) {
				$.toast('实际到账金额小于0元, 不能进行提现');
				return false;
			}
			$this.addClass('disabled');
			$.post("<?php  echo $this->createMobileUrl('mgtrade', array('op' => 'getcash'));?>", {fee: fee}, function(data){
				var result = $.parseJSON(data);
				if(result.message.errno == -1) {
					$.toast(result.message.message);
					$this.removeClass('disabled');
				} else {
					$.toast('申请提现成功, 平台会尽快处理', "<?php  echo $this->createMobileUrl('mghome');?>");
				}
				return false;
			});
		});
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/common', TEMPLATE_INCLUDEPATH)) : (include template('manage/common', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('manage/footer', TEMPLATE_INCLUDEPATH)) : (include template('manage/footer', TEMPLATE_INCLUDEPATH));?>