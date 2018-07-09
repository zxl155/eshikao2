<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
require_once "../resources/views/home/wxpay/lib/WxPay.Api.php";
require_once '../resources/views/home/wxpay/example/log.php';
 
//初始化日志
$logHandler= new CLogFileHandler("../resources/views/home/wxpay/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
 
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#f00;'>$key</font> : $value <br/>";
    }
}
 
 
if(isset($_REQUEST["transaction_id"]) && $_REQUEST["transaction_id"] != ""){
    $transaction_id = $_REQUEST["transaction_id"];
    $input = new WxPayOrderQuery();
    $input->SetTransaction_id($transaction_id);
    //printf_info(WxPayApi::orderQuery($input));
    $result=WxPayApi::orderQuery($input);
    echo $result['trade_state'];
    exit();
}
 
if(isset($out_trade_no) && $out_trade_no != ""){
    $out_trade_no = $out_trade_no;
    $input = new WxPayOrderQuery();
    $input->SetOut_trade_no($out_trade_no);
    //printf_info(WxPayApi::orderQuery($input));
    $result=WxPayApi::orderQuery($input);
    echo $result['trade_state'];
    exit();
}
?>