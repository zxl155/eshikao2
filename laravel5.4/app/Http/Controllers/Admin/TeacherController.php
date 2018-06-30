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
	
}