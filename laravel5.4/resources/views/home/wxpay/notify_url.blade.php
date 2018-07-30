<?php 
	/**
     * 支付回调接口
     * @return [type] [description]
     */
    public function pay_callback() {
        $postData = '';
        if (file_get_contents("php://input")) {
            $postData = file_get_contents("php://input");
        } else {
            return;
        }
        $payInfo = array();
        $notify = $this->wxpay_model->wxPayNotify($postData);

        if ($notify->checkSign == TRUE) {
            if ($notify->data['return_code'] == 'FAIL') {
                $payInfo['status'] = FALSE;
                $payInfo['msg'] = '通信出错';
            } elseif ($notify->data['result_code'] == 'FAIL') {
                $payInfo['status'] = FALSE;
                $payInfo['msg'] = '业务出错';
            } else {
                $payInfo['status'] = TRUE;
                $payInfo['msg'] = '支付成功';
                $payInfo['sn']=substr($notify->data['out_trade_no'],8);
                $payInfo['order_no'] = $notify->data['out_trade_no'];
                $payInfo['platform_no']=$notify->data['transaction_id'];
                $payInfo['attach']=$notify->data['attach'];
                $payInfo['fee']=$notify->data['cash_fee'];
                $payInfo['currency']=$notify->data['fee_type'];
                $payInfo['user_sign']=$notify->data['openid'];
            }
        }
        $returnXml = $notify->returnXml();

        echo $returnXml;

        $this->load->library('RedisCache');
        if($payInfo['status']){
           //这里要记录到日志处理（略）
            $this->model->order->onPaySuccess($payInfo['sn'], $payInfo['order_no'], $payInfo['platform_no'],'', $payInfo['user_sign'], $payInfo);
            $this->redis->RedisCache->set('order:payNo:'.$payInfo['order_no'],'OK',5000);
        }else{
           //这里要记录到日志处理（略）
            $this->model->order->onPayFailure($payInfo['sn'], $payInfo['order_no'], $payInfo['platform_no'],'', $payInfo['user_sign'], $payInfo, '订单支付失败 ['.$payInfo['msg'].']');
        }
    }
 ?>