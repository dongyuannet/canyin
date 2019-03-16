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
		<input type="hidden" name="action" value="cz" />
        <div class="panel panel-default">
            <div class="panel-heading">
                会员卡信息
            </div>
            <div class="panel-body">

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员卡号</label>
                    <div class="col-sm-9">
                        <input type="text" name="num" class="form-control" value="<?php  echo $item['num'];?>" readonly="readonly" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开卡金额</label>
                    <div class="col-sm-9">
                        <input type="text" name="price" class="form-control" value="<?php  echo $item['price'];?>" readonly="readonly"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">姓名</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" value="<?php  echo $item['name'];?>" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">联系电话</label>
                    <div class="col-sm-9">
                        <input type="text" name="phone" id="tel" value="<?php  echo $item['phone'];?>" class="form-control" readonly="readonly">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">余额</label>
                    <div class="col-sm-9">
                        <input type="number" name="yue" id="" value="<?php  echo $item['yue'];?>" class="form-control" readonly="readonly">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">充值金额</label>
                    <div class="col-sm-9">
                        <input type="number"  step="0.01" name="jine" id="" value="" class="form-control" >
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

<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>