<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Broadcast extends Model
{
	//查询轮播图开启的数据
   	public function index()
   	{
   		$arr = DB::table('broadcast')->orderBy('order_by','asc')->where(['state'=>1])->get();
   		return $arr;
   	}
}
