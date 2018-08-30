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
          $arr = DB::table('order')->where('sales_user_id','!=','')->where(['order_state'=>1,'sales_user_id'=>$user_id[0]->user_id])->orderBy('order_time','desc')->get();
      } else {
          $arr = DB::table('order')->where('sales_user_id','!=','')->where(['order_state'=>1])->orderBy('order_time','desc')->get();
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
     //修改用户对应的发货快递公司
     public function invoices($data)
     {
         $arr = DB::table('order')->where('order_id',$data['order_id'])->update(['invoice'=>$data['invoice']]);
         return $arr;
     }
     //给用户添加对应的课程执行添加
     public function userCurriculumAdds($data)
     {
          $user =  DB::table('user')->where(['user_tel'=>$data['user_tel']])->select('user_id')->get()->toArray();
          if (empty($user)) {
              echo "当前用户不存在";die;
          }
          $curriculum = DB::table('curriculum')->where(['curriculum_id'=>$data['curriculum_id']])->select('bought_number','present_price')->get(); //当前课程对应的购买数量
          if ($data['is_statistics'] == 1) {
            $bought_number = intval($curriculum[0]->bought_number)+1;
            $bought_number = DB::table('curriculum')->where(['curriculum_id'=>$data['curriculum_id']])->update(['bought_number'=>$bought_number]);
          }
          $order_number = substr(time().$data['curriculum_id'].$user[0]->user_id.rand(11111111,99999999),0,18);//订单
          if ($data['is_consignor'] == 1) {
             $address_id = DB::table('goods_address')->insertgetid(['address_name'=>$data['address_name'],'address_tel'=>$data['address_tel'],'address_detailed'=>$data['address_detailed'],'user_id'=>$user[0]->user_id]);
             $arr = DB::table('order')->insert(['order_number'=>$order_number,'curriculum_id'=>$data['curriculum_id'],'order_time'=>date('Y-m-d H:i:s'),'address_id'=>$address_id,'order_state'=>1,'order_money'=>$curriculum[0]->present_price,'user_id'=>$user[0]->user_id,'pay_mode'=>3]);
             if ($arr) {
                $arr = DB::table('user_curriculum')->insert(['curriculum_id'=>$data['curriculum_id'],'user_id'=>$user[0]->user_id]);
                return $arr;
             } else {
                echo "添加订单失败";
             }
          } else {
             $arr = DB::table('order')->insert(['order_number'=>$order_number,'curriculum_id'=>$data['curriculum_id'],'order_time'=>date('Y-m-d H:i:s'),'address_id'=>0,'order_state'=>1,'order_money'=>$curriculum[0]->present_price,'user_id'=>$user[0]->user_id,'pay_mode'=>3]);
            if ($arr) {
                $arr = DB::table('user_curriculum')->insert(['curriculum_id'=>$data['curriculum_id'],'user_id'=>$user[0]->user_id]);
                return $arr;
             } else {
                echo "添加订单失败";
             }
          }
      
     }
}
