<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Broadcast extends Model
{
	protected $table = 'broadcast';  //表名
    public $timestamps = false;  //过滤默认的字段

    /**
     * @李一明
     * @DateTime  2018-06-22
     * 状态修改
     */
    public function upd($data){
        $arr = DB::table('broadcast')->where('broadcast_id','=',$data['broadcast_id'])->update(['state'=>$data['state']]);
        if($arr){
            return true;
        }else{
            return false;
        }
    }
}