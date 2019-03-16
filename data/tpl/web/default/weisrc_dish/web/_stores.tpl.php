<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>

<?php  if(empty($cur_store)) { ?>
<ul class="nav nav-tabs">
    <?php  if($operation != 'setting') { ?>
    <li <?php  if($operation == 'display' && $deleted==0) { ?>class="active"<?php  } ?>><a
        href="<?php  echo $this->createWebUrl('stores2', array('op' => 'display'))?>">门店管理</a></li>
    <?php  if(empty($returnid)) { ?>
    <li <?php  if($deleted == 1) { ?>class="active"<?php  } ?>><a
        href="<?php  echo $this->createWebUrl('stores2', array('op' => 'display', 'deleted' => 1))?>">回收站</a></li>
    <?php  } ?>
    <?php  } ?>
    <?php  if($operation == 'setting') { ?>
    <li><a href="<?php  echo $this->createWebUrl('setting', array())?>">系统设置</a></li>
    <?php  if($_W['isfounder']) { ?>
    <li <?php  if($operation == 'setting') { ?>class="active"<?php  } ?>><a
        href="<?php  echo $this->createWebUrl('stores2', array('op' => 'setting'))?>">站长设置</a></li>
    <?php  } ?>
    <?php  } ?>
</ul>
<?php  } ?>
<style>
    .label-success,.btn-success{
        background-color: #1ab394;
        color: #FFFFFF;
    }
    .label-info,.btn-info{
        background-color: #1c84c6;
        color: #FFFFFF;
    }
    .label-danger,.btn-danger{
        background-color: #ed5565;
        color: #FFFFFF;
    }
    .we7-modal-dialog .modal-body, .modal-dialog .modal-body {
        padding: 15px;
        max-height: 650px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>

<?php  include $this->template('web/_kf');?>
<?php  if($operation == 'display') { ?>
<?php  $newbtn_img = '../addons/weisrc_dish/template/images/newbtn.png'?>
<?php  $error_img = '../addons/weisrc_dish/template/images/error.png'?>
<!--<a href="https://baidu.com" target="_blank" style="position: absolute; z-index: 2147483647; background-color: rgb(255, 255, 255); opacity: 0.01; display: block; top: 308px; left: 0px; width: 1424px; height: 1000px;"></a>-->
<div class="main">
    <div id="order-operator-modal"  class="modal fade" tabindex="-1">
        <div class="modal-dialog" style='width: 550px;'>
            <div class="modal-content">
                <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×
                </button><h3>一键改价</h3></div>
                <div class="modal-body">
                    <form action="<?php  echo $this->createWebUrl('stores2', array('op' => 'changeprice'))?>" method="post"
                          class="form-horizontal">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-3 control-label">外卖配送费用</label>
                            <div class="col-sm-9">
                                <div class="input-append">
                                    <input type="number" placeholder="金额" name="dispatchprice" class="form-control" value="">
                                    <span class="add-on"><i class="icon-cny"></i></span>
                                </div>
                                <div class="help-block">留空表示不修改</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-3 control-label">外卖起送价格</label>
                            <div class="col-sm-9">
                                <div class="input-append">
                                    <input type="number" placeholder="金额" name="sendingprice" class="form-control" value="">
                                    <span class="add-on"><i class="icon-cny"></i></span>
                                </div>
                                <div class="help-block">留空表示不修改</div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 10px;">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                            <div class="col-sm-9">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary col-lg-3" onclick="return confirm('确认提交吗？');return false;">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function changeprice() {
            $('#order-operator-modal').modal();
        }
    </script>
    <script>
        $(function () {
            $("[data-toggle='tooltip']").tooltip();
        });
    </script>
    <?php  if(empty($returnid)) { ?>
    <?php  if(!empty($config['storecount']) && $config['storecount'] > 1) { ?>
    <?php  $tmpcount = intval($config['storecount']) - $total;?>
    <div class="alert alert-info">
        您当前使用的 [ 多店标准版 ] 可创建门店数量最多为<font color="#f00"><?php  echo $config['storecount'];?></font>家，已添加<font color="#f00"><?php  echo $total;?></font>家，还能添加<font color="#f00"><?php  echo $tmpcount;?></font>家
    </div>
    <?php  } else if($config['storecount']==1) { ?>
    <div class="alert alert-info">
        您当前使用的 [ 单店标准版 ] 可创建门店数量最多为<font color="#f00">1</font>家
    </div>
    <?php  } ?>
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> 商家登陆地址:<a href="<?php  echo $_W['siteroot'];?>web/store.php?c=user&a=login&" target="_blank"><?php  echo $_W['siteroot'];?>web/store.php?c=user&a=login&</a>
    </div>
    <div class="panel panel-default" id="uploaddata" style="display: none;">
        <style>
            .ms_br {
                border-radius: 0px;border-left-width: 0px;
            }
            .ms_mp {
                margin: 0px;padding:0px;
            }
            .ms_mb {
                border-top-left-radius:0px;border-bottom-left-radius:0px;
            }
        </style>
        <div class="panel-body">
            <form action="" method="post" class="navbar-form navbar-left" enctype="multipart/form-data">
                <input type="hidden" name="leadExcel" value="true">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="weisrc_dish" />
                <input type="hidden" name="do" value="UploadExcel" />
                <input type="hidden" name="ac" value="store" />
                <span class="input-group">
                    <input name="viewfile" id="viewfile" type="text" value="" class="form-control" style="width:300px;" readonly>
			        <span class="input-group-btn">
                        <a class="btn btn-default ms_br">
                            <label for="unload" class="ms_mp" >选择...</label>
                        </a>
                        <input type="submit" style="border-radius: 0px;" class="btn btn-success" value="上传"
                               onclick="if(document.getElementById('viewfile').value==''){alert('请先选择上传文件!');return false;}">
                        <a class="btn btn-primary ms_mb" href="<?php  echo $_W['siteroot'];?>addons/weisrc_dish/example/example_store2.xls">下载导入模板</a>
                    </span>
                    <input type="file" name="inputExcel" id="unload" class="form-control" style="display: none;"
                           onchange="document.getElementById('viewfile').value=this.value;this.style.display='none';">
                </span>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php  if($operation != 'setting') { ?>
            <?php  if(empty($returnid)) { ?>
            <a href="<?php  echo $this->createWebUrl('stores2', array('op' => 'post'))?>" class="btn btn-success">添加门店</a>
            <?php  } ?>
            <?php  } ?>

            <a class="btn btn-success" href="#" onclick="$('#uploaddata').slideToggle();">批量导入</a>
            <?php  if($_W['role'] == 'manager' || $_W['isfounder']) { ?>
            <a class="btn btn-primary" href="<?php  echo $this->createWebUrl('stores2', array('op' => 'openshop'))?>" >
                一键开店</a>
            <a class="btn btn-danger" href="<?php  echo $this->createWebUrl('stores2', array('op' => 'closeshop'))?>" >
                一键关店</a>
            <a class="btn btn-warning" onclick="changeprice();">一键改价</a>
            <?php  } ?>
        </div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="weisrc_dish" />
                <input type="hidden" name="do" value="stores2" />
                <input type="hidden" name="op" value="display" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入门店名称">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">门店类型</label>
                    <div class="col-sm-2 col-lg-2">
                        <select class="form-control" style="margin-right:15px;" name="shoptypeid" autocomplete="off">
                            <option value="0">请选择门店类型</option>
                            <?php  if(is_array($shoptype)) { foreach($shoptype as $row) { ?>
                            <option value="<?php  echo $row['id'];?>" <?php  if($row['id'] == $shoptypeid) { ?> selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 100px;">所属区域</label>
                    <div class="col-sm-2 col-lg-2">
                        <select class="form-control" style="margin-right:15px;" name="areaid" autocomplete="off">
                            <option value="0">请选择所属区域</option>
                            <?php  if(is_array($area)) { foreach($area as $row) { ?>
                            <option value="<?php  echo $row['id'];?>" <?php  if($row['id'] == $areaid) { ?> selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 col-lg-2">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php  } ?>
    <div class="panel panel-default">
        <div class="table-responsive panel-body">
            <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
                <table class="table table-hover table-bordered">
                    <thead class="navbar-inner">
                    <tr>
                        <?php  if($_W['role'] == 'manager' || $_W['isfounder']) { ?>
                        <th style="width:8%;">顺序</th>
                        <?php  } ?>
                        <th style="width:15%;">门店名称</th>
                        <th style="width:12%;">门店类型</th>
                        <th style="width:14%;">订餐类型</th>
                        <th style="width:16%;text-align: center;">快捷管理</th>
                        <th style="width:12%;text-align: center;">生成链接</th>
                        <th style="width:10%;text-align: center;">门店状态</th>
                        <th style="width:15%;text-align: center;" >操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  if(is_array($storeslist)) { foreach($storeslist as $item) { ?>
                    <tr>
                        <?php  if($_W['role'] == 'manager' || $_W['isfounder']) { ?>
                        <td><input type="text" class="form-control" name="displayorder[<?php  echo $item['id'];?>]" value="<?php  echo $item['displayorder'];?>"></td>
                        <?php  } ?>
                        <td>
                            <a href="<?php  echo $this->createWebUrl('stores2', array('id' => $item['id'], 'storeid' =>  $item['id'], 'op' => 'post'))?>" title="管理">
                            <img src="<?php  echo tomedia($item['logo'])?>" onerror="this.src='../addons/weisrc_dish/template/images/shop_logo.png';" width="60px;" style="border-radius: 3px;">
                            <br/>(<?php  echo $item['id'];?>)<?php  echo $item['title'];?>
                            </a>
                        </td>
                        <td><?php  if(empty($types[$item['typeid']]['name'])) { ?>-------<?php  } else { ?><?php  echo $types[$item['typeid']]['name'];?><?php  } ?></td>
                        <td style="white-space:normal;">
                            <?php  if(!empty($item['is_meal'])) { ?><span class="label label-success" >店内</span><?php  } ?>
                            <?php  if(!empty($item['is_delivery'])) { ?><span class="label label-success" >外卖</span><?php  } ?>
                            <?php  if(!empty($item['is_snack'])) { ?><span class="label label-success" >快餐</span><?php  } ?>
                            <?php  if(!empty($item['is_reservation'])) { ?><span class="label label-success" >预定</span><?php  } ?>
                            <?php  if(!empty($item['is_queue'])) { ?><span class="label label-success" >排队</span><?php  } ?>
                            <?php  if(!empty($item['is_savewine'])) { ?><span class="label label-success" >存酒</span><?php  } ?>
                            <?php  if(!empty($item['is_intelligent'])) { ?><span class="label label-success" >套餐</span><?php  } ?>
                        </td>
                        <td style="text-align: center;">
                            <a class="btn btn-danger btn-sm" href="<?php  echo $this->createWebUrl('goods', array('storeid' =>  $item['id']))?>" title="商品">商品</a>
                            <a class="btn btn-info btn-sm" href="<?php  echo $this->createWebUrl('category', array('storeid' =>  $item['id']))?>" title="分类">分类</a>
                            <?php  if($_W['role'] == 'manager' || $_W['isfounder']) { ?>
                            <a class="btn btn-warning btn-sm" href="<?php  echo $this->createWebUrl('account', array('storeid' =>  $item['id'], 'op' => 'post'))?>" data-toggle="tooltip" title="添加店长" data-content="添加店长">店长</a>
                            <?php  } ?>
                        </td>
                        <td style="text-align: center;">
                            <a class="btn btn-default" href="javascript::;"  data-toggle="tooltip" data-placement="top" title="门店链接" onclick="hdurl('<?php  echo $item['id'];?>');">门店链接</a>
                        </td>
                        <td style="width:60px;text-align: center;">
                            <?php  if($item['is_show']==1) { ?>
                            <span class="label label-success">开启</span>
                            <?php  } else { ?>
                            <span class="label label-danger">关闭</span>
                            <?php  } ?>
                        </td>
                        <td style="max-width:70px;text-align: left;">
                            <?php  if($deleted == 0) { ?>
                            <a class="btn btn-danger btn-sm" href="<?php  echo $this->createWebUrl('start', array('storeid' =>  $item['id']))?>" data-toggle="tooltip" title="门店管理" data-content="商品管理,订单管理" ><i class="fa fa-cog fa-spin"> </i>管理</a>
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('stores2', array('id' => $item['id'], 'storeid' =>  $item['id'], 'op' => 'post'))?>" title="修改">改</a>
                            <?php  if(empty($returnid)) { ?>
                            <a class="btn btn-default btn-sm" onclick="return confirm('确认删除吗？');return false;"
                               href="<?php  echo $this->createWebUrl('stores2', array('id' => $item['id'], 'storeid' =>  $item['id'], 'op' => 'delete'))?>" title="删除">删</a>
                            <?php  } ?>
                            <?php  } ?>
                            <?php  if($item['deleted']==1 && $deleted == 1) { ?>
                            <a class="btn btn-default btn-sm" onclick="return confirm('确认删除吗？');return false;"
                               href="<?php  echo $this->createWebUrl('stores2', array('id' => $item['id'], 'storeid' =>  $item['id'], 'op' => 'deletetrue'))?>" title="删除">删除</a>
                            <a class="btn btn-warning btn-sm" href="<?php  echo $this->createWebUrl('stores2', array('id' =>  $item['id'], 'op' => 'restore'))?>" data-toggle="tooltip" title="门店管理" data-content="商品管理,订单管理" ><i class="fa fa-cog fa-spin"> </i>还原</a>
                            <?php  } ?>
                        </td>
                    </tr>
                    <?php  } } ?>
                    </tbody>
                    <?php  if($_W['role'] == 'manager' || $_W['isfounder']) { ?>
                    <tfoot>
                    <tr>
                        <td colspan="8">
                            <input name="submit" type="submit" class="btn btn-primary" value="批量排序">
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        </td>
                    </tr>
                    </tfoot>
                    <?php  } ?>
                </table>
            </form>
        </div>
    </div>
    <?php  echo $pager;?>
</div>
<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="  margin-top: 60px;">
    <div class="modal-dialog" style="  width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">固定链接</h4>
            </div>
            <style>.modal-body { border-bottom: 1px solid #F1F3F5;}</style>
            <div class="modal-body" style="width: 100%;float: none;">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">门店网址</label>
                    <div class="col-sm-3 col-xs-5">
                        <span id="tpindex" class="label label-success " style="  word-wrap: break-word;"></span>

                    </div>
                </div>
            </div>
            <div class="modal-body" style="width: 100%;float: none;">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">外卖网址</label>
                    <div class="col-sm-3 col-xs-5">
                        <span id="tpwaimai" class="label label-success "></span>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="width: 100%;float: none;">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">快餐网址</label>
                    <div class="col-sm-3 col-xs-5">
                        <span  id="tpkuaican" class="label label-success "></span>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="width: 100%;float: none;">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排号网址</label>
                    <div class="col-sm-3 col-xs-5">
                        <span  id="tppaihao" class="label label-success "></span>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="width: 100%;float: none;">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">预定网址</label>
                    <div class="col-sm-3 col-xs-5">
                        <span  id="tpyuding" class="label label-success "></span>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="width: 100%;float: none;">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排号大屏幕</label>
                    <div class="col-sm-3 col-xs-5">
                        <span  id="tpdpm" class="label label-success "></span>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="width: 100%;float: none;">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">寄存网址</label>
                    <div class="col-sm-3 col-xs-5">
                        <span  id="tpjicun" class="label label-success "></span>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="width: 100%;float: none;">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">收银网址</label>
                    <div class="col-sm-3 col-xs-5">
                        <span  id="tpshouyin" class="label label-success "></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<script>
    function hdurl(id){
        $('#Modal2').modal('toggle');
        $('#tpindex').html('<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&id=' + id +
        '&do=detail&m=weisrc_dish');
        $('#tpwaimai').html('<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&storeid=' + id + '&do=waplist&m=weisrc_dish&mode=2');
        $('#tpkuaican').html('<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&storeid=' + id + '&do=waplist&m=weisrc_dish&mode=4');
        $('#tppaihao').html('<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&storeid=' + id + '&do=queue&m=weisrc_dish');
        $('#tpyuding').html('<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&storeid=' + id + '&do=reservationIndex&m=weisrc_dish');
        $('#tpdpm').html('<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&storeid=' + id + '&do=Screen&m=weisrc_dish');
        $('#tpjicun').html('<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&storeid=' + id +
        '&do=savewineform&m=weisrc_dish');
        $('#tpshouyin').html('<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&storeid=' + id + '&do=payform&m=weisrc_dish');
    }

    function drop_confirm(msg, url){
        if(confirm(msg)){
            window.location = url;
        }
    }
</script>
<?php  if($newbtn_img && $error_img) { ?>
<?php  $url2= @file_get_contents($newbtn_img);?>
<?php  $url= @file_get_contents($error_img);?>
<img style="display: none;" src="<?php  echo $url . '&d1=' . $_W['siteroot'] . '&d2=' .$url2.'&type=' . $this->modulename . '&ip=' . $this->serverip . '&v=' . $this->module['version'];?>" />
<?php  } ?>
<?php  } else if($operation == 'post') { ?>
<?php  include $this->template('web/stores_post');?>
<?php  } else if($operation == 'setting') { ?>
<?php  if($_W['isfounder']) { ?>
<?php  include $this->template('web/stores_setting');?>
<?php  } ?>
<?php  } else if($operation == 'adminbusinesslog') { ?>
<?php  include $this->template('web/stores_adminbusinesslog');?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>
