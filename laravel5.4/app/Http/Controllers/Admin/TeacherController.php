<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Curriculum;
use App\Admin\Models\Pplive;

class TeacherController extends CommonController
{	
	public function teacherLive()
	{
		$admin_id = session('data')['admin_id'];
		$pplive = new Pplive;
		$data = $pplive ->admin_pplive($admin_id);
		return view('admin/teacher/teacherLive',[
			'data'=>$data,
		]);
	}
	//助教入口
	public function Assistant()
	{
		$pplive_id = Input::get('pplive_id');
		$pplive = new Pplive;
		$arr = $pplive->Assistant($pplive_id);
	}
	//老师直播
	public function teacherLives()
	{
		$pplive_id = Input::get('pplive_id');
		$pplive = new Pplive;
		$arr = $pplive->teacherShow($pplive_id);
	}
	//直播回放
	public function playback()
	{
		$pplive_id = Input::get('pplive_id');
		$pplive = new Pplive;
		$pplive->playback($pplive_id);
	}
	//讲义展示
	public function handout()
	{
		$pplive_id = Input::get('pplive_id');
		$pplive = new Pplive;
		$data = $pplive->oneSelect($pplive_id);
		return view('admin/teacher/handout',['pplive_id'=>$pplive_id,'data'=>$data]);
	}
	//添加讲义
	public function handoutadd()
	{
		$pplive_id = Input::get('pplive_id');
		return view('admin/teacher/handoutadd',['pplive_id'=>$pplive_id]);
	}
	//执行添加
	public function handoutadds(Request $request)
	{
		$data = Input::all();
		$file = $request->file('jianyi');
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
   
            $bool = Storage::disk('jianyi')->put(iconv("UTF-8", "gbk",$originalName), file_get_contents($realPath));
        } else {
        	$originalName = '';
        }
        $data['jianyi'] = "$originalName";
		$pplive = new Pplive;
		$arr = $pplive->handoutadds($data);
		if($arr){
			return redirect('admin/handout?pplive_id='.$data['pplive_id']);
		} else {
			echo "添加讲义失败";
		}
	}
	//修改讲义
	public function handoutupd()
	{
		$pplive_id = Input::get('pplive_id');
		return view('admin/teacher/handoutadd',['pplive_id'=>$pplive_id]);
	}
}