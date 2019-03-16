<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<?php  if($operation == 'post') { ?>
<div class="main">
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-warning" href="<?php  echo $this->createWebUrl('cardlist', array('op' => 'display', 'storeid' => $storeid))?>">返回会员卡管理
            </a>
        </div>
    </div>
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
        <div class="panel panel-default">
            <div class="panel-heading">
                会员卡信息
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">类型</label>
                    <div class="col-sm-9">
                        <label for="status1" class="radio-inline"><input type="radio" name="type" value="1" id="status1" <?php  if(empty($item) || $item['type'] == 1) { ?>checked="true"<?php  } ?> /> vip卡</label>
                        <label for="status2" class="radio-inline"><input type="radio" name="type" value="2" id="status2"  <?php  if(!empty($item) && $item['type'] == 2) { ?>checked="true"<?php  } ?> /> 股东卡</label>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员卡号</label>
                    <div class="col-sm-9">
                        <input type="text" name="num" class="form-control" value="<?php  echo $item['num'];?>" <?php  if(!empty($id)) { ?>readonly=""<?php  } ?>/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开卡金额</label>
                    <div class="col-sm-9">
                        <input type="text" name="price" class="form-control" value="<?php  echo $item['price'];?>" <?php  if(!empty($id)) { ?>readonly=""<?php  } ?>   />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">姓名</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" value="<?php  echo $item['name'];?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">联系电话</label>
                    <div class="col-sm-9">
                        <input type="text" name="phone" id="tel" value="<?php  echo $item['phone'];?>" class="form-control">
                    </div>
                </div>
                
                
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-3" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
	</form>
</div>
<?php  } else if($operation == 'display') { ?>
<div class="main">
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./store.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="weisrc_dish" />
                <input type="hidden" name="do" value="cardlist" />
                <input type="hidden" name="op" value="display" />
                <input type="hidden" name="storeid" value="<?php  echo $storeid;?>" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 100px;">关键字</label>
                    <div class="col-sm-3 col-lg-4">
                        <input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入会员卡号/姓名/手机号">
                    </div>
                    <div class="col-sm-2 col-lg-1">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                    <div class="col-sm-2 col-lg-1">
                        <a href="<?php  echo $this->createWebUrl('CardList', array('op' => 'post', 'storeid' => $storeid))?>"
                           class="btn btn-success">添加会员卡</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div style="margin: 10px 0;" class="clearfix">
        <div class="btn-group pull-left" style="margin-right: 10px;">
            <a class="btn btn-default <?php  if($status == 0) { ?>active<?php  } ?>" href="<?php  echo $this->createWebUrl('cardlist', array('op' => 'display', 'storeid' => $storeid))?>">
                全部
            </a>

            <a class="btn btn-default <?php  if($status == 1) { ?> active<?php  } ?>" href="<?php  echo $this->createWebUrl('cardlist', array('op' => 'display', 'status' => 1, 'storeid' => $storeid))?>">
                vip卡
            </a>
            <a class="btn btn-default <?php  if($status == 2) { ?> active<?php  } ?>" href="<?php  echo $this->createWebUrl('cardlist', array('op' => 'display', 'status' => 2, 'storeid' => $storeid))?>">
                股东卡
            </a>
        </div>
    </div>
    <div class="panel panel-default" style="float: left;">
        <form action="" method="post" class="form-horizontal form">
            <div class="table-responsive panel-body">
                <table class="table table-hover">
                    <thead class="navbar-inner">
                    <tr>
                        <th style="width:8%;">编号</th>
                        <th style="width:12%;">会员卡号</th>
                        <th style="width:12%;">姓名</th>
                        <th style="width:12%;">手机号</th>
                        <th style="width:8%;">开卡金额</th>
                        <th style="width:8%;">卡内余额</th>
                        <th style="width:8%;">类型</th>
                        <th style="width:8%;">操作人id</th>
                        <th style="width:8%;">添加时间</th>
                        <th style="width:12%;text-align: center;">操作</th>
                    </tr>
                    </thead>
                    <tbody id="level-list">
                    <?php  if(is_array($list)) { foreach($list as $item) { ?>
                    <tr>
                        <td><?php  echo $item['id'];?></td>
                        <td>
                            <?php  echo $item['num'];?>
                        </td>
                        <td>
                            <?php  echo $item['name'];?>
                        </td>
                        <td>
                            <?php  echo $item['phone'];?>
                        </td>
                        <td>
                            <?php  echo $item['price'];?>
                        </td>
                        <td>
                            <?php  echo $item['yue'];?>
                        </td>
                        <td>
                            <?php  if($item['type']==1) { ?>
                            vip卡
                            <?php  } ?>
                            <?php  if($item['type']==2) { ?>
                            股东卡
                            <?php  } ?>
                        </td>
                        <td>
                            <?php  echo $item['action_id'];?>
                        </td>
                        <td>
                            <?php  echo $item['created_at'];?>
                        </td>
                        <td align="center">
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('cardlist', array('op' => 'post', 'id' => $item['id'], 'storeid' => $storeid))?>" title="编辑">改</a>
                            <a class="btn btn-default" href="<?php  echo $this->createWebUrl('cardlist', array('op' => 'post','ac'=>1, 'id' => $item['id'], 'storeid' => $storeid))?>" title="充值">充</a>
                             <a class="btn btn-default" href="<?php  echo $this->createWebUrl('cardlist', array('op' => 'post','re'=>1, 'id' => $item['id'], 'storeid' => $storeid))?>" title="充值记录">记</a>
                            
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
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>