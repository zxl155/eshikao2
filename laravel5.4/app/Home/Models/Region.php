<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Region extends Model
{
   public function show()
   {
      $arr = DB::select('select * from region');
      return $arr;
   }
    
}
