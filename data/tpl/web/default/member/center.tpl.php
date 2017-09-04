<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/header-gw', TEMPLATE_INCLUDEPATH));?>
<style>
.btn-green {
	background: #21d376;
	color: #fff;
	border-color: #21d376;
}

.btn-green:hover {
	background: #0dbf62;
	color: #fff;
	border-color: #0dbf62
}
.account-box {
	border: 1px solid #e9eaed;
	border-radius: 3px;
	padding: 20px 0;
	margin-bottom: 30px
	background: #fff;
}

.account-box:after {
	content: ".";
	display: block;
	height: 0;
	clear: both;
	visibility: hidden
}

.account-box .item {
	float: left;
	width: 33.333333333333%;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	padding: 0 30px
}

.account-box .item.list2 {
	border: 1px solid #e9eaed;
	border-top: 0;
	border-bottom: 0
}

.account-box .item:last-child {
	border-right: 0
}

.account-box h3 {
	font-size: 16px;
	margin-bottom: 20px
}

.account-box .number {
	font-size: 50px;
	font-weight: 300;
	color: #ff595f;
	text-align: center;
	margin-bottom: 50px
}

.account-box .btn-sm {
	margin-left: 15px
}

.account-box ul {
	margin-bottom: 2px
}

.account-box li {
    list-style: none;
	padding: 10px 0;
	border-bottom: 1px dotted #e9eaed
}

.account-box li span {
	color: #ff595f
}

.account-box li a {
	margin-left: 15px;
	color: #0096C4
}

.account-box li a:hover {
	color: #48b6d7
}


</style>
<h3 class="page-title">
    在线充值 <small></small>
</h3>
<ul class="nav nav-tabs">
		<li <?php  if($do == 'member') { ?> class="active"<?php  } ?>><a href="<?php  echo url('member/member/member');?>">在线充值</a></li>
		<li <?php  if($do == 'buypackage') { ?> class="active"<?php  } ?>><a href="<?php  echo url('member/buypackage');?>">增值业务</a></li>
		<li <?php  if($do == 'record') { ?> class="active"<?php  } ?>><a href="<?php  echo url('member/member/record');?>">消费记录</a></li>
		<li <?php  if($do == 'chongzhi') { ?> class="active"<?php  } ?>><a href="<?php  echo url('member/member/chongzhi');?>">充值记录</a></li>
</ul>
<div class="account-box">
	<div class="clearfix">
		<iframe src="<?php  if($_W['setting']['copyright']['payhost']) { ?>http://<?php  echo $_W['setting']['copyright']['payhost'];?><?php  } else { ?><?php  echo $_W['siteroot'];?><?php  } ?>/web/index.php?c=member&a=payhost&username=<?php  echo $_W['username'];?>" marginheight="0" marginwidth="0" frameborder="0" width="100%" style="height:1020px;" scrolling="auto" allowTransparency="true"></iframe>
	</div>
</div>
<div class="modal fade" id="myModal" data-backdrop="static" style="top: 25%">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">充值提醒</h4>
            </div>
            <div class="modal-body" style="line-height: 30px;text-indent: 2em;font-size: 16px;font-weight: bold">
                请在新弹出的第三方支付平台完成支付，即可自动充值到帐户，未完成支付前请不要关闭本窗口。<br/>
                <span style="font-weight: normal;font-size: 14px;color: red">若充值过程中网络中断或失败，请拨打我司电话.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning done">完成支付</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    require(['bootstrap'],function($){
        $("button.ChangePackage").click(function() {
            var id = $(this).attr("id");
            if(parseInt(id) <= 0) return;
            $.post("<?php  echo url('member/buypackage');?>", {'groupid' : parseInt(id)}, function(data){
                if(data == 'illegal-uniacid') {
                    u.message('您没有操作该公众号的权限');
                } else if (data == 'illegal-group') {
                    u.message('您没有使用该服务套餐的权限');
                } else {
                    location.reload();
                }
            });
        });
        $("#is_auto").on("click",function (){
            var is_auto = 0;
            if($(this).is(':checked')) {
                console.log("c");
                is_auto = 1;
            }
            $.ajax({
                'url':"<?php  echo url('member/site')?>",
                'data':{is_auto:is_auto},
                'type':'POST',
                'async':'true',
                'dataType':'json',
                'success':function(data){
                    console.debug(data);
                    alert(data.message);
                }
            });
        });
        $("a.buy").on("click",function(){
            $("a.buy").removeAttr("disabled");
            $('#myModal').modal('show');
            $("form.form").action = "<?php  echo url('member/recharge')?>";
            $("form.form").submit();
        });
        $("button.done").on("click",function(){
            location.reload();
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>