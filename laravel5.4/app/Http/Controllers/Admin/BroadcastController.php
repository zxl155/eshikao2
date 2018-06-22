<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Broadcast;

class BroadcastController extends Controller
{	

	/**
     * @李一明
     * @DateTime  2018-06-22
     * 轮播图添加
     */
	public function addbro(){
		return view('admin/broadcast/addbro');
	}

	/**
     * @李一明
     * @DateTime  2018-06-22
     * 执行添加
     */
	public function dobro(Request $request){
		$directory = 'public/uploads/'.date("Y-m-d");
		$res = Storage::makeDirectory($directory);
		$path = $request->file('broadcast_url')->store($directory);
		$path = str_replace('public','storage', $path);
		$bro = new Broadcast;
		$bro->broadcast_url = $path;
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
		$bro = new Broadcast;
		$data = $bro->get();
		return view('admin/broadcast/listbro',[
			'data' =>$data
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-22
     * 修改
     */
	public function updbro(){
		$bro = new Broadcast;
		$broadcast_id = Input::get('id');
		$data = $bro->where(['broadcast_id'=>$broadcast_id])->first();
		return view('admin/broadcast/updbro',[
			'data' =>$data
		]);
	}

	/**
     * @李一明
     * @DateTime  2018-06-22
     * 执行修改
     */
	public function updsbro(){
		$data = Input::all();
		$curr = new Broadcast;
		$data = $curr->upd($data);
		if($data){
			return redirect('admin/listbro');
		}
	}
}