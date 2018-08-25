<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

use App\Admin\Models\Curriculum;
use App\Admin\Models\Pplive;
use App\Admin\Models\Admin;
use App\Admin\Models\AdminCurriculum;
use App\Admin\Models\AdminPplive;
use DB;

class PpliveController extends CommonController
{
	/**
     * @李一明
     * @DateTime  2018-06-15
     * 直播课程
     */
	public function listpplive(){
		$curriculum_id = Input::get('curriculum_id');
		$pplive = new Pplive;
		$data = $pplive -> select($curriculum_id);
		return view('admin/pplive/listpplive',[
			'curriculum_id'=>$curriculum_id,
			'data'=>$data,
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-15
     * 添加直播课程
     */
	public function addpplive(){
		$curriculum_id = Input::get('curriculum_id');
		//查询教师
		$admin = new Admin;
		$admin_teacher = $admin->searchTeacher();
		return view('admin/pplive/addpplive',[
			'admin_teacher'=>$admin_teacher,
			'curriculum_id'=>$curriculum_id,
		]);
	}
	/**
     * @李一明
     * @DateTime  2018-06-15
     * 执行添加直播课程
     */
	public function dopplive(Request $request){
		$data = Input::all();
		$curriculum_id = $data['curriculum_id'];
		$pplive = new Pplive;
		$res = $pplive->insert($data);
		if($res){
			return redirect("admin/listpplive?curriculum_id=$curriculum_id");
		} else {
			echo "添加失败";
		}
	}

	/**
     * @李一明
     * @DateTime  2018-06-15
     * 所属教师
     */
	public function selects(){
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
		$pplive_id = Input::get('pplive_id');
		$curriculum_id = Input::get('curriculum_id');
		$pplive = new Pplive;
		$res = $pplive->deletes($pplive_id,$curriculum_id);
		if($res){
			return redirect('admin/listpplive?curriculum_id='.$curriculum_id);
		} else {
			echo "删除直播课程失败";
		}
	}
	//修改直播课程
	public function updpplive()
	{
		$pplive_id = Input::get('pplive_id');
		$curriculum_id = Input::get('curriculum_id');
		$pplive = new Pplive;
		$data = $pplive->oneSelect($pplive_id);
		$admin = new Admin;
		$admin_teacher = $admin->searchTeacher();
		return view('admin/pplive/updpplive',[
			'data'=>$data,
			'admin_teacher'=>$admin_teacher,
			'curriculum_id'=>$curriculum_id,
		]);
	}
	//执行修改直播课程
	public function updspplive()
	{
		$data = Input::all();
		$curriculum_id = $data['curriculum_id'];
		$pplive = new Pplive;
		$res = $pplive->updspplive($data);
		if ($res) {
			return redirect('admin/listpplive?curriculum_id='.$curriculum_id);
		} else {
			echo "修改直播课程失败";
		}
	}
	//复制直播间
	public function copyPplive()
	{
		$curriculum_id = Input::get('curriculum_id');
		$curriculum = new Curriculum;
		$curriculum = $curriculum->selects();
		return view('admin/pplive/copyPplive',['curriculum_id'=>$curriculum_id,'curriculum'=>$curriculum]);
	}
	//查询课程对应直播间
	public function copySearch()
	{
		$curriculum_id = Input::get('curriculum_id'); //查询课程id
		$curriculum_ids = Input::get('curriculum_ids'); //当前复制课程id
		$curriculum = new Pplive;
		$data = $curriculum->copySearch($curriculum_id,$curriculum_ids);
		if (empty($data)) {
			$arr = "无直播";
		} else {
			$arr = $data;
		}
		return json_encode($arr);
	}
	//复制直播间入库
	public function copyPplives()
	{
		$data = Input::all();
		$curriculum_id = $data['curriculum_ids'];
		$pplive = new Pplive;
		$arr = $pplive->copyPplives($data);
		if ($arr) {
			return redirect("admin/listpplive?curriculum_id=$curriculum_id");
		} else {
			echo "添加失败";
		}
	}
}