<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Course extends Model
{
	//查询课程包
    public function package()
    {
    	$arr = DB::table('course')->get();
    	return $arr;
    }
    //添加课程包
    public function addPackages($data)
    {
    	$curriculum_id = $data['curriculum_id'];
    	$curriculum_id = implode($curriculum_id,',');
    	$arr = DB::table('course')->insert(['course_name'=>$data['course_name'],'curriculum_id'=>$curriculum_id]);
    	return $arr;
    }
    //删除课程包
    public function delPackage($course_id)
    {
    	$arr = DB::table('course')->where('course_id',$course_id)->delete();
    	return $arr;
    }
  	//自改课程包
  	public function updatePackage($course_id)
  	{
  		$arr = DB::table('course')->where('course_id',$course_id)->get();
  		return $arr;die;
  	}
  	//修改课程包
  	public function updatePackages($data)
  	{
  		$curriculum_id = $data['curriculum_id'];
    	$curriculum_id = implode($curriculum_id,',');
    	$arr = DB::table('course')->where('course_id',$data['course_id'])->update(['curriculum_id'=>$curriculum_id,'course_name'=>$data['course_name']]);
    	return $arr;
  	}
}
