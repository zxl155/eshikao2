<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Qualifications extends Model
{
   public function catType()
   {
   		$type = DB::select('select * from cat_type');
   		return $type;
   }
   public function gradeType()
   {
   		$type = DB::select('select * from grade_type');
   		return $type;
   }
   public function subjectType()
   {
   		$type = DB::select('select * from subject_type');
   		return $type;
   }

   public function curriculum()
   {
   		$data = DB::table('curriculum')->where('teacher_type','=','1')->simplePaginate(12);
   		return $data;
   }
   public function curriculums()
   {
      $data = DB::table('curriculum')->where('teacher_type','=','2')->simplePaginate(12);
      return $data;
   }
     public function region()
   {
      $type = DB::select('select * from region');
      return $type;
   }
     /**
    * 查询教师资格课程
    */
    public function qualifications()
    {
    	$sql = "select * from curriculum";
    	$qualifications = DB::select($sql);
    	return $qualifications;
    }
     /**
     * 查询课程对应的教师
     */
    public function teacher()
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
     * 查询课程对应教师的信息
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
     * 搜索教师资格证数据
     */
    public function quaSearch($data)
    {
       if ($data['cattype_id'] == 0 & $data['grade_id'] == 0 & $data['subject_id'] ==0) {
          $arr = DB::select('select * from curriculum where teacher_type = 1');
          return $arr;
       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']==0) {
          $arr = DB::select('select * from curriculum where teacher_type = 1 and type_id = :type_id', [':type_id'=>$data['cattype_id']]);
         return $arr;
       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']==0) {
          $arr = DB::select('select * from curriculum where teacher_type = 1 and grade_id = :grade_id', [':grade_id'=>$data['grade_id']]);
         return $arr;
       } elseif ($data['cattype_id']==0 & $data['grade_id']==0 & $data['subject_id']!=0) {
         $arr = DB::select('select * from curriculum where teacher_type = 1 and subject_id = :subject_id', [':subject_id'=>$data['subject_id']]);
         return $arr;
       } elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']==0) {
         $arr = DB::select('select * from curriculum where teacher_type = 1 and type_id = :cattype_id and grade_id = :grade_id', [':cattype_id'=>$data['cattype_id'],':grade_id'=>$data['grade_id']]);
         return $arr;
       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']!=0) {
          $arr = DB::select('select * from curriculum where teacher_type = 1 and type_id = :cattype_id and subject_id = :subject_id', [':cattype_id'=>$data['cattype_id'],':subject_id'=>$data['subject_id']]);
         return $arr;
       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']!=0) {
          $arr = DB::select('select * from curriculum where teacher_type = 1 and grade_id = :grade_id and subject_id = :subject_id', [':grade_id'=>$data['grade_id'],':subject_id'=>$data['subject_id']]);
         return $arr;
       } elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']!=0) {
          $arr = DB::select('select * from curriculum where teacher_type = 1 and grade_id = :grade_id and subject_id = :subject_id and type_id = :type_id', [':grade_id'=>$data['grade_id'],':subject_id'=>$data['subject_id'],':type_id'=>$data['cattype_id']]);
         return $arr;
       }
    }

    /**
     * 搜索教师招聘数据
     */
    public function recruitSearch($data)
    {
       if ($data['cattype_id'] == 0 & $data['grade_id'] == 0 & $data['subject_id'] == 0 & $data['region_id'] == 0) {

          $arr = DB::select('select * from curriculum where teacher_type = 2');
          return $arr;

       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']==0 & $data['region_id'] == 0) {

          $arr = DB::select('select * from curriculum where teacher_type = 2 and type_id = :type_id', [':type_id'=>$data['cattype_id']]);
         return $arr;

       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']==0 & $data['region_id'] == 0) {

          $arr = DB::select('select * from curriculum where teacher_type = 2 and grade_id = :grade_id', [':grade_id'=>$data['grade_id']]);
         return $arr;

       } elseif ($data['cattype_id']==0 & $data['grade_id']==0 & $data['subject_id']!=0 & $data['region_id'] == 0) {

         $arr = DB::select('select * from curriculum where teacher_type = 2 and subject_id = :subject_id', [':subject_id'=>$data['subject_id']]);
         return $arr;

       } elseif ($data['cattype_id']==0 & $data['grade_id']==0 & $data['subject_id']==0 & $data['region_id'] != 0) {

         $arr = DB::select('select * from curriculum where teacher_type = 2 and region_id = :region_id', [':region_id'=>$data['region_id']]);
         return $arr;

       } elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']==0 & $data['region_id'] == 0) {

         $arr = DB::select('select * from curriculum where teacher_type = 2 and type_id = :cattype_id and grade_id = :grade_id', [':cattype_id'=>$data['cattype_id'],':grade_id'=>$data['grade_id']]);
         return $arr;

       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']!=0 & $data['region_id'] == 0) {

          $arr = DB::select('select * from curriculum where teacher_type = 2 and type_id = :cattype_id and subject_id = :subject_id', [':cattype_id'=>$data['cattype_id'],':subject_id'=>$data['subject_id']]);
         return $arr;

       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']==0 & $data['region_id'] != 0) {
         
          $arr = DB::select('select * from curriculum where teacher_type = 2 and type_id = :cattype_id and region_id = :region_id', [':cattype_id'=>$data['cattype_id'],':region_id'=>$data['region_id']]);
         return $arr;

       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']!=0 & $data['region_id'] == 0) {

          $arr = DB::select('select * from curriculum where teacher_type = 2 and grade_id = :grade_id and subject_id = :subject_id', [':grade_id'=>$data['grade_id'],':subject_id'=>$data['subject_id']]);
         return $arr;

       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']==0 & $data['region_id'] != 0) {

          $arr = DB::select('select * from curriculum where teacher_type = 2 and grade_id = :grade_id and region_id = :region_id', [':grade_id'=>$data['grade_id'],':region_id'=>$data['region_id']]);
         return $arr;

       } elseif ($data['cattype_id']==0 & $data['grade_id']==0 & $data['subject_id']!=0 & $data['region_id'] != 0) {

          $arr = DB::select('select * from curriculum where teacher_type = 2 and subject_id = :subject_id and region_id = :region_id', [':subject_id'=>$data['subject_id'],':region_id'=>$data['region_id']]);
         return $arr;

       }  elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']!=0 & $data['region_id'] == 0) {

         $arr = DB::select('select * from curriculum where teacher_type = 2 and type_id = :cattype_id and grade_id = :grade_id and subject_id = :subject_id', [':cattype_id'=>$data['cattype_id'],':grade_id'=>$data['grade_id'],':subject_id'=>$data['subject_id']]);
         return $arr;

       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']!=0 & $data['region_id'] != 0) {

         $arr = DB::select('select * from curriculum where teacher_type = 2 and region_id = :region_id and grade_id = :grade_id and subject_id = :subject_id', [':region_id'=>$data['region_id'],':grade_id'=>$data['grade_id'],':subject_id'=>$data['subject_id']]);
         return $arr;
         
       }  elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']==0 & $data['region_id'] != 0) {

         $arr = DB::select('select * from curriculum where teacher_type = 2 and type_id = :cattype_id and grade_id = :grade_id and region_id = :region_id', [':cattype_id'=>$data['cattype_id'],':grade_id'=>$data['grade_id'],':region_id'=>$data['region_id']]);
         return $arr;
         
       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']!=0 & $data['region_id'] != 0) {

         $arr = DB::select('select * from curriculum where teacher_type = 2 and type_id = :cattype_id and subject_id = :subject_id and region_id = :region_id', [':cattype_id'=>$data['cattype_id'],':subject_id'=>$data['subject_id'],':region_id'=>$data['region_id']]);
         return $arr;
         
       } elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']!=0 & $data['region_id'] != 0) {

         $arr = DB::select('select * from curriculum where teacher_type = 2 and type_id = :cattype_id and subject_id = :subject_id and region_id = :region_id and grade_id = :grade_id', [':cattype_id'=>$data['cattype_id'],':subject_id'=>$data['subject_id'],':region_id'=>$data['region_id'],':grade_id'=>$data['grade_id']]);
         return $arr;
         
       } 
    }
}

