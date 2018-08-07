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
        $data['subject_id'] = implode($data['subject_id'],',');
        $data['grade_id'] = implode($data['grade_id'],',');
        $data['region_id'] = implode($data['region_id'], ',');
        $arr = DB::insert('insert into curriculum (curriculum_pricture,curriculum_name,purchase_number,original_price,recovery_original,present_price,purchase_state_time,purchase_end_time,teacher_type,type_id,subject_id,grade_id,admin_id,notice,qq_group_key,publish,region_id,curriculum_content,is_goods,qq_number) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$data['curriculum_pricture'],$data['curriculum_name'],$data['purchase_number'],$data['original_price'],$data['recovery_original'],$data['present_price'],$data['purchase_state_time'],$data['purchase_end_time'],$data['teacher_type'],$data['type_id'],$data['subject_id'],$data['grade_id'],$data['admin_id'],$data['notice'],$data['qq_group_key'],$data['publish'],$data['region_id'],$data['curriculum_content'],$data['is_goods'],$data['qq_number']]);
       if ($arr) {
           return true;
       } else {
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
      $data['subject_id'] = implode($data['subject_id'],',');
        $data['grade_id'] = implode($data['grade_id'],',');
        $data['region_id'] = implode($data['region_id'], ',');
      if(isset($data['curriculum_pricture'])){
        $arr = DB::table('curriculum')->where('curriculum_id','=',$data['curriculum_id'])->update(['curriculum_name'=>$data['curriculum_name'],'purchase_number'=>$data['purchase_number'],'original_price'=>$data['original_price'],'recovery_original'=>$data['recovery_original'],'present_price'=>$data['present_price'],'purchase_state_time'=>$data['purchase_state_time'],'purchase_end_time'=>$data['purchase_end_time'],'teacher_type'=>$data['teacher_type'],'type_id'=>$data['type_id'],'subject_id'=>$data['subject_id'],'grade_id'=>$data['grade_id'],'region_id'=>$data['region_id'],'admin_id'=>$data['admin_id'],'notice'=>$data['notice'],'qq_group_key'=>$data['qq_group_key'],'publish'=>$data['publish'],'curriculum_content'=>$data['curriculum_content'],'curriculum_pricture'=>$data['curriculum_pricture'],'is_goods'=>$data['is_goods'],'qq_number'=>$data['qq_number']]);
      } else {
        $arr = DB::table('curriculum')->where('curriculum_id','=',$data['curriculum_id'])->update(['curriculum_name'=>$data['curriculum_name'],'purchase_number'=>$data['purchase_number'],'original_price'=>$data['original_price'],'recovery_original'=>$data['recovery_original'],'present_price'=>$data['present_price'],'purchase_state_time'=>$data['purchase_state_time'],'purchase_end_time'=>$data['purchase_end_time'],'teacher_type'=>$data['teacher_type'],'type_id'=>$data['type_id'],'subject_id'=>$data['subject_id'],'grade_id'=>$data['grade_id'],'region_id'=>$data['region_id'],'admin_id'=>$data['admin_id'],'notice'=>$data['notice'],'qq_group_key'=>$data['qq_group_key'],'publish'=>$data['publish'],'curriculum_content'=>$data['curriculum_content'],'is_goods'=>$data['is_goods'],'qq_number'=>$data['qq_number']]);
      }
        if($arr){
            return true;
        }else{
            return false;
        }
    }
    
    //查询所有课程进修展示
    public function select()
    {
       $arr = DB::table('curriculum')->orderBy('curriculum_id', 'desc')->paginate(5);
        return $arr;
    }
    //删除课程
    public function deletes($curriculum_id)
    {
        $arr = DB::delete("delete from curriculum where curriculum_id = ?",[$curriculum_id]);
        return $arr;
    }
    //课程上架未上架
    public function shelf($data)
    {   $curriculum_id = $data['curriculum_id'];
        if ($data['state'] == 1) {
           $arr = DB::update("update curriculum set state = '0' where curriculum_id = $curriculum_id");
           return $arr;
        } else {
           $arr = DB::update("update curriculum set state = '1' where curriculum_id = $curriculum_id");
           return $arr;
        }
    }
    //查询单条数据通过课程id
    public function oneSelect($curriculum_id)
    {
      $arr = DB::select("select * from curriculum where curriculum_id = $curriculum_id");
      //学科
      $subject_id = $arr[0]->subject_id;
      $subject_id = explode(',',$subject_id);
      $arr[0]->subject_id = $subject_id;
      //学段
      $grade_id = $arr[0]->grade_id;
      $grade_id = explode(',',$grade_id);
      $arr[0]->grade_id = $grade_id;
      //地区
       $region_id = $arr[0]->region_id;
      $region_id = explode(',',$region_id);
      $arr[0]->region_id = $region_id;
      return $arr;
    }
    //查询输有数据
    public function selects()
    {
      $arr = DB::table('curriculum')->orderBy('curriculum_id','desc')->get()->toarray(); 
      return $arr;
    }
    //pc查询教师资格证
    public function qualificationsPc()
    {
      $times = date('Y-m-d H:i:s');
      $sql = "select curriculum_id,curriculum_name,order_by,home_page from curriculum where teacher_type = 1 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >= '".$times."' order by order_by asc";
      $qualifications = DB::select($sql);
      return $qualifications;
    }
    //修改排序
    public function qualificationsPcSearch($data)
    {
       $arr = DB::table('curriculum')->where('curriculum_id',$data['curriculum_id'])->update(['order_by'=>$data['order_by']]);
       return $arr;
    }
    //pc查询教师招聘
    public function recruitPC()
    {
      $times = date('Y-m-d H:i:s');
      $sql = "select curriculum_id,curriculum_name,order_by,home_page from curriculum where teacher_type = 2 and state = 1 and purchase_state_time <= '".$times."' and purchase_end_time >= '".$times."'  order by order_by asc";
      $qualifications = DB::select($sql);
      return $qualifications;
    }
    //修改是否为PC首页
    public function homePage($curriculum_id)
    {   
        $curriculum = DB::table('curriculum')->where('curriculum_id',$curriculum_id)->select('home_page')->get();
        if($curriculum[0]->home_page == ''){
          $arr = DB::table('curriculum')->where('curriculum_id',$curriculum_id)->update(['home_page'=>1]);
        } else {
          $arr = DB::table('curriculum')->where('curriculum_id',$curriculum_id)->update(['home_page'=>0]);
        }
        return $arr;
    }
}
