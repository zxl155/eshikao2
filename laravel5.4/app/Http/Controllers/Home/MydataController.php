<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Models\User;

class MydataController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-12
     * 前台个人中心修改资料
     */
	public function index(){
		$user_id = session('user_id');
		$user = new User;
		$data = $user -> oneuser($user_id);
		return view('home/personal/userdata',['data' => $data]);
	}
	/**
     * @
     * @DateTime  2018-06-12
     * 前台个人中心修改个人资料
     */
	public function updatemydata(){
		$data['user_name'] = Input::get('user_name');
		$data['user_id'] = Input::get('user_id');
		$user = new User;
		$data = $user -> updatemydata($data);
		if ( $data == true ) {
			echo "修改成功";
		} else {
			echo "修改失败";
		}
	}
	/**
	 * 修改个人密码
	 */
	public function updatepwd(){
		return view('home/personal/usercode');
	}
	/**
	 * 修改个人密码进行修改
	 */
	public function updatepwds(){
		$data = Input::all();
		$user = new User;
		$data = $user -> updatepwds($data);
		if ($data == true) {
			echo "修改成功";
		} else {
			echo "修改失败";
		}
	}
	/**
	 * 上传图片
	 */
     public function  insetArticle(Request $request){
     	
        $directory = 'public/storage'.date("Y-m-d");
		$res = Storage::makeDirectory($directory);
		$path = $request->file('head_pirctur')->store($directory);
		$user = new User;
		$data = $user -> images($path);
		if ($data==true) {
			return redirect('/home/mydata');
		} else {
			return redirect('/home/mydata');
		}
	} 
		
	
}