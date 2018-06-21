<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Admin;
use App\Admin\Models\Role;
use App\Admin\Models\AdminRole;
use App\Admin\Models\CatType;
use App\Admin\Models\GradeType;
use App\Admin\Models\SubjectType;
use App\Admin\Models\Region;
use App\Admin\Models\Curriculum;
use App\Admin\Models\AdminCurriculum;
use DB;

class CurriculumController extends Controller
{
	/**
     * @李一明
     * @DateTime  2018-06-09
     * 添加课程
     */
	public function addcurr(){
		$admin = new Admin;
		$role = new Role;
		$adminrole = new AdminRole;
		$cat = new CatType;
		$grade = new GradeType;
		$subject = new SubjectType;
		$region = new Region;
		$role_id = $role->where(['role_name'=>'教师'])->value('role_id');
		$admin_id = $adminrole->where(['role_id'=>$role_id])->pluck('admin_id')->toArray();
		$teacher = $admin->show($admin_id);
		$cat = $cat->get();
		$grade = $grade->get();
		$subject = $subject->get();
		$region = $region->where(['parent_id'=>0])->get();
		return view('admin/curriculum/addcurr',[
			'teacher'=>$teacher,
			'cat'=>$cat,
			'grade'=>$grade,
			'subject'=>$subject,
			'region'=>$region
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-09
     * 执行添加
     */
	public function docurr(){
		$data = Input::all();
		$curr = new Curriculum;
		$curriculum_id = $curr->insert($data);
		foreach ($data['admin_id'] as $key => $value) {
			$sql = "insert into admin_curriculum(admin_id,curriculum_id) values('$value','$curriculum_id')";
			$res = DB::insert($sql);
		}
		if($res){
			return redirect('admin/listcurr');
		}
	}

	/**
     * @李一明
     * @DateTime  2018-06-09
     * 课程列表
     */
	public function listcurr(){
		$curriculum = new Curriculum;
		$user = new Admin;
		$search = Input::get('search',null);
		if(isset($search)){
			$data = DB::table('curriculum')->where([['curriculum_name','like','%'.$search.'%']])->paginate(3);
			$admin = $user->searchTeacher();//获取所有用户信息
			$teacher = $curriculum->teacher($data); //获取教师与课程的管理数据
			$admin = $curriculum->admin($admin,$teacher);
			$num = '';
		}else{
			$data = $curriculum->select()->paginate(3);
			$admin = $user->searchTeacher();//获取所有用户信息
			$teacher = $curriculum->teacher($data); //获取教师与课程的管理数据
			$admin = $curriculum->admin($admin,$teacher);
			$num = $curriculum->count();
		}
		return view('admin/curriculum/listcurr',[
			'data' =>$data,
			'admin' => $admin,
			'num' => $num,
			'search' => $search
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-14
     * 执行删除
     */
	public function delcurr(){
		$id = Input::get('id');
		$curr = new Curriculum;
		$admincurr = new AdminCurriculum;
		$aid = $admincurr->where(['curriculum_id'=>7])->pluck('id')->toArray();
		$aid = implode($aid,',');
		$res = $curr->where(['curriculum_id'=>$id])->delete();
		if($res){
			DB::delete("delete from admin_curriculum where id in($aid)");
			return redirect('admin/listcurr');
		}
	}

	/**
     * @李一明
     * @DateTime  2018-06-14
     * 修改课程
     */
	public function updcurr(){
		$id = Input::get('id');
		$curr = new Curriculum;
		$data = $curr->where(['curriculum_id'=>$id])->first();
		return view('admin/curriculum/updcurr',[
			'data'=>$data,
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-15
     * 执行修改课程
     */
	public function doupd(){
		$data = Input::all();
		$curr = new Curriculum;
		$data = $curr->upd($data);
		if($data){
			return redirect('admin/listcurr');
		}
	}
}