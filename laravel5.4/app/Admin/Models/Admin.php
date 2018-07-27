<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    protected $table = 'admin';  //表名
    public $timestamps = false;  //过滤默认的字段

    //查询当前登录用户的信息
    public function oneSelect($admin_id)
    {
        $arr = DB::table('admin')->where('admin_id',$admin_id)->get()->toarray();
        return $arr;
    }
    /**
     * @李一明
     * @DateTime  2018-06-13
     * 教师添加
     */
    public function insert($data){
    	/*$arr = DB::insert('insert into admin (admin_name,password,nickname,realname,admin_head,admin_sex,admin_phone,identity,bank_name,bank_number,general_edition,admin_desc,register_time,modify_time) values (?, ?, ? ,? ,?,?,?,?,?,?,?,?,?,?)',
        [$data['admin_name'], md5($data['password']),$data['nickname'],$data['realname'],$data['admin_head'],$data['admin_sex'],$data['admin_phone'],$data['identity'],$data['bank_name'],$data['bank_number'],$data['general_edition'],$data['admin_desc'],date('Y-m-d H:i:s'),date('Y-m-d H:i:s')]);*/
        $admin_id=DB::table('admin')->insertGetId(['admin_name'=>$data['admin_name'],'password'=>md5($data['password']),'nickname'=>$data['nickname'],'realname'=>$data['realname'],'admin_head'=>$data['admin_head'],'admin_sex'=>$data['admin_sex'],'admin_phone'=>$data['admin_phone'],'identity'=>$data['identity'],'bank_name'=>$data['bank_name'],'bank_number'=>$data['bank_number'],'general_edition'=>$data['general_edition'],'admin_desc'=>$data['admin_desc'],'register_time'=>date('Y-m-d H:i:s'),'modify_time'=>date('Y-m-d H:i:s')]);
        $all = DB::insert('insert into admin_role (admin_id,role_id) values(?,?)',[$admin_id,$data['role_id']] );
        if($admin_id){
            if ($all) {
                return true;
            } else {
                return false;
            }
        	
        }else {
        	return false;
        }
    }
    /**
     * @李一明
     * @DateTime  2018-06-14
     * 查询教师名称
     */
    public function show($admin_id){
        $admin_id = implode($admin_id,',');
        $sql = "select * from admin where admin_id in($admin_id)"; 
        return $teacher = DB::select($sql);
    }

    /**
     * @李一明
     * @DateTime  2018-06-14
     * 获取admin表谁是教师
     */
    public function searchTeacher()
    {
        $role = DB::select("select * from role where role_name = '教师'");
        $role = DB::select('select * from admin_role where role_id = :phone', [':phone'=>$role[0]->role_id]);
        foreach ($role as $key => $value) {
            $arr[$key] = $value->admin_id;
        }
        $arr = implode($arr, ',');
        $sql = "select admin_id,nickname,admin_head from admin where admin_id in($arr)";
        $admin = DB::select($sql);
        return $admin;
    }
    //删除管理员
    public function del($admin_id)
    {
        $arr = DB::table('admin')->where('admin_id',$admin_id)->delete();
        return $arr;
    }
    //修改管理员 状态
    public function updates($admin_id,$start)
    {
        if ($start==1) {
            $arr = DB::table('admin')->where('admin_id','=',$admin_id)->update(['start'=>0]);
        } else {
            $arr = DB::table('admin')->where('admin_id','=',$admin_id)->update(['start'=>1]);
        }
        return $arr;
    }
    //admin修改管理员资料
    public function adminUpdate($admin_id)
    {
       $arr = DB::table('admin')->where('admin_id',$admin_id)->get()->toarray();
       return $arr;
    }
    //执行修改
    public function adminUpdates($data)
    {
        $arr = DB::table('admin')->where('admin_id','=',$data['admin_id'])->update(['admin_name'=>$data['admin_name'],'nickname'=>$data['nickname'],'realname'=>$data['realname'],'admin_sex'=>$data['admin_sex'],'admin_phone'=>$data['admin_phone'],'identity'=>$data['identity'],'bank_name'=>$data['bank_name'],'bank_number'=>$data['bank_number'],'general_edition'=>$data['general_edition'],'admin_desc'=>$data['admin_desc'],'admin_head'=>$data['admin_head']]);
        $all = DB::table('admin_role')->where('admin_id','=',$data['admin_id'])->update(['role_id'=>$data['role_id']]);
        if ($arr&$all) {

            return true;
        } else {
            return false;
        }
    }   
}
