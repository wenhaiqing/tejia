<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-meepo', TEMPLATE_INCLUDEPATH)) : (include template('common/header-meepo', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/task/navs', TEMPLATE_INCLUDEPATH)) : (include template('web/task/navs', TEMPLATE_INCLUDEPATH));?>
<style>
    .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {overflow: visible !important;}
    .dropdown-menu{min-width:4em;}
    .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {white-space: normal !important;overflow: visible !important;}
    .dropdown{display:inline-block !important;}
    .account-stat-num > div {width: 25%;float: left;font-size: 16px;text-align: center;}
    .account-stat-num > div span {display: block;font-size: 30px;font-weight: bold;}
</style>
<div class="panel panel-default" style="padding:1em">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="z-index:1;margin: -1em -1em 1em -1em;">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:;">数据统计</a>
        </div>
    </nav>
    <div class="panel-body">
        <div class="account-stat-num row">
            <?php  $m = M('star')->totalstar();?>
            <div>总数<span><?php  echo $m['all']['sum'];?></span></div>
            <div>本日总数<span><?php  echo $m['day']['sum'];?></span></div>
            <div>本周总数<span><?php  echo $m['week']['sum'];?></span></div>
            <div>本月总数<span><?php  echo $m['month']['sum'];?></span></div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        评星记录
    </div>
    <div class="panel-body">
        <table st-table="items" class="table table-striped table-condensed" style="display:auto;">
            <thead>
            <tr>
                <th style="width:8em;">评价人昵称</th>
                <th style="width:6em;">评价人头像</th>
                <th style="width:8em;">被评价昵称</th>
                <th style="width:6em;">被评价头像</th>
                <th style="width:10em;">任务</th>
                <th style="width:5em;">星星个数</th>
                <th style="width:10em;">评价内容</th>
                <th style="width:12em;">评价时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list['list'])) { foreach($list['list'] as $li) { ?>
            <?php  $from = M('member')->getInfo($li['from_openid'])?>
            <?php  $to = M('member')->getInfo($li['to_openid'])?>
            <tr>
                <td><?php  echo $from['nickname'];?></td>
                <td><img src="<?php  echo $from['avatar']?>" style="width:4em;height:4em;" alt=""/></td>
                <td><?php  echo $to['nickname'];?></td>
                <td><img src="<?php  echo $to['avatar']?>" style="width:4em;height:4em;" alt=""/></td>
                <td><a href="<?php  echo $this->createWebUrl('task',array('id'=>$li['taskid'],'act'=>'edit'))?>">点击查看</a></td>
                <td><?php  echo $li['star'];?></td>
                <td><?php  echo $li['content'];?></td>
                <td>
                    <label class="label label-success"><?php  echo date('Y-m-d H:i',$li['create_time'])?></label>
                </td>
                <td>
                    <a href="<?php  echo $this->createWebUrl('star',array('act'=>'edit','id'=>$li['id']))?>" class="btn btn-default">编辑</a>
                    <a href="<?php  echo $this->createWebUrl('star',array('act'=>'delete','id'=>$li['id']))?>" class="btn btn-danger">删除</a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $list['pager']?>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>