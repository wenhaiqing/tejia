<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
	<li <?php  if($_GPC['mp']=="setting") { ?>class="active"<?php  } ?>>
		<a href="<?php  echo $this->createWebUrl('plugin',array('mp'=>'setting','mdo'=>'setting'))?>">系统设置</a>
	</li>
</ul>