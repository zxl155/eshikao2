<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Sales;
use App\Admin\Models\Course;
class SalesController extends CommonController
{	
	//展示
	public function sales()
	{
		$sales = new Sales;
		$data = $sales->sales();
		return view('admin/sales/sales',['data'=>$data]);
	}
	//添加
	public function addSales()
	{
		$course = new Course;
		$course = $course->package();
		return view('admin/sales/addSales',['course'=>$course]);
	}
	//执行添加
	public function addSaless()
	{
		$data = Input::all();
		$sales = new Sales;
		$arr = $sales->addSaless($data);
		if ($arr) {
			return redirect('admin/sales');
		} else {
			echo "添加失败";
		}
	}
	//删除
	public function delSales()
	{
		$sales_id = Input::get('sales_id');
		$sales = new Sales;
		$arr = $sales->delSales($sales_id);
		if ($arr) {
			return redirect('admin/sales');
		} else {
			echo "删除失败";
		}
	}
	//修改
	public function updSales()
	{
		$course = new Course;
		$course = $course->package();
		$sales_id = Input::get('sales_id');
		$sales = new Sales;
		$data = $sales->updSales($sales_id);
		return view('admin/sales/updSales',['data'=>$data,'course'=>$course]);
	}
	//执行修改
	public function updSaless()
	{
		$data = Input::all();
		$sales = new Sales;
		$arr = $sales->updSaless($data);
		if ($arr) {
			return redirect('admin/sales');
		} else {
			echo "修改失败";
		}
	}
}