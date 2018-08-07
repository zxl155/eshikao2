<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Order extends Model
{
    //查询不为空的订单
	   public function seletes($search)
     { 
     
      if ($search!='') {
         $user_id = DB::table('user')->where('user_tel',$search)->get()->toArray();
         if (empty($user_id)) {
            echo "请输入正确的代理手机号";die;
         }
          $arr = DB::table('order')->where('sales_user_id','!=','')->where(['pay_mode'=>1,'sales_user_id'=>$user_id[0]->user_id])->orderBy('order_time','desc')->get();
      } else {
          $arr = DB::table('order')->where('sales_user_id','!=','')->where(['pay_mode'=>1])->orderBy('order_time','desc')->get();
      }
      
        $sales = DB::table('sales')->select(['sales_name','sales_tel'])->get();
        $user = DB::table('user')->select(['user_id','user_tel'])->get();
        $curriculum = DB::table('curriculum')->select(['curriculum_name','curriculum_id'])->get();
        foreach ($arr as $key => $value) {
          foreach ($user as $k => $val) {
            if ($value->sales_user_id==$val->user_id) {
                $value->sales_user_tel = $val->user_tel;
            }
            if ($value->user_id==$val->user_id) {
              $value->user_tel = $val->user_tel;
            }
          }
        }
        foreach ($arr as $key => $value) {
            foreach ($sales as $k => $val) {
              if ($value->sales_user_tel == $val->sales_tel) {
                 $value->sales_name = $val->sales_name;
              }
            }
        }
        foreach ($arr as $key => $value) {
          foreach ($curriculum as $k => $val) {
              if ($value->curriculum_id==$val->curriculum_id) {
                $value->curriculum_name = $val->curriculum_name;
              }
          }
        }
       
        return $arr;
     }
     //修改用户对应的单号
     public function invoice($data)
     {
         $arr = DB::table('order')->where('order_id',$data['order_id'])->update(['invoice_number'=>$data['invoice_number']]);
         return $arr;
     }
}
