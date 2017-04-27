<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
	<li <?php  if($_GPC['mdo']=="help") { ?>class="active"<?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('plugin',array('mp'=>'help','mdo'=>'help'))?>">使用手册</a>
	</li>
	<li <?php  if($_GPC['mdo']=="deve") { ?>class="active"<?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('plugin',array('mp'=>'help','mdo'=>'deve'))?>">开发手册</a>
	</li>
	<li <?php  if($_GPC['mdo']=="qus") { ?>class="active"<?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('plugin',array('mp'=>'help','mdo'=>'qus'))?>">常见问题</a>
	</li>
	<li <?php  if($_GPC['mdo']=="post") { ?>class="active"<?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('plugin',array('mp'=>'help','mdo'=>'post'))?>">工单提交</a>
	</li>
</ul>