<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$cur_nave = 'search';

//$word = $setting['searchword'];
//if ($word) {
//    $words = explode(' ', $word);
//}

$searchword = trim($_GPC['searchword']);
if ($searchword) {

    $childsql = " SELECT distinct(storeid) FROM " . tablename($this->table_goods) . " WHERE weid = :weid AND title like '%" . $searchword . "%' ";
    $strwhere = " AND (title like '%" . $searchword . "%' OR id in({$childsql})) ";
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND is_show=1 AND deleted=0 {$strwhere} ORDER BY
displayorder DESC,id DESC", array(':weid' => $weid), 'storeid');

    $childlist = pdo_fetchall($childsql, array(':weid' => $weid));

    foreach ($list as $key => $value) {
        $goodslist = array();
        foreach ($childlist as $k => $v) {
            $sid = intval($v['storeid']);
            if ($value['id'] == $sid) {
                $goodslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE title like '%" . $searchword . "%' AND storeid={$sid}");
            }
        }
        $list[$key]['goods'] = $goodslist;
    }
//    print_r($list);
//    exit;
}
//else {
//    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND is_hot=1 AND is_show=1 AND deleted=0 ORDER BY displayorder
//DESC,id DESC", array(':weid' => $weid));
//}

include $this->template($this->cur_tpl . '/search');