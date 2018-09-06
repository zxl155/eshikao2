<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Paylog extends Model
{
   public function payLog($LogType,$LogMark,$Key1,$Key2,$Key3,$Key4,$ResponseBody,$Status)
   {
      	$data = DB::table('pay_log')->insert(['RecDate'=>date('Y-m-d H:i:s'),'LogType'=>$LogType,'LogMark'=>$LogMark,'Key1'=>$Key1,'Key2'=>$Key2,'Key3'=>$Key3,'Key4'=>$Key4,'ResponseBody'=>$ResponseBody,'Status'=>$Status]);

      	return $data;
   }
}
