<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Recruitment extends Model
{
   public function index()
   {
      $arr = DB::table('recruitment')->orderBy('add_time','desc')->select(['recruitment_id','recruitment_name','add_time','region_id'])->paginate(6);
      $region = DB::select('select * from region');
      foreach ($arr as $key => $value) {
			$value->year = substr($value->add_time, 0,4);
			$value->month = substr($value->add_time, 5,2);
			$value->day = substr($value->add_time, 8,2);
		}
		foreach ($arr as $key => $value) {
			foreach ($region as $keys => $values) {
				if ($value->region_id == $values->region_id) {
					$value->region_name = $values->region_name;
				}
			}
		}
      return $arr;
   }
  public function notice($recruitment_id)
  {
  	 $arr = DB::select("select * from recruitment where recruitment_id = $recruitment_id");
  	 $region = DB::select('select * from region ');
      foreach ($arr as $key => $value) {
			$value->year = substr($value->add_time, 0,4);
			$value->month = substr($value->add_time, 5,2);
			$value->day = substr($value->add_time, 8,2);
		}
		foreach ($arr as $key => $value) {
			foreach ($region as $keys => $values) {
				if ($value->region_id == $values->region_id) {
					$value->region_name = $values->region_name;
				}
			}
		}
  	 return $arr;
  }
  public function noticeSearch($region_id)
  {
      $arr = DB::table('recruitment')->orderBy('add_time','desc')->where('region_id',$region_id)->select(['recruitment_id','recruitment_name','add_time','region_id'])->get()->toArray();
        $region = DB::select('select * from region ');
      foreach ($arr as $key => $value) {
      $value->year = substr($value->add_time, 0,4);
      $value->month = substr($value->add_time, 5,2);
      $value->day = substr($value->add_time, 8,2);
    }
    foreach ($arr as $key => $value) {
      foreach ($region as $keys => $values) {
        if ($value->region_id == $values->region_id) {
          $value->region_name = $values->region_name;
        }
      }
    }
  	  	return $arr;
  }
}
