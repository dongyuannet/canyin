<?php defined('IN_IA') or exit('Access Denied');?><div class="tab-pane  active" id="tab_basic">
    <div class="panel panel-default">
        <div class="panel-heading">商品编辑</div>
        <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">人气值</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="subcount" value="<?php  echo $item['subcount'];?>" />
                        <div class="help-block">人气值大于20时显示人气图标</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商品名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="goodsname" class="form-control" value="<?php  echo $item['title'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商品分类</label>
                    <div class="col-sm-9">
                        <select class="form-control" style="margin-right:15px;" name="pcate" onchange="fetchChildCategory(this.options[this.selectedIndex].value)"  autocomplete="off" class="form-control">
                            <option value="0">请选择分类</option>
                            <?php  if(is_array($category)) { foreach($category as $row) { ?>
                            <option value="<?php  echo $row['id'];?>" <?php  if($row['id'] == $item['pcate']) { ?>
                            selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
                            <?php  } } ?>
                        </select>
                        <div class="help-block">
                            还没有分类，点我 <a href="<?php  echo $this->createWebUrl('category', array('op' => 'post', 'storeid' => $storeid))?>"><i class="fa fa-plus-circle"></i> 添加分类</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">打印标签</label>
                    <div class="col-sm-9">
                        <select class="form-control" style="margin-right:15px;" name="labelid"  autocomplete="off" class="form-control">
                            <option value="0">请选择标签</option>
                            <?php  if(is_array($label)) { foreach($label as $row) { ?>
                            <option value="<?php  echo $row['id'];?>" <?php  if($row['id'] == $item['labelid']) { ?> selected="selected"<?php  } ?>><?php  echo $row['title'];?></option>
                            <?php  } } ?>
                        </select>
                        <div class="help-block">
                            还没有标签，点我 <a href="<?php  echo $this->createWebUrl('printlabel', array('op' => 'post', 'storeid' => $storeid))?>"><i class="fa fa-plus-circle"></i> 添加标签</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商品图片</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image('thumb', $item['thumb'])?>
                        <span class="help-block" style="color: #f00;">建议尺寸:300*300</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">价格</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="marketprice" class="form-control" value="<?php  echo $item['marketprice'];?>" />
                            <span class="input-group-addon">元</span>
                        </div>
                        <div class="help-block">必填</div>
                    </div>
                </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">起售份数</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" name="startcount" class="form-control" value="<?php  echo $item['startcount'];?>" />
                        <span class="input-group-addon">份</span>
                    </div>
                    <div class="help-block">必填</div>
                </div>
            </div>


                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员价格</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="memberprice" class="form-control" value="<?php  echo $item['memberprice'];?>" />
                            <span class="input-group-addon">元</span>
                        </div>
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">原价</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="productprice" class="form-control" value="<?php  echo $item['productprice'];?>" />
                            <span class="input-group-addon">元</span>
                        </div>
                        <div class="help-block"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">打包费</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="packvalue" class="form-control" value="<?php  echo $item['packvalue'];?>" />
                            <span class="input-group-addon">元</span>
                        </div>
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">每日库存</label>
                    <div class="col-sm-9">
                        <input type="text" name="counts" class="form-control" value="<?php  if(empty($item)) { ?>-1<?php  } else { ?><?php  echo $item['counts'];?><?php  } ?>" />
                        <div class="help-block">-1表示不限制</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">今日已售</label>
                    <div class="col-sm-9">
                        <input type="text" name="today_counts" class="form-control" value="<?php  echo $item['today_counts'];?>" />
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">总销量</label>
                    <div class="col-sm-9">
                        <input type="text" name="sales" class="form-control" value="<?php  echo $item['sales'];?>" />
                        <div class="help-block"></div>
                    </div>
                </div>
            <!--isshow_sales-->

                <?php  if($_W['role'] != 'operator') { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">购买积分</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" name="credit" class="form-control" value="<?php  echo $item['credit'];?>" />
                            <span class="input-group-addon">分</span>
                        </div>
                        <div class="help-block">购买一份赠送多少积分，不赠送积分请填0。<code>注：只有订单完成后才赠送</code></div>
                    </div>
                </div>
                <?php  } ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商品单位</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="unitname" value="<?php  if(empty($item['unitname'])) { ?>份<?php  } else { ?><?php  echo $item['unitname'];?><?php  } ?>" />
                        <div class="help-block">份、例、斤、半斤、个 等</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商品描述</label>
                    <div class="col-sm-9">
                        <textarea style="height:150px;" class="form-control richtext" name="description" cols="70"><?php  echo $item['description'];?></textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
                <!--<div class="form-group">-->
                    <!--<label class="col-xs-12 col-sm-3 col-md-2 control-label">口味</label>-->
                    <!--<div class="col-sm-9">-->
                        <!--<textarea style="height:50px;" class="form-control" name="taste" cols="70"><?php  echo $item['taste'];?></textarea>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否上架</label>
                    <div class="col-sm-9">
                        <label for="isshow1" class="radio-inline"><input type="radio" name="status" value="1" id="isshow1" <?php  if(empty($item) || $item['status'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
                        &nbsp;&nbsp;&nbsp;
                        <label for="isshow2" class="radio-inline"><input type="radio" name="status" value="0" id="isshow2"  <?php  if(!empty($item) && $item['status'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
                        <span class="help-block"></span>
                    </div>
                </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示销量</label>
                <div class="col-sm-9">
                    <label for="isshow_sales1" class="radio-inline"><input type="radio" name="isshow_sales" value="1" id="isshow_sales1" <?php  if($item['isshow_sales'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
                    &nbsp;&nbsp;&nbsp;
                    <label for="isshow_sales2" class="radio-inline"><input type="radio" name="isshow_sales" value="0" id="isshow_sales2"  <?php  if($item['isshow_sales'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
                    <span class="help-block"></span>
                </div>
            </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                    <div class="col-sm-9">
                        <input type="text" name="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>" />
                    </div>
                </div>
            </div>
    </div>
</div>
