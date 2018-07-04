<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pplive extends Model
{
   public function shows($curriculum_id)
   {
   		$pplive_content = DB::table('pplive')->where('curriculum_id',$curriculum_id)->orderBy('start_time', 'asc')->get();
         $admin_content = DB::table('admin')->get();
         foreach ($pplive_content as $key => $value) {
            foreach ($admin_content as $k => $val) {
                  if ($value->admin_id == $val->admin_id) {
                        $value->admin_name = $val->admin_name;
                        $value->admin_head = $val->admin_head;
                        $value->admin_desc = $val->admin_desc;
                  }
                  if($value->start_time > date('Y-m-d H:i:s')){
                     $value->is_time = 0;
                  } else if($value->end_time < date('Y-m-d H:i:s')){
                     $value->is_time = 2;
                  } else {
                      $value->is_time = 1;
                  }
            }
         }
         //print_r($pplive_content);die;
        return $pplive_content;
   }
   //学生进入直播间
   public function coursedetailShow($pplive_id)
   {
      $pplive = DB::table('pplive')->where('pplive_id',$pplive_id)->get();
      $usercurriculum =  DB::table('user_curriculum')->where('curriculum_id',$pplive[0]->curriculum_id)->get();
      $user = DB::table('user')->where('user_id',$usercurriculum[0]->user_id)->get();
      //print_r($admin);die;
      foreach ($pplive as $key => $value) {
         foreach ($user as $k => $val) {
               $value->user_name = $val->user_name;
               $value->head_images = $val->head_images;
         }
      }
      $params =  [
          "room_id" => $pplive[0]->entrance, //房间号码
            "user_number" => $pplive[0]->admin_id, //admin——id
            "user_name" =>$pplive[0]->user_name,
            "user_role" =>0,
            "user_avatar" => $pplive[0]->head_images,
      ];
      $partner_key = "C0fV8gWo7lbFTyqDZM8AwYwbqbc0QqAM/uCwlJp/Ohip0Iz8bWp4VeLKvj4hM5hx3czelHEN5TEl2LeIxIFFaA==";
      ksort($params);//将参数按key进行排序
       $str = '';
       $ginseng= '';
       foreach ($params as $k => $val) {
           $str .= "{$k}={$val}&"; //拼接成 key1=value1&key2=value2&...&keyN=valueN& 的形式
       }
       $ginseng = $str; //赋值
       $str .= "partner_key=" . $partner_key; //结尾再拼上 partner_key=$partner_key
       $sign = md5($str); //计算md5值
       $ginseng .="sign=" . $sign; 
       $url = "http://www.baijiayun.com/web/room/enter?".$ginseng;
       header("Location: ".$url.""); 
   }
}
