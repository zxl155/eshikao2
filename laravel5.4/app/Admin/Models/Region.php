<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Region extends Model
{
    protected $table = 'region';  //表名
    public $timestamps = false;  //过滤默认的字段
    public function select()
    {
    	$arr = DB::select("select * from region");
    	return $arr;
    }
}
