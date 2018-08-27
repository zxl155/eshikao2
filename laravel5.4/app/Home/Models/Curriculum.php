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
    	$sql = "select * from curriculum where course_id = 0 and teacher_type = 1 and state = 1 and home_page =1 and purchase_state_time <= '".$times."' and purchase_end_time >= '".$times."' LIMIT 4";
    	$qualifications = DB::select($sql);
        $admin = DB::table('admin')->get();
        foreach ($qualifications as $key => $value) {
            foreach ($admin as $ke => $val) {
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
           $arr = DB::table('curriculum')->where(['course_id'=>$value->curriculum_id])->select('bought_number','course_id')->get()->toarray();
           foreach ($arr as $k => $v) {
               if($v->course_id == $value->curriculum_id) {
                  $value->bought_numbers[] = $v->bought_number;
               }
           }
          if(isset($value->bought_numbers)){
            $value->bought_number= array_sum($value->bought_numbers);
          }
        }
    	return $qualifications;
    }
    /**
    * 首页查询教师招聘课程
    */
    public function recruit()
    {
    	$times = date('Y-m-d H:i:s');
        $sql = "select * from curriculum where  course_id = 0 and  teacher_type = 2 and state = 1 and home_page =1 and purchase_state_time <= '".$times."' and purchase_end_time >= '".$times."' LIMIT 4";
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
             $arr = DB::table('curriculum')->where(['course_id'=>$value->curriculum_id])->select('bought_number','course_id')->get()->toarray();
           foreach ($arr as $k => $v) {
               if($v->course_id == $value->curriculum_id) {
                  $value->bought_numbers[] = $v->bought_number;
               }
           }
          if(isset($value->bought_numbers)){
            $value->bought_number= array_sum($value->bought_numbers);
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
       $curriculum->where('course_id','=',0);
       $curriculum->where('teacher_type','=',1);
       $curriculum->where('state','=',1);
       $curriculum->where('purchase_state_time','<=',$times);
       $curriculum->where('purchase_end_time','>=',$times);
       //$qualificationss = $curriculum->paginate(5);
       $curriculum->orderBy('order_by','asc');
       $qualificationss = $curriculum->get();
        $admin = DB::table('admin')->get();
        foreach ($qualificationss as $key => $value) {
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
            $arr = DB::table('curriculum')->where(['course_id'=>$value->curriculum_id])->select('bought_number','course_id')->get()->toarray();
           foreach ($arr as $k => $v) {
               if($v->course_id == $value->curriculum_id) {
                  $value->bought_numbers[] = $v->bought_number;
               }
           }
          if(isset($value->bought_numbers)){
            $value->bought_number= array_sum($value->bought_numbers);
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
       $curriculum->where('course_id','=',0);
       $curriculum->where('teacher_type','=',2);
       $curriculum->where('state','=',1);
       $curriculum->where('purchase_state_time','<=',$times);
       $curriculum->where('purchase_end_time','>=',$times);
       //$recruits = $curriculum->paginate(5);
       $curriculum->orderBy('order_by','asc');
        $recruits = $curriculum->get();

        $admin = DB::table('admin')->get();
        foreach ($recruits as $key => $value) {
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
            $arr = DB::table('curriculum')->where(['course_id'=>$value->curriculum_id])->select('bought_number','course_id')->get()->toarray();
           foreach ($arr as $k => $v) {
               if($v->course_id == $value->curriculum_id) {
                  $value->bought_numbers[] = $v->bought_number;
               }
           }
          if(isset($value->bought_numbers)){
            $value->bought_number= array_sum($value->bought_numbers);
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
    				$value->admin_name = $values->nickname;
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
                    $value->admin_name = $val->nickname;
                    $value->admin_head = $val->admin_head;
                    $value->admin_desc = $val->admin_desc;
                }
                if($value->recovery_original < $times){
                    $value->recovery_original_is = 1;
                } else {
                     $value->recovery_original_is = 0;
                }
            }
            if (strtotime($value->purchase_state_time) >= strtotime(date('Y-m-d H:i:s'))) {
                //未开始售卖
                $value->is_p_s = 1;
            } else {
                //开始售卖
                $value->is_p_s = 0;
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
       return $curriculum_region;
    }
    //查询课程包对应课程
    public function courselist($curriculum_id)
    {
        $times = date('Y-m-d H:i:s');
       $curriculum = DB::table('curriculum');
        $curriculum->where('course_id','=',$curriculum_id);
       $curriculum->where('state','=',1);
       $curriculum->where('purchase_state_time','<=',$times);
       $curriculum->where('purchase_end_time','>=',$times);
       $curriculum->orderBy('order_by','asc');
       $data = $curriculum->get();
        $admin = DB::table('admin')->get();
        foreach ($data as $key => $value) {
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
        return $data;
    }
    //查询单条课程
    public function oneCurriculum($curriculum_id)
    {
        $data = DB::table('curriculum')->where(['curriculum_id'=>$curriculum_id])->select('curriculum_name')->get();
        return $data;
    }
}
