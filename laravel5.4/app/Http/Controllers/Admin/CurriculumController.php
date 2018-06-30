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

class CurriculumController extends CommonController
{
	/**
     * @李一明
     * @DateTime  2018-06-09
     * 添加课程
     */
	public function addcurr(){
		//查询 面试或者笔试
		$cattype = new CatType;
		$cattype_content = $cattype->select();

		//查询学科
		$subjecttype = new SubjectType;
		$subjecttype_content = $subjecttype->select();

		//查询学段
		$gradetype =  new GradeType;
		$gradetype_content = $gradetype->select();

		//查询教师
		$admin = new Admin;
		$admin_teacher = $admin->searchTeacher();

		//查询地区
		$region = new Region;
		$region_content = $region->select();
		return view('admin/curriculum/addcurr',[
			'cattype_content'=>$cattype_content,
			'subjecttype_content'=>$subjecttype_content,
			'gradetype_content'=>$gradetype_content,
			'admin_teacher'=>$admin_teacher,
			'region_content'=>$region_content,
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-09
     * 执行添加
     */
	public function docurr(Request $request){
		$data = Input::all();
            $head_pirctur=$request->file('curriculum_pricture');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'.$ext;//生成新的的文件名
		  $bool=Storage::disk('curriculum_pricture')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
		$data['curriculum_pricture'] = $fileName;
		$curriculum = new Curriculum;
		$curriculums = $curriculum->insert($data);
		if ($curriculums == 'true') {
			return redirect('admin/listcurr');
		} else {
			echo "添加失败";
		}
	}

	/**
     * @李一明
     * @DateTime  2018-06-09
     * 课程列表
     */
	public function listcurr(){
		$curriculum = new Curriculum;
		$curriculum_content = $curriculum -> select();

		$object = DB::select('select * from curriculum');
        $curriculum = json_decode(json_encode($object), true);
        $count = count($curriculum);
		return view('admin/curriculum/listcurr',[
			'curriculum_content' =>$curriculum_content,
			'count' => $count,
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-14
     * 执行删除
     */
	public function delcurr(){
		$curriculum_id = Input::get('curriculum_id');
		$curriculum = new Curriculum;
		$arr = $curriculum->deletes($curriculum_id);
		if ($arr) {
			return redirect('admin/listcurr');
		} else {
			echo "删除失败";
		}
	}

	/**
     * @李一明
     * @DateTime  2018-06-14
     * 修改课程
     */
	public function updcurr(){
		$curriculum_id = Input::get('curriculum_id');
		$curriculum = new Curriculum;
		$data = $curriculum->oneSelect($curriculum_id);
		//查询 面试或者笔试
		$cattype = new CatType;
		$cattype_content = $cattype->select();

		//查询学科
		$subjecttype = new SubjectType;
		$subjecttype_content = $subjecttype->select();

		//查询学段
		$gradetype =  new GradeType;
		$gradetype_content = $gradetype->select();

		//查询教师
		$admin = new Admin;
		$admin_teacher = $admin->searchTeacher();

		//查询地区
		$region = new Region;
		$region_content = $region->select();
		return view('admin/curriculum/updcurr',[
			'cattype_content'=>$cattype_content,
			'subjecttype_content'=>$subjecttype_content,
			'gradetype_content'=>$gradetype_content,
			'admin_teacher'=>$admin_teacher,
			'region_content'=>$region_content,
			'data'=>$data,
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-15
     * 执行修改课程
     */
	public function doupd(Request $request){
		$data = Input::all();
            $head_pirctur=$request->file('curriculum_pricture');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'.$ext;//生成新的的文件名
		  $bool=Storage::disk('curriculum_pricture')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
		$data['curriculum_pricture'] = $fileName;
		$curriculum = new Curriculum;
		$curriculums = $curriculum->upd($data);
		if ($curriculums == 'true') {
			return redirect('admin/listcurr');
		} else {
			echo "修改失败";
		}
	}
	 //课程上架未上架
    public function shelf()
    {
        $data = Input::all();
        $curriculum = new Curriculum;
        $arr = $curriculum->shelf($data);
        if ($arr) {
        	$all['state'] = "修改成功";
        } else {
        	$all['state'] = "修改失败";
        }
        return json_encode($all);
    }
}