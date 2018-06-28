<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class SubjectType extends Model
{
    protected $table = 'subject_type';  //表名
    public $timestamps = false;  //过滤默认的字段
    public function select()
    {
    	$arr = DB::select("select * from subject_type");
    	return $arr;
    }
}
