<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Admin;
use App\Admin\Models\AdminRole;
use App\Admin\Models\AdminCurriculum;
use App\Admin\Models\AdminPplive;
use App\Admin\Models\Role;
use DB;

class AdminController extends CommonController
{
	/**
     * @李一明
     * @DateTime  2018-06-13
     * 管理员添加
     */
	public function addadmin(){
		//查询角色
		$role = new Role;
		$role_content = $role->select();
		return view('admin/admin/addadmin',[
			'role_content'=>$role_content,
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-13
     * 执行添加
     */
	public function doadmin(Request $request){
		$data = Input::all();
		$head_pirctur=$request->file('admin_head');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'.$ext;//生成新的的文件名
		  $bool=Storage::disk('articles')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
		$data['admin_head'] = $fileName;
		$admin = new Admin;
		$arr = $admin->insert($data);

		if ($arr) {
			return redirect('admin/listadmin');
		} else {
			echo "添加管理员失败";
		}
	}
	/**
     * @李一明
     * @DateTime  2018-06-13
     * 教师列表
     */
	public function listadmin(){
		$admin = new Admin;
		$data = $admin->select()->orderBy('admin_id', 'desc')->paginate(5);
		foreach ($data as $key => $val) {
			$val['admin_desc'] = substr_replace($val['admin_desc'],'....', 30);
		}
		$adminrole = new AdminRole;
		$role = $adminrole->select();
		foreach ($data as $key => $value) {
			foreach ($role as $k => $val) {
				if ($value->admin_id==$val->admin_id) {
					$value->role_name = $val->role_name;
				}
			}
		}
		
		return view('admin/admin/listadmin',[
			'data' => $data
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-13
     * 删除
     */
	public function del(){
		$admin_id = Input::get('admin_id');
		$admin = new Admin;
		$res = $admin->del($admin_id);
		if ($res) {
			return redirect('admin/listadmin');
		} else {
			echo "删除失败";
		}
	}
	//修改admin状态
	public function updates()
	{
		$admin_id = Input::get('admin_id');
		$start = Input::get('start');
		$admin = new Admin;
		$res = $admin -> updates($admin_id,$start);
		if($res) {
			return redirect('admin/listadmin');
		} else {
			echo "修改管理员状态失败";
		}
	}

	//管理员修改用户资料
	public function adminUpdate()
	{
		$admin_id = Input::get('admin_id');
		$admin = new Admin;

		$data = $admin->adminUpdate($admin_id);
		$adminrole = new AdminRole;
		$role = $adminrole->select();
		foreach ($data as $key => $value) {
			foreach ($role as $k => $val) {
				if ($value->admin_id==$val->admin_id) {
					$value->role_name = $val->role_name;
				}
			}
		}
		//查询角色
		$role = new Role;
		$role_content = $role->select();
		return view('admin/admin/adminUpdate',[
			'data'=>$data,
			'role_content'=>$role_content,
		]);
	}
	//执行修改管理员资料
	public function adminUpdates(Request $request)
	{
		$data = Input::all();
		$head_pirctur=$request->file('admin_head');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'.$ext;//生成新的的文件名
		  $bool=Storage::disk('articles')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
		$data['admin_head'] = $fileName;
		$admin = new Admin;
		$arr = $admin->adminUpdates($data);
		if ($arr) {
			return redirect('admin/listadmin');
		} else {
			echo "修改失败";
		}
	}
}