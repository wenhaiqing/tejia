<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/template/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/template/navs', TEMPLATE_INCLUDEPATH));?>
<style>
    .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {overflow: visible !important;}
    .dropdown-menu{min-width:4em;}
    .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {white-space: normal !important;overflow: visible !important;}
    .dropdown{display:inline-block !important;}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li <?php  if(empty($_GPC['position'])) { ?>class="active"<?php  } ?>>
                <a href="<?php  echo $this->createWebUrl('navs')?>">全部</a>
            </li>
            <li <?php  if($_GPC['position']=="user") { ?>class="active"<?php  } ?>>
                <a href="<?php  echo $this->createWebUrl('navs',array('position'=>'user'))?>">客户端</a>
            </li>
            <li <?php  if($_GPC['position']=="runner") { ?>class="active"<?php  } ?>>
                <a href="<?php  echo $this->createWebUrl('navs',array('position'=>'runner'))?>">服务端</a>
            </li>
            <li <?php  if($_GPC['position']=="user_home") { ?>class="active"<?php  } ?>>
                <a href="<?php  echo $this->createWebUrl('navs',array('position'=>'user_home'))?>">个人中心</a>
            </li>
            <li <?php  if($_GPC['position']=="runner_home") { ?>class="active"<?php  } ?>>
                <a href="<?php  echo $this->createWebUrl('navs',array('position'=>'runner_home'))?>">跑腿中心</a>
            </li>
        </ul>
    </div>
    <div class="panel-body">
        <form action="" method="post"  class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">显示顺序</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <input type="text" name="displayorder" placeholder="" value="<?php  echo $item['displayorder'];?>" class="form-control"/>
                    <span class="help-block">越大越靠前</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">导航标题</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <input type="text" name="title" placeholder="" value="<?php  echo $item['title'];?>" class="form-control"/>
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">导航链接</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <div class="input-group">
                        <input type="text" value="<?php  echo $item['link']?>" name="link" class="form-control" autocomplete="off">
		                <span class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" aria-haspopup="true" aria-expanded="false">选择链接 <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:" data-type="system" onclick="showLinkDialog(this);">系统菜单</a></li>
                                <li><a href="javascript:" data-type="system" onclick="showRunnerDialog(this);">跑腿菜单</a></li>
                            </ul>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">图标</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <?php  echo tpl_form_field_icon('icon',$item['icon'])?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">ido</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <input type="text" name="ido" placeholder="" value="<?php  echo $item['ido'];?>" class="form-control"/>
                    <span class="help-block"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">导航位置</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <select name="position" id="" class="form-control">
                        <option value="0">请选择</option>
                        <?php  if(is_array($options)) { foreach($options as $option) { ?>
                        <option value="<?php  echo $option['value'];?>" <?php  if($item['position']==$option['value']) { ?>selected<?php  } ?>><?php  echo $option['title'];?></option>
                        <?php  } } ?>
                    </select>
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

<script type="text/javascript">
    require(['util'],function(util){
        util.runnerBrowser = function(callback){
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>';
            var modalobj = util.dialog('请选择链接',['<?php  echo $this->createWebUrl('link')?>&callback=selectLinkComplete'],footer,{containerName:'link-container'});
            modalobj.modal({'keyboard': false});
            modalobj.find('.modal-body').css({'height':'300px','overflow-y':'auto' });
            modalobj.modal('show');

            window.selectLinkComplete = function(link){
                if($.isFunction(callback)){
                    callback(link);
                    modalobj.modal('hide');
                }
            };
        };
    });
    function showLinkDialog(elm) {
        require(["util","jquery"], function(u, $){
            var ipt = $(elm).parent().parent().parent().prev();
            u.linkBrowser(function(href){
                var multiid = "<?php  echo $_GPC['multiid'];?>";
                if (multiid) {
                    href = /(&)?t=/.test(href) ? href : href + "&t=" + multiid;
                }
                ipt.val(href);
            });
        });
    }
    function showRunnerDialog(elm){
        require(["util","jquery"], function(u, $){
            var ipt = $(elm).parent().parent().parent().prev();
            u.runnerBrowser(function(href){
                var multiid = "<?php  echo $_GPC['multiid'];?>";
                if (multiid) {
                    href = /(&)?t=/.test(href) ? href : href + "&t=" + multiid;
                }
                ipt.val(href);
            });
        });
    }
    function newsLinkDialog(elm, page) {
        require(["util","jquery"], function(u, $){
            var ipt = $(elm).parent().parent().parent().prev();
            u.newsBrowser(function(href, page){
                if (page != "" && page != undefined) {
                    newsLinkDialog(elm, page);
                    return false;
                }
                var multiid = "<?php  echo $_GPC['multiid'];?>";
                if (multiid) {
                    href = /(&)?t=/.test(href) ? href : href + "&t=" + multiid;
                }
                ipt.val(href);
            }, page);
        });
    }
    function pageLinkDialog(elm, page) {
        require(["util","jquery"], function(u, $){
            var ipt = $(elm).parent().parent().parent().prev();
            u.pageBrowser(function(href, page){
                if (page != "" && page != undefined) {
                    pageLinkDialog(elm, page);
                    return false;
                }
                var multiid = "<?php  echo $_GPC['multiid'];?>";
                if (multiid) {
                    href = /(&)?t=/.test(href) ? href : href + "&t=" + multiid;
                }
                ipt.val(href);
            }, page);
        });
    }
    function articleLinkDialog(elm, page) {
        require(["util","jquery"], function(u, $){
            var ipt = $(elm).parent().parent().parent().prev();
            u.articleBrowser(function(href, page){
                if (page != "" && page != undefined) {
                    articleLinkDialog(elm, page);
                    return false;
                }
                var multiid = "<?php  echo $_GPC['multiid'];?>";
                if (multiid) {
                    href = /(&)?t=/.test(href) ? href : href + "&t=" + multiid;
                }
                ipt.val(href);
            }, page);
        });
    }
    function phoneLinkDialog(elm, page) {
        require(["util","jquery"], function(u, $){
            var ipt = $(elm).parent().parent().parent().prev();
            u.phoneBrowser(function(href, page){
                if (page != "" && page != undefined) {
                    phoneLinkDialog(elm, page);
                    return false;
                }
                ipt.val(href);
            }, page);
        });
    }
    function mapLinkDialog(elm) {
        var val = {lat:'',lng:''};
        require(["util","jquery"], function(u, $){
            var ipt = $(elm).parent().parent().parent().prev();
            u.map(elm, function(val){
                var href = 'http://api.map.baidu.com/marker?location='+val.lat+','+val.lng+'&output=html&src=we7';
                var multiid = "<?php  echo $_GPC['multiid'];?>";
                if (multiid) {
                    href = /(&)?t=/.test(href) ? href : href + "&t=" + multiid;
                }
                ipt.val(href);
            });
        });
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>