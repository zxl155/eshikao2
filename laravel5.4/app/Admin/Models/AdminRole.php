<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class AdminRole extends Model
{
    protected $table = 'admin_role';  //表名
    public $timestamps = false;  //过滤默认的字段
    public function select()
    {
    	$role = DB::select('select * from role');
		$admin_role = DB::select('select * from admin_role');
		foreach ($admin_role as $key => $value) {
			foreach ($role as $keys => $val) {
				if ($value->role_id==$val->role_id) {
					$value->role_name = $val->role_name;
				}
			}
		}
		return $admin_role;
    }
}
