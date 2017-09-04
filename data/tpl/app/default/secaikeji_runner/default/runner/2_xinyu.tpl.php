<?php defined('IN_IA') or exit('Access Denied');?><?php  $member = M('member')->getInfo($_W['openid'])?>
<div class="page page-current msg">
  <div class="weui_msg">
      <div class="weui_icon_area"><i class="weui_icon_msg weui_icon_success"></i></div>
      <div class="weui_text_area">
          <h2 class="weui_msg_title">信誉度充值</h2>
          <p class="weui_msg_desc">当前信誉：￥<?php  echo $member['xinyu'];?></p>
      </div>
      <div class="weui_opr_area">
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">充值</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="number" name="num" pattern="[0-9]*" placeholder="请输入充值数目">
                </div>
            </div>
        </div>
        <div class="weui_cells_tips"><?php  echo $pay['desc'];?></div>
        <div class="weui_extra_area">
            <a href="">充值说明</a>
        </div>

        <div class="weui_btn_area">
            <a class="weui_btn weui_btn_primary" id="goPay">去支付</a>
        </div>
      </div>
  </div>
</div>

<script type="text/javascript">
require(['jquery','core'],function($,core){
	$('#footer').show();
	$('#goPay').click(function(){
		var num = $('input[name="num"]').val();
		core.post('runner_xinyu',{act:'post',num:num},function(data){
			if(data.status == 1){
				window.location.href = "<?php  echo $this->createMobileUrl('payxinyu')?>&tid="+data.tid;
			}else{
				core.cancel(data.message);
			}
		});
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('default/common/share', TEMPLATE_INCLUDEPATH)) : (include template('default/common/share', TEMPLATE_INCLUDEPATH));?>