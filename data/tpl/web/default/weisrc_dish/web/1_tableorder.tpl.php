<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<style>
    /*top1.html*/
    .topleft1{background-color:#f8f8f8; height:58px; border:1px solid #ebebeb;margin-bottom: 10px;}
    .topright1 li{display:inline-block; line-height:60px; font-size:16px; color:#666; width:210px; padding-left:10px;}
    .topright1 li a{font-size:16px;}
    .xian{border-left:1px solid #DCDCDC; line-height:45px; display:block; padding-left:10px;}
    .topright1 li img{margin-left:5px; width:28px; vertical-align:middle; margin-top:-2px;}
</style>
<?php  if($operation == '') { ?>


<?php  } else if($operation == 'display') { ?>
<style>
    .page-nav {
        margin: 0;
        width: 100%;
        min-width: 800px;
    }

    .page-nav > li > a {
        display: block;
    }

    .page-nav-tabs {
        background: #EEE;
    }

    .page-nav-tabs > li {
        line-height: 40px;
        float: left;
        list-style: none;
        display: block;
        text-align: -webkit-match-parent;
    }

    .page-nav-tabs > li > a {
        font-size: 14px;
        color: #666;
        height: 40px;
        line-height: 40px;
        padding: 0 10px;
        margin: 0;
        border: 1px solid transparent;
        border-bottom-width: 0px;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
    }

    .page-nav-tabs > li > a, .page-nav-tabs > li > a:focus {
        border-radius: 0 !important;
        background-color: #f9f9f9;
        color: #999;
        margin-right: -1px;
        position: relative;
        z-index: 11;
        border-color: #c5d0dc;
        text-decoration: none;
    }

    .page-nav-tabs >li >a:hover {
        background-color: #FFF;
    }

    .page-nav-tabs > li.active > a, .page-nav-tabs > li.active > a:hover, .page-nav-tabs > li.active > a:focus {
        color: #576373;
        border-color: #c5d0dc;
        border-top: 2px solid #4c8fbd;
        border-bottom-color: transparent;
        background-color: #FFF;
        z-index: 12;
        margin-top: -1px;
        box-shadow: 0 -2px 3px 0 rgba(0, 0, 0, 0.15);
    }
    .shop-preview {
        position: fixed;
        padding: 0 15px;
        bottom: 0;
        right: 0;
        z-index: 100;
        width: 83.33333333%;
    }
    .shop-preview div {
        filter:alpha(opacity=20);
    }
</style>
<div class="main">
    <!-- <div class="alert alert-info">
        <i class="fa fa-info-circle"></i>提示：<br/>
        1.未处理订单表示商家未接单，确认订单表示商家已接单，完成订单表示交易成功，若设置积分顾客可以获得积分。<br/>
        2.完成和取消操作才有信息提醒用户，其它操作想信息提醒，请勾选单子后点通知按钮。
    </div> -->
    <div class="panel panel-default">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="weisrc_dish" />
                <input type="hidden" name="do" value="tableorder" />
                <input type="hidden" name="op" value="display" />
                <input type="hidden" name="storeid" value="1" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:90px;">订单号</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="ordersn" id="" type="text" value="<?php  echo $_GPC['ordersn'];?>">
                    </div>
                    
                    
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:90px;">桌台号</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="table"  type="text" value="<?php  echo $_GPC['table'];?>">
                    </div>
                    

                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width: 90px;">支付状态</label>
                   
                    <div class="col-sm-3 col-lg-3">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                        <!-- <button class="btn btn-success" name="out_put" value="output"><i class="fa fa-file"></i> 导出</button> -->
                        <!-- <button class="btn btn-success" name="out_put" value="out_goods"><i class="fa fa-file"></i>
                            导出(商品)
                        </button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row-fluid">
                <div class="span3 control-group">
                    总记录:<strong class="text-danger"><?php  echo $total;?></strong>

                    ,订单总金额:<strong class="text-danger"><?php  echo $order_price;?></strong>

                </div>
            </div>
        </div>
        <form action="" method="post" class="form-horizontal form" >
            <input type="hidden" name="storeid" value="<?php  echo $storeid;?>" />
            <div class="table-responsive panel-body">
                <table class="table  table-bordered">
                    <thead class="navbar-inner">
                        <tr>
                            <th class='with-checkbox' style="width:2%;"><input type="checkbox" class="check_all" /></th>
                            <th style="width:5%;">编号</th>
                            <th style="width:10%;">订单ID</th>
                            <th style="width:15%;">订单号</th>
                            <th style="width:10%;">桌台号</th>
                            <th style="width:8%;">应收金额</th>
                            <th style="width:8%;">实收金额</th>
                            <th style="width:8%;">支付类型</th>
                            <th style="width:8%;">使用股东卡</th>
                            <th style="width:5%;">操作人id</th>
                            <th style="width:10%;">创建时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  if(is_array($list)) { foreach($list as $item) { ?>
                        <tr>
                            <td class="with-checkbox"><input type="checkbox" name="check" value="<?php  echo $item['id'];?>"></td>
                            <td>
                                <?php  echo $item['id'];?>
                            </td>
                            <td>
                                <?php  echo $item['orderids'];?>
                            </td>
                            <td>
                                <?php  echo $item['ordersns'];?>
                            </td>
                            <td>
                                <?php  echo $item['tableid'];?> - <?php  echo $item['table'];?>
                            </td>
                            <td>
                                <?php  echo $item['totalprice'];?>
                            </td>
                            <td>
                                <?php  echo $item['money'];?>
                            </td>
                            <td>
                                
                                <?php  if($item['paytype'] == 0) { ?>
                                <span class="label label-success"><i class="fa fa-money">&nbsp;线下付款</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 1) { ?>
                                <span class="label label-success"><i class="fa fa-money">&nbsp;余额支付</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 2) { ?>
                                <span class="label label-success"><i class="fa fa-check-circle">&nbsp;微信支付</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 3) { ?>
                                <span class="label label-success"><i class="fa fa-money">&nbsp;现金支付</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 4) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;支付宝</i></span>
                                <?php  } ?>
                                <!--5现金，6银行卡，7会员卡，8微信，9支付宝-->
                                <?php  if($item['paytype'] == 5) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;现金</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 6) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;银行卡</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 7) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;会员卡</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 8) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;微信(线下)</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 9) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;支付宝(线下)</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 10) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;pos刷卡</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 11) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;挂帐</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 12) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;vip卡</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 13) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;午餐卡(现金)</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 14) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;午餐卡(微信)</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 15) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;午餐卡(支付宝)</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 16) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;午餐卡(pos刷卡)</i></span>
                                <?php  } ?>
                                <?php  if($item['paytype'] == 17) { ?>
                                <span class="label label-info"><i class="fa fa-alipay">&nbsp;午餐卡(挂账)</i></span>
                                <?php  } ?>
                                <br/>
                                
                                
                            </td>
                            <td>
                                <?php  if($item['usedong'] ==1 ) { ?>是<?php  } else { ?>否<?php  } ?>
                            </td>
                            <td>
                                <?php  echo $item['actionid'];?>
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
            <div style="height: 50px;"></div>
        </form>
    </div>
</form>

</div>



<?php  } else if($operation == 'detail') { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/order_detail', TEMPLATE_INCLUDEPATH)) : (include template('web/order_detail', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>