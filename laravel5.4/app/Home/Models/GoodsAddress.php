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
}
