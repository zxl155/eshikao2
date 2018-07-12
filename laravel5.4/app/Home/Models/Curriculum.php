<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Curriculum extends Model
{
   /**
    * 首页查询教师资格课程
    */
    public function qualifications()
    {
        $times = date('Y-m-d H:i:s');
    	$sql = "select * from curriculum where teacher_type = 1 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >= '".$times."' order by bought_number desc  LIMIT 8";
    	$qualifications = DB::select($sql);
        $admin = DB::table('admin')->get();
        foreach ($qualifications as $key => $value) {
            foreach ($admin as $key => $val) {
                if($value->admin_id == $val->admin_id){
                    $value->admin_name = $val->nickname;
                    $value->admin_head = $val->admin_head;
                }
                if($value->recovery_original < $times){
                    $value->recovery_original_is = 1;
                } else {
                     $value->recovery_original_is = 0;
                }
            }
        }
        //print_r($qualifications);die;
    	return $qualifications;
    }
    /**
    * 首页查询教师招聘课程
    */
    public function recruit()
    {
    	$times = date('Y-m-d H:i:s');
        $sql = "select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >= '".$times."' order by bought_number desc  LIMIT 8";
        $recruit = DB::select($sql);
        $admin = DB::table('admin')->get();
        foreach ($recruit as $key => $value) {
            foreach ($admin as $key => $val) {
                if($value->admin_id == $val->admin_id){
                    $value->admin_name = $val->nickname;
                    $value->admin_head = $val->admin_head;
                }
                if($value->recovery_original < $times){
                    $value->recovery_original_is = 1;
                } else {
                     $value->recovery_original_is = 0;
                }
            }
        }
    	return $recruit;
    }
    /**
     * 查询教师资格课程
     */
    public function qualificationss()
    {
        $times = date('Y-m-d H:i:s');
       $curriculum = DB::table('curriculum');
       $curriculum->where('teacher_type','=',1);
       $curriculum->where('state','=',1);
       $curriculum->where('purchase_state_time','<=',$times);
       $curriculum->where('purchase_end_time','>=',$times);
       //$qualificationss = $curriculum->paginate(5);
       $qualificationss = $curriculum->get();
        $admin = DB::table('admin')->get();
        foreach ($qualificationss as $key => $value) {
            foreach ($admin as $key => $val) {
                if($value->admin_id == $val->admin_id){
                    $value->admin_name = $val->admin_name;
                    $value->admin_head = $val->admin_head;
                }
                if($value->recovery_original < $times){
                    $value->recovery_original_is = 1;
                } else {
                     $value->recovery_original_is = 0;
                }
            }
        }
        return $qualificationss;
    }
    /**
     * 查询教师招聘
     */
    public function recruits()
    {
        $times = date('Y-m-d H:i:s');
       $curriculum = DB::table('curriculum');
       $curriculum->where('teacher_type','=',2);
       $curriculum->where('state','=',1);
       $curriculum->where('purchase_state_time','<=',$times);
       $curriculum->where('purchase_end_time','>=',$times);
       //$recruits = $curriculum->paginate(5);
        $recruits = $curriculum->get();

        $admin = DB::table('admin')->get();
        foreach ($recruits as $key => $value) {
            foreach ($admin as $key => $val) {
                if($value->admin_id == $val->admin_id){
                    $value->admin_name = $val->admin_name;
                    $value->admin_head = $val->admin_head;
                }
                if($value->recovery_original < $times){
                    $value->recovery_original_is = 1;
                } else {
                     $value->recovery_original_is = 0;
                }
            }
        }
        return $recruits;
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
     * 课程的详情
     */
    public function coursedetails($curriculum_id)
    {
        $times = date('Y-m-d H:i:s');
        $arr = DB::select('select * from curriculum where curriculum_id = :curriculum_id', [':curriculum_id'=>$curriculum_id]);
        $admin = DB::table('admin')->get();
        foreach ($arr as $key => $value) {
            foreach ($admin as $keys => $val) {
                if ($value->admin_id == $val->admin_id) {
                    $value->admin_name = $val->admin_name;
                    $value->admin_head = $val->admin_head;
                    $value->admin_desc = $val->admin_desc;
                }
                if($value->recovery_original < $times){
                    $value->recovery_original_is = 1;
                } else {
                     $value->recovery_original_is = 0;
                }
            }
        }
        if ($arr) {
            return $arr;
        } else {
            return false;
        }
    }
   //详情页右侧栏
    public function regihtContent($curriculum_id)
    {
        $times = date('Y-m-d H:i:s');
       $curriculum = DB::table('curriculum')->where('curriculum_id',$curriculum_id)->get();
       $region_id = $curriculum[0]->region_id;
       $region_id = substr($region_id,0,1);
       //echo $region_id;die;
       $curriculum_region = DB::select("select * from curriculum where find_in_set(".$region_id.",region_id) limit 3");
       $admin = DB::table('admin')->get();
       foreach ($curriculum_region as $key => $value) {
           foreach ($admin as $k => $val) {
               if($value->admin_id == $val->admin_id){
                $value->admin_name = $val->admin_name;
                $value->admin_head = $val->admin_head;
               }
                if($value->recovery_original < $times){
                    $value->recovery_original_is = 1;
                } else {
                     $value->recovery_original_is = 0;
                }
           }
       }
       return $curriculum_region;
    }
}
