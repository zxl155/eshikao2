<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Models\Curriculum;
use App\Models\Pplive;
use App\Models\Admin;
use App\Models\AdminCurriculum;
use App\Models\AdminPplive;
use DB;

class PpliveController extends Controller
{
	/**
     * @李一明
     * @DateTime  2018-06-15
     * 直播课程
     */
	public function listpplive(){
		$pplive = new Pplive;
		$curr = new Curriculum;
		$user = new Admin;
		$ap = new AdminPplive;
		$data = $pplive->select()->paginate(3);
		$teacher = $ap->teacher($data);
		$admin = $user->searchTeacher();
		$admin = $curr->admin($admin,$teacher);
		$data = $pplive->show($data);
		return view('admin/pplive/listpplive',[
			'data'=>$data,
			'admin'=>$admin
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-15
     * 添加直播课程
     */
	public function addpplive(){
		$curr = new Curriculum;
		$data = $curr->get();
		$teacher = $curr->teacher($data);
		$user = new Admin;
		$admin = $user->searchTeacher();
		$admin = $curr->admin($admin,$teacher);
		// dd($admin);die;
		return view('admin/pplive/addpplive',[
			'data'=>$data,
		]);
	}
	/**
     * @李一明
     * @DateTime  2018-06-15
     * 执行添加直播课程
     */
	public function dopplive(){
		$data = Input::all();
		$pplive = new Pplive;
		$str = $pplive->get_week($data['start_time']);
		$data['stop_time'] = date('H:i',strtotime($data['stop_time']));
		$data['start_time'] = date('Y年m月d日',strtotime($data['start_time'])).'('.$str.')'.' '.date('H:i',strtotime($data['start_time'])).'-'.$data['stop_time'];
		$pplive_id = $pplive->insert($data);
		$admin_id = $data['admin_id'];
		$sql = "insert into admin_pplive(admin_id,pplive_id) values('$admin_id','$pplive_id')";
		$res = DB::insert($sql);
		if($res){
			return redirect('admin/listpplive');
		}
	}

	/**
     * @李一明
     * @DateTime  2018-06-15
     * 所属教师
     */
	public function select(){
		$id = Input::get('id');
		$user = new Admin;
		$ac = new AdminCurriculum;
		$admin_id = $ac->where(['curriculum_id'=>$id])->pluck('admin_id')->toArray();
		$admin = $user->show($admin_id);
		return json_encode($admin);
	}

	/**
     * @李一明
     * @DateTime  2018-06-15
     * 删除直播
     */
	public function delpplive(){
		$id = Input::get('id');
		$pplive = new Pplive;
		$ap = new AdminPplive;
		$aid = $ap->where(['pplive_id'=>$id])->value('id');
		$res = $pplive->where(['pplive_id'=>$id])->delete();
		if($res){
			DB::delete("delete from admin_pplive where id = $aid");
			return redirect('admin/listpplive');
		}
	}
}