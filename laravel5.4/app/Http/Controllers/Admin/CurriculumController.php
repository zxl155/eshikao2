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
		$curriculum_name = Input::get('curriculum_name');
		$curriculum = new Curriculum;
		if ($curriculum_name != '') {
			$curriculum_content = DB::table('curriculum')->orwhere('curriculum_name','like','%'.$curriculum_name.'%')->get();
			$object = DB::select("select * from curriculum where curriculum_name like '%$curriculum_name%'");
		} else {
			$curriculum_content = $curriculum -> select();
			$object = DB::select('select * from curriculum');
		}
        $curriculum = json_decode(json_encode($object), true);
        $count = count($curriculum);
		return view('admin/curriculum/listcurr',[
			'curriculum_content' =>$curriculum_content,
			'count' => $count,
			'curriculum_name' => $curriculum_name,
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
		if(isset($data['curriculum_pricture'])){
			$head_pirctur=$request->file('curriculum_pricture');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'.$ext;//生成新的的文件名
		  	$bool=Storage::disk('curriculum_pricture')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
			$data['curriculum_pricture'] = $fileName;
		} else {
			
		}
            
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
    //添加课程包
    public function curriculumCourse()
    {
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
		return view('admin/curriculum/curriculumCourse',[
			'cattype_content'=>$cattype_content,
			'subjecttype_content'=>$subjecttype_content,
			'gradetype_content'=>$gradetype_content,
			'admin_teacher'=>$admin_teacher,
			'region_content'=>$region_content,
		]);
    }
    //执行添加课程包
    public function curriculumCourses(Request $request)
    {
    	$data = Input::all();
    	$head_pirctur=$request->file('curriculum_pricture');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'.$ext;//生成新的的文件名
		  $bool=Storage::disk('curriculum_pricture')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
		$data['curriculum_pricture'] = $fileName;
    	$curriculum = new Curriculum;
    	$arr = $curriculum->curriculumCourses($data);
    	if ($arr) {
    		return redirect('admin/listcurr');
    	} else {
    		echo "添加课程包失败";
    	}
    }
    //课程包列表
    public function courselist()
    {
    	$curriculum_id = Input::get('curriculum_id');
    	$curriculum = new Curriculum;
    	$data = $curriculum->courselist($curriculum_id);
        $count = count($data);
        $curriculum_name = DB::table('curriculum')->where(['curriculum_id'=>$curriculum_id])->select('curriculum_name','curriculum_id')->get();
    	return view('admin/curriculum/courselist',[
    		'curriculum_content'=>$data,
    		'count'=>$count,
    		'curriculum_name'=>$curriculum_name,
    	]);
    }
    //课程包对应添加课程
    public function courseadd()
    {
    	$curriculum_id = Input::get('curriculum_id');
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
		return view('admin/curriculum/courseadd',[
			'cattype_content'=>$cattype_content,
			'subjecttype_content'=>$subjecttype_content,
			'gradetype_content'=>$gradetype_content,
			'admin_teacher'=>$admin_teacher,
			'region_content'=>$region_content,
			'curriculum_id'=>$curriculum_id,
		]);
    }
    //执行课程包对应添加课程
    public function courseadds(Request $request)
    {
    	$data = Input::all();
    	$head_pirctur=$request->file('curriculum_pricture');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'.$ext;//生成新的的文件名
		  $bool=Storage::disk('curriculum_pricture')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
		$data['curriculum_pricture'] = $fileName;
		$curriculum = new Curriculum;
		$curriculums = $curriculum->courseadds($data);
		if ($curriculums == 'true') {
			return redirect("admin/courselist?curriculum_id=".$data['curriculum_id']);
		} else {
			echo "添加失败";
		}
    }
    //执行课程包对应添加课程
    public function coursedel()
    {
    	$curriculum_id = Input::get('curriculum_id');
    	$curriculum_ids = Input::get('curriculum_ids');
    	$curriculum = new Curriculum;
		$arr = $curriculum->deletes($curriculum_id);
		if ($arr) {
			return redirect("admin/courselist?curriculum_id=".$curriculum_ids);
		} else {
			echo "删除失败";
		}
    }
    //修改课程包对应的课程
    public function courseupd()
    {
    	$curriculum_id = Input::get('curriculum_id');
    	$curriculum_ids = Input::get('curriculum_ids');
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
		return view('admin/curriculum/courseupd',[
			'cattype_content'=>$cattype_content,
			'subjecttype_content'=>$subjecttype_content,
			'gradetype_content'=>$gradetype_content,
			'admin_teacher'=>$admin_teacher,
			'region_content'=>$region_content,
			'data'=>$data,
			'curriculum_ids'=>$curriculum_ids,
		]);
    }
    //执行修改课程包对应课程
    public function courseupds(Request $request)
    {
    	$data = Input::all();
		if(isset($data['curriculum_pricture'])){
			$head_pirctur=$request->file('curriculum_pricture');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'.$ext;//生成新的的文件名
		  	$bool=Storage::disk('curriculum_pricture')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
			$data['curriculum_pricture'] = $fileName;
		} else {
			
		}
		$curriculum = new Curriculum;
		$curriculums = $curriculum->upd($data);
		if ($curriculums == 'true') {
			return redirect("admin/courselist?curriculum_id=".$data['curriculum_ids']);
		} else {
			echo "修改失败";
		}
    }
}