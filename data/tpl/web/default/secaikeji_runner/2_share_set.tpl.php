<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/template/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/template/navs', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
    <div class="panel-heading">
        分享设置
    </div>
    <div class="panel-body">
        <form action="" method="post"  class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">应用标题</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <input type="text" name="title" placeholder="" value="<?php  echo $item['title'];?>" class="form-control"/>
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">分享标题</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <input type="text" name="share_title" placeholder="" value="<?php  echo $item['share_title'];?>" class="form-control"/>
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">分享图标</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <?php  echo tpl_form_field_image('share_image',$item['share_image'])?>
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">分享简介</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <textarea name="share_desc"  class="form-control" id="" cols="30" rows="10"><?php  echo $item['share_desc'];?></textarea>
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
                    <input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                </div>
            </div>
        </form>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>