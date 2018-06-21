<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

use App\Admin\Models\Region;
use App\Admin\Models\Recruitment;

class RecruitmentController extends Controller
{
	/**
     * @李一明
     * @DateTime  2018-06-19
     * 添加公告
     */
	public function addrecr(){
		$region = new Region;
		$region = $region->where(['parent_id'=>0])->get();
		return view('admin/recruitment/addrecr',[
			'region' =>$region
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-19
     * 执行添加
     */
	public function dorecr(){
		$data['recruitment_name'] = Input::get('recruitment_name');
		$data['region_id'] = Input::get('region_id');
		$data['content'] = $_POST['content'];
		$data['add_time'] = date('Y-m-d');
		$recr = new Recruitment;
		$res = $recr->insert($data);
		if($res){
			return redirect('admin/listrecr');
		}
	}

	/**
     * @李一明
     * @DateTime  2018-06-19
     * 公告列表
     */
	public function listrecr(){
		$recr = new Recruitment;
		$region = new Region;
		$data = $recr->select()->paginate(3);
		foreach ($data as $key => $val) {
			$val['content'] = substr_replace($val['content'],'......', 30);
		}
		$region = $region->where(['parent_id'=>0])->get();
		return view('admin/recruitment/listrecr',[
			'data' =>$data,
			'region' =>$region
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-19
     * 公告修改
     */
	public function updrecr(){
		$recr = new Recruitment;
		$region = new Region;
		$id = Input::get('id');
		$data = $recr->where(['recruitment_id'=>$id])->first();
		return view('admin/recruitment/updrecr',[
			'data' =>$data
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-19
     * 执行修改
     */
	public function updsrecr(){
		$data['recruitment_name'] = Input::get('recruitment_name');
		$data['recruitment_id'] = Input::get('recruitment_id');
		$data['content'] = $_POST['content'];
		$recr = new Recruitment;
		$data = $recr->upd($data);
		if($data){
			return redirect('admin/listrecr');
		}
	}

	/**
     * @李一明
     * @DateTime  2018-06-19
     * 执行删除
     */
	public function delrecr(){
		$id = Input::get('id');
		$recr = new Recruitment;
		$res = $recr->where(['recruitment_id'=>$id])->delete();
		if($res){
			return redirect('admin/listrecr');
		}
	}
}