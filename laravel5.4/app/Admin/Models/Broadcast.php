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
    	$arr = DB::table('broadcast')->orderBy('order_by','asc')->get()->toarray();
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
    public function orderbro($data)
    {
        $arr = DB::table('broadcast')->where(['broadcast_id'=>$data['broadcast_id']])->update(['order_by'=>$data['order_by']]);
        return $arr;
    }
}