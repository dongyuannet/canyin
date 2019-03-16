<?php
global $_GPC, $_W;
load()->func('tpl');

// $weid = $this->_weid;
$uid = !empty($_W['user']['uid'])?$_W['user']['uid']:2;
$action = 'cardlist';
$title = $this->actions_titles[$action];

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$status = !isset($_GPC['status']) ? 0 : $_GPC['status'];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $condition = " 1=1 ";
    if (!empty($_GPC['keyword'])) {
        $condition .= " AND (num LIKE '%{$_GPC['keyword']}%' OR name LIKE '%{$_GPC['keyword']}%' OR phone LIKE '%{$_GPC['keyword']}%') ";
    }

    if ($status > 0) {
        $condition .= " AND type = '" . intval($_GPC['status']) . "'";
    }


    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_cardlist) . " WHERE  $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);

    foreach ($list as $key => $v) {
        $res = pdo_fetch("SELECT sum(price) as p FROM " . tablename($this->table_cardrecord) . " WHERE  cid = {$v['id']} ");
        $list[$key]['yue'] = $res['p']?$res['p']:0;
    }
 
    if(!strrpos("AND", $condition)) $condition='';
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_cardlist) . "  $condition");
    $pager = pagination($total, $pindex, $psize);

} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    // 处理充值
    if (!empty($id) && !empty($_GPC['ac'])) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_cardlist) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) message('抱歉，不存在或是已经删除！', '', 'error');
        if(!empty($_GPC['action'])){
            $jine = $_GPC['jine'];
            if(!is_numeric($jine) || empty($jine)) message('金额不正确', '', 'error');
            $data = [
                'num'=>$item['num'],
                'price'=>$jine,
                'action_id' => $uid,
                'cid'=>$item['id'],
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ];
            pdo_insert($this->table_cardrecord, $data);
            message('操作成功！', $this->createWebUrl('cardlist', array('op' => 'display', 'storeid' => $storeid)),
            'success');
        }
        $res = pdo_fetch("SELECT sum(price) as a FROM " . tablename($this->table_cardrecord) . " WHERE cid = :id", array(':id' => $item['id']));
        $item['yue'] =  $res['a'];
        include $this->template('web/cardrecord');
        die();
    }

    // 充值记录
    if (!empty($id) && !empty($_GPC['re'])) {
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_cardrecord) . " WHERE cid = :id ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':id' => $id));
        include $this->template('web/cardhis');
        die();
    }


    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_cardlist) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，不存在或是已经删除！', '', 'error');
        }
    } 
    if (checksubmit('submit')) {

        $num = trim($_GPC['num']);
        $name = trim($_GPC['name']);
        $phone = trim($_GPC['phone']);
        $price = trim($_GPC['price']);
        $type = intval($_GPC['type']);

        if(empty($num)) message('卡号为空', '', 'error');
        if(empty($name)) message('姓名为空', '', 'error');
        if(empty($phone)) message('联系方式为空', '', 'error');
        if(empty($price)) message('开卡金额为0', '', 'error');
        if(empty($type)) message('类型未选', '', 'error');

        $data = array(
            'action_id' => $uid,
            'num'=>trim($_GPC['num']),
            'name' => trim($_GPC['name']),
            'phone' => trim($_GPC['phone']),
            'price' => trim($_GPC['price']),
            'type' => intval($_GPC['type']),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        );

        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_cardlist) . " WHERE num = :num limit 1", array(':num' => $num));

        if($item) message('卡号已经存在', '', 'error');

        if (empty($id)) {
            $res = pdo_insert($this->table_cardlist, $data);

            // var_dump(pdo_insertid());die;
            pdo_insert($this->table_cardrecord, [
                'cid'=>pdo_insertid(),
                'num'=>trim($_GPC['num']),
                'price'=>trim($_GPC['price']),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_cardlist, $data, array('id' => $id));
        }
        message('操作成功！', $this->createWebUrl('cardlist', array('op' => 'display', 'storeid' => $storeid)),
            'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename($this->table_cardlist) . " WHERE id = :id", array(':id' => $id));
    if (empty($item)) {
        message('数据不存在或是已经被删除！', $this->createWebUrl('cardlist', array('op' => 'display', 'storeid' =>
            $storeid)), 'error');
    }
    pdo_delete($this->table_cardlist, array('id' => $id, 'weid' => $weid));
    message('删除成功！', $this->createWebUrl('cardlist', array('op' => 'display', 'storeid' => $storeid)), 'success');
}
include $this->template('web/cardlist');