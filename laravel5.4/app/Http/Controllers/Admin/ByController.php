<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Curriculum;
class ByController extends Controller
{
	//展示PC资格证PC
    public function qualificationsPc()
    {
        $curriculum = new Curriculum;
        $curriculum = $curriculum->qualificationsPc();
        return view('admin/by/qualificationsPc',['curriculum'=>$curriculum]);
    }
    //修改跳转到资格证展示
    public function qualificationsPcSearch()
    {
    	$data = Input::all();
    	$curriculum = new Curriculum;
    	$arr = $curriculum->qualificationsPcSearch($data);
    	if ($arr) {
    		return redirect('admin/qualificationsPc');
    	} else {
    		echo "修改教师资格证排序失败";
    	}
    }
    //展示PC教师招聘
    public function recruitPC()
    {
    	$curriculum = new Curriculum;
        $curriculum = $curriculum->recruitPC();
        return view('admin/by/recruit',['curriculum'=>$curriculum]);
    }
    //修改跳转到教师招聘
    public function recruitPCSearch()
    {
    	$data = Input::all();
    	$curriculum = new Curriculum;
    	$arr = $curriculum->qualificationsPcSearch($data);
    	if ($arr) {
    		return redirect('admin/recruitPC');
    	} else {
    		echo "修改教师资格证排序失败";
    	}
    }
}