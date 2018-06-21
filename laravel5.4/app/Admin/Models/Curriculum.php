<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Curriculum extends Model
{
    protected $table = 'curriculum';  //表名
    public $timestamps = false;  //过滤默认的字段


     /**
     * @李一明
     * @DateTime  2018-06-14
     * 课程添加
     */
     public function insert($data){
     	$curriculum_id = DB::table('curriculum')->insertGetId(['curriculum_name'=>$data['curriculum_name'],'type_id'=>$data['type_id'],'teacher_type'=>$data['teacher_type'],'grade_id'=>$data['grade_id'],'subject_id'=>$data['subject_id'],'region_id'=>$data['region_id'],'start_time'=>$data['start_time'],'notice'=>$data['notice'],'money'=>$data['money'],'stock_number'=>$data['stock_number']]);
        if($curriculum_id){
        	return $curriculum_id;
        }else {
        	return false;
        }
     }
    /**
     * @李一明
     * @DateTime  2018-06-14
     * 课程对应的教师
     */
    public function teacher($data)
    {
    	foreach ($data as $key => $value) {
            $id[$key] = $value->curriculum_id;
        }
       $curriculum = implode($id ,',');
       $sql = "select * from admin_curriculum where curriculum_id in ($curriculum)";
       $teacher = DB::select($sql);
 		return $teacher;
    }
	/**
     * @李一明
     * @DateTime  2018-06-14
     * 课程对应的教师信息
     */
    public function admin($admin,$teacher)
    {
    	foreach ($teacher as $key => $value) {
    		foreach ($admin as $keys => $values) {
    			if($value->admin_id==$values->admin_id){
    				$value->admin_id = $values->admin_id;
    				$value->admin_name = $values->admin_name;
    				$value->admin_head = $values->admin_head;
    			}
    		}
    	}
    	return $teacher;
    }

    /**
     * @李一明
     * @DateTime  2018-06-14
     * 课程修改
     */
    public function upd($data){
        $arr = DB::table('curriculum')->where('curriculum_id','=',$data['curriculum_id'])->update(['curriculum_name'=>$data['curriculum_name'],'start_time'=>$data['start_time'],'notice'=>$data['notice'],'money'=>$data['money'],'stock_number'=>$data['stock_number']]);
        if($arr){
            return true;
        }else{
            return false;
        }
    }
    

}
