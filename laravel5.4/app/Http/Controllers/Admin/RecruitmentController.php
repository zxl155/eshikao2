<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Region;
use App\Admin\Models\Recruitment;

class RecruitmentController extends CommonController
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
	public function dorecr(Request $request){
		$data = Input::all();
		if($request->isMethod('POST')){
            $file = $request->file('recruitment_file');
            //判断文件是否上传成功
           if ($file) {
                //获取原文件名
                $originalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //文件类型
                $type = $file->getClientMimeType();
                //临时绝对路径
                $realPath = $file->getRealPath();
       
                $bool = Storage::disk('recruitment')->put(iconv("UTF-8", "gbk",$originalName), file_get_contents($realPath));
            } else {
            	$originalName = '';
            }
			$data['recruitment_name'] = Input::get('recruitment_name');
			$data['region_id'] = Input::get('region_id');
			$data['content'] = $_POST['content'];
			$data['add_time'] = Input::get('add_time');
			$data['recruitment_file'] = "$originalName";
			//$data['recruitment_files'] = "$filename";
			$recr = new Recruitment;
			$res = $recr->insert($data);
			if($res){
				return redirect('admin/listrecr');
			} else {
				 echo "添加失败";
			}
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
		$data = $recr->select()->orderBy('add_time','desc')->paginate(10);
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
		$recruitment_id = Input::get('id');
		$region = new Region;
		$region = $region->where(['parent_id'=>0])->get();
		$recruitment = new Recruitment;
		$recruitment_content = $recruitment->selects($recruitment_id);
		return view('admin/recruitment/updrecr',[
			'region' =>$region,
			'recruitment_content'=>$recruitment_content,
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-19
     * 执行修改
     */
	public function updsrecr(Request $request){
		if($request->isMethod('POST')){
//            var_dump($_FILES);
            $file = $request->file('recruitment_file');
 			if ($file) {
            //判断文件是否上传成功
                //获取原文件名
                $originalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //文件类型
                $type = $file->getClientMimeType();
                //临时绝对路径
                $realPath = $file->getRealPath();
                $bool = Storage::disk('recruitment')->put(iconv("UTF-8", "gbk",$originalName), file_get_contents($realPath));
             }else {
             	$originalName = '';
             }
			$data['recruitment_name'] = Input::get('recruitment_name');
			$data['recruitment_id'] = Input::get('recruitment_id');
			$data['content'] = $_POST['content'];
			$data['region_id'] = Input::get('region_id');
			$data['add_time'] = Input::get('add_time');
			$data['recruitment_file'] = $originalName;
			$recr = new Recruitment;
			$data = $recr->upd($data);
			if($data){
				return redirect('admin/listrecr');
			} else {
				echo "修改失败";
			}
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