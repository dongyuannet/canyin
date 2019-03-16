<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<div class="main">
    
    <div class="panel panel-default" style="float: left;">
        <form action="" method="post" class="form-horizontal form">
            <div class="table-responsive panel-body">
                <table class="table table-hover">
                    <thead class="navbar-inner">
                    <tr>
                        <th style="width:8%;">编号</th>
                        <th style="width:8%;">会员卡id</th>
                        <th style="width:12%;">会员卡号</th>
                        <th style="width:8%;">金额</th>
                        <th style="width:8%;">操作人id</th>
                        <th style="width:8%;">订单id</th>
                        <th style="">添加时间</th>

                    </tr>
                    </thead>
                    <tbody id="level-list">
                    <?php  if(is_array($list)) { foreach($list as $item) { ?>
                    <tr>
                        <td><?php  echo $item['id'];?></td>
                        <td>
                            <?php  echo $item['cid'];?>
                        </td>
                        <td>
                            <?php  echo $item['num'];?>
                        </td>
 
                        <td>
                            <?php  echo $item['price'];?>
                        </td>
                        
                        <td>
                            <?php  echo $item['action_id'];?>
                        </td>
                         <td>
                            <?php  echo $item['order_id'];?>
                        </td>
                        <td>
                            <?php  echo $item['created_at'];?>
                        </td>
                        
                    </tr>
                    <?php  } } ?>
                    </tbody>
                </table>
                <?php  echo $pager;?>
            </div>
        </form>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>