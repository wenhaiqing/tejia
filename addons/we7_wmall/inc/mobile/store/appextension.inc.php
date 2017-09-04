<?php
/**
 * 外送系统
 * @author 灯火阑珊
 * @QQ 2471240272
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'order';
mload()->model('store');
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';
$uid = intval($_GPC['uid']);
$member = pdo_get('mc_members',array('uid'=>$uid));
 $p = substr($member['mobile'],0,3)."****".substr($member['mobile'],7,4);
?>
<html>
<head>
	<title>我要推广</title>
       <link rel="stylesheet" type="text/css" href="aui.css" />
       <style type="text/css">
            .aui-list .aui-list-item-inner {
    position: relative;
    min-height: 4.2rem;
}
       </style>  
</head>
<body>
     <div>
        <img src="share.jpg" alt="" id="test" style="width:100%;">
    </div>
	<div style="text-align:center">
		<h1>您手机号为<?php echo $p ?>的朋友向您推荐山西菜市场</h1>
	</div>
<!-- 	<div style="text-align:center">
		<h3>请先绑定手机号才能下载APP</h3>
		手机号：<input type="number" id="mobile"><br/>
        验证码：<input type = "number" id="code"><button onclick = "code();">获取验证码</button><br>
		<button onclick="login();">绑定手机号</button>
	</div> -->
    <section class="aui-content aui-margin-t-15">
        <ul class="aui-list aui-form-list">
            <li class="aui-list-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-label aui-border-r color-orange">
                        手机号 <small class="aui-margin-l-5 aui-text-warning">+86</small>
                    </div>
                    <div class="aui-list-item-input aui-padded-l-10">
                        <input type="number" pattern="[0-9]*" placeholder="输入手机号" id="mobile" >
                    </div>
                </div>
            </li>
            <li class="aui-list-item">
                <div class="aui-list-item-inner">
                    <div class="aui-list-item-input" style="width: auto;">
                        <input type="number" pattern="^1[345678][0-9]{9}$" placeholder="输入短信验证码" id="code">
                    </div>
                    <div class="aui-list-item-label aui-margin-r-15" style="width: 6rem;">
                        <div class="aui-btn" style="width: 6rem;background-color: #50d28f"  id="btn-code">获取验证码</div>
                    </div>
                </div>
            </li>
        </ul>
    </section>
    <section class="aui-content-padded">
        <div class="aui-btn aui-btn-block aui-btn-sm" style="background-color: #50d28f" tapmode onclick="login();">绑定手机号</div>
    </section>
</body>
 <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<script type="text/javascript"></script>
<script type="text/javascript">

    $('#btn-code').click(function(){
        if($(this).hasClass('disabled')) {
                return false;
            }
        var mobile = $("#mobile").val();
        if(!mobile.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/)){
                alert('请输入正确的手机号');
                return false;
            }
            var $this = $(this);
            $this.addClass("disabled");
            var downcount = 60;
            $this.html(downcount + "秒后重新获取");
            var timer = setInterval(function(){
                downcount--;
                if(downcount <= 0){
                    clearInterval(timer);
                    $this.html("重新获取验证码");
                    $this.removeClass("disabled");
                    downcount = 60;
                }else{
                    $this.html(downcount + "秒后重新获取");
                }
            }, 1000);
        $.ajax({
            url:'http://tejia.zdxinfo.com/app/index.php?i=2&c=entry&do=cmnappcode&m=we7_wmall&sid=0&suiji='+Math.random(),
            type:'POST', //GET
            async:true,    //或false,是否异步
            data:{
                product:'山西菜市场',mobile:mobile,type:'registercode'
            },
            dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            success:function(data){
                if(data.status == 1){
                    alert('验证码发送成功');
               
            }else{
                alert('验证码发送失败');
            }
                
            }
        })
    })
    function login(){
         var mobile = $("#mobile").val();
         if(!mobile.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/)){
                alert('请输入正确的手机号');
                return false;
            }
            var code = $("#code").val();
            if (!code) {
                alert('请输入验证码');
            };
            $.ajax({
            url:'http://tejia.zdxinfo.com/app/index.php?i=2&c=auth&a=login&do=basic2&username='+mobile+'&password='+code+'&mode=code',
            type:'get', //GET
            dataType:'json',
            success:function(data){
                if(data.status == 'success'){
                   banding(mobile);
               
            }else{
                alert('绑定失败，请重新修改');
            }
                
            }
        })
    }
	function banding(mobile){
		var uid = <?php echo $uid; ?>;
		$.ajax({
            url:'http://tejia.zdxinfo.com/app/index.php?i=2&c=entry&do=appgoods&op=extension&m=we7_wmall&suiji='+Math.random(),
            type:'POST', //GET
            async:true,    //或false,是否异步
            data:{
                uid:uid,mobile:mobile
            },
            dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            success:function(data){
                if(data.status == 1){
                    alert('绑定成功');
                    window.location.href = 'http://tejia.zdxinfo.com/山西菜市场.apk';
               
            }else{
            	alert(data.info);
            }
                
            }
        })
	}

	function download(){
		$.ajax({
            url:'http://tejia.zdxinfo.com/山西菜市场.apk',
            type:'get', //GET
            async:true,    //或false,是否异步
  
    //返回的数据格式：json/xml/html/script/jsonp/text
            success:function(data){
                
            }
        })
	}
</script>
</html>

