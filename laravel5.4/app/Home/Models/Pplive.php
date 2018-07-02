<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pplive extends Model
{
   public function shows($curriculum_id)
   {
   		$pplive_content = DB::table('pplive')->where('curriculum_id',$curriculum_id)->orderBy('start_time', 'asc')->get();
         $admin_content = DB::table('admin')->get();
         foreach ($pplive_content as $key => $value) {
            foreach ($admin_content as $k => $val) {
                  if ($value->admin_id == $val->admin_id) {
                        $value->admin_name = $val->admin_name;
                        $value->admin_head = $val->admin_head;
                        $value->admin_desc = $val->admin_desc;

                  }
            }
         }
        return $pplive_content;
   }
    
}
