<?php
error_reporting(E_ERROR);
require_once '../resources/views/home/wxpay/example/phpqrcode/phpqrcode.php';
$url = urldecode($data);
if(substr(urldecode("weixin%3A%2F%2Fwxpay%2Fbizpayurl%3Fpr%3DgxjvrGB"), 0, 6) == "weixin"){
	QRcode::png($url);
}else{
	 header('HTTP/1.1 404 Not Found');
}
