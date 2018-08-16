<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Broadcast;
use App\Admin\Models\Curriculum;

class BroadcastController extends CommonController
{	

	/**
     * @李一明
     * @DateTime  2018-06-22
     * 轮播图添加
     */
	public function addbro(){
		$admin = new Curriculum;
		$data = $admin->selects();
		return view('admin/broadcast/addbro',[
			'data'=>$data,
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-22
     * 执行添加
     */
	public function dobro(Request $request){
		 $data = Input::all();
		 $directory = 'public/storage'.date("Y-m-d");
            $head_pirctur=$request->file('broadcast_url');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'.$ext;//生成新的的文件名
		  $bool=Storage::disk('sowing_msp')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
		$bro = new Broadcast;
		$bro->broadcast_url = $fileName;
		$bro->curriculum_id = $data['curriculum_id'];
		$res = $bro->save();
		if($res){
			return redirect('admin/listbro');
		}
	}

	/**
     * @李一明
     * @DateTime  2018-06-22
     * 列表
     */
	public function listbro(){
		$broadcast = new Broadcast;
		$data = $broadcast->select();
		return view('admin/broadcast/listbro',[
			'data' =>$data
		]);
	}

	//删除
	public function delbro()
	{
		$broadcast_id = Input::get('broadcast_id');
		$broadcast = new Broadcast;
		$arr = $broadcast -> deletes($broadcast_id);
		if ($arr) {
			return redirect('admin/listbro');
		} else {
			echo "删除轮播图失败";
		}
	}
	//排序
	public function orderbro()
	{
		$data = Input::all();
		$broadcast = new Broadcast;
		$arr = $broadcast->orderbro($data);
		if ($arr) {
			return redirect('admin/listbro');
		} else {
			echo "修改轮播图排序失败";
		}
	}
}