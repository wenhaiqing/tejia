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
        幻灯片管理
    </div>
    <div class="panel-body">
        <table st-table="items" class="table table-striped table-condensed" style="display:auto;">
            <thead>
            <tr>
                <th style="width:12em;">标题</th>
                <th style="width:8em;">广告图片</th>
                <th style="width:8em;">位置</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list['list'])) { foreach($list['list'] as $li) { ?>
            <tr>
                <td><?php  echo $li['title'];?></td>
                <td><img src="<?php  echo tomedia($li['image'])?>" style="width:4em;height:4em;" alt=""/></td>
                <td>
                    <label class="label label-info"><?php  echo $options[$li['position']];?></label>
                </td>
                <td>
                    <a href="<?php  echo $this->createWebUrl('advs',array('act'=>'edit','activeid'=>$activeid,'id'=>$li['id']))?>" class="btn btn-default">编辑</a>
                    <a href="<?php  echo $this->createWebUrl('advs',array('act'=>'delete','activeid'=>$activeid,'id'=>$li['id']))?>" class="btn btn-danger">删除</a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $list['pager']?>
    </div>

    <div class="panel-footer">
        <a href="<?php  echo $this->createWebUrl('advs',array('act'=>'edit','activeid'=>$activeid))?>" class="btn btn-default">新增</a>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>