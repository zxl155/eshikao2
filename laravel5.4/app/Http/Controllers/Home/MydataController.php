<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\User;

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
            $head_pirctur=$request->file('head_pirctur');
            $name=$head_pirctur->getClientOriginalName();
            $ext=$head_pirctur->getClientOriginalExtension();//得到图片后缀；
            $fileName=md5(uniqid($name));
            $fileName=$fileName.'.'."png";//生成新的的文件名
		  $bool=Storage::disk('article')->put($fileName,file_get_contents($head_pirctur->getRealPath()));//
		  var_dump($bool);
		$user = new User;
		$data = $user -> images($fileName);
		if ($data==true) {
			session(['head'=>$fileName]);
		 	return redirect('/home/mydata.html');
		 } else {
		 	return redirect('/home/mydata.html');
		 }
	} 
	//移动修改密码
	public function movepassword()
	{
		return view('home/personal/musercode');
	}
	
}