<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pplive extends Model
{
   public function show($curriculum_id)
   {
   		$pplive = DB::select("select * from pplive where curriculum_id = $curriculum_id");
   		$admin_pplive = DB::select("select * from admin_pplive");
   		foreach ($pplive as $key => $value) {
   			foreach ($admin_pplive as $keys => $values) {
   				if ($value->pplive_id == $values->pplive_id) {
   					$value->admin_id = $values->admin_id;
   				}
   			}
   		}
   		$admin = DB::select("select * from admin");
   		foreach ($pplive as $key => $value) {
   			foreach ($admin as $keys => $values) {
   				if ($value->admin_id == $values->admin_id) {
   					$value->admin_name = $values->admin_name;
   				}
   			}
   		}
   		return $pplive;
   }
    
}
