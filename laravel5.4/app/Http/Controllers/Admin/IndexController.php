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
		$admin_id = session('data')['admin_id'];
		$admin = new Admin;
		$admin_content = $admin->oneSelect($admin_id);
		$adminrole = new AdminRole;
		$role = $adminrole->select();
		foreach ($admin_content as $key => $value) {
			foreach ($role as $k => $val) {
				if ($value->admin_id==$val->admin_id) {
					$value->role_name = $val->role_name;
				}
			}
		}
		return view('admin/index/personal',[
			'admin_content' => $admin_content,
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-12
     * 修改资料
     */
	public function upd(){
		$admin = new Admin;
		$admin_id = Input::get('admin_id');
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
		 $data = Input::all();
            $head_pirctur=$request->file('admin_head');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'.$ext;//生成新的的文件名
		  $bool=Storage::disk('articles')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
		$data['admin_head'] = $fileName;
		$arr = DB::table('admin')->where('admin_id','=',$data['admin_id'])->update(['nickname'=>$data['nickname'],'admin_head'=>$data['admin_head'],'admin_sex'=>$data['admin_sex'],'admin_desc'=>$data['admin_desc'],'admin_phone'=>$data['admin_phone'],'modify_time'=>date('Y-m-d H:i:s')]);
		if($arr){ 
			session(['data'=>$data]);
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
		$admin_id = Input::get('admin_id');
		return view('admin/index/pwds',[
			'admin_id' => $admin_id
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-12
     * 执行修改密码
     */
	public function pwds(){
		$data = Input::all();
		$password = md5($data['original_pwd']);
		$admin = new Admin;
		$admin_id = $data['admin_id'];
		$dat = DB::select("select * from admin where admin_id='$admin_id' and password = '$password'");
		if(empty($dat)){
			return 1;
		} else if($data['new_pwd'] != $data['confirm_pwd']) {
			return 2;
		} else{
			$arr = DB::table('admin')->where('admin_id','=',$data['admin_id'])->update(['password'=>md5($data['new_pwd']),'modify_time'=>date('Y-m-d H:i:s')]);
			if ($arr) {
				return 3;
			} else {
				return 4;
			}
		}
	}
}