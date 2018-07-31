<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Course extends Model
{
	//查询课程包对应课程
    public function package($user_id)
    {
      $sales = DB::table('sales')->where(['user_id'=>$user_id,'sales_is'=>1])->get();
      $arr = DB::table('course')->where('course_id',$sales[0]->course_id)->get();
      $curriculum_id = $arr[0]->curriculum_id;
      $times = date('Y-m-d H:i:s');
      $sql = "select * from curriculum where teacher_type = 1 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >= '".$times."' and curriculum_id in($curriculum_id)";
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
      return $qualifications;
    }
}
