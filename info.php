<?php
echo mt_rand(1000,9999);
die;
// 发送短信
function sendCode($phone='',$content=''){
    $statusStr = array(
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    );
    if(is_array($phone)) $phone = implode(',', $phone);
    $smsapi = "http://api.smsbao.com/";
    $user = "sx1989"; //短信平台帐号
    $pass = md5("pwdsx1989"); //短信平台密码
    $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
    $result =file_get_contents($sendurl) ;
    echo $statusStr[$result];
}
sendCode('18217182872','您的蜀食汇vip卡号0000365 本次消费：10.5,卡内余额：205.6');