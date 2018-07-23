<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class GoodsAddress extends Model
{
   public function insert($data)
   {
      $address_detailed = $data['s_province'].'-'.$data['s_city'].'-'.$data['s_county'].'-'.$data['details'];
   	$arr = DB::insert('insert into goods_address (address_name,address_tel,address_detailed,user_id) values(?,?,?,?)',[$data['address_name'],$data['address_tel'],$address_detailed,session('user_id')]);
      if ($arr) {
         return true;
      } else {
         return false;
      }
   }
   public function select()
   {
      $user_id = session('user_id');
      $arr = DB::select("select * from goods_address where user_id = $user_id");
      return $arr;
   }
   public function deletes($address_id)
   {
      $arr = DB::delete("delete from goods_address where address_id = $address_id");
      return $arr;
   }
   public function updates($address_id)
   {
      $arr = DB::select("select * from goods_address where address_id = $address_id");
      return $arr;
   }
   public function updatess($data)
   {
      $address_detailed = $data['s_province'].'-'.$data['s_city'].'-'.$data['s_county'].'-'.$data['details'];
      $arr = DB::update("update goods_address set address_name = ?,address_tel = ?,address_detailed = ? where address_id = ?",[$data['address_name'],$data['address_tel'],$address_detailed,$data['address_id']]);
      return $arr;
   }

   //查询当前用户默认地址
   public function details($user_id)
   {
      $arr = DB::table('goods_address')->where(['user_id'=>$user_id,'is_default'=>1])->get();
      return $arr;
   }

   //移动修改当前用户的默认地址
   public function movedefault($address_id,$user_id)
   {  
      $address = DB::table('goods_address')->where(['user_id'=>$user_id,'is_default'=>1])->get()->toArray();
      if (empty($address)) {
          $arr = DB::table('goods_address')->where('address_id',$address_id)->update(array('is_default'=>1));
          return $arr;
      } else {
         $data = DB::table('goods_address')->where('user_id',$user_id)->update(array('is_default'=>0));
         $arr = DB::table('goods_address')->where('address_id',$address_id)->update(array('is_default'=>1));
         if ($data&$arr) {
            return true;
         } else {
            return false;
         }
      }
    
     
   }
}
