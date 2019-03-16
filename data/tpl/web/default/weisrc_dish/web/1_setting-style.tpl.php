<?php defined('IN_IA') or exit('Access Denied');?><div class="tab-pane" id="tab_style">
    <div class="panel panel-default">
        <div class="panel-heading">
            个性化设置
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">底部导航显示首页</label>
                <div class="col-sm-9">
                    <label for="is_show_home1" class="radio-inline"><input type="radio" name="is_show_home" value="1" id="is_show_home1" <?php  if($setting['is_show_home']==1) { ?>checked<?php  } ?> /> 开启</label>
                    <label for="is_show_home2" class="radio-inline"><input type="radio" name="is_show_home" value="0" id="is_show_home2"  <?php  if($setting['is_show_home']==0 || empty($setting)) { ?>checked<?php  } ?> /> 关闭</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示虚拟下单信息</label>
                <div class="col-sm-9">
                    <label for="is_show_virtual1" class="radio-inline"><input type="radio" name="is_show_virtual" value="1" id="is_show_virtual1" <?php  if($setting['is_show_virtual']==1) { ?>checked<?php  } ?> /> 开启</label>
                    <label for="is_show_virtual2" class="radio-inline"><input type="radio" name="is_show_virtual" value="0" id="is_show_virtual2"  <?php  if($setting['is_show_virtual']==0 || empty($setting)) { ?>checked<?php  } ?> /> 关闭</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示浏览数和商家数量</label>
                <div class="col-sm-9">
                    <label for="is_show_visit1" class="radio-inline"><input type="radio" name="is_show_visit" value="1" id="is_show_visit1" <?php  if($setting['is_show_visit']==1) { ?>checked<?php  } ?> /> 开启</label>
                    <label for="is_show_visit2" class="radio-inline"><input type="radio" name="is_show_visit" value="0" id="is_show_visit2"  <?php  if($setting['is_show_visit']==0 || empty($setting)) { ?>checked<?php  } ?> /> 关闭</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示美食头条</label>
                <div class="col-sm-9">
                    <label for="is_show_toutiao1" class="radio-inline"><input type="radio" name="is_show_toutiao" value="1" id="is_show_toutiao1" <?php  if($setting['is_show_toutiao']==1) { ?>checked<?php  } ?> /> 开启</label>
                    <label for="is_show_toutiao2" class="radio-inline"><input type="radio" name="is_show_toutiao" value="0" id="is_show_toutiao2"  <?php  if($setting['is_show_toutiao']==0 || empty($setting)) { ?>checked<?php  } ?> /> 关闭</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">桌台图文封面</label>

                <div class="col-sm-9 col-xs-12">
                    <?php  echo tpl_form_field_image('table_cover', $setting['table_cover']);?>
                    <div class="help-block">建议尺寸：800 × 450</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">桌台图文描述</label>

                <div class="col-sm-9">
                    <input type="text" name="table_desc" value="<?php  echo $setting['table_desc'];?>" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">首页列表颜色</label>

                <div class="col-sm-9">
                    <?php  if(!empty($setting['style_base'])) { ?>
                    <?php  echo tpl_form_field_color('style_base', $setting['style_base']);?>
                    <?php  } else { ?>
                    <?php  echo tpl_form_field_color('style_base', '#3190e8');?>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">列表头部颜色1</label>

                <div class="col-sm-9">
                    <?php  if(!empty($setting['style_list_btn1'])) { ?>
                    <?php  echo tpl_form_field_color('style_list_btn1', $setting['style_list_btn1']);?>
                    <?php  } else { ?>
                    <?php  echo tpl_form_field_color('style_list_btn1', '#6a3f34');?>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">列表头部颜色2</label>

                <div class="col-sm-9">
                    <?php  if(!empty($setting['style_list_btn2'])) { ?>
                    <?php  echo tpl_form_field_color('style_list_btn2', $setting['style_list_btn2']);?>
                    <?php  } else { ?>
                    <?php  echo tpl_form_field_color('style_list_btn2', '#a57664');?>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">列表头部颜色3</label>

                <div class="col-sm-9">
                    <?php  if(!empty($setting['style_list_btn3'])) { ?>
                    <?php  echo tpl_form_field_color('style_list_btn3', $setting['style_list_btn3']);?>
                    <?php  } else { ?>
                    <?php  echo tpl_form_field_color('style_list_btn3', '#9995a3');?>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">列表按钮颜色</label>

                <div class="col-sm-9">
                    <?php  if(!empty($setting['style_list_base'])) { ?>
                    <?php  echo tpl_form_field_color('style_list_base', $setting['style_list_base']);?>
                    <?php  } else { ?>
                    <?php  echo tpl_form_field_color('style_list_base', '#FE4F4E');?>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>
</div>