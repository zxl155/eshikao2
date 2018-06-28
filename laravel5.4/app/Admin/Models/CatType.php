<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class CatType extends Model
{
    protected $table = 'cat_type';  //表名
    public $timestamps = false;  //过滤默认的字段
    //查询所有数据
    public function select()
    {
    	$arr = DB::select("select * from cat_type");
    	return $arr;
    }
}
