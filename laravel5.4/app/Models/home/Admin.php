<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Admin extends Model
{
    protected $table = 'admin';  //表名
    public $timestamps = false;  //过滤默认的字段

    /**
     * @李一明
     * @DateTime  2018-06-13
     * 教师添加
     */
    public function insert($data){
    	$arr = DB::insert('insert into admin (admin_name,password,nickname,admin_head,admin_sex,admin_phone, admin_desc,register_time) values (?, ?, ? ,? ,?,?,?,?)',
        [$data['admin_name'], md5($data['password']),$data['nickname'],$data['admin_head'],$data['admin_sex'],$data['admin_phone'],$data['admin_desc'],$data['register_time']]);
        if($arr){
        	return true;
        }else {
        	return false;
        }
    }

    /**
     * @张小龙
     * @DateTime  2018-06-14
     * 查询教师id
     */
    public function searchTeachers(){
        $role = DB::select("select * from role where role_name = '教师'");
        $role = DB::select('select * from admin_role where role_id = :phone', [':phone'=>$role[0]->role_id]);
        foreach ($role as $key => $value) {
            $arr[$key] = $value->admin_id;
        }
        $arr = implode($arr, ',');
        $sql = "select admin_id,admin_name,admin_head from admin where admin_id in($arr)";
        $admin = DB::select($sql);
        return $admin;
    }

}
