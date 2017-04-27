<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/template/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/template/navs', TEMPLATE_INCLUDEPATH));?>
<style>
    .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {overflow: visible !important;}
    .dropdown-menu{min-width:4em;}
    .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {white-space: normal !important;overflow: visible !important;}
    .dropdown{display:inline-block !important;}
    .account-stat-num > div {width: 25%;float: left;font-size: 16px;text-align: center;}
    .account-stat-num > div span {display: block;font-size: 30px;font-weight: bold;}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        信誉等级
    </div>
    <div class="panel-body">
        <table st-table="items" class="table table-striped table-condensed" style="display:auto;">
            <thead>
            <tr>
                <th style="width:6em;">跑腿等级</th>
                <th style="width:12em;">等级名称</th>
                <th style="width:12em;">需要信誉度</th>
                <th style="width:6em;">等级标识</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list['list'])) { foreach($list['list'] as $li) { ?>
            <tr>
                <td><?php  echo $li['displayorder'];?></td>
                <td><?php  echo $li['title'];?></td>
                <td>
                    <label class="label label-info"><?php  echo $li['xinyu'];?></label>
                </td>
                <td><img src="<?php  echo tomedia($li['icon'])?>" style="width:4em;height:4em;" alt=""/></td>
                <td>
                    <a href="<?php  echo $this->createWebUrl('runner_level',array('act'=>'edit','id'=>$li['id']))?>" class="btn btn-default">编辑</a>
                    <a href="<?php  echo $this->createWebUrl('runner_level',array('act'=>'delete','id'=>$li['id']))?>" class="btn btn-danger">删除</a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $list['pager']?>
    </div>

    <div class="panel-footer">
        <a href="<?php  echo $this->createWebUrl('runner_level',array('act'=>'edit'))?>" class="btn btn-default">新增</a>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>