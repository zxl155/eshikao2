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
    	$curriculum_id = implode(',',$arr);
    	$data = DB::select("select * from curriculum where curriculum_id in($curriculum_id)");
    	return $data;
    }
    //查询我的课程
}
