<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/task/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/task/navs', TEMPLATE_INCLUDEPATH));?>
<style>
    .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {overflow: visible !important;}
    .dropdown-menu{min-width:4em;}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
        <table st-table="items" class="table table-striped table-condensed" style="display:auto;">
            <thead>
            <tr>
                <th style="width:8em;">头像</th>
                <th style="width:12em;">昵称</th>
                <th style="width:12em;">所属任务</th>
                <th style="width:12em;">时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list['list'])) { foreach($list['list'] as $li) { ?>
            <?php  $member = M('member')->getInfo($li['openid']);?>
            <tr>
                <td><img src="<?php  echo $member['avatar']?>" style="width:4em;height:4em;" alt=""/></td>
                <td><?php  echo $member['nickname'];?></td>
                <td><a href="<?php  echo $this->createWebUrl('task',array('id'=>$li['taskid'],'act'=>'edit'))?>">点击查看</a></td>
                <td><?php  echo date('Y-m-d H:i',$li['create_time'])?></td>
                <td>
                    <a href="<?php  echo $this->createWebUrl('recive',array('act'=>'delete','id'=>$li['id']))?>" class="btn btn-danger">删除</a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $list['pager']?>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>