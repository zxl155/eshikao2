<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Broadcast extends Model
{
	protected $table = 'broadcast';  //表名
    public $timestamps = false;  //过滤默认的字段
    public function select()
    {
    	$arr = DB::table('broadcast')->get()->toarray();
    	$curriculum = DB::table('curriculum')->get()->toarray();
    	foreach ($arr as $key => $value) {
    		foreach ($curriculum as $keys => $val) {
    			if ($value->curriculum_id == $val->curriculum_id) {
    				$value->curriculum_name = $val->curriculum_name;
    			}
    		}
    	}
    	return $arr;
    }
    public function deletes($broadcast_id)
    {
       $arr = DB::table('broadcast')->where('broadcast_id', '=', $broadcast_id)->delete();
       return $arr;
    }

}