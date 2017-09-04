<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
	<li <?php  if($do == 'notice') { ?> class="active"<?php  } ?>><a href="<?php  echo url('mc/card/notice');?>">通知管理</a></li>
	<li <?php  if($do == 'sign') { ?> class="active"<?php  } ?>><a href="<?php  echo url('mc/card/sign');?>">签到管理</a></li>
</ul>