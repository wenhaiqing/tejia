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
        <table st-table="items" class="table table-striped table-condensed" style="display:auto;">
            <thead>
            <tr>
                <th style="width:12em;">显示顺序</th>
                <th style="width:8em;">导航标题</th>
                <th style="width:30em;">导航链接</th>
                <th style="width:6em;">导航图标</th>
                <th style="width:5em;">位置</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list['list'])) { foreach($list['list'] as $li) { ?>
            <tr>
                <td><?php  echo $li['displayorder'];?></td>
                <td><?php  echo $li['title'];?></td>
                <td><?php  echo $li['link'];?></td>
                <td><i class="<?php  echo $li['icon']?>"></i></td>
                <td>
                    <label for="" class="label label-info">
                        <?php  if($li['position']=='user') { ?>
                            客户端
                        <?php  } else if($li['position']=='runner') { ?>
                            服务端
                        <?php  } else if($li['position']=='runner_home') { ?>
                            跑腿中心
                        <?php  } else if($li['position'] == 'user_home') { ?>
                            用户中心
                        <?php  } ?>
                    </label>
                </td>
                <td>
                    <a href="<?php  echo $this->createWebUrl('navs',array('act'=>'edit','position'=>$position,'id'=>$li['id']))?>" class="btn btn-default">编辑</a>
                    <a href="<?php  echo $this->createWebUrl('navs',array('act'=>'delete','position'=>$position,'id'=>$li['id']))?>" class="btn btn-danger">删除</a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $list['pager']?>
    </div>
    <div class="panel-footer">
        <a href="<?php  echo $this->createWebUrl('navs',array('act'=>'edit','position'=>$position))?>" class="btn btn-default">新增</a>
        <?php  if(!empty($position)) { ?>
        <a href="<?php  echo $this->createWebUrl('onekey',array('act'=>$position))?>" class="btn btn-success">一键配置</a>
        <?php  } ?>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>