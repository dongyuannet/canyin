<?php

global $_GPC, $_W;
$weid = $this->_weid;
$action = 'tables';
$storeid = intval($_GPC['storeid']);
//检查门店
$this->checkStore($storeid);
$title = $this->actions_titles[$action];
$returnid = $this->checkPermission($storeid);
//当前门店
$cur_store = $this->getStoreById($storeid);
//设置菜单
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);

$type = !empty($_GPC['type']) ? $_GPC['type'] : 'state';
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$tablezones = pdo_fetchall("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE weid = :weid AND storeid=:storeid ORDER BY displayorder DESC", array(':weid' => $weid, ':storeid' => $storeid));
$table_label = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_label) . " WHERE weid=:weid and storeid=:storeid", array(":weid" => $weid, ":storeid" => $storeid));

if (empty($tablezones)) {
    $url = $this->createWebUrl('tablezones', array('op' => 'display', 'storeid' => $storeid));
    message('请先添加桌台类型', $url);
}

if ($operation == 'post') {
    load()->func('tpl');

    $id = intval($_GPC['id']);
    $tablezonesid = intval($_GPC['tablezonesid']);

    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，数据不存在或是已经删除！', '', 'error');
        }
    }

    if (checksubmit('submit')) {
        $data = array(
            'weid' => intval($weid),
            'storeid' => $storeid,
            'tablezonesid' => intval($_GPC['tablezonesid']),
            'title' => trim($_GPC['title']),
            'thumb' => trim($_GPC['thumb']),
            'user_count' => intval($_GPC['user_count']),
            'displayorder' => intval($_GPC['displayorder']),
            'dateline' => TIMESTAMP,
            'print_label' => intval($_GPC['table_label_id']),
        );

        if (empty($data['title'])) {
            message('请输入桌台！');
        }

        if (empty($id)) {
            pdo_insert($this->table_tables, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_tables, $data, array('id' => $id, 'weid' => $weid));
        }

        message('操作成功！', $this->createWebUrl('tables', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'detail') {
    $tablesid = intval($_GPC['tablesid']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " WHERE id = :id", array(':id' => $tablesid));

    $cate = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE id = :id", array(':id' => $item['tablezonesid']));
    $store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " WHERE id = :id", array(':id' => $item['storeid']));
    if ($item['print_label']) {
        $label = pdo_fetch("SELECT * FROM " . tablename($this->table_print_label) . " WHERE id=:id ", array('id' => $item['print_label']));
    }
    $logo = tomedia($store['logo']);
    $tablesorder = pdo_fetchcolumn("SELECT count(1) AS count FROM " . tablename($this->table_tables_order) . " where weid = :weid AND storeid =:storeid AND tablesid=:tablesid ", array(':weid' => $this->_weid, ':storeid' => $storeid, ':tablesid' => $tablesid));
    $tablesorderuser = pdo_fetchcolumn("SELECT count(distinct(from_user)) AS count FROM " . tablename($this->table_tables_order) . " where weid = :weid AND storeid =:storeid AND tablesid=:tablesid ", array(':weid' => $this->_weid, ':storeid' => $storeid, ':tablesid' => $tablesid));
    $orderlist = pdo_fetchall("SELECT a.dateline,a.from_user as from_user,b.nickname as nickname,b.headimgurl as headimgurl FROM " . tablename($this->table_tables_order) . " a INNER JOIN " . tablename($this->table_fans) . " b ON a.from_user=b.from_user WHERE a.weid = :weid AND a.storeid =:storeid AND a.tablesid=:tablesid ORDER BY  a.id DESC LIMIT 20", array(':weid' => $this->_weid, ':storeid' => $storeid, ':tablesid' => $tablesid));

    if (!empty($item)) {
        $totalprice = 0;
        $payprice = 0;
        $notprice = 0;

        $condition = " weid = '{$_W['uniacid']}' AND status<>3 AND status<>-1";
        $condition .= " AND tables = '" . $tablesid . "' ";
        $orderlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE $condition ORDER BY id
        desc, dateline DESC LIMIT 50");

        foreach ($orderlist as $key => $value) {
            $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user = :from_user AND weid=:weid", array(':from_user' => $value['from_user'], ':weid' => $this->_weid));
            if ($fans) {
                $orderlist[$key]['headimgurl'] = $fans['headimgurl'];
                $orderlist[$key]['nickname'] = $fans['nickname'];
                $orderlist[$key]['fansid'] = $fans['id'];
            }
            $totalprice = $totalprice + floatval($value['totalprice']);
            if ($value["ispay"] == 1) {
                $payprice = $payprice + floatval($value['totalprice']);
            } else {
                $notprice = $notprice + floatval($value['totalprice']);
            }

            $orderlist[$key]['goods'] = pdo_fetchall("SELECT a.*,b.title FROM " . tablename($this->table_order_goods) . " as a left join  " . tablename($this->table_goods) . " as b on a.goodsid=b.id WHERE a.weid = '{$this->_weid}' and a.orderid={$value['id']}");
        }
    }

} else if ($operation == 'batch') {
    $tablezonesid = intval($_GPC['tablezonesid']);
    if (checksubmit('submit')) {
        $tablecount = intval($_GPC['table_count']);
        $title = trim($_GPC['title']);
        if ($tablecount <= 0) {
            message('创建桌台数量必须大于0！', '', 'error');
        }
        if (empty($title)) {
            message('请输入起始桌台号！');
        }
        $num = findNum($title);
        if (empty($num)) {
            message('输入起始桌台号必须包含数字！');
        }
        $pre = preg_replace("#[^A-z]#", '', $title);

        for ($i = 0; $i < $tablecount; $i++) {
            $num = intval($num);
            $title = $pre . str_pad($num, 3, "0", STR_PAD_LEFT);
            $data = array(
                'weid' => intval($weid),
                'storeid' => $storeid,
                'tablezonesid' => $tablezonesid,
                'title' => $title,
                'user_count' => intval($_GPC['user_count']),
                'displayorder' => 0,
                'dateline' => TIMESTAMP,
                'print_label' => intval($_GPC['table_label_id']),
            );
            if (empty($id)) {
                pdo_insert($this->table_tables, $data);
            }
            $num++;
        }
        message('操作成功！', $this->createWebUrl('tables', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'display') {
    $condition = '';
    if (!empty($_GPC['keyword'])) {
        $condition .= " AND title LIKE '%{$_GPC['keyword']}%'";
    }

    if (!empty($_GPC['tablezonesid'])) {
        $tid = intval($_GPC['tablezonesid']);
        $condition .= " AND tablezonesid = '{$tid}'";
    }
    $store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " WHERE id = :id LIMIT 1", array(':id' => $storeid));
    $logo = tomedia($store['logo']);
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_tables) . " WHERE weid = :weid AND storeid =:storeid {$condition} ORDER BY displayorder DESC, id DESC", array(':weid' => $this->_weid, ':storeid' => $storeid));
    $tablezones = pdo_fetchall("SELECT id,title FROM " . tablename($this->table_tablezones) . " where weid = :weid AND storeid =:storeid ", array(':weid' => $this->_weid, ':storeid' => $storeid), 'id');
    $tablesorder = pdo_fetchall("SELECT tablesid,count(1) AS count FROM " . tablename($this->table_tables_order) . " where weid = :weid AND storeid =:storeid GROUP BY tablesid ", array(':weid' => $this->_weid, ':storeid' => $storeid), 'tablesid');
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM " . tablename($this->table_tables) . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，数据不存在或是已经被删除！');
    }

    pdo_delete($this->table_tables, array('id' => $id, 'weid' => $weid));
    message('操作成功！', $this->createWebUrl('tables', array('op' => 'display', 'storeid' => $storeid, 'type' => 'qrcode')), 'success');
} else if ($operation == 'updatestate') {
    $tablesid = intval($_GPC['tablesid']);
    $status = intval($_GPC['workflow_state']);
    pdo_update($this->table_tables, array('status' => $status), array('id' => $tablesid, 'weid' => $weid));
    message('操作成功！', $this->createWebUrl('tables', array('op' => 'display', 'storeid' => $storeid)), 'success');
} else if ($operation == 'clear') {
    pdo_update($this->table_tables, array('status' => 0), array('storeid' => $storeid, 'weid' => $weid));
    message('操作成功！', $this->createWebUrl('tables', array('op' => 'display', 'storeid' => $storeid)), 'success');
} elseif ($operation == 'finishall') {

    $paytype = intval($_GPC['paytype']);
    $money = $_GPC['money'];
    $need = $money;
    $totalprice = $_GPC['totalprice'];
    $ids = implode(",", $_GPC['idArr']);
    if($_GPC['totalprice']<=0 || $_GPC['money']<=0) {
        die(json_encode(['code'=>1000,'msg'=>'应付或实付金额大于0']));
    }
    $dyue = $vipyue = 0;
    // 使用股东卡
    if($_GPC['usedong']==1){
        if(empty($_GPC['vertifygd'])) die(json_encode(['code'=>1000,'msg'=>'股东卡未填写']));
        $resgd =  pdo_fetch("SELECT * FROM " . tablename($this->table_cardlist) . " where num = :num AND type =2 limit 1", array(':num' => $_GPC['vertifygd'] ));
        if(empty($resgd)) die(json_encode(['code'=>1000,'msg'=>'股东卡不存在']));

        $recgd =  pdo_fetch("SELECT sum(price) as p FROM " . tablename($this->table_cardrecord) . " where num = :num", array(':num' => $_GPC['vertifygd'] ));
        $rec = $recgd['p']?$recgd['p']:0;
        $discount = $totalprice*0.1;
        if( $discount > $rec) die(json_encode(['code'=>1000,'msg'=>'股东卡余额不足']));
        $need = $totalprice*0.9;
    }


    // 使用vip卡
    if($paytype==12){
        if(empty($_GPC['vertify'])) die(json_encode(['code'=>1000,'msg'=>'vip卡未填写']));
        $res =  pdo_fetch("SELECT * FROM " . tablename($this->table_cardlist) . " where num = :num AND type =1 limit 1 ", array(':num' => $_GPC['vertify'] ));
        if(empty($res)) die(json_encode(['code'=>1000,'msg'=>'vip卡不存在']));
        $recgd =  pdo_fetch("SELECT sum(price) as p FROM " . tablename($this->table_cardrecord) . " where num = :num", array(':num' => $_GPC['vertify'] ));
        $rec = $recgd['p']?$recgd['p']:0;

        $cha = $need-$rec;
        if($need > $rec && $_GPC['stillvip'] == 0){
         die(json_encode(['code'=>999,'msg'=>"vip卡余额不足,是否使用现金支付{$cha}元"]));
        }
        $record = [
            'cid'=>$res['id'],
            'num'=>$res['num'],
            'price'=>-min($rec,$need),
            'action_id'=>!empty($_W['user']['uid'])?$_W['user']['uid']:2,
            'order_id'=>$_GPC['tablesid'],
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        pdo_insert($this->table_cardrecord, $record);

        $viprec = pdo_fetch("SELECT sum(price) as p FROM " . tablename($this->table_cardrecord) . " where num = :num", array(':num' => $_GPC['vertify'] ));
        $vipyue = $viprec['p']?$viprec['p']:0;
        $need = $rec>=$need?0:abs($cha);
    }

    if($_GPC['usedong']==1){
        $record = [
            'cid'=>$resgd['id'],
            'num'=>$resgd['num'],
            'price'=>-$discount,
            'action_id'=>!empty($_W['user']['uid'])?$_W['user']['uid']:2,
            'order_id'=>$_GPC['tablesid'],
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        
        pdo_insert($this->table_cardrecord, $record);
        $dyueres =  pdo_fetch("SELECT sum(price) as p FROM " . tablename($this->table_cardrecord) . " where num = :num", array(':num' => $_GPC['vertifygd'] ));
        $dyue = $dyueres['p']?$dyueres['p']:0;
        
    }

    // 使用午餐卡
    if($paytype==13 || $paytype==14 || $paytype==15 || $paytype==16 || $paytype==17){
        
        $resall = pdo_fetchall("SELECT og.price as p,og.total as t,g.pcate as c FROM " . tablename($this->table_order_goods) . " as og left join ".tablename($this->table_goods)." as g on og.goodsid=g.id where og.orderid in ({$ids})");

        $oprice = 0;
        $jiuprice = 0;
        foreach ($resall as $key => $value) {
            if($value['c']==9) {
                $jiuprice+=$value['p']*$value['t'];
                continue;
            }
            $oprice+=$value['p']*$value['t'];
        }
        $need = $oprice*0.6+$jiuprice;
    }

    $osn = pdo_fetchall("SELECT ordersn FROM " . tablename($this->table_order) . " where id in ({$ids})");
    $osnarr = [];
    foreach ($osn as $key => $value) {
        $osnarr[] = $value['ordersn'];
    }

    $tableorder = [
        'orderids'=>$ids,
        'ordersns'=>implode(",", $osnarr),
        'tableid'=>$_GPC['tablesid'],
        'totalprice'=>$totalprice,
        'money'=>$need,
        'paytype'=>$paytype,
        'usedong'=>$_GPC['usedong'],
        'actionid'=>!empty($_W['user']['uid'])?$_W['user']['uid']:2,
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s')
    ];
    pdo_insert($this->table_tableorder, $tableorder);

    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $order = $this->getOrderById($id);
            if ($order) {
                $paytype = intval($_GPC['paytype']);

                if ($order['isfinish'] == 0) {
                    //计算积分
                    $this->setOrderCredit($order['id']);
                    pdo_update($this->table_order, array('isfinish' => 1), array('id' => $id));
                    pdo_update($this->table_fans, array('paytime' => TIMESTAMP), array('id' => $fans['id']));

                    if ($order['dining_mode'] == 1) { //处理店内
                        pdo_update($this->table_tables, array('status' => 0), array('id' => $order['tables']));
                    }
                    $this->set_commission($id);
                }
                if ($order['ispay'] == 0 && $paytype != 0) {
                    pdo_update($this->table_order, array('paytype' => $paytype), array('id' => $id, 'weid' => $weid));
                }
                pdo_update($this->table_order, array('status' => 3, 'ispay' => 1, 'finishtime' => TIMESTAMP), array('id' => $id, 'weid' => $weid));
                $this->addOrderLog($id, $_W['user']['username'], 2, 2, 4);
                $this->updateFansData($order['from_user']);
                $this->updateFansFirstStore($order['from_user'], $order['storeid']);
                $order = $this->getOrderById($id);
                $store = $this->getStoreById($order['storeid']);
                $this->sendOrderNotice($order, $store, $setting);
                $rowcount++;
            }
        }
    }
    // $this->_feieSend($_GPC['idArr'], 1, 1);
    die(json_encode(['code'=>200,'msg'=>"操作成功,实际需付款{$need}",'need'=>$need]));
    /*还原*/
    
    
    // $this->message("操作成功,共操作{$rowcount}条数据!", '', 0);
} elseif ($operation == 'printall') {
    $rowcount = 0;
    $notrowcount = 0;
    $position_type = intval($_GPC['position_type']);
    $this->_feieSend($_GPC['idArr'], $position_type);
    $this->message("操作成功！", '', 0);
}elseif ($operation == 'cardVertify') {
    if(empty($_GPC['num'])) die(json_encode(['code'=>1000,'msg'=>'没有填写卡号']));

    $order = pdo_fetch("SELECT * FROM " . tablename($this->table_cardlist) . " where num = :num and type=:type limit 1", array(':num' => $_GPC['num'],':type'=>$_GPC['type']));
    if(empty($order)) die(json_encode(['code'=>1000,'msg'=>'没有该卡号']));

    $tablesorder = pdo_fetch("SELECT sum(price) as p FROM " . tablename($this->table_cardrecord) . " where num = :num ", array(':num' => $_GPC['num']));

    $yue = $tablesorder['p']?$tablesorder['p']:0;

    die(json_encode(['yue'=>$yue,'code'=>200]));
}

include $this->template('web/tables');
