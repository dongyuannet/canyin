<?php defined('IN_IA') or exit('Access Denied');?><?php  define('MUI', true);?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php  if($activity_type == 'coupon') { ?>
<?php  if($op == 'display') { ?>
<div class="mui-content activity-exchange" style="padding-bottom:55px;">
	<div class="mui-table nav">
		<a href="<?php  echo $this->createMobileurl('activity')?>" class="mui-table-cell mui-active">
			卡券
		</a>
		<a href="<?php  echo $this->createMobileurl('activity', array('activity_type' => 'goods'))?>" class="mui-table-cell">
			实物
		</a>
	</div>
	<div class="discount-voucher mui-content-padded">
		<?php  if(!empty($exchange_lists)) { ?>
		<?php  if(is_array($exchange_lists)) { foreach($exchange_lists as $item) { ?>
		<?php  echo tpl_app_coupon_item($item);?>
		<?php  } } ?>
		<?php  } else { ?>
		<div class="mui-input-row mui-text-center">暂无可兑换卡券</div>
		<?php  } ?>
	</div>
</div>
<script type="text/javascript">
$('.js-scan-rules').click(function() {
	$(this).parent().parent().next().toggle();
	$(this).find('span').toggleClass('fa-angle-up');
	$(this).find('span').toggleClass('fa-angle-down');
})
$('.js-coupon-exchange').click(function() {
	var id = $.trim($(this).data('id'));
	var source = $(this).data('source');
	var href = $(this).data('href');
	var cancel_href = $(this).data('cancel-href');
	var exchange_href = $(this).data('exchange-href');
	if (!id) {
		return false;
	}
	$.post(href, {'id' : id}, function(data) {
		data = $.parseJSON(data);
		if (data.message.errno < 0) {
			util.toast(data.message.message, '', 'error');
		} else {
			util.toast(data.message.message, data.redirect, 'error');
		}
	});
});
</script>
<?php  } else if($op == 'mine') { ?>
<div class="mui-content pay-select-coupon">
	<div id="voucher" class="mui-control-content mui-active">
		<?php  if(!empty($coupon_records)) { ?>
		<?php  if(is_array($coupon_records)) { foreach($coupon_records as $row) { ?>
		<div class="mui-input-row">
			<?php  if(COUPON_TYPE == WECHAT_COUPON) { ?>
			<a href="javascript:;" class="js-coupon-info" data-ajax=<?php  echo $row['extra_ajax'];?> data-id="<?php  echo $row['id'];?>" data-code="<?php  echo $row['code'];?>">
			<?php  } else { ?>
			<a href="<?php  echo $this->createMobileurl('activity', array('op' => 'use', 'activity_type' => 'coupon', 'recid' => $row['recid']))?>">
			<?php  } ?>
			<label>
				<div class="coupon-panel">
					<div class="mui-row">
						<div class="mui-col-xs-4 mui-text-center">
							<div class="coupon-panel-left">
								<?php  echo $row['icon'];?>
							</div>
						</div>
						<div class="mui-col-xs-8">
							<div class="store-title mui-ellipsis mui-mb10"><?php  echo $row['title'];?></div>
							<div class="date"><?php  echo $row['extra_date_info'];?></div>
							<span class="use-token" data-id="<?php  echo $row['id'];?>">
								<span class="mui-block icon-use-token">⇌</span>
								<span class="mui-block">使用</span>
							</span>
						</div>
					</div>
				</div>
			</label>
			</a>
			<ol class="coupon-rules" style="display:none;">
				<?php  echo $row['description'];?>
			</ol>
			<div class="scan-rules js-scan-rules"><?php  echo $type_names[$row['type']]['0'];?>使用规则<span class="fa fa-angle-up"></span></div>
		</div>
		<?php  } } ?>
		<?php  } else { ?>
		<div class="mui-input-row">
			<div class="mui-input-row mui-text-center">
				<div>暂无卡券
					<?php  if($exchange_enable['exchange_enable'] == 1) { ?>
					,<a href="<?php  echo $this->createMobileurl('activity')?>">点击兑换</a>
					<?php  } ?>
				</div>
			</div>
		</div>
		<?php  } ?>
	</div>
</div>
<script> 
<?php  if(COUPON_TYPE == WECHAT_COUPON) { ?>
$(document).on('click', '.js-coupon-info', function() {
	id = $(this).data('id');
	code = $(this).data('code');
	href = $(this).data('ajax');
	if (!code) {
		$.post(href, {'id' : id}, function(data) {
			var data = $.parseJSON(data);
			if (data.message.errno < 0) {
				util.toast(data.message.error, '', 'error');
			} else {
				wx.ready(function(){
					wx.addCard({
						cardList:[
							{
								cardId : data.message.message.card_id,
								cardExt : data.message.message.card_ext
							}
						],
						success: function (res) {
						location.href = data.redirect;
						}
					});
				});
			}
			return false;
		});
	} else {
		$.post(href, {'id' : id, 'code' : code}, function(data) {
		var data = $.parseJSON(data);
		if (data.message.errno < 0) {
			util.message(data.message.error, '', 'error');
		} else {
			wx.ready(function(){
				wx.openCard({
					cardList:[
						{
							cardId : data.message.message.card_id,
							code : data.message.message.code
						}
					],
				});
			});
		}
		return false;
	});
	}
})
<?php  } ?>
	$(document).on('click', '.js-use-coupon-now', function() {
		code = $(this).data('code');
		url = "<?php  echo $this->createMobileurl('activity', array('op' => 'use', 'activity_type' => 'coupon'))?>";
		$.post(url, {code: code}, function(data) {
			data = $.parseJSON(data);
			$('.pay-select-coupon img').attr('src', data.thumb);
			$('.pay-select-coupon .js-use-code').html(data.code)
			qrcodeShow(data.code);
		});
	});
	var qrcodeShow = function(code) {
		require(['jquery.qrcode'], function() {
			url = "<?php  echo url('entry', array('i' => $_W['uniacid'],'do' => 'home', 'm' => 'paycenter'));?>";
			$('.js-qrcode-show').show();
			$('.qrcode-block').html('').qrcode({
				render: 'canvas',
				width: 150,
				height: 150,
				text: url
			});
		})
	};
	$(document).on('click', '.js-scan-rules', function() {
		$(this).prev().toggle();
		$(this).find('span').toggleClass('fa-angle-up');
		$(this).find('span').toggleClass('fa-angle-down');
	});
</script>
<?php  } ?>
<?php  if($op == 'use') { ?>
	<div class="mui-content activity-wx-card" style="background-color:<?php  echo $coupon_info['color'];?>">
		<div class="wx-card-panel">
			<img src="<?php  echo tomedia($coupon_info['logo_url'])?>" alt="" class="mui-img-circle"/>
			<div class="mui-text-muted mui-text-center"><?php  echo $_W['account']['name'];?></div>
			<div class="title mui-text-center"><?php  echo $coupon_info['title'];?></div>
			<div class="btn-used mui-text-center">
				<?php  if($starttime > strtotime(date('Ymd'))) { ?>
				<a href="javascript:;" class="mui-btn mui-btn-block mui-disabled" style="background-color:<?php  echo $coupon_info['color'];?>;color:#fff;border-color:<?php  echo $coupon_info['color'];?>">未到可用时间</a>
				<?php  } else { ?>
				<a href="<?php  echo $this->createMobileurl('activity', array('activity_type' => 'coupon', 'op' => 'qrcode', 'couponid' => $coupon_info['id'], 'recid' => $recid))?>" class="mui-btn mui-btn-block" style="background-color:<?php  echo $coupon_info['color'];?>;color:#fff;border-color:<?php  echo $coupon_info['color'];?>">立即使用</a>
				<?php  } ?>
			</div>
			<div class="sub-title mui-text-center"><?php  echo $coupon_info['sub_title'];?></div>
			<div class="date mui-text-center"><?php  echo $coupon_info['exp_date'];?></div>
			<ul class="mui-table-view mui-table-view-chevron">
				<li class="mui-table-view-cell">
					<a href="<?php  echo $this->createMobileurl('activity', array('activity_type' => 'coupon', 'op' => 'detail', 'couponid' => $coupon_info['id'], 'recid' => $recid))?>" class="mui-navigate-right"><?php  if($coupon_info['type'] == '1') { ?>折扣<?php  } else { ?>代金<?php  } ?>券详情</a>
				</li>
				<li class="mui-table-view-cell">
				<a href="<?php  echo url('entry', array('m' => 'we7_coupon', 'do' => 'consume', 'encrypt_code' => $coupon_record['code'], 'card_id' => $coupon_info['id'], 'openid' => $_W['openid'], 'source' => $coupon_info['source']))?>" class="mui-navigate-right">立即使用</a>
				</li>
				<li class="mui-table-view-cell">
					<a href="<?php  echo url('mc/home')?>" class="mui-navigate-right">
						个人中心
						<span class="mui-pull-right">点击进入</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
<?php  } ?>
<?php  if($op == 'detail') { ?>
	<div class="mui-content">
		<div class="mui-pl10 mui-mt15"><?php  if($coupon_info['type'] == '1') { ?>折扣<?php  } else { ?>代金<?php  } ?>券详情</div>
		<hr />
		<div class="mui-content-padded">
			<dl class="mui-dl-horizontal">
				<dt>优惠说明</dt>
				<dd><?php  echo $coupon_info['discount_info'];?></dd>
				<dt>有效日期</dt>
				<dd><?php  echo $coupon_info['detail_date_info'];?></dd>
				<dt>使用须知</dt>
				<dd><?php  echo $coupon_info['description'];?></dd>
			</dl>
		</div>
	</div>
<?php  } ?>
<?php  if($op == 'qrcode') { ?>
	<div class="mui-content activity-wx-card-detail" style="background-color:<?php  echo $coupon_info['color']?>">
		<div class="mui-card mui-text-center">
			<a href="<?php  echo $this->createMobileurl('activity', array('activity_type' => 'coupon', 'op' => 'use', 'couponid' => $coupon_info['couponid'], 'recid' => $recid))?>" class="cancel">取消</a>
			<div class="mui-text-muted"><?php  echo $_W['account']['name'];?></div>
			<div class="title"><?php  echo $coupon_info['title'];?></div>
			<div class="hr"></div>
			<div class="img">
				<div class="qrcode-block" data-url="<?php  echo murl('entry', array('m' => 'we7_coupon', 'do' => 'couponcode', 'code' => $coupon_info['code']), true, true);?>" style="margin-top:20px"></div>
			</div>
			<div class="bar-code"><?php  echo $coupon_info['code'];?></div>
			<div class="mui-text-muted">请在付款时出示此券</div>
		</div>
	</div>
	<script>
	require(['jquery.qrcode'], function(){
		var url = $('.qrcode-block').data('url');
		$('.qrcode-block').html('').qrcode({
			render: 'canvas',
			width: 150,
			height: 150,
			text: url
		});
	})
	</script>
<?php  } ?>
<?php  } ?>

<?php  if($activity_type == 'goods') { ?>
<?php  if($op == 'display') { ?>
<div class="mui-content activity-exchange">
	<div class="mui-table nav">
		<a href="<?php  echo $this->createMobileurl('activity', array('activity_type' => 'coupon'))?>" class="mui-table-cell">
			卡券
		</a>
		<a href="<?php  echo $this->createMobileurl('activity', array('activity_type' => 'goods'))?>" class="mui-table-cell mui-active">
			实物
		</a>
	</div>
	<div class="entity">
		<div class="mui-row">
			<?php  if(is_array($lists)) { foreach($lists as $row) { ?>
			<div class="mui-col-xs-6">
				<div class="mui-card mui-border-radius0 mui-mt10">
					<div class="img-container"><img class="mui-card-img-top mui-border-radius0" src="<?php  echo tomedia($row['thumb'])?>"></div>
					<div class="mui-card-block">
						<div class="mui-card-title mui-small"><?php  echo $row['title'];?></div>
						<div class="mui-row exchange-action">
							<div class="mui-col-xs-6 mui-text-info"><img src="resource/images/icon-signed.png" alt=""/><span><?php  echo $row['credit'];?></span></div>
							<div class="mui-col-xs-6 mui-text-right"><a href="<?php  echo $this->createMobileurl('activity', array('activity_type' => 'goods', 'op' => 'deliver', 'id' => $row['id']))?>" class="mui-badge mui-badge-blue">兑换 <span class="fa fa-angle-right"></span></a></div>
						</div>
					</div>
				</div>
			</div>
			<?php  } } ?>
		</div>
	</div>
</div>
<?php  } else if($op == 'deliver') { ?>
<div class="mui-content activity-entity-content">
	<div class="img-container">
		<img class="mui-card-img-top mui-border-radius0" src="<?php  echo tomedia($goods_info['thumb'])?>"/>
		<div class="title"><?php  echo $goods_info['title'];?></div>
	</div>
	<div class="mui-row mui-bg-white mui-pa10">
		<div class="mui-col-xs-4">
			<span class="fa fa-database"></span>
			<?php  echo $goods_info['credit'];?>
		</div>
		<div class="mui-col-xs-4 mui-text-muted">(剩余<?php  echo $goods_info['reside'];?>件)</div>
		<div class="mui-col-xs-4 mui-text-center"><a href="javascript:;" class="mui-btn mui-btn-green mui-btn-outlined js-address-info"><?php  echo $is_exchange['name'];?></a></div>
	</div>
	<div class="mui-content-padded">
		<div class="mui-segmented-control mui-segmented-control-info">
			<a class="mui-control-item mui-active" href="#exchange-info">兑换说明</a>
			<a class="mui-control-item" href="#address-info">收货信息</a>
		</div>
	</div>
	<div id="exchange-info" class="mui-control-content mui-active">
		<div class="mui-bg-white mui-mt10 mui-pa10">
			<div class="mui-big mui-mt10 mui-mb10">兑换说明</div>
			<div class="mui-text-muted state">
				<div><?php  echo $goods_info['exp_date'];?></div>
				<div>每人只可兑换<?php  echo $goods_info['pretotal'];?>件此商品</div>
			</div>
			<div class="mui-big mui-mt10 mui-mb10">产品简介</div>
			<div class="mui-text-muted introduction"><?php  echo $goods_info['description'];?></div>
		</div>
	</div>
	<div id="address-info" class="mui-control-content">
		<div class="mui-bg-white mui-mt10 mui-pa10">
			<div class="mui-big mui-mt10 mui-mb10">收货信息</div>
			<div class="state">
				<label for="">收货人姓名:</label>
				<?php  echo tpl_app_fans_form('username', $address_data['username'], '收货人姓名');?>
				<label for="">收货人电话:</label>
				<?php  echo tpl_app_fans_form('mobile', $address_data['mobile'], '收货人电话');?>
				<label for="">收货人邮编:</label>
				<?php  echo tpl_app_fans_form('zipcode', $address_data['zipcode'], '收货人邮编');?>
				<label>收货人地址:</label>
				<?php  echo tpl_app_form_field_district('address',array('province' => $address_data['province'],'city' => $address_data['city'],'district' => $address_data['district']));?>
				<?php  echo tpl_app_fans_form('address[address]', $address_data['address'], '收货人地址');?>
			</div>
			</div>
			<div class="mui-content-padded">
				<?php  if($is_exchange['error'] == '1') { ?>
				<button class="mui-btn mui-btn-success mui-btn-block js-exchange" type="button" data-id="<?php  echo $goods_info['id'];?>" data-tid="<?php  echo $tid;?>">提交</button>
				<?php  } else if($is_exchange['error'] == '-1') { ?>
				<button class="mui-btn mui-btn-block mui-btn-danger"><?php  echo $is_exchange['name'];?></button>
				<?php  } ?>
			</div>
		</div>
		
	</div>
</div>
<script type="text/javascript">
	$(document).on('click', '.js-address-info', function() {
		$('#exchange-info').removeClass('mui-active');
		$('#address-info').addClass('mui-active');
		$('a[href="#exchange-info"]').removeClass('mui-active');
		$('a[href="#address-info"]').addClass('mui-active');
	});
	$(document).on('click', '.js-exchange', function() {
		$(this).addClass('mui-disabled');
		username = $('input[name="username"]').val();
		mobile = $('input[name="mobile"]').val();
		zipcode = $('input[name="zipcode"]').val();
		address_province = $('input[name="address[province]"]').val();
		address_city = $('input[name="address[city]"]').val();
		address_district = $('input[name="address[district]"]').val();
		address_addr = $('input[name="address[address]"]').val();
		type = "<?php  echo $type;?>";
		id = $(this).data('id');
		tid = $(this).data('tid');
		if (!(username && mobile && zipcode && address_province && address_city && address_district && address_addr)) {
			util.toast('请填写收货人信息', '', 'error');
			return;
		}
		if (type == 'edit') {
			ajax_url = "<?php  echo $this->createMobileurl('activity', array('activity_type' => 'goods', 'op' => 'deliver'))?>";
		} else {
			ajax_url = "<?php  echo $this->createMobileurl('activity', array('activity_type' => 'goods', 'op' => 'post'))?>";
		}
		$.post(ajax_url, {'username' : username, 'mobile' : mobile, 'zipcode' : zipcode, 'address_province' : address_province, 'address_city' : address_city, 'address_district' : address_district, 'address_addr' : address_addr, 'id' : id, 'tid' : tid}, function(data) {
			data = $.parseJSON(data);
			if (data.message.errno < 0) {
				util.toast(data.message.message, '', 'error');
			} else {
				util.toast(data.message.message, data.redirect, 'success');
			}
		});
	});
</script>
<?php  } else if($op == 'mine') { ?> 
<div class="mui-content activity-exchange">
	<div class="entity">
		<div class="mui-row">
			<?php  if(is_array($lists)) { foreach($lists as $row) { ?>
			<?php  if(($row['status'] == '' || $row['status'] == 0)) { ?>
			<a href="<?php  echo $this->createMobileurl('activity', array('activity_type' => 'goods', 'op' => 'deliver', 'id' => $row['gid'], 'type' => 'edit', 'tid' => $row['tid']))?>">
			<?php  } ?>
			<div class="mui-col-xs-6">
				<div class="mui-card mui-border-radius0 mui-mt10">
					<div class="img-container"><img class="mui-card-img-top mui-border-radius0" src="<?php  echo tomedia($row['thumb'])?>"></div>
					<div class="mui-card-block">
						<div class="mui-card-title mui-small"><?php  echo $row['title'];?></div>
						<div class="mui-row exchange-action">
							<div class="mui-col-xs-12 mui-text-right">
							<?php  if($row['status'] == '1') { ?>
							<a href="javascript:;" class="mui-badge mui-badge-blue js-shipping-confirm" data-tid="<?php  echo $row['tid'];?>">确认收货<span class="fa fa-angle-right"></span>
							<?php  } else if(($row['status'] == '' || $row['status'] == 0)) { ?>
							<a href="<?php  echo $this->createMobileurl('activity', array('activity_type' => 'goods', 'op' => 'deliver', 'id' => $row['gid'], 'type' => 'edit', 'tid' => $row['tid']))?>" class="mui-badge mui-badge-blue">待发货<span class="fa fa-angle-right"></span>
							<?php  } else if($row['status'] == '2') { ?>
							<a href="javascript:;" class="mui-badge mui-badge-disabled">已完成<span class="fa fa-angle-right"></span>
							<?php  } ?>
							</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php  if(($row['status'] == '' || $row['status'] == 0)) { ?>
			</a>
			<?php  } ?>
			<?php  } } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on('click', '.js-shipping-confirm', function() {
		tid = $(this).data('tid');
		$.post("<?php  echo $this->createMobileurl('activity', array('activity_type' => 'goods', 'op' => 'confirm'))?>", {'tid' : tid}, function(data) {
			data = $.parseJSON(data);
			if (data.message.errno > 0) {
				util.toast(data.message.message, data.redirect, 'success');
			} else {
				util.toast(data.message.message, '', 'error');
			}
		})
	})
</script>
<?php  } ?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
