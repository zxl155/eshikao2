<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class GradeType extends Model
{
    protected $table = 'grade_type';  //表名
    public $timestamps = false;  //过滤默认的字段
    public function select()
    {
    	$arr = DB::select("select * from grade_type");
    	return $arr;
    }
}
