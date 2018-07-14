<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Qualifications extends Model
{
  //移动端通过教师资格证人气查询
  public function popularity()
  {
           $times = date('Y-m-d H:i:s');
           $curriculum = DB::table('curriculum');
           $curriculum->where('teacher_type','=',1);
           $curriculum->where('state','=',1);
           $curriculum->where('purchase_state_time','<=',$times);
           $curriculum->where('purchase_end_time','>=',$times);
           $curriculum->orderBy('bought_number','desc');
           $qualifications = $curriculum->get();
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
  //移动端通过价格查询
  public function moneys($moneys)
  {
      if($moneys == 1){
           $times = date('Y-m-d H:i:s');
           $curriculum = DB::table('curriculum');
           $curriculum->where('teacher_type','=',1);
           $curriculum->where('state','=',1);
           $curriculum->where('purchase_state_time','<=',$times);
           $curriculum->where('purchase_end_time','>=',$times);
           $curriculum->orderBy('present_price','desc');
           $qualifications = $curriculum->get();
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
      } else {
         $times = date('Y-m-d H:i:s');
           $curriculum = DB::table('curriculum');
           $curriculum->where('teacher_type','=',1);
           $curriculum->where('state','=',1);
           $curriculum->where('purchase_state_time','<=',$times);
           $curriculum->where('purchase_end_time','>=',$times);
          $curriculum->orderBy('present_price','asc');
            
           $qualifications = $curriculum->get();
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
  //移动端通过教师招聘人气查询
  public function popularitys()
  {
           $times = date('Y-m-d H:i:s');
           $curriculum = DB::table('curriculum');
           $curriculum->where('teacher_type','=',2);
           $curriculum->where('state','=',1);
           $curriculum->where('purchase_state_time','<=',$times);
           $curriculum->where('purchase_end_time','>=',$times);
           $curriculum->orderBy('bought_number','desc');
           $qualifications = $curriculum->get();
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
  //移动端通教师招聘价格查询
  public function moneyss($moneys)
  {
      if($moneys == 1){
           $times = date('Y-m-d H:i:s');
           $curriculum = DB::table('curriculum');
           $curriculum->where('teacher_type','=',2);
           $curriculum->where('state','=',1);
           $curriculum->where('purchase_state_time','<=',$times);
           $curriculum->where('purchase_end_time','>=',$times);
           $curriculum->orderBy('present_price','desc');
           $qualifications = $curriculum->get();
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
      } else {
         $times = date('Y-m-d H:i:s');
           $curriculum = DB::table('curriculum');
           $curriculum->where('teacher_type','=',2);
           $curriculum->where('state','=',1);
           $curriculum->where('purchase_state_time','<=',$times);
           $curriculum->where('purchase_end_time','>=',$times);
          $curriculum->orderBy('present_price','asc');
            
           $qualifications = $curriculum->get();
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
     * 搜索教师资格证数据
     */
    public function quaSearch($data)
    {
       if ($data['cattype_id'] == 0 & $data['grade_id'] == 0 & $data['subject_id'] ==0) {
           $times = date('Y-m-d H:i:s');
           $curriculum = DB::table('curriculum');
           $curriculum->where('teacher_type','=',1);
           $curriculum->where('state','=',1);
           $curriculum->where('purchase_state_time','<=',$times);
           $curriculum->where('purchase_end_time','>=',$times);
           $qualifications = $curriculum->get();
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
       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']==0) {
          $times = date('Y-m-d H:i:s');
           $curriculum = DB::table('curriculum');
           $curriculum->where('teacher_type','=',1);
           $curriculum->where('state','=',1);
           $curriculum->where('type_id','=',$data['cattype_id']);
           $curriculum->where('purchase_state_time','<=',$times);
           $curriculum->where('purchase_end_time','>=',$times);
           $qualifications = $curriculum->get();
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
       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']==0) {
           $times = date('Y-m-d H:i:s');
           $qualifications = DB::select("select * from curriculum where teacher_type = 1 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['grade_id'].",grade_id)");
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
       } elseif ($data['cattype_id']==0 & $data['grade_id']==0 & $data['subject_id']!=0) {
        $times = date('Y-m-d H:i:s');
           $qualifications = DB::select("select * from curriculum where teacher_type = 1 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['subject_id'].",subject_id)");
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
       } elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']==0) {
         $times = date('Y-m-d H:i:s');
           $qualifications = DB::select("select * from curriculum where teacher_type = 1 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['grade_id'].",grade_id) and find_in_set(".$data['cattype_id'].",type_id)");
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
       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']!=0) {
          $times = date('Y-m-d H:i:s');
           $qualifications = DB::select("select * from curriculum where teacher_type = 1 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['subject_id'].",subject_id) and find_in_set(".$data['cattype_id'].",type_id)");
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
       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']!=0) {
          $times = date('Y-m-d H:i:s');
           $qualifications = DB::select("select * from curriculum where teacher_type = 1 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['subject_id'].",subject_id) and find_in_set(".$data['grade_id'].",grade_id)");
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
       } elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']!=0) {
          $times = date('Y-m-d H:i:s');
           $qualifications = DB::select("select * from curriculum where teacher_type = 1 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['subject_id'].",subject_id) and find_in_set(".$data['grade_id'].",grade_id) and find_in_set(".$data['cattype_id'].",type_id)");
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

    /**
     * 搜索教师招聘数据
     */
    public function recruitSearch($data)
    {
       if ($data['cattype_id'] == 0 & $data['grade_id'] == 0 & $data['subject_id'] == 0 & $data['region_id'] == 0) {
           $times = date('Y-m-d H:i:s');
           $curriculum = DB::table('curriculum');
           $curriculum->where('teacher_type','=',2);
           $curriculum->where('state','=',1);
           $curriculum->where('purchase_state_time','<=',$times);
           $curriculum->where('purchase_end_time','>=',$times);
           $recruitSearch = $curriculum->get();
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;
       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']==0 & $data['region_id'] == 0) {
           $times = date('Y-m-d H:i:s');
           $curriculum = DB::table('curriculum');
           $curriculum->where('teacher_type','=',2);
           $curriculum->where('state','=',1);
           $curriculum->where('type_id','=',$data['cattype_id']);
           $curriculum->where('purchase_state_time','<=',$times);
           $curriculum->where('purchase_end_time','>=',$times);
           $recruitSearch = $curriculum->get();
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
         return $recruitSearch;
       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']==0 & $data['region_id'] == 0) {

         $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['grade_id'].",grade_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       } elseif ($data['cattype_id']==0 & $data['grade_id']==0 & $data['subject_id']!=0 & $data['region_id'] == 0) {

          $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['subject_id'].",subject_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       } elseif ($data['cattype_id']==0 & $data['grade_id']==0 & $data['subject_id']==0 & $data['region_id'] != 0) {

         $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['region_id'].",region_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       } elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']==0 & $data['region_id'] == 0) {

          $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['cattype_id'].",type_id) and find_in_set(".$data['grade_id'].",grade_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']!=0 & $data['region_id'] == 0) {

           $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['cattype_id'].",type_id) and find_in_set(".$data['subject_id'].",subject_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']==0 & $data['region_id'] != 0) {
         
          $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['cattype_id'].",type_id) and find_in_set(".$data['region_id'].",region_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']!=0 & $data['region_id'] == 0) {

           $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['grade_id'].",grade_id) and find_in_set(".$data['subject_id'].",subject_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']==0 & $data['region_id'] != 0) {

          $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['grade_id'].",grade_id) and find_in_set(".$data['region_id'].",region_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       } elseif ($data['cattype_id']==0 & $data['grade_id']==0 & $data['subject_id']!=0 & $data['region_id'] != 0) {

         $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['subject_id'].",subject_id) and find_in_set(".$data['region_id'].",region_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       }  elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']!=0 & $data['region_id'] == 0) {

        $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['cattype_id'].",type_id) and find_in_set(".$data['grade_id'].",grade_id) and find_in_set(".$data['subject_id'].",subject_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       } elseif ($data['cattype_id']==0 & $data['grade_id']!=0 & $data['subject_id']!=0 & $data['region_id'] != 0) {

        $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['region_id'].",region_id) and find_in_set(".$data['grade_id'].",grade_id) and find_in_set(".$data['subject_id'].",subject_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

       }  elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']==0 & $data['region_id'] != 0) {

          $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['region_id'].",region_id) and find_in_set(".$data['grade_id'].",grade_id) and find_in_set(".$data['cattype_id'].",type_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;

         
       } elseif ($data['cattype_id']!=0 & $data['grade_id']==0 & $data['subject_id']!=0 & $data['region_id'] != 0) {

         $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['region_id'].",region_id) and find_in_set(".$data['subject_id'].",subject_id) and find_in_set(".$data['cattype_id'].",type_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;
         
       } elseif ($data['cattype_id']!=0 & $data['grade_id']!=0 & $data['subject_id']!=0 & $data['region_id'] != 0) {

         $times = date('Y-m-d H:i:s');
           $recruitSearch = DB::select("select * from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >='".$times."' and find_in_set(".$data['region_id'].",region_id) and find_in_set(".$data['subject_id'].",subject_id) and find_in_set(".$data['cattype_id'].",type_id)  and find_in_set(".$data['grade_id'].",grade_id)");
           $admin = DB::table('admin')->get();
            foreach ($recruitSearch as $key => $value) {
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
          return $recruitSearch;
         
       } 
    }
}

