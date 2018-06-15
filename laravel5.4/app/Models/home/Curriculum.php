<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Curriculum extends Model
{
   /**
    * 查询教师资格课程
    */
    public function qualifications()
    {
    	$sql = "select * from curriculum where teacher_type = 1 order by bought_number desc  LIMIT 8";
    	$qualifications = DB::select($sql);
    	return $qualifications;
    }
    /**
    * 查询教师招聘课程
    */
    public function qualification()
    {
    	$sql = "select * from curriculum where teacher_type = 2 order by bought_number desc  LIMIT 8";
    	$qualification = DB::select($sql);
    	return $qualification;
    }
    /**
     * 查询课程对应的教师
     */
    public function teachera()
    {
    	$arr = $this->qualifications();
    	foreach ($arr as $key => $value) {
            $id[$key] = $value->curriculum_id;
        }
       $curriculum = implode($id ,',');
       $sql = "select * from admin_curriculum where curriculum_id in ($curriculum)";
       $teacher = DB::select($sql);
 		return $teacher;
    }
     /**
     * 查询课程对应的教师
     */
    public function teachers()
    {
    	$arr = $this->qualification();
    	foreach ($arr as $key => $value) {
            $id[$key] = $value->curriculum_id;
        }
       $curriculum = implode($id ,',');
       $sql = "select * from admin_curriculum where curriculum_id in ($curriculum)";
       $teacher = DB::select($sql);
 		return $teacher;
    }
    /**
     * 查询课程对应教师的信息
     */
    public function admina($admin,$teacher)
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
     * 查询课程对应教师的信息
     */
    public function admins($admin,$teachers)
    {
    	foreach ($teachers as $key => $value) {
    		foreach ($admin as $keys => $values) {
    			if($value->admin_id==$values->admin_id){
    				$value->admin_id = $values->admin_id;
    				$value->admin_name = $values->admin_name;
    				$value->admin_head = $values->admin_head;
    			}
    		}
    	}
    	return $teachers;
    }
    /**
     * 课程的详情
     */
    public function coursedetails($curriculum_id)
    {
        $arr = DB::select('select * from curriculum where curriculum_id = :phone', [':phone'=>$curriculum_id]);
        if ($arr) {
            return $arr;
        } else {
            return false;
        }
    }
    /**
     * 单课程对应的教师
     */
    public function oneTeacher($curriculum_id)
    {
        $arr = DB::select('select * from admin_curriculum where curriculum_id = :phone', [':phone'=>$curriculum_id]);
        foreach ($arr as $key => $value) {
            $data[] = $value->admin_id;
        }
        $admin_id = implode($data,',');
        $sql = "select * from admin where admin_id in($admin_id)";
        $teacher = DB::select($sql);
        return $teacher;
    }
}
