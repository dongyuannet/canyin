<?php defined('IN_IA') or exit('Access Denied');?><div class="tab-pane  active" id="tab_basic">
    <div class="panel panel-default">
        <div class="panel-heading">
            基本设置
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">网站名称</label>
                <div class="col-sm-9">
                    <input type="text" name="title" value="<?php  echo $setting['title'];?>" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">网站LOGO</label>
                <div class="col-sm-9 col-xs-12">
                    <?php  echo tpl_form_field_image('site_logo', $setting['site_logo']);?>
                    <div class="help-block">建议尺寸：590 × 100</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">浏览量</label>
                <div class="col-sm-9">
                    <input type="text" name="visit" value="<?php  echo $setting['visit'];?>" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">搜索关键字设置</label>
                <div class="col-sm-9">
                    <input type="text" name="searchword" value="<?php  echo $setting['searchword'];?>" class="form-control"/>
                    <div class="help-block">多个搜索关键词请用空格符号分开</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启语音提示</label>
                <div class="col-sm-9">
                    <label for="is_speaker1" class="radio-inline"><input type="radio" name="is_speaker" value="1" id="is_speaker1" <?php  if($setting['is_speaker']==1) { ?>checked<?php  } ?> /> 开启</label>
                    <label for="is_speaker2" class="radio-inline"><input type="radio" name="is_speaker" value="0" id="is_speaker2"  <?php  if($setting['is_speaker']==0 || empty($setting)) { ?>checked<?php  } ?> /> 关闭</label>
                </div>
            </div>
            <?php  if($_W['role'] == 'manager' || $_W['isfounder']) { ?>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启操作密码</label>
                <div class="col-sm-9">
                    <label for="is_operator_pwd1" class="radio-inline"><input type="radio" name="is_operator_pwd" value="1" id="is_operator_pwd1" <?php  if($setting['is_operator_pwd']==1) { ?>checked<?php  } ?> /> 开启</label>
                    <label for="is_operator_pwd2" class="radio-inline"><input type="radio" name="is_operator_pwd" value="0" id="is_operator_pwd2"  <?php  if($setting['is_operator_pwd']==0 || empty($setting)) { ?>checked<?php  } ?> /> 关闭</label>
                    <div class="help-block">门店订单退款和改价的时候使用</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">操作密码</label>
                <div class="col-sm-9">
                    <input type="password" name="operator_pwd" value="<?php  echo $setting['operator_pwd'];?>" class="form-control"/>
                </div>
            </div>
            <?php  } ?>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">收餐地址模式</label>
                <div class="col-sm-9">
                    <label for="is_auto_address1" class="radio-inline"><input type="radio" name="is_auto_address" value="1" id="is_auto_address1" <?php  if($setting['is_auto_address']==1) { ?>checked<?php  } ?> /> 快速定位模式</label>
                    <label for="is_auto_address2" class="radio-inline"><input type="radio" name="is_auto_address" value="0" id="is_auto_address2"  <?php  if($setting['is_auto_address']==0 || empty($setting)) { ?>checked<?php  } ?> /> 多收餐地址选址</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">auth接入方式</label>
                <div class="col-sm-9">
                    <label for="auth_mode1" class="radio-inline"><input type="radio" name="auth_mode" value="1" id="auth_mode1" <?php  if($setting['auth_mode']==1 || empty($setting)) { ?>checked<?php  } ?> /> 普通模式</label>
                    <label for="auth_mode2" class="radio-inline"><input type="radio" name="auth_mode" value="2" id="auth_mode2"  <?php  if($setting['auth_mode']==2) { ?>checked<?php  } ?> /> 授权模式</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">底部第三方统计</label>
                <div class="col-sm-9">
                    <textarea name="statistics" class="form-control"><?php  echo $setting['statistics'];?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            积分策略
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">奖励积分模式:</label>
                <div class="col-sm-9">
                    <label for="credit_mode1" class="radio-inline"><input type="radio" name="credit_mode" value="1" id="credit_mode1"  <?php  if($setting['credit_mode'] == 1) { ?>checked="true"<?php  } ?> /> 商品积分</label>
                    <label for="credit_mode2" class="radio-inline"><input type="radio" name="credit_mode" value="2" id="credit_mode2" <?php  if($setting['credit_mode'] == 2) { ?>checked="true"<?php  } ?> /> 订单金额</label>
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">消费一元奖励积分:</label>
                <div class="col-sm-9">
                    <input type="text" name="payx_credit" value="<?php  echo $setting['payx_credit'];?>" class="form-control"/>
                    <span class="help-block">积分模式选择<font color="#f00">"订单金额"</font>才有效</span>
                    <div class="help-block">单商家奖励积分<a href="<?php  echo $this->createWebUrl('creditsetting', array('op' => 'display'))?>">点击设置</a></div>
                </div>
            </div>
        </div>

    </div>
    <?php  if($config['is_fengniao']==1) { ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            蜂鸟配送
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">接口配置:</label>
                <div class="col-sm-9">
                    <label for="fengniao_mode1" class="radio-inline"><input type="radio" name="fengniao_mode" value="1" id="fengniao_mode1"  <?php  if($setting['fengniao_mode'] == 1) { ?>checked="true"<?php  } ?> /> 正式启用</label>
                    <label for="fengniao_mode2" class="radio-inline"><input type="radio" name="fengniao_mode" value="2" id="fengniao_mode2" <?php  if($setting['fengniao_mode'] == 2) { ?>checked="true"<?php  } ?> /> 测试联调</label>
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">App ID:</label>
                <div class="col-sm-9">
                    <input type="text" name="fengniao_appid" value="<?php  echo $setting['fengniao_appid'];?>" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">Secret Key:</label>
                <div class="col-sm-9">
                    <input type="text" name="fengniao_key" value="<?php  echo $setting['fengniao_key'];?>" class="form-control"/>
                </div>
            </div>
        </div>
    </div>
    <?php  } ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            模式
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">模式</label>
                <div class="col-sm-9">
                    <label for="mode2" class="radio-inline"><input type="radio" name="mode" value="0" id="mode2"  <?php  if(empty($setting) || $setting['mode'] == 0) { ?>checked="true"<?php  } ?> /> 多店</label>
                    <label for="mode1" class="radio-inline"><input type="radio" name="mode" value="1" id="mode1" <?php  if($setting['mode'] == 1) { ?>checked="true"<?php  } ?> /> 单店</label>
                    <span class="help-block">选择单店模式的情况下搜索页和门店搜索栏目将会隐藏</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">默认门店</label>
                <div class="col-sm-9">
                    <select id="storeid" name="storeid" class="form-control">
                        <?php  if(is_array($stores)) { foreach($stores as $item) { ?>
                        <option value="<?php  echo $item['id'];?>" <?php  if($item['id']==$setting['storeid']) { ?>selected<?php  } ?>><?php  echo $item['title'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            关注设置
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">强制关注</label>
                <div class="col-sm-9">
                    <label for="isneedfollow1" class="radio-inline"><input type="radio" name="isneedfollow" value="1" id="isneedfollow1" <?php  if($setting['isneedfollow']==1) { ?>checked<?php  } ?> /> 开启</label>
                    <label for="isneedfollow2" class="radio-inline"><input type="radio" name="isneedfollow" value="0" id="isneedfollow2"  <?php  if($setting['isneedfollow']==0 || empty($setting)) { ?>checked<?php  } ?> /> 关闭</label>
                    <div class="help-block">开启后未关注用户跳到引导关注链接</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示类型</label>
                <div class="col-sm-9">
                    <label for="tiptype1" class="radio-inline"><input type="radio" name="tiptype" value="1" id="tiptype1" <?php  if($setting['tiptype']==1) { ?>checked<?php  } ?> /> 关注后隐藏</label>
                    <label for="tiptype2" class="radio-inline"><input type="radio" name="tiptype" value="2" id="tiptype2"  <?php  if($setting['tiptype']==2) { ?>checked<?php  } ?> /> 始终显示</label>
                    <label for="tiptype3" class="radio-inline"><input type="radio" name="tiptype" value="0" id="tiptype3"  <?php  if($setting['tiptype']==0) { ?>checked<?php  } ?> /> 关闭</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">按钮事件</label>
                <div class="col-sm-9">
                    <label for="tipbtn1" class="radio-inline"><input type="radio" name="tipbtn" value="1" id="tipbtn1" <?php  if($setting['tipbtn']==1) { ?>checked<?php  } ?> /> 跳转链接</label>
                    <label for="tipbtn2" class="radio-inline"><input type="radio" name="tipbtn" value="2" id="tipbtn2"  <?php  if($setting['tipbtn']==2) { ?>checked<?php  } ?> /> 弹出二维码</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 二维码设置</label>
                <div class="col-sm-9 col-xs-12">
                    <?php  echo tpl_form_field_image('tipqrcode',$setting['tipqrcode']);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">引导跳转链接</label>
                <div class="col-sm-9">
                    <input type="text" name="follow_url" value="<?php  echo $setting['follow_url'];?>" class="form-control"/>
                    <div class="help-block">引导关注的链接! 推荐用微信平台的素材库，转成短地址。<a target="_blank" href="http://www.dwz.cn/">短网址转换</a></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 图标设置</label>
                <div class="col-sm-9 col-xs-12">
                    <?php  echo tpl_form_field_image('follow_logo',$setting['follow_logo']);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 按钮文字</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" id="follow_title" class="form-control" placeholder="" name="follow_title" value="<?php  echo $setting['follow_title'];?>">
                    <div class="help-block">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 关注描述</label>
                <div class="col-sm-9 col-xs-12">
                    <textarea style="height:60px;" name="follow_desc" class="form-control" cols="60"><?php  echo $setting['follow_desc'];?></textarea>
                    <div class="help-block">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 客服二维码</label>
                <div class="col-sm-9 col-xs-12">
                    <?php  echo tpl_form_field_image('kefuqrcode',$setting['kefuqrcode']);?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            分享设置
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 分享标题</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" id="share_title" class="form-control" placeholder="" name="share_title" value="<?php  echo $setting['share_title'];?>">
                    <div class="help-block">
                        分享的文字，用户显示分享给用户的介绍!<br/>
                        #username#为分享出去用户昵称
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 分享图片</label>
                <div class="col-sm-9 col-xs-12">
                    <?php  echo tpl_form_field_image('share_image',$setting['share_image']);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 分享描述</label>
                <div class="col-sm-9 col-xs-12">
                    <textarea style="height:60px;" name="share_desc" class="form-control" cols="60"><?php  echo $setting['share_desc'];?></textarea>
                    <div class="help-block">
                        #username#为分享出去用户昵称
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>