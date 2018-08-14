<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{
	/**
	 * 用户注册
	 */
	public function index($data)
	{
		$arr = DB::insert('insert into user (user_tel,password, add_time) values (?, ?, ?  )',
        [$data['user_tel'], $data['password'],$data['add_time']]);
        if($arr) {
        	return true;
        } else {
        	return false;
        }
		
	}

   /**
	 * 用户是否唯一
	 */
   public function only($phone)
   {
   		$start = DB::select('select * from user where user_tel = :phone', [':phone'=>$phone]);
   		if (empty($start)) {
   			return 1;
   		} else {
   			return 0;
   		}
   }
   /**
   * 登录
   */
   public function dologin($data)
   {
      $user = DB::select('select * from user where user_tel = :phone and password = :password', [':phone'=>$data['user_tel'],':password'=>$data['password']]);
      if(empty($user)){
        return false;
      } else {
        session(['user_id' => $user[0]->user_id]);
        session(['user_name' => $user[0]->user_name]);
        session(['user_tel' => $user[0]->user_tel]);
        return true;
      }
   }
   /**
    * 登录用户信息
    */
   public function oneuser($user_id)
   {
      $data = DB::select('select * from user where user_id = :user_id', [':user_id'=>$user_id]);
      if( $data ){
          return $data;
      } else {
          return false;
      }
   }
   /**
    * 修改用户名称
    */
   public function updatemydata($data)
   {
      $affected = DB::update("update user set user_name=? where user_id = ?", [$data['user_name'],$data['user_id']]);
      if ($affected) {
        return true;
      } else {
        return false;
      }
   }
   /**
    * 修改密码
    */
   public function updatepwds($data)
   {
    $pwd = md5($data['onepwd']);
       $arr = DB::select('select * from user where user_id = :user_id', [':user_id'=>$data['user_id']]);
       $password = $arr[0]->password;
      if (md5($data['clean']) == $password ) {
          if ($data['onepwd'] == $data['twopwd']) {
              $affected = DB::update("update user set password='".$pwd."' where user_id = ?", [$data['user_id']]);
              if ($affected) {
                  return true;
              } else {
                  return false;
              }
          } else {
              return false;
          }
      } else {
          return false;
      }
   }
   /**
    * 头像
    */
   public function images($path)
   {
      $user_id = session('user_id');
      $affected = DB::update("update user set head_images=? where user_id = ?", [$path,$user_id]);
      if ($affected) {
        return true;
      } else {
        return false;
      }
   }
   //后台添加新用户
   public function addUsers($data)
   {
     if (strlen($data['user_tel'])!=11) {
       echo "请输入正确的手机号";die;
     }
      $user = DB::table('user')->where('user_tel',$data['user_tel'])->get()->toArray();
      if (empty($user)) {
        $arr = DB::table('user')->insert(['user_tel'=>$data['user_tel'],'password'=>md5($data['password']),'add_time'=>date('Y-m-d H:i:s'),'is_login'=>1]);
      } else {
        echo "此账号以注册";die;
      }
      return $arr;
   }
   //管理员添加的用户
   public function manualUser()
   {
     $data = DB::table('user')->where('is_login','1')->orderBy('add_time','desc')->paginate(15);
     return $data;
   }
   //自己注册的用户
   public function registerUser()
   {
      $data = DB::table('user')->where('is_login','!=1','1')->orderBy('add_time','desc')->paginate(15);
     return $data;
   }
   //用户对应的购买课程
   public function userCurriculum($user_tel,$need)
   {
      if ($user_tel == ''&$need == '') {
          $order = DB::table('order')->where(['order_state'=>1])->orderBy('order_time','desc')->paginate(15);
      } else {
          if ($user_tel != '' & $need == '') {
              $user = DB::table('user')->where('user_tel',$user_tel)->get()->toArray();
              if (empty($user)) {
                  echo "暂无本用户";die;
              }
              $order = DB::table('order')->where(['order_state'=>1,'user_id'=>$user[0]->user_id])->orderBy('order_time','desc')->get();
          } else if($user_tel == '' & $need != '') {
              $order = DB::table('order')->where(['order_state'=>1])->where('address_id','!=',0)->orderBy('order_time','desc')->get();
          }  
      }
      
      $user = DB::table('user')->select('user_tel','user_id')->get();
      $curriculum = DB::table('curriculum')->select('curriculum_id','curriculum_name')->get();
      $goods_address = DB::table('goods_address')->select('address_id','address_name','address_detailed','address_tel')->get();
      foreach ($order as $key => $value) {
          foreach ($curriculum as $k => $val) {
              if($value->curriculum_id==$val->curriculum_id){
                  $value->curriculum_name = $val->curriculum_name;
              }
          }
      }
      foreach ($order as $key => $value) {
          foreach ($goods_address as $key => $val) {
            if ($value->address_id == 0) {
                  $value->address_name = '无需发货';
                  $value->address_detailed = '无需发货';
                  $value->address_tel = "无需发货";
            } else {
                if($value->address_id == $val->address_id){
                  $value->address_name = $val->address_name;
                  $value->address_detailed = $val->address_detailed;
                  $value->address_tel = $val->address_tel;
                }
            }
              
          }
      }
      return $order;
   }
}
