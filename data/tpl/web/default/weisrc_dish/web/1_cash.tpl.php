<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>

<?php  if($operation == 'display') { ?>
<link rel="stylesheet" type="text/css" href="<?php  echo $_W['siteroot'];?>addons/weisrc_dish/template/css/main.css"/>
<style>
    .qr-code-table .qr-code-item {
        width: 150px;
    }
    ol,ul {
        list-style: none;
        padding-left: 10px;
    }
    .guige {
        border-bottom: 1px solid #f0f0f0;width: 100%;font-size: 14px;line-height: 20px;margin:4px 0 2px;
    }
    span {
        display: inline-block;
    }

    #addShow ul li{
        padding: 6px 0;
        float: left;
        width: 50px;
        border: 1px solid #f0f0f0;
        font-size: 12px;
        line-height: 20px;
        text-align: center ;
        margin-right: 8px;
        margin-top: 10px;

    }

    #addShow ul li.on{
        padding: 6px 0;
        float: left;
        width: 50px;
        /*border: 1px solid #fea000;*/
        border: 1px solid #FE4F4E;
        background-color: #FE4F4E;
        color: #fff;
        font-size: 12px;
        line-height: 20px;
        text-align: center ;
        margin-right: 8px;
        margin-top: 10px;
    }

    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
        color: #FFF;
        background-color: #20a0ff;
        border-color: #20a0ff;
        border-radius: 5px;
    }
    .qr-code-table .qr-code-item {
        float: left;
        /*! width: 200px; */
        margin: 0px 10px 10px 0;
        text-align: center;
        color: #555555
    }
    .i-add-btn{
        padding:0 7px 2px;  line-height:20px; text-align:center; border-radius:20px;  font-size:20px;
        /*background-color:#fbd163;*/
        background-color:#FE4F4E;
        color: #fff;
    }
    .i-remove-btn{
        border: 1px solid #a7a2a9;padding:0 8px 2px 8px;  line-height:19px; text-align:center;
        border-radius:20px; font-size:19px
    }
</style>
<div class="main" style="margin-top: 0px;padding-right: 10px;padding-left: 10px;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color: #f00;">此页面用来查询合适商品，代顾客下单</div>
        <div class="panel-body">
            <form action="" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="weisrc_dish" />
                <input type="hidden" name="do" value="cash" />
                <input type="hidden" name="op" value="display" />
                <input type="hidden" name="storeid" value="<?php  echo $storeid;?>" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:90px;">商品分类</label>
                    <div class="col-sm-8 col-lg-2 col-xs-12">
                        <select style="margin-right:15px;" name="category_id" class="form-control">
                            <option value="0">请选择商品分类</option>
                            <?php  if(is_array($category)) { foreach($category as $row) { ?>
                            <option value="<?php  echo $row['id'];?>" <?php  if($row['id'] == $_GPC['category_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="width:90px;">商品名称</label>
                    <div class="col-sm-2 col-lg-2">
                        <input class="form-control" name="keyword" id="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>">
                    </div>
                    <div class="col-sm-3 col-lg-3">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-2 col-lg-8" style="margin: 0px;padding: 0px;width: 62%;">
        <ul class="nav nav-tabs" role="tablist">
            <?php  if(is_array($category)) { foreach($category as $row) { ?>
            <li <?php  if($row['id']==$_GPC['category_id']) { ?>class="active"<?php  } ?>>
                <a href="<?php  echo $this->createWebUrl('cash', array('op' => 'display', 'storeid' => $storeid, 'category_id' => $row['id']))?>"><?php  echo $row['name'];?></a>
            </li>
            <?php  } } ?>
        </ul>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row-fluid">
                <div class="span3 control-group">
                    请选择商品
                </div>
            </div>
        </div>
        <form action="" method="post" class="form-horizontal form" >
            <input type="hidden" name="storeid" value="<?php  echo $storeid;?>" />
            <div class="table-responsive panel-body">
                <div class="qr-code-table">
                    <?php  if(is_array($list)) { foreach($list as $item) { ?>
                    <div class="qr-code-item">
                        <a <?php  if($item['isoptions']==1) { ?>onclick="tan(<?php  echo $item['id'];?>);"<?php  } else { ?>onclick="addfood(<?php  echo $item['id'];?>);"<?php  } ?>  id="dishid_<?php  echo $item['id'];?>" dishid="<?php  echo $item['id'];?>">
                            <div class="qr-code-box">
                                <div class="qr-code-item-image">
                                    <img alt="<?php  echo $item['title'];?>" src="<?php  echo tomedia($item['thumb']);?>"  onerror="this.src='../addons/weisrc_dish/icon.jpg';" width="100px" height="100px">
                                </div>
                                <div class="qr-code-item-info" style="overflow:hidden;background-color: #08afe6;
    color: #fff;"><?php  echo $item['title'];?>
                                </div>
                                <div class="qr-code-item-info" style="overflow: hidden;">
                                    ￥<?php  echo $item['marketprice'];?>/<?php  echo $item['unitname'];?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php  } } ?>
                    <div class="space"></div>
                </div>
            </div>
        </form>
    </div>
    </div>
    <div class="col-sm-2 col-lg-4"   style="margin: 0px;padding: 0px;padding-left: 10px;width: 38%;">
        <div class="panel panel-default" style="width: 100%;">
            <div class="panel-heading">
                <div class="row-fluid">
                    <div class="span3 control-group">
                        订单信息 <a class="btn btn-warning btn-sm clear-btn" >清空购物车</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive panel-body">
                <table class="table table-hover text-center" id="native-scroll" style="min-width:100%;">
                    <tr><td style="width: 40%;">名称</td><td>数量</td><td>单价</td><td>操作</td></tr>
                    <?php  if(is_array($cart)) { foreach($cart as $item) { ?>
                    <?php  if($item['total']>0) { ?>
                    <tr dishid="<?php  echo $item['goodsid'];?>" optionid="<?php  echo $item['optionid'];?>"><td><?php  echo $item['goodstitle'];?><?php  if(!empty($item['optionname'])) { ?>[<?php  echo $item['optionname'];?>]<?php  } ?></td><td class="total"><?php  echo $item['total'];?></td><td>¥<font><?php  echo $item['price'];?></font></td><td><i class="i-add-btn">+</i> <i class="i-remove-btn">-</i></td></tr>
                    <?php  } ?>
                    <?php  } } ?>
                </table>
            </div>
            <div class="panel-footer">
                <h5>商品价格:<strong class="text-danger" id="goodsprice"><?php  echo $totalprice;?></strong></h5>
            </div>
        </div>
        <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row-fluid">
                        <div class="span3 control-group">
                            用户信息
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-4 control-label">订单类型</label>
                        <div class="col-sm-10 col-lg-6">
                            <select class="form-control" name="mode" id="mode" autocomplete="off">
                                <option value="1" >店内</option>
                                <option value="2" >外卖</option>
                                <option value="4" >快餐</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-4 control-label">支付方式</label>
                        <div class="col-sm-10 col-lg-6">
                            <select class="form-control" name="paytype" id="paytype" autocomplete="off">
                                <option value="3" >现金付款</option>
                                <option value="10" >pos刷卡</option>
                                <option value="11" >挂帐</option>
                                <!--<option value="1" >余额支付</option>-->
                                <!--<option value="2" >微信支付</option>-->
                                <!--<option value="4" >支付宝</option>-->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-4 control-label">支付状态</label>
                        <div class="col-sm-10 col-lg-6">
                            <select class="form-control" name="ispay" id="ispay" autocomplete="off">
                                <option value="0" >未支付</option>
                                <option value="1" >已支付</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-4 control-label"><span class="require">*</span>微信昵称
                        </label>
                        <div class="col-sm-10 col-lg-6">
                            <div class="input-group">
                                <input type="text" name="nickname" value="<?php  echo $fans['nickname'];?>" class="form-control" readonly="">
                                <input type="hidden" name="from_user" value="<?php  echo $account['from_user'];?>" id="from_user">
                                <span class="input-group-btn">
				                    <button class="btn btn-default" type="button" onclick="$('#modal-module-menus').modal();" data-original-title="" title="">选择粉丝</button>
			                    </span>
                            </div>
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-4 control-label">
                            真实姓名</label>
                        <div class="col-sm-10 col-lg-6">
                            <input type="text" name="username" id="username" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-4 control-label">
                            手机号码</label>
                        <div class="col-sm-10 col-lg-6">
                            <input type="text" name="mobile" id="mobile" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group peisong">
                        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-4 control-label">
                            收餐地址</label>
                        <div class="col-sm-10 col-lg-6">
                            <input type="text" name="address" id="address" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group peisong">
                        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-4 control-label">
                            地图坐标</label>
                        <div class="col-sm-10 col-lg-6">
                            <?php  echo tpl_form_field_coordinate('baidumap', $item)?>
                        </div>
                    </div>
                    <div class="form-group peisong">
                        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-4 control-label">配送日期</label>
                        <div class="col-sm-10 col-lg-6">
                            <select name="meal_date" id="meal_date" class="form-control">
                                <?php  echo $select_mealdate;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group peisong">
                        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-4 control-label">配送时间</label>
                        <div class="col-sm-10 col-lg-6">
                            <select name="meal_time" id="meal_time" class="form-control">
                                <?php  echo $select_mealtime;?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group diannei">
                        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-4 control-label">
                            餐桌</label>
                        <div class="col-sm-10 col-lg-6">
                            <select  class="form-control" name="tables" id="tables">
                                <option value="" selected="selected">请选择桌号</option>
                                <?php  if(is_array($tables)) { foreach($tables as $item) { ?>
                                <option value="<?php  echo $item['id'];?>"><?php  echo $item['title'];?></option>
                                <?php  } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group diannei">
                        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-4 control-label">
                            人数</label>
                        <div class="col-sm-10 col-lg-6">
                            <select name="counts" id="counts" class="form-control">
                                <option value="0" >请选择用餐人数</option>
                                <?php  for($i = 1;$i<21;$i++){?>
                                <option value="<?php  echo $i;?>" ><?php  echo $i;?></option>
                                <?php  }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-4 control-label">
                            备注</label>
                        <div class="col-sm-10 col-lg-6">
                            <textarea name="remark" id="remark" style="height:80px;" class="form-control"><?php  echo $users['remark'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <h5 id="totalprice">订单总价:<strong class="text-danger"><?php  echo $totalprice;?></strong></h5>
                </div>
            </div>
        </form>
        <div class="form-group col-sm-11" style="padding-left: 0px;">
            <a  class="btn btn-primary col-lg-8" id="btnadd">保存订单</a>
        </div>

    </div>
    <input type="hidden" id="cur_dishid" value="" name="cur_dishid">
    <input type="hidden" id="cur_optionid" value="" name="cur_optionid">

    <div class="modal fade" id="addDish" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" style="width:500px;">
            <input type="hidden" name="addDish" value="1">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        请选择商品属性 价格:<font color="#f00" id="option_price">100</font>
                    </h4>
                </div>
                <div class="table-responsive" id="addShow" style="height: 280px;">

                </div>
                <div class="modal-footer">
                    <a class="btn btn-warning col-lg-2" id="add_option_food">
                        加入订单
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
    <script>
        function tan(i)
        {
            var url = "<?php  echo $this->createWebUrl('getgoodsoption', array(), true)?>";
            var params = {
                'id': i
            };
            $.ajax({
                url: url,
                type: "post",
                data: params,
                dataType: 'json',
                success: function (data) {
                    if (data != 0) {
                        $("#option_price").html(data.price);
                        $("#option_title").html(data.title);
                        $("#addShow").html(data.content);
                        $("#goodsoptionnum").html(1)
                        $('#goodsoption').css({"display": "block"});
                        $('#goodsoption').slideDown(400)

                        $('#addDish').modal();
                    }
                }
            });
        }

        function addfood(i)
        {
            var url = "<?php  echo $this->createWebUrl('UpdateDishNumOfCategory', array('storeid' => $storeid, 'from_user' => 'admin'), true)?>";
            var params = {
                'dishid': i,
                'optionid': '',
                'optype':'add',
                'o2uNum': 1
            };
            $.ajax({
                url: url,
                type: "post",
                data: params,
                dataType: 'json',
                success: function (data) {
                    if (data['message']['code'] != 0) {
                        alert(data['message']['msg']);
                        return;
                    } else {
                        $('#native-scroll').html(data['message']['cart']);
                        $('#goodsprice').html(data['message']['totalprice']);
                        doSelectBtn();
                        gettotalprice();
                    }
                }
            });
        }

        function setgoodsoptionnum(type)
        {
            var num= $("#goodsoptionnum").html();
            num =  parseInt(num);
            if (type == 1) {
                num = num+1;
                $("#goodsoptionnum").html(num);
            } else {
                if (num > 1) {
                    num = num-1;
                    $("#goodsoptionnum").html(num);
                }
            }
        }

        //选择多规格
        function addClass(a, dishid) {
            $(a).addClass("on").siblings().removeClass("on");

            var all_select = 0;
            for (var i = 0; i < $('.que_box').length; i++) {
                if ($('.que_box').find('li.on').length == $('.que_box').length) {
                    all_select = 1;
                }
            }
            if (all_select == 1) {
                var specs = "";
                for (var i = 0; i < $('.que_box').length; i++) {
                    if (i == ($('.que_box').length - 1)) {
                        specs += $('.que_box').eq(i).find('li.on').attr("specid");
                    } else {
                        specs += $('.que_box').eq(i).find('li.on').attr("specid") + "_";
                    }
                }

                $('#cur_dishid').val(dishid);
                $('#cur_optionid').val(specs);
                var url = "<?php  echo $this->createWebUrl('getselectoption', array(), true)?>";
                $.ajax({
                    url: url, type: "post", dataType: "json", timeout: "10000",
                    data: {
                        "dishid": dishid,
                        "optionid": specs
                    },
                    success: function (data) {
                        if (data == 0) {
                            alert('调试中');
                            return false;
                        } else {
                            $("#option_price").html(data['price']);
                        }
                    }, error: function () {
                        alert("数据请求失败");
                        return false;
                    }
                });
//
            }
        }

        $("#add_option_food").click(function (event) {
            cur_dishid = $('#cur_dishid').val();
            cur_optionid = $('#cur_optionid').val();

            ojb = $('#dishid_' + cur_dishid);
            for (var i = 0; i < $('.que_box').length; i++) {
                if ($('.que_box').eq(i).find('li.on').length < 1) {
                    alert("请选择" + $('.que_box').eq(i).find('.guige').html());
                    return false;
                }
            }

            //规格商品数量
//            goodsoptionnum = parseInt($('#goodsoptionnum').html());
            goodsoptionnum = 1;
            var dishid = ojb.attr('dishid');
            totalnum = parseInt(goodsoptionnum);

            var url = "<?php  echo $this->createWebUrl('UpdateDishNumOfCategory', array('storeid' => $storeid, 'from_user' => 'admin'), true)?>";

            var params = {
                'dishid': dishid,
                'optionid':cur_optionid,
                'o2uNum':totalnum,
                'optype':'add'
            };
            $.ajax({
                url: url,
                type: "post",
                data: params,
                dataType: 'json',
                success: function (data) {
                    if (data['message']['code'] != 0) {
                        alert(data['message']['msg']);
                        return;
                    } else {
                        $('#native-scroll').html(data['message']['cart']);
                        $('#goodsprice').html(data['message']['totalprice']);
                        doSelectBtn();
                        $('#addDish').modal("hide");
                    }
                }
            });
        });

        function doSelectBtn() {
            var btnAdd = $(".i-add-btn");
            var btnMin = $(".i-remove-btn");
            var btnClean = $(".clear-btn");

            btnClean.on('click', function () {
                var url = "<?php  echo $this->createWebUrl('clearmenu', array('storeid' => $storeid, 'from_user' => 'admin', 'type' => 'ajax'), true)?>";
                var params = {};
                $.ajax({
                    url: url,
                    type: "post",
                    data: params,
                    dataType: 'json',
                    success: function (data) {
                        if (data['message']['code'] != 0) {
                            alert(data['message']['msg']);
                            return;
                        } else {
                            $('#native-scroll').html('<tr><td style="width: 40%;">名称</td><td>数量</td><td>单价</td><td>操作</td></tr>');
                            $('#goodsprice').html('0');
                            $('#totalprice').html('订单总价:<strong class="text-danger">0</strong>');

                        }
                    }
                });
            });

            btnAdd.on('click', function () {
                var dishid = this.parentNode.parentNode.getAttribute('dishid'); //商品编号
                var optionid = this.parentNode.parentNode.getAttribute('optionid'); //规格编号
                var goodsnum = $(this).parent().prev().prev().text();
                goodsnum = parseInt(goodsnum) + 1;

                var url = "<?php  echo $this->createWebUrl('UpdateDishNumOfCategory', array('storeid' => $storeid), true)?>";
                var params = {
                    'dishid': dishid,
                    'optionid':optionid,
                    'o2uNum': goodsnum
                };
                $.ajax({
                    url: url,
                    type: "post",
                    data: params,
                    dataType: 'json',
                    success: function (data) {
                        if (data['message']['code'] != 0) {
                            alert(data['message']['msg']);
                            return;
                        } else {
                            totalprice = data['message']['totalprice'];
                            totalcount = data['message']['totalcount'];
                            goodscount = data['message']['goodscount'];

                            $('#native-scroll').html(data['message']['cart']);
                            $('#goodsprice').html(totalprice);
                            doSelectBtn();
                            gettotalprice();

                        }
                    }
                });
            });

            btnMin.on('click', function () {
                var dishid = this.parentNode.parentNode.getAttribute('dishid'); //商品编号
                var optionid = this.parentNode.parentNode.getAttribute('optionid'); //规格编号
                var goodsnum = $(this).parent().prev().prev().text();
                goodsnum = parseInt(goodsnum) - 1;


                var url = "<?php  echo $this->createWebUrl('UpdateDishNumOfCategory', array('storeid' => $storeid, 'from_user' => $from_user), true)?>";
                var params = {
                    'dishid': dishid,
                    'optionid':optionid,
                    'o2uNum': goodsnum
                };
                $.ajax({
                    url: url,
                    type: "post",
                    data: params,
                    dataType: 'json',
                    success: function (data) {
                        if (data['message']['code'] != 0) {
                            alert(data['message']['msg']);
                            return;
                        } else {
                            totalprice = data['message']['totalprice'];
                            totalcount = data['message']['totalcount'];
                            goodscount = data['message']['goodscount'];

                            $('#native-scroll').html(data['message']['cart']);
                            $('#goodsprice').html(totalprice);
                            doSelectBtn();
                            gettotalprice();
                        }
                    }
                });
            });
        }

        $('#mode').change(function(){
            if($(this).val() == 1) { //店内
                $('.peisong').hide();
                $('.diannei').show();
                //服务费，茶位费
            } else if($(this).val() == 2) { //外卖
                $('.peisong').show();
                $('.diannei').hide();

                //打包费，配送费
            } else if($(this).val() == 4) { //快餐
                $('.peisong').hide();
                $('.diannei').hide();
            }
            gettotalprice();
        });

        $('#tables').change(function(){
            gettotalprice();
        });

        $('#counts').change(function(){
            gettotalprice();
        });

        $("#btnadd").click(function(){
            var ordertype = $("#mode").val();
            var mealtime = $("#meal_date").val() + ' ' + $("#meal_time").val();
            if ($("#meal_date").val() == undefined) {
                if ($("#meal_time").val() == undefined) {
                    mealtime = '';
                } else {
                    mealtime = $("#meal_time").val();
                }
            }

            var url = "<?php  echo $this->createWebUrl('addtoorder', array('storeid' => $storeid), true)?>";
            var lat = $('[name="baidumap[lat]"]').val();
            var lng = $('[name="baidumap[lng]"]').val();

            $.ajax({
                url: url, type: "post", dataType: "json", timeout: "10000",
                data: {
                    "lat":lat,
                    "lng":lng,
                    "paytype":$("#paytype").val(),
                    "ispay":$("#ispay").val(),
                    "ordertype":ordertype,
                    "tables": $("#tables").val(),
                    "username": $("#username").val(),
                    "mobile": $("#mobile").val(),
                    "address":$("#address").val(),
                    "meal_time": mealtime,
                    "counts": $("#counts").val(),
                    "remark": $("#remark").val(),
                    "from_user":$("#from_user").val()
                },
                success: function (data) {
                    if (data['message']['code'] == 0) {
                        alert(data['message']['msg']);
                    } else {
                        alert("订单提交成功！");

                        var url = "<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'storeid' => $storeid), true)?>" + "&id=" + data.message['orderid'];
                        location.href = url;
                    }
                },error: function () {
                    alert("订单提交失败！");
                }
            });
        });

        function gettotalprice()
        {
            var ordertype = $("#mode").val();
            var mealtime = $("#meal_date").val() + ' ' + $("#meal_time").val();
            if ($("#meal_date").val() == undefined) {
                if ($("#meal_time").val() == undefined) {
                    mealtime = '';
                } else {
                    mealtime = $("#meal_time").val();
                }
            }

            var url = "<?php  echo $this->createWebUrl('gettotalprice', array('storeid' => $storeid), true)?>";
            var lat = $('[name="baidumap[lat]"]').val();
            var lng = $('[name="baidumap[lng]"]').val();

            $.ajax({
                url: url, type: "post", dataType: "json", timeout: "10000",
                data: {
                    "lat":lat,
                    "lng":lng,
                    "ordertype":ordertype,
                    "tables": $("#tables").val(),
                    "username": $("#username").val(),
                    "mobile": $("#mobile").val(),
                    "address":$("#address").val(),
                    "meal_time": mealtime,
                    "counts": $("#counts").val(),
                    "remark": $("#remark").val(),
                    "from_user":$("#from_user").val()
                },
                success: function (data) {
                    if (data['message']['code'] == 0) {
                        alert(data['message']['msg']);
                    } else {
                        $("#totalprice").html(data['message']['totalprice']);
                    }
                },error: function () {
                    alert("订单提交失败！");
                }
            });
        }

        $(document).ready(function () {
            $('.peisong').hide();
            doSelectBtn();
        });
    </script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_modal_cash_fans', TEMPLATE_INCLUDEPATH)) : (include template('web/_modal_cash_fans', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/footer', TEMPLATE_INCLUDEPATH)) : (include template('public/footer', TEMPLATE_INCLUDEPATH));?>