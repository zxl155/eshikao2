<?php
namespace App\Home\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Pplive extends Model
{
   public function shows($curriculum_id)
   {
    $sql = "select * from pplive where find_in_set(".$curriculum_id.",curriculum_id) and is_free=0 order by start_time asc";
    $pplive_content = DB::select($sql);
         $admin_content = DB::table('admin')->get();
         foreach ($pplive_content as $key => $value) {
            foreach ($admin_content as $k => $val) {
                  if ($value->admin_id == $val->admin_id) {
                        $value->admin_name = $val->nickname;
                        $value->admin_head = $val->admin_head;
                        $value->admin_desc = $val->admin_desc;
                  }
                  if($value->start_time > date('Y-m-d H:i:s',strtotime('+30 minute'))){
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
      //$usercurriculum =  DB::table('user_curriculum')->where('curriculum_id',$pplive[0]->curriculum_id)->get();
      $user = DB::table('user')->where('user_id',session('user_id'))->get();
      foreach ($pplive as $key => $value) {
         foreach ($user as $k => $val) {
                $value->user_id = $val->user_id;
                if ($val->user_name=='') {
                  $value->user_name = $val->user_tel;
                } else {
                  $value->user_name = $val->user_name;
                }
               if ($val->head_images=='') {
                 $value->head_images = "touxiang.png";
               } else {
                 $value->head_images = $val->head_images;
               }
               
         }
      }
      $params =  [
          "room_id" => $pplive[0]->entrance, //房间号码
            "user_number" => $pplive[0]->user_id, //admin——id
            "user_name" =>$pplive[0]->user_name,
            "user_role" =>0,
            "user_avatar" => "http://www.eshikao.com/home/img/head/".$pplive[0]->head_images."",
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
       $sign = md5($str);
       $params['sign'] = $sign;
       $ginseng = http_build_query($params);
       if ($pplive[0]->type == 1) {
        echo "<script> if(confirm('小主，请确认是否安装客户端'))  location.href='baijiacloud://urlpath=http://www.baijiayun.com/web/room/enter?".$ginseng."&token=token&ts=ts';else location.href='http://www.baijiayun.com/web/room/enter?".$ginseng."'; </script>";
         //$url = "baijiacloud://urlpath=http://www.baijiayun.com/web/room/enter?".$ginseng."&token=token&ts=ts";
       } else {
         $url = "http://www.baijiayun.com/web/room/enter?".$ginseng;
         header("Location: ".$url."");
       }
      // header("Location: ".$url.""); 
   }

   //查看回放
   public function playback($pplive_id)
   {
     $pplive = DB::table('pplive')->where('pplive_id',$pplive_id)->get();
     if ($pplive[0]->type == 5) {
      $params =  [
        "partner_id" => 70707480, //百家云 合作方id
          "room_id" => $pplive[0]->playback_room_id, //房间号码
          "session_id" => $pplive[0]->playback_session_id, //session_id
          "timestamp" => time(),
          "expires_in" => 0,    //回放过期时间

      ];
    } else {
      $params =  [
        "partner_id" => 70707480, //百家云 合作方id
          "room_id" => $pplive[0]->entrance, //房间号码
          "timestamp" => time(),
          "expires_in" => 0,    //回放过期时间

      ];
    }
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
         $ch = curl_init();//初始化curl
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
         // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
          curl_setopt($ch, CURLOPT_URL,"https://api.baijiayun.com/openapi/playback/getPlayerToken");//抓取指定网页
          curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
          curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
          curl_setopt($ch, CURLOPT_POSTFIELDS, $ginseng);
          $arr = curl_exec($ch);//运行curl
          $arr = json_decode($arr);
          if($arr->code == 0){
            if ($pplive[0]->type == 5) {
              $url = "http://www.baijiayun.com/web/playback/index?classid=".$pplive[0]->playback_room_id."&session_id=".$pplive[0]->playback_session_id."&token=".$arr->data->token;
            } else if($pplive[0]->type == 6) {
              $url = $pplive[0]->demand_address;
            } else {
              $url = "http://www.baijiayun.com/web/playback/index?classid=".$pplive[0]->entrance."&token=".$arr->data->token;
            }
            header("Location: ".$url.""); 
          } else {
            if($pplive[0]->type == 6) {
              $url = $pplive[0]->demand_address;
              header("Location: ".$url."");die;
            } 
            echo "查询回放token失败(请在直播结束俩小时后进行观看)";die;
          }
   }
   //查询免费课程
   public function is_free($curriculum_id)
   {
    $sql = "select * from pplive where find_in_set(".$curriculum_id.",curriculum_id) and is_free = 1 order by start_time asc";
    $data = DB::select($sql);
      $admin = DB::table('admin')->select('admin_id','nickname')->get();
      foreach ($data as $key => $value) {
         foreach ($admin as $key => $val) {
            if ($value->admin_id == $val->admin_id) {
              $value->admin_name = $val->nickname;
            }
            if($value->start_time > date('Y-m-d H:i:s',strtotime('+30 minute'))){
                     $value->is_time = 0;
                  } else if($value->end_time < date('Y-m-d H:i:s')){
                     $value->is_time = 2;
                  } else {
                      $value->is_time = 1;
                  }
         }
      }
      return $data;
   }
}
