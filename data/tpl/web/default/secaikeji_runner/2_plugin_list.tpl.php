<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/task/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/task/navs', TEMPLATE_INCLUDEPATH));?>
<div class="col-xs-12 col-sm-9 col-lg-10">
    <div class="module">
        <ul class="thumbnails">
        	<?php  if(is_array($plugins)) { foreach($plugins as $plugin) { ?>
            <li style="width:262px;" class="list-unstyled">
                <div class="thumbnail">
                    <div class="module-pic">
                        <img src="<?php  echo $plugin['image'];?>" onerror="this.src='../web/resource/images/nopic.jpg'">
                        <div class="module-detail">
                            <h5 class="module-title"><?php  echo $plugin['title'];?></h5>
                            <p class="module-brief"><?php  echo $plugin['desc'];?></p>
                            <p class="module-description">
                                <a href="<?php  echo $this->createWebUrl('plugin_detail',array('mp'=>$plugin['code']))?>" class="text-info">进入插件</a>
                            </p>
                        </div>
                    </div>
                </div>
            </li>
            <?php  } } ?>
        </ul>
        <div>
        </div>
    </div>
    <script type="text/javascript">
        function toggle_description(id) {
            var container = $('#' + id).parent().parent().parent();
            var status = $('#' + id).attr("status");
            if (status == 1) {
                $('#' + id).attr("status", "0") container.find(".module_description").show();
            } else {
                $('#' + id).attr("status", "1") container.find(".module_description").hide();
            }
        }
        $('.module .thumbnails').delegate('li .module-button-switch', 'click',
        function() { //控制模块开关
            if ($(this).hasClass('btn-primary')) { //禁用模块
                $(this).removeClass('btn-primary').addClass('btn-danger').html('开启');
            } else if ($(this).hasClass('btn-danger')) { //开启模块
                $(this).removeClass('btn-danger').addClass('btn-primary').html('禁用');
            }
            $(this).parent().parent().find('.module-pic img').toggleClass('gray');
        });
    </script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>