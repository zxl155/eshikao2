<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Admin\Models\Admin;
use App\Admin\Models\AdminRole;
use App\Admin\Models\Role;


class IndexController extends Controller
{
	/**
     * @李一明
     * @DateTime  2018-06-12
     * 后台首页
     */
	public function index(Request $request){
        
		return view('admin/index/index');
	}

	/**
     * @李一明
     * @DateTime  2018-06-12
     * 个人中心
     */
	public function personal(){
		$admin = new Admin;
		$adminrole = new AdminRole;
		$role = new Role;
		$data = $admin->where(['admin_id'=>session('data')['admin_id']])->first();
		$role_id = $adminrole->where(['admin_id'=>$data['admin_id']])->value('role_id');
		$data['role_name'] = $role->where(['role_id'=>$role_id])->value('role_name');
		return view('admin/index/personal',[
			'data' => $data
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-12
     * 修改资料
     */
	public function upd(){
		$admin = new Admin;
		$admin_id = Input::get('id');
		$data = $admin->where(['admin_id'=>$admin_id])->first();
		return view('admin/index/upds',[
			'data' => $data
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-12
     * 执行修改资料
     */
	public function upds(Request $request){
		$directory = 'public/uploads/'.date("Y-m-d");
		$res = Storage::makeDirectory($directory);
		$path = $request->file('admin_head')->store($directory);
		$path = str_replace('public','storage', $path);
		$data = Input::get();
		$arr = DB::table('admin')->where('admin_id','=',$data['admin_id'])->update(['nickname'=>$data['nickname'],'admin_head'=>$path,'admin_phone'=>$data['admin_phone'],'modify_time'=>date('Y-m-d H:i:s')]);
		if($arr){
			return redirect('admin/personal');
		}
		
	}

	/**
     * @李一明
     * @DateTime  2018-06-12
     * 修改密码
     */
	public function pwd(){
		$admin = new Admin;
		$admin_id = Input::get('id');
		return view('admin/index/pwds',[
			'id' => $admin_id
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-12
     * 执行修改密码
     */
	public function pwds(){
		$admin_pwd = Input::get('admin_pwd');
		$admin_id = Input::get('id');
		$pwd = Input::get('pwd');
		$qpwd = Input::get('qpwd');
		$admin = new Admin;
		$data = $admin->where(['password' =>md5($admin_pwd)])->first();

		if(!$data){
			return 1;
		} else if($pwd != $qpwd) {
			return 2;
		} else{
			DB::table('admin')->where('admin_id','=',$admin_id)->update(['password'=>md5($pwd),'modify_time'=>date('Y-m-d H:i:s')]);
		}
	}
}