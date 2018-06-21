<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AdminPplive extends Model
{
    protected $table = 'admin_pplive';  //表名
    public $timestamps = false;  //过滤默认的字段

    /**
     * @李一明
     * @DateTime  2018-06-15
     * 查询所属教师
     */
	public function teacher($data){
		foreach ($data as $key => $value) {
            $id[$key] = $value->pplive_id;
        }
        $pplive_id = implode($id ,',');
		$sql = "select * from admin_pplive where pplive_id in ($pplive_id)";
        $teacher = DB::select($sql);
        return $teacher;
	}
}
