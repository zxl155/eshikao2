<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Sales extends Model
{
    //列表查询
	   public function sales()
     {
        $arr = DB::table('sales')->get();
        return $arr;
     }
    //添加
     public function addSaless($data)
     {
       $user = DB::table('user')->where('user_tel',$data['sales_tel'])->get()->toArray();
       if (empty($user)) {
           echo "手机号未在本站注册,请通知注册";die;
       }
       $arr =  DB::table('sales')->insert(['sales_tel'=>$data['sales_tel'],'sales_name'=>$data['sales_name'],'sales_identity'=>$data['sales_identity'],'sales_bank'=>$data['sales_bank'],'sales_number'=>$data['sales_number'],'sales_channel'=>$data['sales_channel'],'sales_is'=>$data['sales_is'],'course_id'=>$data['course_id'],'sales_content'=>$data['sales_content'],'sales_time'=>date('Y-m-d H:i:s'),'user_id'=>$user[0]->user_id,'name'=>$data['name']]);
        return $arr;
     }
     //删除
     public function delSales($sales_id)
     {
        $arr = DB::table('sales')->where('sales_id',$sales_id)->delete();
        return $arr;
     }
     //修改
     public function updSales($sales_id)
     {
       $data = DB::table('sales')->where('sales_id',$sales_id)->get();
       return $data;
     }
     //执行修改
     public function updSaless($data)
     {
        $arr = DB::table('sales')->where('sales_id',$data['sales_id'])->update(['sales_tel'=>$data['sales_tel'],'sales_name'=>$data['sales_name'],'sales_identity'=>$data['sales_identity'],'sales_bank'=>$data['sales_bank'],'sales_number'=>$data['sales_number'],'sales_channel'=>$data['sales_channel'],'sales_is'=>$data['sales_is'],'course_id'=>$data['course_id'],'sales_content'=>$data['sales_content'],'sales_time'=>date('Y-m-d H:i:s'),'name'=>$data['name']]);
        return $arr;
     }
}
