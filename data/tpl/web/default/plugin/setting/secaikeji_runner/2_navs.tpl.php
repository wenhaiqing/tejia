<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
	<li <?php  if($_GPC['mdo']=="setting") { ?>class="active"<?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('plugin',array('mp'=>'setting','mdo'=>'setting'))?>">系统设置</a>
	</li>
	<li <?php  if($_GPC['mdo']=="address") { ?>class="active"<?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('plugin',array('mp'=>'setting','mdo'=>'address'))?>">城市管理</a>
	</li>
</ul>