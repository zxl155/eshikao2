<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Curriculum;
use App\Teacher;

class CurriculumController extends Controller
{
	/**
     * @李一明
     * @DateTime  2018-06-09
     * 添加课程
     */
	public function addcurr(){
		$tea = new Teacher;
		$data = $tea->get();
		return view('admin/curriculum/addcurr',[
			'data'=>$data
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
		$curr->curriculum_name = $data['curriculum_name'];
		$curr->curriculum_title = $data['curriculum_title'];
		$curr->curriculum_desc = $data['curriculum_desc'];
		$curr->curriculum_time = $data['curriculum_time'];
		$curr->tea_id = $data['tea_id'];
		$curr->curriculum_notice = $data['curriculum_notice'];
		$curr->curriculum_price = $data['curriculum_price'];
		$curr->curriculum_num = $data['curriculum_num'];
		$curr->curriculum_stock = $data['curriculum_stock'];
		$curr->add_time = date("Y-m-d H:i:s");
		$res = $curr->save();
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
		$curr = new Curriculum;
		$tea = new Teacher;
		$data = $curr->get();
		$arr = $tea->get();
		return view('admin/curriculum/listcurr',[
			'data' =>$data,
			'arr' =>$arr
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-09
     * 执行删除
     */
	public function delcurr(){
		$id = Input::get('id');
		$curr = new Curriculum;
		$res = $curr->where(['curriculum_id'=>$id])->delete();
		if($res){
			return 1;
		}else {
			return 2;
		}
	}
}