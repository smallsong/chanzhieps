<?php
$config->alipay->payGW     = 'https://www.alipay.com/cooperate/gateway.do?';
$config->alipay->checkGW   = "http://notify.alipay.com/trade/notify_query.do?";
$config->alipay->service   = 'create_direct_pay_by_user'; 
$config->alipay->signType  = 'MD5';
$config->alipay->payType   = 1;
$config->alipay->charset   = 'utf-8';

$config->alipay->pid       = '2088302779984780';
$config->alipay->key       = 'b8baofwu5kqy25f0vzj9m1vcljc2jqzc';
$config->alipay->email     = 'chunsheng@cnezsoft.com';
$config->alipay->notifyURL = '';
$config->alipay->returnURL = '';

$config->alipay->map['service']   = 'service';
$config->alipay->map['signType']  = 'sign_type';
$config->alipay->map['payType']   = 'payment_type';
$config->alipay->map['charset']   = '_input_charset';
$config->alipay->map['notifyURL'] = 'notify_url';
$config->alipay->map['returnURL'] = 'return_url';

$config->alipay->map['pid']       = 'partner';
$config->alipay->map['key']       = 'security_code';
$config->alipay->map['email']     = 'seller_email';

$config->alipay->map['orderNO'] = 'out_trade_no';
$config->alipay->map['subject'] = 'subject';
$config->alipay->map['money']   = 'total_fee';
$config->alipay->map['body']    = 'body';
$config->alipay->map['extra']   = 'extra_common';
