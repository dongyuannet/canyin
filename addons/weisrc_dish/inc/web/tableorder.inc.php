<?php 
global $_W, $_GPC;
$weid = $this->_weid;
$setting = $this->getSetting();
load()->func('tpl');
$action = 'order';
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
if (empty($cur_store)) {
    message('门店不存在!');
}

if (!$this->exists()) {
    $_GPC['idArr'] = '';
}

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == '') {

}elseif ($operation == 'display') {
	$paras = [];
	$commoncondition = " 1=1 ";


    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;

    if (!empty($_GPC['ordersn'])) {
        $commoncondition .= " AND ordersns LIKE '%{$_GPC['ordersn']}%' ";
    }

    $table = $_GPC['table'];
    $tableres = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where title=:title LIMIT 1", array(':title' => $table));
    if (!empty($tableres) && !empty($table)) {

        $commoncondition .= " AND tableid = '" . $tableres['id'] . "' ";
    }


    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_tableorder) . " WHERE $commoncondition ORDER BY  created_at DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $paras);
    foreach ($list as $key => $v) {
    	$list[$key]['ordersns'] = str_replace(",", "<br>", $v['ordersns']);
    	$orderids = explode(",",$v['orderids']);
    	$ostr = "";
    	foreach ($orderids as $k => $value) {
    		$ostr .= "<a href='/web/store.php?c=site&a=entry&do=order&op=detail&id={$value}&storeid=1&do=order&m=weisrc_dish' target='_blank'>".$value."</a><br>";
    	}
    	$list[$key]['orderids'] = $ostr;
    }
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_tableorder) . " WHERE $commoncondition", $paras);
    $pager = pagination($total, $pindex, $psize);


    if (!empty($list)) {
        foreach ($list as $key => $value) {

	        $tablesid = intval($value['tableid']);
	        $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where id=:id LIMIT 1", array(':id' => $tablesid));
	        if (!empty($table)) {
	            $table_title = $table['title'];
	            $list[$key]['table'] = $table_title;
	        }

        }
    }

    $order_price = pdo_fetchcolumn("SELECT sum(totalprice) FROM " . tablename($this->table_tableorder) . " WHERE $commoncondition ", $paras);
    $order_price = sprintf('%.2f', $order_price);

}
include $this->template('web/tableorder');
 ?>