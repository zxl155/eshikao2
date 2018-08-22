<?php

namespace App\Home\Models;

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
        $lifeTime = 24 * 3600 * 30;  // 保存一个月 
        session_set_cookie_params($lifeTime); 
        session(['user_id' => $user[0]->user_id]);
        session(['user_name' => $user[0]->user_name]);
        session(['user_tel' => $user[0]->user_tel]);
        session(['head' => $user[0]->head_images]);
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
        session(['user_name' => $data['user_name']]);
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
   //通过手机号验证码修改密码
   public function retrieves($data)
   {
     $arr = DB::table('user')->where('user_tel',$data['user_tel'])->update(['password'=>md5($data['user_pwd'])]);
     return $arr;
   }
   //通过手机号查询数据
   public function app($user_tel)
   {
      $arr = DB::table('user')->where(['user_tel'=>$user_tel])->get()->toArray();
      return $arr;
   }
}
