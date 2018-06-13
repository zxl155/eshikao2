<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Models\Admin;

class AdminController extends Controller
{
	/**
     * @李一明
     * @DateTime  2018-06-13
     * 管理员添加
     */
	public function addadmin(){
		return view('admin/admin/addadmin');
	}

	/**
     * @李一明
     * @DateTime  2018-06-13
     * 执行添加
     */
	public function doadmin(Request $request){
		$directory = 'public/uploads/'.date("Y-m-d");
		$res = Storage::makeDirectory($directory);
		$path = $request->file('admin_head')->store($directory);
		$path = str_replace('public','storage', $path);
		$data = Input::get();
		$data['admin_head'] = $path;
		$data['register_time'] = date("Y-m-d H:i:s");
		$admin = new Admin;
		$res = $admin->insert($data);
		if($res){
			return redirect('admin/listadmin');
		}
	}
	/**
     * @李一明
     * @DateTime  2018-06-13
     * 教师列表
     */
	public function listadmin(){
		$admin = new Admin;
		$data = $admin->get();
		foreach ($data as $key => $val) {
			$val['admin_desc'] = substr_replace($val['admin_desc'],'....', 40);
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
		$id = Input::get('id');
		$admin = new Admin;
		if($id == 1){
			return 3;
		}else{
			$res = $admin->where(['admin_id'=>$id])->delete();
			if($res){
				return 1;
			}else {
				return 2;
			}
		}
		
	}
}