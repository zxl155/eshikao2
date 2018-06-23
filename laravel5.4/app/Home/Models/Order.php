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
}
