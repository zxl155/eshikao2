<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserCurriculum extends Model
{
	//查询我的直播课程
    public function index($user_id)
    {
    	$user_curriculum = DB::table('user_curriculum')->where('user_id',$user_id)->get();
    	foreach ($user_curriculum as $key => $value) {
    		$arr[] = $value->curriculum_id;
    	}
        if(empty($arr)){
            return false;die;
        }
    	$curriculum_id = implode(',',$arr);
    	$data = DB::select("select * from curriculum where curriculum_id in($curriculum_id)");
    	return $data;
    }
    //查询用户是否购买了课程
    public function isPurchase($curriculum_id)
    {
       $arr = DB::table('user_curriculum')->where(['curriculum_id'=>$curriculum_id,'user_id'=>session('user_id')])->get()->toarray();
       
       if(!empty($arr)){
        return true;
       }else {
        return false;
       }

    }

}
