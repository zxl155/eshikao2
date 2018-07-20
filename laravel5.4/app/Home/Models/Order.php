<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    protected $table = 'order';  //表名
    public $timestamps = false;  //过滤默认的字段
    //通过订单号查询地址
   	public function address($order_number)
   	{
   		$order = DB::select("select * from `order` where order_number = $order_number");
   		$address_id = $order[0]->address_id;
   		$address = DB::select("select * from goods_address where address_id = $address_id");
   		foreach ($address as $key => $value) {
   			foreach ($order as $keys => $val) {
   				$value->order_number = $val->order_number;
   				$value->curriculum_id = $val->curriculum_id;
   				$value->order_money = $val->order_money;
   			}
   		}
   		return $address;
   	}
     //通过订单号查询课程  没有收货地址
    public function noaddress($order_number)
    {
      $order = DB::select("select * from `order` where order_number = $order_number");
      return $order;
    }
    //查询用户名称
    public function curriuclumName($curriculum_id,$data)
    {
      $curriculum = DB::select("select * from `curriculum` where curriculum_id = $curriculum_id ");
      foreach ($data as $key => $value) {
        foreach ($curriculum as $k => $val) {
          if($data[0]->curriculum_id == $val->curriculum_id){
            $value->curriculum_name = $val->curriculum_name;
          }
        }
      }
      return $data;
    }
    //查询是否有当前订单
    public function selects($user_id,$curriculum_id)
    {
      
     $order = DB::select('select * from `order` where user_id = '.$user_id.' and curriculum_id = '.$curriculum_id.'');
      return $order;
    }
    //支付成功修改订单状态
    public function orderPay($order_id)
    {
       $order = DB::table('order')->where('order_id',$order_id)->get();
        $arr =  DB::table('order')->where('order_id',$order_id)->update(['order_state'=>1,'order_time'=>date('Y-m-d H:i:s'),'pay_mode'=>1]);
       $order_is = DB::table('user_curriculum')->insert( ['user_id' => $order[0]->user_id, 'curriculum_id' => $order[0]->curriculum_id]);

        $curriculum =  DB::table('curriculum')->where('curriculum_id',$order[0]->curriculum_id)->get();
        $bought_number =  intval($curriculum[0]->bought_number+1);
        $curriculum =  DB::table('curriculum')->where('curriculum_id',$order[0]->curriculum_id)->update(['bought_number'=>$bought_number]);
       if($arr&$order_is&$curriculum){
          return true;
       } else {
          return false;
       }
    }
    //微信支付成功修改订单状态
    public function orderPays($order_id)
    {
       $order = DB::table('order')->where('order_id',$order_id)->get();
        $arr =  DB::table('order')->where('order_id',$order_id)->update(['order_state'=>1,'order_time'=>date('Y-m-d H:i:s'),'pay_mode'=>2]);
       $order_is = DB::table('user_curriculum')->insert( ['user_id' => $order[0]->user_id, 'curriculum_id' => $order[0]->curriculum_id]);

        $curriculum =  DB::table('curriculum')->where('curriculum_id',$order[0]->curriculum_id)->get();
        $bought_number =  intval($curriculum[0]->bought_number+1);
        $curriculum =  DB::table('curriculum')->where('curriculum_id',$order[0]->curriculum_id)->update(['bought_number'=>$bought_number]);
       if($arr&$order_is&$curriculum){
          return true;
       } else {
          return false;
       }
    }

    //查询当前登录用户所有订单
    public function oneOrder()
    {
      $user_id = session('user_id');
      $order = DB::table('order')->where(['user_id'=>$user_id,'order_state'=>1])->orderBy('order_time','desc')->get();
      $curriculum = DB::table('curriculum')->get();
      foreach ($order as $key => $value) {
          foreach ($curriculum as $k => $val) {
              if($value->curriculum_id == $val->curriculum_id){
                  $value->curriculum_name = $val->curriculum_name;
                  $value->qq_group_key = $val->qq_group_key;
                  $value->curriculum_id = $val->curriculum_id;
                  $value->is_goods = $val->is_goods;
                  $value->curriculum_pricture = $val->curriculum_pricture;
              }
          }
      }
      return $order;
    }
    //查询商品的金额是否被修改
    public function quantity($WIDout_trade_no,$WIDtotal_fee)
    {
      $order = DB::table('order')->where('order_number',$WIDout_trade_no)->get();
      $curriculum = DB::table('curriculum')->where('curriculum_id',$order[0]->curriculum_id)->get();
      if($curriculum[0]->recovery_original < date('Y-m-d H:i:s')){
        if($curriculum[0]->original_price == $WIDtotal_fee){
          return true;
        } else {
          return false;
        }
      } else {
        if($curriculum[0]->present_price == $WIDtotal_fee){
          return true;
        } else {
          return false;
        }
      }
      
    }
    //查询商品的数量
    public function orderNumber($order_number)
    {
      $order = DB::table('order')->where('order_number',$order_number)->get();
      $curriculum = DB::table('curriculum')->where('curriculum_id',$order[0]->curriculum_id)->get();
      if($curriculum[0]->bought_number>=$curriculum[0]->purchase_number){
         return "超标";
      } else {
        return "正常";
      }
    }
    //查询用户是否购买
    public function isOrder($order_number)
    {
        $order = DB::table('order')->where('order_number',$order_number)->get();
        $order = DB::table('user_curriculum')->where(['curriculum_id'=>$order[0]->curriculum_id,'user_id'=>session('user_id')])->get()->toarray();
        if(empty($order)){
            return false;
        } else {
            return true;
        }
    }

    //移动支付宝进行生成订单
    public function movezfbpay($data)
    {
       $arr = DB::table('order')->insertGETID(array('order_number'=>$data['order_number'],'curriculum_id'=>$data['curriculum_id'],'order_time'=>date('Y-m-d H:i:s'),'address_id'=>$data['address_id'],'order_state'=>0,'order_money'=>$data['order_money'],'user_id'=>$data['user_id']));
       if ($arr) {
         return $data['order_number'];
       }
    }
    //移动查询课程数据
    public function movecurriculum($order_number)
    {
       $order = DB::table('order')->where('order_number',$order_number)->get();
       $curriculum = DB::table('curriculum')->where('curriculum_id',$order[0]->curriculum_id)->get();
       foreach ($order as $key => $value) {
          foreach ($curriculum as $k => $val) {
              $value->WIDsubject = $val->curriculum_name;
              $value->WIDout_trade_no = $value->order_number;
              $value->WIDtotal_amount = $value->order_money;
              $value->WIDbody = "易师考课程";
          }
       }
       return $order;
    }
}
